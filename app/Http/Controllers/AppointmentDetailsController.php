<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patients;
use App\Models\Referer_details;
use App\Models\Scanning_details;
use App\Models\appointment_details;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AppointmentDetailsController extends Controller
{
	//
	 public function index()
	 {
		 $user= User::all();
            return view('pages.newappointment')->with('user',$user);
	 }

	  public function view()
         {
		// $apdetails= appointment_details::with('patient', 'referer','modality')->paginate(10);//->get();
		 $apdetails = appointment_details::with('patient', 'referer', 'modality')->orderBy('appointment_details.created_at', 'desc')->paginate(50);
		 //            return view('pages.viewappointment')->with('apdetails',$apdetails);
		 return view('pages.viewappointment', compact('apdetails'));
	  }

	  public function vw($id)
         {
		 $apdetails= appointment_details::findOrFail($id);
		 $patient = Patients::findorFail($apdetails->patient_id);
		 $referer = Referer_details::findorFail($apdetails->referer_id);
		 $modality = ""; //Scanning_details::findorFail($apdetails->modality_id);
		 //            return view('pages.viewappointmentn')->with('apdetails',$apdetailsonerec);
		 //dd($referer);
		 return view('pages.viewappointmentn', compact('apdetails', 'patient','referer','modality'));
          }

	  public function reschedule()
         {
            $apdetails= appointment_details::all();
            return view('pages.rescheduleappointment')->with('apdetails',$apdetails);
         }

	 public function addappointment(Request $req){
		//dd($req);

		 $validatedData = $req->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
	    'gender' => 'required|string|in:Male,Female',
	    'mobileno'=> 'required|string|min:10|max:10',
	    'address'=> 'required|string|max:500',
            // Add more validation rules as needed
        ]);

		// Check if a patient with the provided mobile number exists
		 $patient = Patients::where('mobileno', $validatedData['mobileno'])
			 ->where('name', $validatedData['name'])
			 ->first();
	//dd($patient->visit_no);
	if ($patient) {
		$patient->name = $validatedData['name'];
		$patient->age = $validatedData['age'];
		$patient->address = $validatedData['address'];
		$patient->visit_no = $patient->visit_no +1; 
		//	$patient->address = $validatedData['a'];
		$patient->save();
	}
	else{
        // Create new patient instance
	$patient = new Patients;
        $patient->name = $validatedData['name'];
        $patient->age = $validatedData['age'];
        $patient->gender = $validatedData['gender'];
	$patient->mobileno = $validatedData['mobileno'];
	$patient->address = $validatedData['address'];
	$patient->visit_no = 1;
	$patient->patienttype="abd";
        // Save patient details
	$patient->save();
	}

// Validate incoming request data
        $validatedData = $req->validate([
		'drname' => 'required|string|max:255',
	//	'drmobileno'=> 'required|string',
	//	'modality' => 'required|string',
	//	'date' => 'required|date',
           // 'mobile_number' => 'required|string|unique:referer_details', // Ensure mobile number is unique
            // Add more validation rules as needed
        ]);

        // Check if a doctor with the provided mobile number exists
	//$doctor = Referer::where('mobile_number', $validatedData['mobile_number'])->first();
	$doctor = Referer_details::where('referer_name', $validatedData['drname'])->first();

//	dd($doctor);

        // If doctor exists, update the record; otherwise, create a new one
        if ($doctor) {
		$doctor->referer_name = $validatedData['drname'];
		$doctor->referer_count = $doctor->referer_count + 1;
		$doctor->referer_amount = $doctor-> referer_amount+ 100;
            // Update other properties as needed
		$doctor->save();
//		dd($doctor);
            $message = 'Doctor details updated successfully';
        } else {
            // Create new doctor instance
            $doctor = new Referer_details;
            $doctor->referer_name = $validatedData['drname'];
	    $doctor->referer_phno = $req->drmobileno;//$validatedData['drmobileno'];
	    $doctor->referer_count = 1;
	    $doctor->referer_amount =100;
            // Set other properties as needed
            $doctor->save();
            $message = 'New doctor added successfully';
        }

//dd($doctor);
	$validatedData = $req->validate([
		'modality' => 'required|string',
		'selected_date' => 'required',
		'selected_time'=>'required',
        //      'date' => 'required|date',
           // 'mobile_number' => 'required|string|unique:referer_details', // Ensure mobile number is unique
            // Add more validation rules as needed
        ]);
	if($validatedData['modality']=='CT')
		$modality=1;
	else $modality=2;
//	$modality = Scanning_details::where('modality', $validatedData['modality'])->first();
//dd($modality);
//$message = $message + $modality->id;

	$appointment = new appointment_details();
	$appointment->referer_id = $doctor->id;
	$appointment->patient_id = $patient->id;
	$appointment->modality_id = $modality;
	$appointment->appointment_status = "SCHEDULED";
//	$dt = Carbon::createFromFormat('m/d/Y',$validatedData['selected_date'])->format('Y-m-d');//Carbon::parse($validatedData['selected_date']);
//	$appointment->appointment_date = $dt; //->fiormat('Y-m-d iH:i:s'); //$validatedData['selected_date'];
	$dateTimeString = $validatedData['selected_date']." ".$validatedData['selected_time'];//.":00";
