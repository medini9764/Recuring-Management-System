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

Route::get('/', function () {
	return redirect('payment_form_recurring');
});

Route::get('/one_time_pay', function () {
	return view('welcome');
});
Route::get('/one_time_pay/{id}', 'StcFormController@loadOnetimePaymentForm');

Route::get('/thank_you_recurring', function () {
	return view('thank_you_recurring');
});
Route::get('/sorry_recurring', function () {
	return view('sorry_recurring');
});
Route::post('/submit_stc_form', 'StcFormController@submitForm');
Route::get('/visa_payment', 'StcFormController@visaPayment');

Route::group(['middleware' => 'auth'], function () {

	Route::get('/user_profile', 'UserController@viewProfile');
	Route::post('/user_profile_update', 'UserController@updateProfile');
	Route::post('/upload_image','UserController@uploadImage');
});
Route::post('/response', 'StcFormController@responseForm');

Route::group(['middleware' => 'customer'], function () {


	Route::post('/submit_stc_form_recurring', 'StcFormController@submitFormRecurring');


	Route::get('/payment_form', 'StcFormController@showPaymentForm');
	Route::get('/payment_form_recurring', 'StcFormController@showPaymentFormRecurring');
	Route::post('/submit_stc_form_recurring', 'StcFormController@submitStcFormRecurring');

	Route::post('/get_session_data', 'StcFormController@getSessionData');

	Route::post('/save_card_data', 'StcFormController@saveCardData');
	Route::post('/save_amex_card', 'StcFormController@saveAmexCard');
	Route::post('/pay_from_card', 'StcFormController@payFromCard');
	Route::get('/list_card', 'StcFormController@listCard');
	Route::post('/delete_card', 'StcFormController@deleteCard');
	Route::post('/save_card_data', 'StcFormController@saveCardData');
	Route::get('/customer_payments_recurrent', 'ReportController@showPaymentsRecurrent');
	Route::get('/customer_payments_one_time', 'ReportController@showPaymentOneTime');
	Route::get('/z', function () {

		$exitCode = Artisan::call('config:cache');
		$exitCode_other = Artisan::call('cache:clear');
	
	
	});

});
Auth::routes();

Route::group(['middleware' => 'admin'], function () {
	Route::get('/amex_users', 'ReportController@amexPayments');
	Route::get('/visa_users', 'ReportController@visaPayments');
	Route::get('/one_time_payment', 'ReportController@oneTimePayment');
	Route::get('/category', 'AdminController@category');
	Route::post('/submit_category_form', 'AdminController@addCategory');
	Route::post('/editCategory', 'AdminController@editCategory');

});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{lang}', 'HomeController@lang')->name('lang');




Route::get('/link-storage', function () {
	Artisan::call('storage:link');
});

Route::get('token','TestController@handle');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');