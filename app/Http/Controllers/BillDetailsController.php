<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\appointment_details;
use App\Models\Patients;
use App\Models\Referer_details;
use App\Models\Scanning_details;
use App\Models\Investigation_details;

class BillDetailsController extends Controller
{
	//
	public function index(){
                 $apdetails = appointment_details::all();
        return view('pages.startbilling', compact('apdetails'));
        }
	public function newbill($id){
		$apdetails = appointment_details::findOrFail($id);
		$patient = Patients::findorFail($apdetails->patient_id);
                 $referer = Referer_details::findorFail($apdetails->referer_id);
                 $modality = Scanning_details::findorFail($apdetails->modality_id);
                 return view('pages.newbilling', compact('apdetails', 'patient','referer','modality'));
//        return view('pages.newbilling', compact('apdetails'));
	}
	public function createnewbill(Request $request){
		//dd($request->all());
		//dd($request->all());
		$patient_name=$request['bill_pt_name'];
		$patient_no=$request['bill_pt_no'];
		$patient_age= $request['bill_pt_age'];
		$patient_gender =$request['bill_pt_gender'];
		$patient_address=$request['bill_pt_address'];
		$patient_ref_name=$request['bill_ref_name'];
		$patient_ref_no=$request['bill_ref_phno'];
		$patient_apt_date=$request['bill_apt_date'];
		$patient_apt_status=$request['bill_apt_status'];
		$patient_no_apt= $request['bill_no_apt'];
		$no_apts= $request['apt_no'];
		$inv_type_sel=$request['inv_type1'];
		$sub_inv_type_sel=$request['sub_inv_type1'];
		$rate_sel=$request['rate1'];
		$qty_sel=$request['qty1'];
		$amount_sel=$request['amount1'];
		$discount_sel=$request['discount1'];

		$investigation = new Investigation_details();
		$investigation->modality_id =1;

				$investigation->study=$sub_inv_type_sel;
				        $investigation->rate = $rate_sel;
				        $investigation->qty = $qty_sel;
						$investigation->discount = $discount_sel;
					$investigation->amount = $amount_sel;
					$investigation->payment_status='not paid';
					$investigation->scanning_status='not scanned';
					$investigation->report_status='not done';
							
						        // Save patient details
						$investigation->save();

       /* for ($i = 1; $i <= $no_apts; $i++) {
		$inv_typ_list = 'inv_type' . $i;
		$inv_type_sel = $request->input($inv_typ_list);
		$sub_inv_type='sub_inv_type'.$i;
		$sub_inv_type_sel=$request->input($sub_inv_type);
		$rate = 'rate' . $i;
		$rate_sel = $request->input($rate);
			$qty = 'qty' . $i;
		$qty_sel = $request->input($qty_sel);
		$discount = 'discount' . $i;
		$discount_sel = $request->input($discount);
		$amount = 'amount' . $i;
		$amount_sel = $request->input($amount);
	$investigation = new Investigation_details;
		$investigation->modality_id = $inv_type_sel;
		$investigation->study=$sub_inv_type_sel;
        $investigation->rate = $rate_sel;
        $investigation->qty = $qty_sel;
	$investigation->discount = $discount_sel;
	$investigation->amount = $amount_sel;
	
        // Save patient details
	$investigation->save();}*/
		

	}}
