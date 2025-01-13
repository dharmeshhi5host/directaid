<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->name('api.v1.')->namespace('Api\V1')->group(function () {
//    Route::group(['middleware' => 'languageCheck'], function () {
    Route::get('languageString', 'LanguageStringController@index')->name('languageString');
    Route::get('languages', 'LanguageController@index')->name('languages');
    Route::get('getActiveNationalities', 'LanguageStringController@getActiveNationalities')->name('languages');

    Route::get('getMerchantId/{centerId}', 'PaymentWebViewController@getMerchantId')->name('getMerchantId');
    Route::get('paymentWebView', 'PaymentWebViewController@index')->name('paymentWebView');
    Route::get('paymentSuccess', 'PaymentWebViewController@paymentSuccess')->name('paymentSuccess');
    Route::get('paymentFailed', 'PaymentWebViewController@paymentFailed')->name('paymentFailed');
    Route::get('paymentCancel', 'PaymentWebViewController@paymentCancel')->name('paymentCancel');
    Route::get('getPaymentStatus', 'PaymentWebViewController@getPaymentStatus')->name('getPaymentStatus');

//    });
});
