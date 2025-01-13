<?php


use Illuminate\Support\Facades\Route;


Route::get('/', 'LoginController@index')->name('login');
Route::get('login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@loginCheck')->name('loginCheck');

Route::group(['middleware' => ['auth:admin', 'adminLanguage']], function () {

    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    Route::resource('admin', 'AdminController');

    Route::get('profile', 'HomeController@profile')->name('profile');
    Route::post('editProfile', 'HomeController@editProfile')->name('editProfile');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('password', 'PasswordController@index')->name('password');
    Route::post('changePassword', 'PasswordController@changePassword')->name('changePassword');
    Route::get('changeThemes/{id}', 'HomeController@changeThemes')->name('changeThemes');
    Route::get('changeThemesMode/{local}', 'HomeController@changeThemesMode')->name('changeThemesMode');

    Route::resource('nationality', 'NationalityController');
    Route::get('nationality/status/{id}/{status}', 'NationalityController@changeStatus')->name('nationality.status.change');

    Route::resource('language', 'LanguageController');
    Route::get('language/status/{id}/{status}', 'LanguageController@changeStatus')->name('language.status.change');
    Route::get('language/changeByDefaultStatus/{id}/{status}', 'LanguageController@changeByDefaultStatus')->name('language.status.changeByDefaultStatus');

    Route::resource('language-screen', 'LanguageScreenController');
    Route::post('getLanguageScreen', 'LanguageStringController@getLanguageScreen')->name('getLanguageScreen');
    Route::get('view-language-screen/{id}', 'LanguageScreenController@viewLanguageScreen')->name('view-language-screen');

    Route::get('viewScreenString', 'LanguageScreenController@viewScreenString')->name('viewScreenString');
    Route::get('language-screen/status/{id}/{status}', 'LanguageScreenController@changeStatus')->name('languageScreen.status.change');
    Route::resource('language-string', 'LanguageStringController');
    Route::get('language-string/status/{id}/{status}', 'LanguageStringController@changeStatus')->name('languageString.status.change');
    Route::get('language-string-update-developer-mode', 'LanguageStringController@updateDeveloperMode')->name('language-string.update-developer-mode');


    Route::resource('payment-merchant-detail', 'PaymentMerchantDetailController');
    Route::resource('paymentSettings', 'PaymentSettingsController');
    Route::get('paymentSettings/{id}/{status}', 'PaymentSettingsController@status');
//    Route::get('nationality/status/{id}/{status}', 'NationalityController@changeStatus')->name('nationality.status.change');

});
