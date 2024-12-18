<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Patients;
use App\Models\Bill_details;
use App\Models\Referer_details;
use App\Models\Scanning_details;
use App\Models\appointment_details;

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
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::any('/appointmentsearch','App\Http\Controllers\SearchController@appointmentsearch');
//Route::any('/usersearch','App\Http\Controllers\SearchController@usersearch');


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

	Route::get('getappointmenttimes/{dt}',[App\Http\Controllers\AppointmentDetailsController::class,'getappttimes'])->name('getappointmenttimes');

	Route::get('showcalendar',[App\Http\Controllers\AppointmentDetailsController::class,'showcalendar'])->name('showcalendar');

//Billing
	 Route::get('startbilling',  [App\Http\Controllers\BillDetailsController::class, 'index'])->name('startbilling');
	Route::get('newbilling/{id}',  [App\Http\Controllers\BillDetailsController::class, 'newbill'])->name('newbilling');
	Route::post('createnewbill', [App\Http\Controllers\BillDetailsController::class,'createnewbill'])->name('createnewbill');

//	Route::get('/get-investigations/{scanType}', [App\Http\Controllers\ScanningDetailsController::class, 'getInvestigations']);
	Route::get('/get-investigations/{scanType}', [App\Http\Controllers\ScanningDetailsController::class, 'getInvestigations'])->name('getInvestigations');
Route::get('/autocomplete-doctor', [App\Http\Controllers\AppointmentDetailsController::class, 'autocomplete'])->name('autocomplete.doctor');
	Route::get('/newpayment/{id}', 'App\Http\Controllers\PaymentDetailsController@index')->name('newpayment');

	Route::post('/process_payment', 'App\Http\Controllers\PaymentDetailsController@processPayment')->name('process_payment');

	Route::get('/viewpayment/{id}', 'App\Http\Controllers\PaymentDetailsController@index')->name('viewpayment');
	Route::get('/paymentlist', 'App\Http\Controllers\PaymentDetailsController@getData')->name('paymentlist');
	Route::get('/editpayment/{id}', 'App\Http\Controllers\PaymentDetailsController@editpayment')->name('editpayment');
	Route::post('updatepayment/{id}',[App\Http\Controllers\PaymentDetailsController::class,'updatepayment'])->name('updatepayment');
	Route::post('/submitTable', 'App\Http\Controllers\PaymentDetailsController@submitTable')->name('submitTable');
	Route::get('/billList',  [App\Http\Controllers\BillDetailsController::class, 'getAllBill'])->name('billList');
	/*	Route::get('/billList',  [App\Http\Controllers\PaymentDetailsController::class, 'getAllBill'])->name('billList');*/
	Route::get('/viewBillPay/{id}', 'App\Http\Controllers\PaymentDetailsController@viewBillPayment')->name('viewBillPay');
	Route::get('/editBillPay/{id}', 'App\Http\Controllers\PaymentDetailsController@editBillPayment')->name('editBillPay');
	Route::get('/reportscheck', 'App\Http\Controllers\ReportsController@balancereportfun')->name('reportscheck');
	Route::get('/reports', 'App\Http\Controllers\ReportController@index')->name('reports');
	Route::get('/reportsduepaid', [App\Http\Controllers\ReportController::class, 'duepaidreport'])->name('reportsduepaid');
	Route::get('/getbalancereport', 'App\Http\Controllers\ReportsController@balancereportfun')->name('getbalancereport');
		Route::post('/monthlyreport','App\Http\Controllers\ReportsController@monthlyreportfun')->name('monthlyreport');
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
        Route::any('/billsearch','App\Http\Controllers\SearchController@billsearch');	
	Route::any('/appointmentsearch','App\Http\Controllers\SearchController@appointmentsearch');
	Route::any('/usersearch','App\Http\Controllers\SearchController@usersearch');
/*Route::post('/user-search', function () {
	$q = Request::get('q');
	//dd($req);
	if ($q != "") {
		$user = User::where('name', 'LIKE', '%' . $q . '%')
			->orWhere('email', 'LIKE', '%' . $q . '%')
			->orWhere('usertype', 'LIKE', '%' . $q . '%')
			->paginate(5)->setPath('');
		$pagination = $user->appends(array(
			'q' => Request::get('q')
		));
	//	if (count($user) > 0)

			return view('users.index')->with('users', $user);
	//	else
	//		return view('users.index')->with('success', 'No Details found. Try to search again !');
	}else return redirect()->route('usermanagement');
	});
	Route::post('/apmnt-search', function () {
		$q = Request::get('q');

		if ($q != "") {
			$apdetails = appointment_details::with(['patient', 'referer', 'modality'])
				->whereHas('patient', function ($query) use ($q) {
					$query->where('name', 'LIKE', '%' . $q . '%');
				})
				->orWhere('appointment_date', 'LIKE', '%' . $q . '%')
				->orWhere('appointment_status', 'LIKE', '%' . $q . '%')
				->paginate(10)
				->setPath('');
			$pagination = $apdetails->appends(array(
				'q' => Request::get('q')
			));
			//if (count($apdetails) > 0)
				//return view('pages.viewappointment', compact('apdetails', 'patient', 'referer', 'modality'));
				return view('pages.viewappointment', compact('apdetails'));


				
		} 
		else return redirect()->route('viewappointment');
	});
 
		Route::get('bill-search', function () {
		$q = Request::get('q');
		// Query the bills
		$query = Bill_details::query();
		dd($query);
		if ($q != "") {
			$query->where('bill_no', 'like', '%' . $q . '%');
			// Get paginated results
			$allBills = $query->paginate(10);
			return view('pages.billList', compact('allBills'));
		}
		//return view('pages.billList', compact('allBills'));
		return view('pages.billList')->with('success', 'No Details found. Try to search again !');
	})->name('bill-search');
 
*/

});