//	dd($dateTimeString);
	$appointment->start_time = Carbon::createFromFormat('d/m/Y H:i a',$dateTimeString)->format('Y-m-d H:i:s');
	$appointment->appointment_date = $appointment->start_time;
	$etime=Carbon::createFromFormat('d/m/Y H:i a',$dateTimeString);
	$appointment->end_time = $etime->addMinutes(30)->format('Y-m-d H:i:s');
    // Set other properties as needed
    $appointment->save();

$message = "Appointment added successfully";
        // Return a response
        //return response()->json(['message' => $message], 200);
	    $apdetails= appointment_details::all();
//            return view('pages.viewappointment')->with('apdetails',$apdetails);
	//		return view('pages.viewappointment', compact('apdetails', 'message'));
			return redirect()->to('/viewappointment')->with('success','Appointment added sucessfully');
	 }

	 public function editappointment($id){
		 $apdetails= appointment_details::findOrFail($id);
		 $patient = Patients::findorFail($apdetails->patient_id);
		 $referer = Referer_details::findorFail($apdetails->referer_id);
        	$modality="";
		 //$modality = Scanning_details::findorFail($apdetails->modality_id);
		 return view('pages.editappointment', compact('apdetails', 'patient','referer','modality'));
	
}
public function updateappointment(Request $request){
//	dd($request->all());
	$id=$request->id;
	//get the apointment details
	$apdetails = appointment_details::findOrFail($id);

	$validatedData = Validator::make($request->all(), [//[request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|in:Male,Female',
            'mobileno'=> 'required|string|min:10|max:10',
            'address'=> 'required|string|max:500',
	    'drname' => 'required|string|max:255',
	    'scan_type' => 'required|string',
               // 'selected_date' => 'required',
               // 'selected_time'=>'required',

	]);

	if ($validatedData->fails()) {
        return redirect()->back()
            ->withErrors($validatedData)
            ->withInput();
	}

	if($request->appointmentstatus == "RESCHEDULED")
	{
		$validatedData = Validator::make($request->all(), [ //$request->validate([
		'selected_date' => 'required',
                'selected_time'=>'required',

        ]);

        if ($validatedData->fails()) {
        return redirect()->back()
            ->withErrors($validatedData)
            ->withInput();
        }

	}

	//update Patient Details
	$patient=Patients::where('id', '=', $apdetails->patient_id)->update([
		'name'=>$request->name,
		'age'=>$request->age,
		'gender'=>$request->gender,
		'mobileno'=>$request->mobileno,
		'address'=>$request->address
	]);
	$doctor = Referer_details::where('id','=',$apdetails->referer_id)->update([
		'referer_name'=>$request->drname,
		'referer_phno'=>$request->drmobileno
	]);
	
	
	//update appointment details
	
	$aptstatus = $request->appointmentstatus;

	if($request->appointmentstatus == "RESCHEDULED")
        {
	$dateTimeString = $request->selected_date." ".$request->selected_time;
	$start_time = Carbon::createFromFormat('d/m/Y H:i a',$dateTimeString)->format('Y-m-d H:i:s');
        $appointment_date = $start_time;
        $etime=Carbon::createFromFormat('d/m/Y H:i a',$dateTimeString);
        $end_time = $etime->addMinutes(30)->format('Y-m-d H:i:s');
	appointment_details::where('id','=',$id)->update([
		'modality_id'=>$request->scan_type,
		'appointment_status'=>$aptstatus,
		'appointment_date'=>$appointment_date,
		'start_time'=>$start_time,
		'end_time'=>$end_time,
		
	]);
	}

	else{

		appointment_details::where('id','=',$id)->update([
			'modality_id'=>$request->scan_type,
			'appointment_status'=>$aptstatus,
        	]);
	}


	return redirect()->back(); // redirect()->to('/viewappointment')->with('success','updated sucessfully');
    
}

public function showcalendar()
    {
	    $appointments = appointment_details::all();
		if($appointments->count()>0){
	    foreach ($appointments as $appointment) {
		    $patient = Patients::findorFail($appointment->patient_id);
            $events[] = [
                'title' => $patient->name,
                'start' => $appointment->start_time,
                'end' => $appointment->end_time,
            ];
        }}
		else $events[] =  [
			
		];;

	    //        return view('pages.showcalendar', compact('appointments'));
	    return view('pages.showcalendar', compact('events'));
    }

public function getappttimes($dt)
         {
		 //  $apdetails= appointment_details::all();
		 //$dt = '2024-08-1'; // Example date in Y-m-d format
		//dd($dt);
		$appointments = appointment_details::whereDate('appointment_date', $dt)
			->where('appointment_status', '!=', 'CANCELLED')
			 ->whereTime('start_time', '>', '06:00:00')
			->get(['start_time', 'end_time']);

		$timeSlots = [];

		foreach ($appointments as $appointment) {
		    $start_time = Carbon::parse($appointment->start_time)->format('H:i');
    		    $end_time = Carbon::parse($appointment->end_time)->format('H:i');

		    $timeSlots[] = [$start_time, $end_time];
		}
		//dd($timeSlots);
		return $timeSlots;
           // return view('pages.rescheduleappointment')->with('apdetails',$apdetails);
}

public function autocomplete(Request $request)
 {
	$query = $request->get('query');
	$doctors = Referer_details::where('referer_name', 'LIKE', "%{$query}%")->pluck('referer_name');
	return response()->json($doctors);
}

}
