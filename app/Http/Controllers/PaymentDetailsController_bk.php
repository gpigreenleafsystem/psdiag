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

/*	public function submitTable(Request $request)
	{
		$data = $request->all();
		foreach ($data['id'] as $index => $id) {
			if (isset($data['amount'][$index]) && isset($data['details'][$index]) && isset($data['payment_mode'][$index])) {
				$amount = floatval($data['amount'][$index]);
				$details = $data['details'][$index];
				$paymentMode = $data['payment_mode'][$index];
				part_payment_details::where('id', '=', $id)->update([
					'partpayment_amount' => $amount,
					'payment_details' => $details,
					'payment_mode' => $paymentMode
				]);
				// Save $id, $amount, and $details to the database
			}
		}
		return redirect()->back()->with('success', 'Table submitted successfully!');
}*/

	public function submitTable(Request $request)
	{

		$data = $request->all();
		//dd($data);
		$noInvToupdate = $request->updateinvCount;
		$totalinvCount = $request->totalinvCount;
		//$newInv = $totalinvCount - $noInvToupdate;
		$newInv = $request->newinvcount;
		//dd($request->all());
		//update Investigation details
		$investigationIds = $request->input('investigation_ids');
		//dd(count($investigationIds));
		$modalities = $request->input('modality');
		//for new row addition 
		$study = $request->input('investigation');
		//dd($study);
		$quantities = $request->input('qty');
		$rates = $request->input(key: 'rate');
		$discounts = $request->input(key: 'disc');
		$charges = $request->input('charges');
		$inv_row_edited = $request->input('inv_row_edited');



		// For the investigation details changes update the investigation_details Table
		foreach ($investigationIds as $index => $id) {
			$investigation = Investigation_details::find($id);
			if (isset($inv_row_edited[$index])) {
				/* This row got edited*/
				if (isset($study[$index])) {

					/* investigation got changed update the complete row*/
					$updatedStudy = $study[$index];

					$newStudy = explode(',', $updatedStudy);

					$investigation->modality_id = $newStudy[0];
					$investigation->study = $newStudy[1];
					$investigation->modality_type = $modalities[$index];
					$investigation->qty = $quantities[$index];
					$investigation->rate = $rates[$index];
					$investigation->discount = $discounts[$index];
					$investigation->amount = $charges[$index];
					$investigation->save();
				}
				/* when qty & amount got changed*/
				if ((isset($quantities[$index]) && (isset($charges[$index])))) {
					/* update the Qty and Amount only*/
					$investigation->qty = $quantities[$index];
					$investigation->amount = $charges[$index];
					$investigation->save();
				}
				//when rate & amount got chnaged*/
				if ((isset($rates[$index])) && (isset($charges[$index]))) {
					/* update the rate and Amount only*/
					$investigation->rate = $rates[$index];
					$investigation->amount = $charges[$index];
					$investigation->save();
				}
				//when discount & amount got changed//
				if ((isset($discounts[$index])) || (isset($charges[$index]))) {
					$investigation->discount = $discounts[$index];
					$investigation->amount = $charges[$index];
					$investigation->save();
				}
				//when Qty,amount,discount ,rates got changed
				if ((isset($quantities[$index]) && (isset($rates[$index])) && (isset($discounts[$index])) && (isset($charges[$index])))) {
					/* update the Qty and Amount only*/
					$investigation->qty = $quantities[$index];
					$investigation->discount = $discounts[$index];
					$investigation->rate = $rates[$index];
					$investigation->amount = $charges[$index];
					$investigation->save();
				}
			}

			// if (isset($charges[$index])) {
			// 	$investigation->amount = $charges[$index];
			// 	//$investigation->save();
			// }
		}
		/* for the new Investigation.
		 	1. Add in Investigation table
			2. get the Investigation id and Concate with bill_details table required_investigation col
		 */
		$tmp_inv_id = [];
		//dd($totalinvCount);
		if ($newInv > 0) {
			//	dd($newInv);
			for ($i = $noInvToupdate; $i < $totalinvCount; $i++) {
				//dd($i);
				//$i = $i + 1;
				//dd($i);
				$investigation = new Investigation_details;
				$updatedStudy = $study[$i];
				$newStudy = explode(',', $updatedStudy);
				$investigation->modality_id = $newStudy[0];
				$investigation->study = $newStudy[1];

				$investigation->modality_type = $modalities[$i];

				$investigation->qty = $quantities[$i];
				$investigation->discount = $discounts[$i];
				$investigation->amount = $charges[$i];
				$investigation->rate = $charges[$i] - $discounts[$i];
				$investigation->payment_status = "pending";
				$investigation->report_status = "pending";
				$investigation->scanning_status = "pending";
				$investigation->bill_id = $request->billid;
				//dd($investigation);
				$investigation->save();
				$investigation_id = $investigation::orderBy('id', 'DESC')->first();
				//dd($investigation_id);
				$tmp_inv_id[] = $investigation_id->id;
			}
		}



		/* Part_payment_details*/
		/*for each payment update the payment changes*/
		/* 1. Add all paid amount update in part_payment_details table
		   2. caluate total paid amount update in bill_details
		   3. calculate the due_amount update in bill_details */



		//update bill_details

		$last_payment_details = "";
		foreach ($data['id'] as $index => $id) {
			if (isset($data['amount'][$index]) && isset($data['details'][$index]) && isset($data['payment_mode'][$index])) {
				$amount = floatval($data['amount'][$index]);
				$details = $data['details'][$index];
				$paymentMode = $data['payment_mode'][$index];
				part_payment_details::where('id', '=', $id)->update([
					'partpayment_amount' => $amount,
					'payment_details' => $details,
					'payment_mode' => $paymentMode
				]);
				$last_payment_details = $details;
				// Save $id, $amount, and $details to the database
			}
		}
		/* update the bill_details with bill_no
		 	1.bill_amount = total of all Investigations bill_amoount(without discount)
			2.bill_discount= total of all Investigations discount
			3.net_amount= total of all Ibvestigations bill_amount (with discount)
			4.paid_amount=
			  "billTotal" => "17700"
  "billPaidAmt" => "10000"
  "billDueAmt" => "7700"

		*/
		$bill_no_toupdate = $request->billno;
		//	dd($bill_no_toupdate);
		$bill = Bill_details::where('bill_no', $bill_no_toupdate)->first();
		//to concat the new investigation
		if ($newInv > 0) {
			$req_investigations = $bill->required_investigations;
			$lennewinv = count($tmp_inv_id);

			for ($index = 0; $index < $lennewinv; $index++) {
				$req_investigations .= ',' . $tmp_inv_id[$index]; // Assuming $req_investigations is a string
			}
			Bill_details::where('bill_no', '=', $bill_no_toupdate)->update([
				'bill_amount' => $request->totalRate,
				'bill_discount' => $request->totalDiscount,
				'netamount' => $request->billTotal,
				'paid_amount' => $request->billPaidAmt,
				'due_amount' => $request->billDueAmt,
				'required_investigations' => $req_investigations,
				'payment_details' => $last_payment_details
			]);
		} else {
			Bill_details::where('bill_no', '=', $bill_no_toupdate)->update([
				'bill_amount' => $request->totalRate,
				'bill_discount' => $request->totalDiscount,
				'netamount' => $request->billTotal,
				'paid_amount' => $request->billPaidAmt,
				'due_amount' => $request->billDueAmt,
				'payment_details' => $last_payment_details
			]);
		}
		return redirect()->back()->with('success', 'Table submitted successfully!');
	}
}
