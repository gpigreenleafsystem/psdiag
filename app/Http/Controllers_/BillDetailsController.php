<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\appointment_details;
use App\Models\Patients;
use App\Models\Referer_details;
use App\Models\Scanning_details;
use App\Models\Investigation_details;
use App\Models\Bill_details;
use Carbon\Carbon;

class BillDetailsController extends Controller
{
	//
	public function index()
	{
		//$apdetails = appointment_details::all();
		//return view('pages.startbilling', compact('apdetails'));
		$apdetails_info = appointment_details::all();

		foreach ($apdetails_info as $data) {
			$patientdetails = $this->getPatientNameNo($data->patient_id);
			$parts = explode(',', $patientdetails);
			$aptInfos[] = [
				'id' => $data->id,
				'patientName' => $parts[0],
				'patientNo' => $parts[1],
				'aptdate' => $data->appointment_date,
				'aptstatus' => $data->appointment_status,
				'billstatus' => $this->checkAppointmentId($data->id),
				'bill_no' => $this->getBillNo($data->id),
			];
		}
		return view('pages.startbilling', compact('aptInfos'));
	}
	public function newbill($id)
	{
		$apdetails = appointment_details::findOrFail($id);
		$patient = Patients::findorFail($apdetails->patient_id);
		$referer = Referer_details::findorFail($apdetails->referer_id);
		$modality = Scanning_details::findorFail($apdetails->modality_id);
		return view('pages.newbilling', compact('apdetails', 'patient', 'referer', 'modality'));
		//        return view('pages.newbilling', compact('apdetails'));
	}
	public function createnewbill(Request $request)
	{

		$patient_name = $request['bill_pt_name'];
		$patient_no = $request['bill_pt_contactno'];
		$patient_age = $request['bill_pt_age'];
		$patient_gender = $request['bill_pt_gender'];
		$patient_address = $request['bill_pt_address'];
		$patient_ref_name = $request['bill_ref_name'];
		$patient_ref_no = $request['bill_ref_phno'];
		$patient_apt_date = $request['bill_apt_date'];
		$patient_apt_status = $request['bill_apt_status'];
		$apt_id = $request['apt_id'];
		$total_amount = $request['totalAmount'];
		$billamount = $request['billedamount'];
		$billdiscount = $request['billdiscount'];
		$no_invest = $request['rowcounting'];
		$required_investigations = "";
		$previous_investigation = "";
		$billNo = $this->generateBillNo();
		//dd($billNo);
		$bill = new Bill_details;
		$bill->patient_phoneno = $patient_no;
		$bill->appointment_id = $apt_id;
		$bill->required_investigations = "0";
		$bill->paymentids = 0;
		$bill->netamount = $total_amount;
		$bill->bill_amount = $billamount;
		$bill->bill_discount = $billdiscount;
		$bill->generated_by = $request['gen_by'];
		$bill->bill_no = $billNo;
		$bill->save();
		$bill_id = $bill::latest()->first();
		$billId = $bill_id->id;

		$tmp = '';
		for ($i = 1; $i <= $no_invest; $i++) {
			$scan = 'scantype-' . $i;
			$investigation = $request['investigation-' . $i];
			$parts = explode(',', $investigation);
			$modality_id = $parts[0];
			$study = $parts[1];
			$scan_type = $request['scantype-' . $i];
			$rate = $request['rate-' . $i];
			$qty = $request['qty-' . $i];
			$discount = $request['discount-' . $i];
			$amount = $request['amount-' . $i];

			$investigation = new Investigation_details;
			$investigation->modality_id = $modality_id;
			$investigation->study = $study;
			$investigation->rate = $rate;
			$investigation->qty = $qty;
			$investigation->discount = $discount;
			$investigation->amount = $amount;
			$investigation->payment_status = "Pending";
			$investigation->report_status = "pending";
			$investigation->scanning_status = "pending";
			$investigation->bill_id = $billId;
			$investigation->appmt_date = $request['apt_date'];
			$investigation->modality_type = $scan_type;
			$investigation->save();
			$investigation_id = $investigation::orderBy('id', 'DESC')->first();

			$tmp .= $investigation_id->id;


			if ($i < $no_invest) {
				$tmp .= ", ";
			}
		}

		//update the investigation in Bill_details;
		Bill_details::where('id', '=', $billId)->update([
			'required_investigations' => $tmp,
		]);

		return redirect()->to('/newpayment/' . $billId);
	}

	private function generateBillNo()
	{
		$date = Carbon::now()->format('ymd');
		$latestBill = Bill_details::orderBy('id', 'desc')->first();

		if (!$latestBill) {
			return $date . "001";
		}

		$latestBillNo = $latestBill->bill_no;
		$latestNumber = (int) substr($latestBillNo, 6);

		$newNumber = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT);
		return  $date . $newNumber;
	}
	public function getBillNo($appointment_id)
	{
		$billNumber = Bill_details::getBillNumberByAppointmentId($appointment_id);
		return $billNumber;
	}

	public function checkAppointmentId($appointment_id)
	{
		// Check if appointment_id exists in the bill_details table
		$exists = bill_details::where('appointment_id', $appointment_id)->exists();
		return $exists;
	}
	public function getPatientNameNo($patient_id)
	{
		$patient = Patients::findorFail($patient_id);

		return $patient->name . ',' . $patient->mobileno;
	}
}

