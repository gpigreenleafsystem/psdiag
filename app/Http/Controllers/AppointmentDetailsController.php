<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patients;
use App\Models\Referer_details;
use App\Models\Scanning_details;
use App\Models\appointment_details;
use Carbon\Carbon;

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
                 $apdetails= appointment_details::with('patient', 'referer','modality')->get();
		 //            return view('pages.viewappointment')->with('apdetails',$apdetails);
		 return view('pages.viewappointment', compact('apdetails'));
	  }

	  public function vw($id)
         {
		 $apdetails= appointment_details::findOrFail($id);
		 $patient = Patients::findorFail($apdetails->patient_id);
		 $referer = Referer_details::findorFail($apdetails->referer_id);
		 $modality = Scanning_details::findorFail($apdetails->modality_id);
	//            return view('pages.viewappointmentn')->with('apdetails',$apdetailsonerec);
		 return view('pages.viewappointmentn', compact('apdetails', 'patient','referer','modality'));
          }

	  public function reschedule()
         {
            $apdetails= appointment_details::all();
            return view('pages.rescheduleappointment')->with('apdetails',$apdetails);
         }

	 public function addappointment(Request $req){
	//	dd($req);

		 $validatedData = $req->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
	    'gender' => 'required|string|in:male,female',
	    'mobileno'=> 'required|string|min:10|max:10',
	    'address'=> 'required|string|max:500',
            // Add more validation rules as needed
        ]);

		// Check if a patient with the provided mobile number exists
        $patient = Patients::where('mobileno', $validatedData['mobileno'])->first();
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
		'drmobileno'=> 'required|string',
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
	    $doctor->referer_phno = $validatedData['drmobileno'];
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
        //      'date' => 'required|date',
           // 'mobile_number' => 'required|string|unique:referer_details', // Ensure mobile number is unique
            // Add more validation rules as needed
        ]);

	$modality = Scanning_details::where('modality', $validatedData['modality'])->first();
//dd($modality);
//$message = $message + $modality->id;

	$appointment = new appointment_details();
	$appointment->referer_id = $doctor->id;
	$appointment->patient_id = $patient->id;
	$appointment->modality_id = $modality->id;
	$appointment->appointment_status = "SCHEDULED";
	$dt = Carbon::createFromFormat('m/d/Y H:i:s',$validatedData['selected_date'])->format('Y-m-d H:i:s');//Carbon::parse($validatedData['selected_date']);
    	$appointment->appointment_date = $dt; //->format('Y-m-d H:i:s'); //$validatedData['selected_date'];
    // Set other properties as needed
    $appointment->save();

$message = "Appointment added successfully";
        // Return a response
        //return response()->json(['message' => $message], 200);
	    $apdetails= appointment_details::all();
//            return view('pages.viewappointment')->with('apdetails',$apdetails);
		return view('pages.viewappointment', compact('apdetails', 'message'));
	 }

	 public function editappointment($id){
		 $apdetails= appointment_details::findOrFail($id);
		 $patient = Patients::findorFail($apdetails->patient_id);
		 $referer = Referer_details::findorFail($apdetails->referer_id);
		 $modality = Scanning_details::findorFail($apdetails->modality_id);
		 return view('pages.editappointment', compact('apdetails', 'patient','referer','modality'));
	
}
public function updateappointment(Request $request){
	//	dd($request->all());
	$id=$request->id;
	$aptstatus = $request->appointmentstatus;
	$dt = Carbon::createFromFormat('m/d/Y H:i:s',$request->selected_date)->format('Y-m-d H:i:s');//Carbon::parse($validatedData['selected_date']);
appointment_details::where('id','=',$id)->update([
		'appointment_status'=>$aptstatus,
		'appointment_date'=>$dt,
		
]);
 
return redirect()->to('/viewappointment')->with('success','updated sucessfully');
    
}

public function showcalendar()
    {
        $appointments = Appointment::all();
        return view('pages.showcalendar', compact('appointments'));
    }



}
