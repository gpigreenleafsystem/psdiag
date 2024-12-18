<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

//Route::get('usermanagement',  [App\Http\Controllers\TestController::class, 'index']);

//Route::get('investigations',  [App\Http\Controllers\InvestigationDetailsController::class, 'index']);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

//Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/home',[App\Http\Controllers\AppointmentDetailsController::class,'showcalendar'])->name('home');

Route::group(['middleware' => 'auth'], function () {
//	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
Route::get('logout', 'Auth\LoginController@logout');
Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
Route::get('profilenonadmin', ['as' => 'profile.editnonadmin', 'uses' => 'App\Http\Controllers\ProfileController@editnonadmin']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	Route::get('investigations', [App\Http\Controllers\InvestigationDetailsController::class, 'index'])->name('investigations');
Route::get('usermanagement',  [App\Http\Controllers\UserController::class, 'index'])->name('usermanagement');
// Appointment
	Route::get('newappointment',  [App\Http\Controllers\AppointmentDetailsController::class, 'index'])->name('newappointment');
Route::get('vwappointment/{id}',  [App\Http\Controllers\AppointmentDetailsController::class, 'vw'])->name('vwappointment');
	Route::get('viewappointment',  [App\Http\Controllers\AppointmentDetailsController::class, 'view'])->name('viewappointment');

	Route::get('rescheduleappointment',  [App\Http\Controllers\AppointmentDetailsController::class, 'reschedule'])->name('rescheduleappointment');
	Route::post('addappointment',  [App\Http\Controllers\AppointmentDetailsController::class, 'addappointment'])->name('addappointment');
	Route::get('editappointment/{id}',[App\Http\Controllers\AppointmentDetailsController::class,'editappointment'])->name('editappointment');
	Route::post('updateappointment/{id}',[App\Http\Controllers\AppointmentDetailsController::class,'updateappointment'])->name('updateappointment');



	Route::get('showcalendar',[App\Http\Controllers\AppointmentDetailsController::class,'showcalendar'])->name('showcalendar');

//Billing
	 Route::get('startbilling',  [App\Http\Controllers\BillDetailsController::class, 'index'])->name('startbilling');
	Route::get('newbilling/{id}',  [App\Http\Controllers\BillDetailsController::class, 'newbill'])->name('newbilling');
	Route::post('createnewbill', [App\Http\Controllers\BillDetailsController::class,'createnewbill'])->name('createnewbill');

//	Route::get('/get-investigations/{scanType}', [App\Http\Controllers\ScanningDetailsController::class, 'getInvestigations']);
	Route::get('/get-investigations/{scanType}', [App\Http\Controllers\ScanningDetailsController::class, 'getInvestigations'])->name('getInvestigations');
	Route::get('/newpayment/{id}', 'App\Http\Controllers\PaymentDetailsController@index')->name('newpayment');

	Route::post('/process_payment', 'App\Http\Controllers\PaymentDetailsController@processPayment')->name('process_payment');

	Route::get('/viewpayment/{id}', 'App\Http\Controllers\PaymentDetailsController@index')->name('viewpayment');
	Route::get('/paymentlist', 'App\Http\Controllers\PaymentDetailsController@getData')->name('paymentlist');
	Route::get('/editpayment/{id}', 'App\Http\Controllers\PaymentDetailsController@editpayment')->name('editpayment');
	Route::post('updatepayment/{id}',[App\Http\Controllers\PaymentDetailsController::class,'updatepayment'])->name('updatepayment');

	Route::get('/reports', 'App\Http\Controllers\ReportController@index')->name('reports');
	Route::get('/reportsduepaid', [App\Http\Controllers\ReportController::class, 'indexduepaid'])->name('reportsduepaid');
	Route::get('/getbalancereport', 'App\Http\Controllers\ReportsController@balancereportfun')->name('getbalancereport');
	Route::get('/monthlyreport','App\Http\Controllers\ReportsController@monthlyreportfun')->name('monthlyreport');
	Route::get('/referreport','App\Http\Controllers\ReportController@referrerreportfun')->name('referreport');
	//User CRUD

	Route::get('adduser',[App\Http\Controllers\UserController::class,'adduser'])->name('adduser');
	Route::post('createuser',[App\Http\Controllers\UserController::class,'createuser'])->name('createuser');
	Route::get('edituser/{id}',[App\Http\Controllers\UserController::class,'edituser'])->name('edituser');
	Route::post('updateuser/{id}',[App\Http\Controllers\UserController::class,'updateuser'])->name('updateuser');
	Route::get('deleteuser/{id}',[App\Http\Controllers\UserController::class,'deleteuser'])->name('delteuser');

	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);

	//	Route::get('tabletest',  [App\Http\Controllers\TestController::class, 'index']);
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);

	Route::get('/download_invoice/{id}','App\Http\Controllers\PaymentDetailsController@download_invoice'); 


});

