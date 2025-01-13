<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewaySetting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PaymentSettingsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $settings = DB::table('payment_gateway_settings')
                ->select('payment_gateway_settings.*');

            return Datatables::of($settings)
                ->addColumn('action', function ($settings) {
                    $edit_button = '<a href="'.route('admin.paymentSettings.edit',
                            [$settings->id]).'" class="btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="'.config('languageString.edit').'"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delCurrencies = '<a type="button" data-planid="'.$settings->id.'" class="delete-single btn btn-sm btn-outline-info waves-effect waves-light"  data-toggle="tooltip" data-placement="top"  title="'.config('languageString.delet_fare_plan').'"><i class="fas fa-trash font-size-16 align-middle"></i></a>';
                    return $edit_button.' '.$delCurrencies;
                })->addColumn('status', function ($settings) {
                    if ((int) $settings->pgs_status === 1) {
                        return '<a type="button" onclick="updateStatus('.$settings->id.','.$settings->pgs_status.')" class="badge badge-success" data-toggle="tooltip" data-placement="top" title="'.config('languageString.inactive').'">'.config('languageString.active').'</a>';
                    }
                    if ((int) $settings->pgs_status === 0) {
                        return '<a type="button" onclick="updateStatus('.$settings->id.','.$settings->pgs_status.')" class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="'.config('languageString.active').'">'.config('languageString.inactive').'</a>';
                    }
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin.paymentGatewaySettings.index');
    }

    public function create()
    {
        return view('admin.paymentGatewaySettings.create');
    }

    public function store(Request $request)
    {
        $id = $request->input('edit_value');

        if (is_null($id)) {
            $setting = new PaymentGatewaySetting();
            $setting->pgs_username = $request->input('pgs_username');
            $setting->pgs_merchant_id = $request->input('pgs_merchant_id');
            $setting->pgs_base_url = $request->input('pgs_base_url');
            $setting->pgs_password = $request->input('pgs_password');
            $setting->pgs_api_key = $request->input('pgs_api_key');
            $setting->pgs_payment_gateway = $request->input('pgs_payment_gateway');
            $setting->pgs_whitelabled = $request->input('pgs_whitelabled');
            $setting->pgs_success_url = $request->input('pgs_success_url');
            $setting->pgs_error_url = $request->input('pgs_error_url');
            $setting->pgs_currency_code = $request->input('pgs_currency_code');
            $setting->pgs_gateway_type = $request->input('pgs_gateway_type');
            $setting->pgs_status = 0;
            $setting->pgs_created_at = now();
            $setting->pgs_updated_at = now();
            $setting->save();
        } else {
            $setting = PaymentGatewaySetting::find($id);
//            $setting->pgs_username = $request->input('pgs_username');
//            $setting->pgs_merchant_id = $request->input('pgs_merchant_id');
//            $setting->pgs_base_url = $request->input('pgs_base_url');
            $setting->pgs_password = $request->input('pgs_password');
            $setting->pgs_api_key = $request->input('pgs_api_key');
//            $setting->pgs_payment_gateway = $request->input('pgs_payment_gateway');
//            $setting->pgs_whitelabled = $request->input('pgs_whitelabled');
//            $setting->pgs_success_url = $request->input('pgs_success_url');
//            $setting->pgs_error_url = $request->input('pgs_error_url');
//            $setting->pgs_currency_code = $request->input('pgs_currency_code');
            $setting->pgs_gateway_type = $request->input('pgs_gateway_type');
//            $setting->pgs_status = 0;
            $setting->pgs_created_at = now();
            $setting->pgs_updated_at = now();
            $setting->save();
        }
        return response()->json([
            'success' => true, 'message' =>  config('languageString.payment_gateway_setting_are_saved')
        ]);
    }

//    public function show($id)
//    {
//        //
//    }

    public function edit($id)
    {
        $payment = DB::table('payment_gateway_settings')->find($id);
        if ($payment) {
            return view('admin.paymentGatewaySettings.edit', ['payment' => $payment]);
        } else {
            abort(404);
        }
    }
//
//    public function update(Request $request, $id)
//    {
//        //
//    }

    public function destroy($id)
    {
        PaymentGatewaySetting::where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    public function status($id, $status)
    {
        if ((int) $status === 1) {
            $status_new = 0;
        }
        if ((int) $status === 0) {
            $status_new = 1;
        }
        DB::table('payment_gateway_settings')->update(['pgs_status' => 0]);
        PaymentGatewaySetting::where('id', $id)->update(['pgs_status' => 1]);
        return response()->json([
            'success' => true, 'message' => config('languageString.payment_gateway_setting_are_updated')
        ]);
    }
}
