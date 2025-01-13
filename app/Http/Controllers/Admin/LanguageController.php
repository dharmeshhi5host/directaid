<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheClearHelper;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageStoreRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $languages = Language::query();
            return DataTables::of($languages)
                ->addColumn('is_rtl', function ($languages) {
                    if ($languages->is_rtl == 1) {
                        return "Yes";
                    } else {
                        return "No";
                    }
                })
                
                ->addColumn('by_default', function ($languages) {
                    if ($languages->by_default == 1) {
                        $by_default = '<a data-id="' . $languages->id . '" data-status="yes" class="statuschange" data-toggle="tooltip" data-placement="top" title="' . config('languageString.yes') . '" ><span class="badge badge-success">' . config('languageString.yes') . '</span></a>';
                    } else {
                        $by_default = '<span data-id="' . $languages->id . '" data-status="no"  class="statuschange badge badge-danger" data-toggle="tooltip" data-placement="top" title="' . config('languageString.no') . '">' . config('languageString.no') . '</span>';
                    }
                    return $by_default;
                })
                ->addColumn('action', function ($languages) {
                    $edit_button = $delete_button = $status_button = $by_default_btn = '';
                    
                        $edit_button = '<a href="' . route('admin.language.edit', [$languages->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                        $delete_button = '<button data-id="' . $languages->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                        if ($languages->status == 'Active') {
                            $status_button = '<button data-id="' . $languages->id . '" data-status="InActive" class="status-change btn btn-warning btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                        } else {
                            $status_button = '<button data-id="' . $languages->id . '" data-status="Active" class="status-change btn btn-success btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                        }


                        if ($languages->by_default == 1) {
                            $by_default_btn = '';
                        } else {
                            $by_default_btn = '<button data-id="' . $languages->id . '" data-status="Yes"  data-defstatus="1" class="by-default-change btn btn-success btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.by_default') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                        }
                    
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '' . $status_button.' '. $by_default_btn . '</div>';
                })
                ->addColumn('status', function ($languages) {
                    if ($languages->status == 'Active') {
                        $status = '<a data-id="' . $languages->id . '" data-status="InActive" class="statuschange" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><span class="badge badge-success">' . config('languageString.active') . '</span></a>';
                    } else {
                        $status = '<span data-id="' . $languages->id . '" data-status="Active"  class="statuschange badge badge-danger" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '">' . config('languageString.inactive') . '</span>';
                    }
                    return $status;
                })
                ->rawColumns(['action', 'status','by_default'])
                ->make(true);
        }
        return view('admin.language.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LanguageStoreRequest $request)
    {
        $validated = $request->validated();
        if ($validated) {
            if ($request->edit_value == NULL) {
                $lang_flag = NULL;
                if ($request->hasFile('lang_flag')) {
                    $image = $request->file('lang_flag');
                    $lang_flag = time() . '-' . $image->getClientOriginalName();
                    $image->move('./assets/video_thumnails/', $lang_flag);
                    $lang_flag = 'assets/video_thumnails/' . $lang_flag;
                }
                $language = new Language();
                $language->name = $validated['name'];
                $language->language_code = $validated['language_code'];
                $language->is_rtl = $validated['is_rtl'];
                $language->lang_flag = $lang_flag;
                $language->save();

                CacheClearHelper::languageCacheClear();

                return response()->json(['message' => config('languageString.language_added')], 200);
            } else {
                $language = Language::find($request->edit_value);
                $lang_flag = $language->lang_flag;
                if ($request->hasFile('lang_flag')) {
                    $image = $request->file('lang_flag');
                    $lang_flag = $image->getClientOriginalName();
                    $image->move('./assets/language_flags/', $lang_flag);
                    $lang_flag = 'assets/language_flags/' . $lang_flag;
                }
                $language->name = $validated['name'];
                $language->language_code = $validated['language_code'];
                $language->is_rtl = $validated['is_rtl'];
                $language->lang_flag = $lang_flag;
                $language->save();

                CacheClearHelper::languageCacheClear();
                return response()->json(['message' => config('languageString.language_updated')], 200);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $language = Language::findOrFail($id);
        return view('admin.language.edit', ["language" => $language]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        Language::where('id', $id)->delete();
        CacheClearHelper::languageCacheClear();

        return response()->json(['message' => config('languageString.language_deleted')], 200);
    }

    public function changeStatus($id, $status)
    {
        Language::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }

    public function changeByDefaultStatus($id, $status)
    {
        Language::where('by_default', 1)->update(['by_default' => 0]);
        Language::where('id', $id)->update(['by_default' => $status]);
        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }
}
