<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment_details;
use App\Models\Bill_details;
use App\Models\part_payment_details;
use App\Models\appointment_details;
use App\Models\Patients;
use App\Models\Referer_details;
use App\Models\Investigation_details;
use Carbon\Carbon;
use PDF;
use App\Providers\BillData;

class PaymentDetailsController extends Controller
{

	public function index($id){
		$message="";
		$bill = Bill_details::where('id', $id)->first();
		//		$payments= payment_details::find($id);
		$payments =part_payment_details::where('bill_no', $id)->get();
		$totamount =$bill->netamount;$bal =0;$paid=0;
		if(sizeof($payments)!=0){
		/*if(isEmpty($payments->part_payment_id))
			$message="PAYMENT NOT DONE"+" PAYMENT DUE= "+$totamount;
		else{*/
			$message="PART OR FULL PAYMENT DONE";
			$bal =0;$paid=0;
			$payids= $payments; //explode(",",$payments->part_payment_id);
			//dd($payments);
			foreach ($payids as $payment) {
            		// Fetch payment data for each payment ID using Eloquent
			//	$payment = partpayment_details::find($paymentId);
				$paid= $paid + $payment->partpayment_amount;

            		// Process the fetched payment data as needed
            		//if ($payment) {
				// Example: Print the payment data
				
                	$message= $message."Payment ID: " . $payment->id . ", Amount: " . $payment->part_amount . "<br>";
		//}
				$bal=$totamount - $paid;

			}	
			$message = "Total amount= " . $totamount . "," . " Paid amount=" . $paid . "," . " Balance amount=" . $bal;
			//$message = "Total amount= " . $totamount . " Paid amount=" . $paid . " Balance amount=". $bal; 
		}
		else{
			$message="PAYMENT NOT DONE"." PAYMENT DUE= ".$totamount;
			$bal=$totamount;
		}

		
return view('pages.newpayment', compact('payments', 'message', 'bal','paid','totamount','bill'));


	}

    public function processPayment(Request $request)
{

	$partialPaymentDetail = new part_payment_details(); 
        // Set the fields with the request data
	$partialPaymentDetail->payment_type = $request->input('payment_mode');
	$partialPaymentDetail->payment_mode = $request->input('payment_method');
        $partialPaymentDetail->payment_details = $request->input('payment_details');
	$partialPaymentDetail->partpayment_amount = $request->input('partial_amount');
        $partialPaymentDetail->payment_status = $request->input('payment_status');
	$partialPaymentDetail->bill_no = $request->input('bill_no');

        // Save the new record to the database
	$partialPaymentDetail->save();
	$payment_id = $partialPaymentDetail::latest()->first();
		$payment_id = $payment_id->id;

	Bill_details::where('id', '=', $request->input('bill_no'))->update([
			'paid_amount' =>  $request->input('paid_amt') + $request->input('partial_amount'),
			'payment_mode' => $request->input('payment_method'),
			'payment_details' => $request->input('payment_details'),
			'amt_paid_date' => Carbon::now(),
			'due_amount' => abs($request->input('partial_amount') - $request->input('bal_amt')),
			'paymentids' => $payment_id

		]);


		return redirect('/newpayment/'.$request->input('bill_no'));

    }
	public function download_invoice($id){
                $message="";
		$bill = Bill_details::where('id', $id)->first();
		$appt= appointment_details::where('id',$bill->appointment_id)->first();
		
		$patient = Patients::where('id',$appt->patient_id)->first();
		$ref = Referer_details::where('id', $appt->referer_id)->first();
		$payments =part_payment_details::where('bill_no', $id)->get();
		$bal =0;$paid=0;$totamount =$bill->netamount;
		$part_payment_details = "";
                        $payids= $payments;
                        //dd($payments);
                        foreach ($payids as $payment) {
                                $paid= $paid + $payment->partpayment_amount;

				$bal=$totamount - $paid;
				$part_payment_details = $payment->payment_details . "-" . $payment->partpayment_amount . "/" . $part_payment_details;

                        }
			$lastpaid = part_payment_details::where('bill_no', $id)->orderBy('id', 'DESC')->first();
		//	dd($lastpaid);
		$bd = new BillData();
		$bd->Patient_name= $patient->name;
			$bd->Patient_age =$patient->age;
			$bd->gender =$patient->gender;
			$bd->drref = $ref->referer_name;
			$bd->bill_no = $bill->bill_no;
		//	$bd->netamount = $bill->netamount;
			$bd->netamount=$bill->bill_amount;
			//$bd->partialpaymentamount = $lastpaid->partpayment_amount;
			$bd->partialpaymentamount=$bill->netamount;
			$bd->partialpaymentdate = $lastpaid->created_at;
			//$bd->totpaidamount = $paid;
			//$bd->balanceamount = $bal;
			//$bd->paymentdetails = $lastpaid-> payment_details;
			$bd->totpaidamount=$bill->paid_amount;
			$bd->balanceamount=$bill->due_amount;
			$bd->paymentdetails=$part_payment_details;
			$bd->payment_mode = $bill->payment_mode;
			$bd->generated_by = $bill->generated_by;
			$bd->discount = $bill->bill_discount;
			
//dd($bd);			
			$inv= Investigation_details::where('bill_id',$bill->id)
			->leftJoin('scanning_details', 'investigation_details.modality_id', '=', 'scanning_details.id')
			->select('scanning_details.*','investigation_details.*')
			->get();
		      // dd($inv);

		$bd->scanningdetails=$inv;
			//dd($bd);


			
			$invoice_date = Carbon::now()->format('d-m-Y');//date('jS F Y', strtotime($order->invoice_date)); 
	   
		
				$pdf = PDF::loadView('invoice_template', array('order' => $bd));
  return $pdf->stream('Invoice_'.config('app.name').'_Order_No # '.$id.' Date_'.$invoice_date.'.pdf');


	}

