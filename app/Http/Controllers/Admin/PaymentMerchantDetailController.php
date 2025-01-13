<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheClearHelper;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMerchantDetailRequest;
use App\Models\Language;
use App\Models\MerchantCenter;
use App\Models\NationalityTranslation;
use App\Models\PaymentMerchantDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class PaymentMerchantDetailController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $paymentMerchantDetail = PaymentMerchantDetail::query();
            return DataTables::of($paymentMerchantDetail)
                ->addColumn('action', function ($paymentMerchantDetail) {
                    $edit_button = '<a href="' . route('admin.payment-merchant-detail.edit', [$paymentMerchantDetail->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $paymentMerchantDetail->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '</div>';
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
        return view('admin.payment-merchant-detail.index');
    }

    public function store(PaymentMerchantDetailRequest $request)
    {
        if ($request->edit_value == NULL) {
            $paymentMerchantDetail = new PaymentMerchantDetail();
//            $paymentMerchantDetail->center_id = $request->center_id;
            $paymentMerchantDetail->title = $request->title;
            $paymentMerchantDetail->merchant_id = $request->merchant_id;
            $paymentMerchantDetail->description = $request->description;
            $paymentMerchantDetail->save();

            foreach ($request->center_id as $center_id) {
                $merchantCenter = new MerchantCenter();
                $merchantCenter->payment_merchant_detail_id = $paymentMerchantDetail->id;
                $merchantCenter->center_id = $center_id;
                $merchantCenter->save();
            }

            return response()->json(['message' => config('languageString.payment_merchant_detail_added')], 200);
        }

        $id = $request->edit_value;
        $paymentMerchantDetail = PaymentMerchantDetail::find($request->edit_value);
//        $paymentMerchantDetail->center_id = $request->center_id;
        $paymentMerchantDetail->title = $request->title;
        $paymentMerchantDetail->merchant_id = $request->merchant_id;
        $paymentMerchantDetail->description = $request->description;
        $paymentMerchantDetail->save();

        MerchantCenter::where('payment_merchant_detail_id', $paymentMerchantDetail->id)->delete();
        foreach ($request->center_id as $center_id) {
            $merchantCenter = new MerchantCenter();
            $merchantCenter->payment_merchant_detail_id = $paymentMerchantDetail->id;
            $merchantCenter->center_id = $center_id;
            $merchantCenter->save();
        }

        return response()->json(['message' => config('languageString.payment_merchant_detail_updated')], 200);
    }

    public function create()
    {
        $languages = Language::where('status', 'Active')->get();
        return view('admin.payment-merchant-detail.create', ['languages' => $languages]);
    }

    public function edit(int $id)
    {
        $paymentMerchantDetail = PaymentMerchantDetail::findOrFail($id);
        $merchantCenters = MerchantCenter::where('payment_merchant_detail_id', $paymentMerchantDetail->id)->get();
        return view('admin.payment-merchant-detail.edit', [
            'paymentMerchantDetail' => $paymentMerchantDetail,
            'merchantCenters' => $merchantCenters
        ]);
    }

    public function destroy(int $id)
    {
        PaymentMerchantDetail::where('id', $id)->delete();

        return response()->json(['message' => config('languageString.payment_merchant_detail_deleted')], 200);
    }

}
