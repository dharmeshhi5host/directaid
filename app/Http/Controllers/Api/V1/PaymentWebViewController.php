<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;


class PaymentWebViewController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'currency' => 'required',
            'user_name' => 'required',
            'user_country_code' => 'required',
            'mobile_no' => 'required',
            'center_id' => 'required',
            'member_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $firstError = $errors->first(); // Get the first error message
            return response()->json([
                'status' => 'error',
                'message' => $firstError
            ], 422);
        }

        $paymentMerchantDetailId = DB::table('merchant_centers')->where('center_id', $request->center_id)->first();
        if (is_null($paymentMerchantDetailId)) {
            return response()->json(['message' => 'Invalid Center ID'], 402);
        }
        $merchantId = DB::table('payment_merchant_details')->where('id', $paymentMerchantDetailId->payment_merchant_detail_id)->first();
        $payment_gateway_settings = DB::table('payment_gateway_settings')->where('pgs_status', 1)->first();
        $tap_pub_key = $payment_gateway_settings->pgs_api_key;
        $transaction_id = uniqid('', true);
        $amount = $request->amount;
        $user_amount = $request->amount;
        return view('paymentWebView', [
            'tap_pub_key' => $tap_pub_key,
            'transaction_id' => $transaction_id,
            'user_amount' => $user_amount,
            'user_currency' => $request->currency,
            'amount' => $amount,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_country_code' => $request->user_country_code,
            'user_mobile_no' => $request->mobile_no,
            'member_id' => $request->member_id,
            'merchant_id' => $merchantId->merchant_id ?? null,
        ]);
    }

    public function paymentSuccess(Request $request)
    {
//        $tapId = $request->tap_id;
//        $payment_gateway_settings = DB::table('payment_gateway_settings')->where('pgs_status', 1)->first();
//        $tap_pub_key = $payment_gateway_settings->pgs_password;
//
//        $response = Http::withHeaders([
//            'Authorization' => 'Bearer ' . $tap_pub_key,
//            'Content-Type' => 'application/json',
//        ])->get("https://api.tap.company/v2/charges/{$tapId}");
//
//        $paymentDetails = $response->json();
//        if ($response->successful() && $paymentDetails['status'] === 'CAPTURED') {
            DB::table('transactions')->insert([
                'tap_id' => $request->tap_id,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'user_name' => $request->user_name,
                'user_email' => $request->user_email,
                'user_country_code' => $request->user_country_code,
                'user_mobile_no' => $request->user_mobile_no,
                'member_id' => $request->member_id,
                'merchant_id' => $request->merchant_id,
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return url()->full();
//        }
//        DB::table('transactions')->insert([
//            'tap_id' => "",
//            'amount' => $request->amount,
//            'currency' => $request->currency,
//            'user_name' => $request->user_name,
//            'user_email' => $request->user_email,
//            'user_country_code' => $request->user_country_code,
//            'user_mobile_no' => $request->user_mobile_no,
//            'member_id' => $request->member_id,
//            'merchant_id' => $request->merchant_id,
//            'status' => 'failed',
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);
//        return redirect()->route('api.v1.paymentCancel', [
//            'tap_id' => $request->tap_id,
//            'user_country_code' => $request->user_country_code,
//            'merchant_id' => $request->merchant_id,
//            'member_id' => $request->member_id,
//            'user_mobile_no' => $request->user_mobile_no,
//            'amount' => $request->amount,
//            'currency' => $request->currency,
//            'user_name' => $request->user_name,
//            'user_email' => $request->user_email
//        ]);
    }

    public function paymentCancel(Request $request)
    {
        DB::table('transactions')->insert([
            'tap_id' => "",
            'amount' => $request->amount,
            'currency' => $request->currency,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_country_code' => $request->user_country_code,
            'user_mobile_no' => $request->user_mobile_no,
            'member_id' => $request->member_id,
            'merchant_id' => $request->merchant_id,
            'status' => 'failed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo url()->full();
    }

    public function paymentFailed()
    {
        echo url()->full();
    }

    public function getPaymentStatus(Request $request)
    {
        $tapId = $request->tap_id;
        $payment_gateway_settings = DB::table('payment_gateway_settings')->where('pgs_status', 1)->first();
        $tap_pub_key = $payment_gateway_settings->pgs_password;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $tap_pub_key,
            'Content-Type' => 'application/json',
        ])->get("https://api.tap.company/v2/charges/{$tapId}");

        $paymentDetails = $response->json();
        if ($response->successful() && $paymentDetails['status'] === 'CAPTURED') {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function getMerchantId($centerId)
    {
        $paymentMerchantDetailId = DB::table('merchant_centers')->where('center_id', $centerId)->first();
        if (is_null($paymentMerchantDetailId)) {
            return response()->json(['message' => 'Invalid Center ID'], 402);
        }
        $merchantId = DB::table('payment_merchant_details')->where('id', $paymentMerchantDetailId->payment_merchant_detail_id)->first();
        if (is_null($merchantId)) {
            return response()->json(['message' => 'Invalid Center ID'], 402);
        }
        $payment_gateway_settings = DB::table('payment_gateway_settings')->where('pgs_status', 1)->first();


        return response()->json(
            ['merchant_id' => $merchantId->merchant_id, 'payment_gateway_settings' => $payment_gateway_settings]
        );
    }
}
