<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'LoginController@index')->name('login');
Route::get('login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@loginCheck')->name('loginCheck');


Route::get('/clear', function() {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    echo "success";
});

Route::get('/updateCSRF', function() {
    session()->regenerate();
    return response()->json(['token' => csrf_token()]);
})->name('updateCSRF');