	public function getData(Request $request)
    {
	    $payments =part_payment_details::paginate(15);

	return view('pages.viewpayments', compact('payments'));
    }

	
	public function editpayment($id)
	{
    	$partPayment = part_payment_details::findOrFail($id);
    	return view('pages.editpayment', compact('partPayment'));
	}

	public function updatepayment(Request $request, $id)
	{
	//	dd($request);
    	$request->validate([
        'payment_mode' => 'required',
       // 'bill_no' => 'required',
       // 'payment_status' => 'required',
        'partpayment_amount' => 'required|numeric',
        'payment_details' => 'nullable|string',
    ]);

	$partPayment = part_payment_details::findOrFail($id);
//	dd($partPayment);
    	$partPayment->update($request->all());

    return redirect()->route('paymentlist')->with('message', 'Part payment updated successfully!');
}

public function getAllBill(Request $request)
	{
		$allBills = Bill_details::orderBy('created_at', 'DESC')->paginate(10);
		return view('pages.billList', compact('allBills'));
	}
	public function editBillPayment(Request $request, $id)
	{
		//dd($id);
		//Get all Bill details and payment details
		$bill = Bill_details::where('id', $id)->first();
		$appt = appointment_details::where('id', $bill->appointment_id)->first();
		$patient = Patients::where('id', $appt->patient_id)->first();
		$ref = Referer_details::where('id', $appt->referer_id)->first();
		$payments = part_payment_details::where('bill_no', $bill->id)->get();
		$bd = new BillData();
		$bd->Patient_name = $patient->name;
		$bd->Patient_age = $patient->age;
		$bd->gender = $patient->gender;
		$bd->drref = $ref->referer_name;
		$bd->bill_no = $bill->bill_no;
		$bd->generated_by = $bill->generated_by;
		$bd->billamount = $bill->bill_amount;/* bill without discount*/
		$bd->netamount = $bill->netamount;
		$bd->totpaidamount = $bill->paid_amount;
		$bd->balanceamount = $bill->due_amount;
		$bd->bill_id = $id;

		$bd->bill_date = Carbon::createFromFormat('Y-m-d H:i:s', $bill->created_at)->format('d/m/Y H:i:s');

		$inv = Investigation_details::where('bill_id', $id)
			->leftJoin('scanning_details', 'investigation_details.modality_id', '=', 'scanning_details.id')
			->select('scanning_details.*', 'investigation_details.*')
			->get();


		$bd->scanningdetails = $inv;
		return view('pages.editBill', compact('bd', 'payments'));
	}



