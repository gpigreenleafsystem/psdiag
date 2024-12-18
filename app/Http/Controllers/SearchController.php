<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patients;
use App\Models\Bill_details;
use App\Models\Referer_details;
use App\Models\Scanning_details;
use App\Models\appointment_details;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{

	public function usersearch(Request $req) {
		$q = $req->q;
		//dd($req);
		if ($q != "") {
			$user = User::where('name', 'LIKE', '%' . $q . '%')
				->orWhere('email', 'LIKE', '%' . $q . '%')
				->orWhere('usertype', 'LIKE', '%' . $q . '%')
				->paginate(5)->setPath('');
			$pagination = $user->appends(array(
				'q' => $req->q
			));
		//	if (count($user) > 0)

				return view('users.index')->with('users', $user);
		//	else
		//		return view('users.index')->with('success', 'No Details found. Try to search again !');
		}else return redirect()->route('usermanagement');
		//return view('users.index')->with('success', 'No Details found. Try to search again !');
	}



	public function appointmentsearch(Request $req){
	       	$q = $req->q;

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
				'q' => $req->q
			));
			//if (count($apdetails) > 0)
				//return view('pages.viewappointment', compact('apdetails', 'patient', 'referer', 'modality'));
				return view('pages.viewappointment', compact('apdetails'));


				
		} 
		else return redirect()->route('viewappointment');
		//return view('pages.viewappointment')->with('success', 'No Details found. Try to search again !');

}



	 public function billsearch(Request $req)
	 {
		$q = $req->q;
		// Query the bills
		$query = Bill_details::query();
		
//		dd($query);
		if ($q != "") {
			
			$query->where('bill_no', 'like', '%' . $q . '%');
			// Get paginated results
			$allBillInfo= $query->paginate(100);
			//dd($allBillInfo->count());
		if($allBillInfo->count() >0){
                	foreach ($allBillInfo as $data) {

                        $patientname = $this->getPatientNameByPhone($data->patient_phoneno);

                        $allBills[] =  [
                                'bill_id' => $data->id,
                                'bill_no' => $data->bill_no,
                                'patientName' => $patientname,
                                'patientNo' => $data->patient_phoneno,
                                'bill_date' => $data->created_at,
				'bill_amount' => $data->netamount,
				'bill_dueamount' => $data->due_amount
                        ];
                }
			//		return view('pages.billList', compact('allBills'));
			return view('pages.billList', compact('allBillInfo', 'allBills'));
		}
		else {
			//	$query = Bill_details::all();
			$query = Bill_details::query();
			$query->get();
			 $allBillInfo= $query->paginate(100);
//			 dd($allBillInfo);
//			 $allBills[]=null;
			 if($allBillInfo->count() >0){
				 $patsearchcnt=0;$patientnames="";
                        foreach ($allBillInfo as $data) {

				$patientname = $this->getPatientNameByPhone($data->patient_phoneno);
				$patientnames=$patientnames." ".$patientname;
		//		dd($patientnames);
				
				if(str_contains(strtolower($patientname),strtolower($q))){
					$patsearchcnt++;
					
                        $allBills[] =  [
                                'bill_id' => $data->id,
                                'bill_no' => $data->bill_no,
                                'patientName' => $patientname,
                                'patientNo' => $data->patient_phoneno,
                                'bill_date' => $data->created_at,
                                'bill_amount' => $data->netamount,
                                'bill_dueamount' => $data->due_amount
				];
				}
			}
//				 dd($patientnames);
//		dd($allBills);	


			//$patient = Patients::where('patient_name', $q)->first();       
			//if(!$patient){
				 //	$allBills[]=null;  
			if($patsearchcnt>0)	
				return view('pages.billList',compact('allBillInfo','allBills'));
			else{
				$allBills=null;
				return view('pages.billList',compact('allBillInfo','allBills'));
			}
		
		}
		}
		}
		else	return redirect()->route('billList');
		//return view('pages.billList', compact('allBills'));
		//return view('pages.billList')->with('success', 'No Details found. Try to search again !');
            
	 }

	  public function getPatientNameByPhone($phoneNo)
        {
                $patient = Patients::where('mobileno', $phoneNo)->first();
//dd($phoneNo);
                if ($patient) {
                        return $patient->name;
                }

                return null; // or return a message indicating no patient found
        }


}
