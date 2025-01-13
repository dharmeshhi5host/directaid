<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheClearHelper;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\NationalityStoreRequest;
use App\Models\Language;
use App\Models\NationalityTranslation;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class NationalityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $nationalities = Nationality::query();
            return DataTables::of($nationalities)
                ->addColumn('action', function ($nationalities) {
                    $edit_button = '<a href="' . route('admin.nationality.edit', [$nationalities->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $nationalities->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    if ($nationalities->status == 'Active') {
                        $status_button = '<button data-id="' . $nationalities->id . '" data-status="InActive" class="status-change btn btn-warning btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    } else {
                        $status_button = '<button data-id="' . $nationalities->id . '" data-status="Active" class="status-change btn btn-success btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    }
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '' . $status_button . '</div>';
                })
                ->addColumn('status', function ($nationalities) {
                    if ($nationalities->status == 'Active') {
                        $status = '<a data-id="' . $nationalities->id . '" data-status="InActive" class="statuschange" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><span class="badge badge-success">' . config('languageString.active') . '</span></a>';
                    } else {
                        $status = '<span data-id="' . $nationalities->id . '" data-status="Active"  class="statuschange badge badge-danger" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '">' . config('languageString.inactive') . '</span>';
                    }
                    return $status;
                })
                ->rawColumns(['action', 'status', 'by_default'])
                ->make(true);
        }
        return view('admin.nationality.index');
    }

    public function store(NationalityStoreRequest $request)
    {
        if ($request->edit_value == NULL) {
            $nationality = new Nationality();
            $nationality->status = 'Active';
            $nationality->save();

            $languages = Language::where('status', 'Active')->get();
            foreach ($languages as $language) {
                NationalityTranslation::create([
                    'name' => $request->input($language->language_code . '_name'),
                    'nationality_id' => $nationality->id,
                    'locale' => $language->language_code,
                ]);
            }

            return response()->json(['message' => config('languageString.nationality_added')], 200);
        }

        $id = $request->edit_value;
        $nationality = Nationality::find($request->edit_value);
        $nationality->save();
        $languages = Language::where('status', 'Active')->get();
        foreach ($languages as $language) {
            NationalityTranslation::updateOrCreate([
                'nationality_id' => $id,
                'locale' => $language->language_code,
            ],
                [
                    'nationality_id' => $id,
                    'locale' => $language->language_code,
                    'name' => $request->input($language->language_code . '_name'),
                ]);
        }

        return response()->json(['message' => config('languageString.nationality_updated')], 200);
    }

    public function create()
    {
        $languages = Language::where('status', 'Active')->get();
        return view('admin.nationality.create', ['languages' => $languages]);
    }

    public function edit(int $id)
    {
        $nationality = Nationality::findOrFail($id);
        $languages = Language::where('status', 'Active')->get();
        return view('admin.nationality.edit', ["nationality" => $nationality, 'languages' => $languages]);
    }

    public function destroy(int $id)
    {
        Nationality::where('id', $id)->delete();

        return response()->json(['message' => config('languageString.nationality_deleted')], 200);
    }

    public function changeStatus($id, $status)
    {
        Nationality::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }
}