	public function submitTable(Request $request)
	{
		$data = $request->all();
		$noInvToupdate = $request->updateinvCount;
		$totalinvCount = $request->totalinvCount;
		$newInv = $request->newinvcount;

		$investigationIds = $request->input('investigation_ids');
		$modalities = $request->input('modality');
		$study = $request->input('investigation');
		$quantities = $request->input('qty');
		$rates = $request->input('rate');
		$discounts = $request->input('disc');
		$charges = $request->input('charges');
		$inv_row_edited = $request->input('inv_row_edited');

		// Update existing investigations
		$this->updateInvestigations($investigationIds, $modalities, $study, $quantities, $rates, $discounts, $charges, $inv_row_edited);

		// Add new investigations
		$tmp_inv_id = $this->addNewInvestigations($noInvToupdate, $totalinvCount, $study, $modalities, $quantities, $discounts, $charges, $request->billid, $newInv);

		// Handle part payments
		$last_payment_details = $this->handlePartPayments($request, $tmp_inv_id);

		// Update bill details
		$this->updateBillDetails($request, $tmp_inv_id, $newInv, $last_payment_details);

		return redirect()->back()->with('success', 'Table submitted successfully!');
	}

	private function updateInvestigations($investigationIds, $modalities, $study, $quantities, $rates, $discounts, $charges, $inv_row_edited)
	{
		foreach ($investigationIds as $index => $id) {
			$investigation = Investigation_details::find($id);
			if (isset($inv_row_edited[$index])) {
				if (isset($study[$index])) {
					$updatedStudy = explode(',', $study[$index]);
					$investigation->modality_id = $updatedStudy[0];
					$investigation->study = $updatedStudy[1];
					$investigation->modality_type = $modalities[$index];
				}
				$investigation->qty = $quantities[$index] ?? $investigation->qty;
				$investigation->rate = $rates[$index] ?? $investigation->rate;
				$investigation->discount = $discounts[$index] ?? $investigation->discount;
				$investigation->amount = $charges[$index] ?? $investigation->amount;
				$investigation->save();
			}
		}
	}


	private function addNewInvestigations($noInvToupdate, $totalinvCount, $study, $modalities, $quantities, $discounts, $charges, $billId, $newInv)
	{
		$tmp_inv_id = [];
		if ($newInv > 0) {
			for ($i = $noInvToupdate; $i < $totalinvCount; $i++) {
				$updatedStudy = explode(',', $study[$i]);
				$modality_id = $updatedStudy[0];
				$study_name = $updatedStudy[1];

				// Check if the investigation already exists
				$existingInvestigation = Investigation_details::where('modality_id', $modality_id)
					->where('study', $study_name)
					->where('bill_id', $billId) // Assuming you want to check within the same bill
					->first();

				if (!$existingInvestigation) {
					// Create a new investigation since it doesn't exist
					$investigation = new Investigation_details;
					$investigation->modality_id = $modality_id;
					$investigation->study = $study_name;
					$investigation->modality_type = $modalities[$i];
					$investigation->qty = $quantities[$i];
					$investigation->discount = $discounts[$i];
					$investigation->amount = $charges[$i];
					$investigation->rate = $charges[$i] - $discounts[$i];
					$investigation->payment_status = "pending";
					$investigation->report_status = "pending";
					$investigation->scanning_status = "pending";
					$investigation->bill_id = $billId;
					$investigation->save();
					$tmp_inv_id[] = $investigation->id;
				} else {
					// Optionally handle the case where the investigation already exists
					// e.g., log a message, update some fields, or skip.
				}
			}
		}
		return $tmp_inv_id;
	}


	private function handlePartPayments(Request $request, $tmp_inv_id)
	{
		$paymentResult = $this->processNewPayments($request); // Process new payments
		$this->updateExistingPayments($request);
		return $paymentResult; // Return payment result
	}

	private function processNewPayments(Request $request)
	{
		$totalpayrow = $request->oldPayRow + $request->newpaycount;
		$last_payment_details = "";
		$lastpaymentid = null;

		if ($request->newpaycount > 0) {
			for ($i = $request->oldPayRow; $i < $totalpayrow; $i++) {
				$partialPaymentDetail = new part_payment_details();
				$partialPaymentDetail->payment_type = "2";
				$partialPaymentDetail->payment_mode = $request->input('payment_mode')[$i];
				$partialPaymentDetail->payment_details = $request->input('details')[$i];
				$last_payment_details = $request->input('details')[$i];
				$partialPaymentDetail->partpayment_amount = $request->input('amount')[$i];
				$partialPaymentDetail->payment_status = "PAID";
				$partialPaymentDetail->bill_no = $request->input('billid');
				$partialPaymentDetail->save();
				$lastpaymentid = $partialPaymentDetail->id; // Get the last payment ID
			}
		}
		return ['last_payment_details' => $last_payment_details, 'lastpaymentid' => $lastpaymentid]; // Return both values
	}


	private function updateExistingPayments(Request $request)
	{
		if ($request->oldPayRow > 0) {
			foreach ($request->input('id') as $index => $id) {
				if ($request->payEdited[$index] == 1) {
					$amount = floatval($request->input('amount')[$index]);
					$details = $request->input('details')[$index];
					$paymentMode = $request->input('payment_mode')[$index];

					part_payment_details::where('id', $id)->update([
						'partpayment_amount' => $amount,
						'payment_details' => $details,
						'payment_mode' => $paymentMode
					]);
				}
			}
		}
	}

	private function updateBillDetails(Request $request, $tmp_inv_id, $newInv, $paymentResult)
	{
		$last_payment_details = $paymentResult['last_payment_details'];
		$lastpaymentid = $paymentResult['lastpaymentid'];

		$bill_no_toupdate = $request->billno;
		$bill = Bill_details::where('bill_no', $bill_no_toupdate)->first();
		$req_investigations = $bill->required_investigations;

		if ($newInv > 0) {
			foreach ($tmp_inv_id as $invId) {
				$req_investigations .= ',' . $invId;
			}
		}

		$updateData = [
			'bill_amount' => $request->totalRate,
			'bill_discount' => $request->totalDiscount,
			'netamount' => $request->billTotal,
			'paid_amount' => $request->billPaidAmt,
			'due_amount' => $request->billDueAmt,
			'payment_details' => $last_payment_details,
		];

		// Update paymentids only if a new payment was added
		if ($lastpaymentid) {
			$updateData['paymentids'] = $lastpaymentid;
		}

		Bill_details::where('bill_no', $bill_no_toupdate)->update($updateData);
	}

		public function viewBillPayment(Request $request, $id)
	{
		//dd($id);
		//Get all Bill details and payment details
		$bill = Bill_details::where('id', $id)->first();
		$appt = appointment_details::where('id', $bill->appointment_id)->first();
		$patient = Patients::where('id', $appt->patient_id)->first();
		$ref = Referer_details::where('id', $appt->referer_id)->first();
		$payments = part_payment_details::where('bill_no', $bill->id)->get();
		$bd = new BillData();
		$bd->Patient_name = $patient->name;
		$bd->Patient_age = $patient->age;
		$bd->gender = $patient->gender;
		$bd->drref = $ref->referer_name;
		$bd->bill_no = $bill->bill_no;
		$bd->generated_by = $bill->generated_by;
		$bd->billamount = $bill->bill_amount;/* bill without discount*/
		$bd->netamount = $bill->netamount;
		$bd->totpaidamount = $bill->paid_amount;
		$bd->balanceamount = $bill->due_amount;
		$bd->bill_id = $id;

		$bd->bill_date = Carbon::createFromFormat('Y-m-d H:i:s', $bill->created_at)->format('d/m/Y H:i:s');

		$inv = Investigation_details::where('bill_id', $id)
			->leftJoin('scanning_details', 'investigation_details.modality_id', '=', 'scanning_details.id')
			->select('scanning_details.*', 'investigation_details.*')
			->get();


		$bd->scanningdetails = $inv;
		return view('pages.viewBill', compact('bd', 'payments'));
	}
}
