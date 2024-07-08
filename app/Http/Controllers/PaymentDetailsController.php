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
			$message = "Total amount= " . $totamount . " Paid amount=" . $paid . " Balance amount=". $bal; 
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
	
	$partialPaymentDetail->payment_mode = $request->input('payment_method');
        $partialPaymentDetail->payment_details = $request->input('payment_details');
	$partialPaymentDetail->partpayment_amount = $request->input('partial_amount');
        $partialPaymentDetail->payment_status = $request->input('payment_status');
	$partialPaymentDetail->bill_no = $request->input('bill_no');

        // Save the new record to the database
	$partialPaymentDetail->save();

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
                        $payids= $payments;
                        //dd($payments);
                        foreach ($payids as $payment) {
                                $paid= $paid + $payment->partpayment_amount;

                                $bal=$totamount - $paid;

                        }
			$lastpaid = part_payment_details::where('bill_no', $id)->orderBy('id', 'DESC')->first();
		//	dd($lastpaid);
		$bd = new BillData();
		$bd->Patient_name= $patient->name;
			$bd->Patient_age =$patient->age;
			$bd->gender =$patient->gender;
			$bd->drref = $ref->referer_name;
			$bd->bill_no = $bill->id;
			$bd->netamount = $bill->netamount;
			$bd->partialpaymentamount = $lastpaid->partpayment_amount;
			$bd->partialpaymentdate = $lastpaid->created_at;
			$bd->totpaidamount = $paid;
			$bd->balanceamount = $bal;
			$bd->paymentdetails = $lastpaid-> payment_details;
			
			$inv= Investigation_details::where('bill_id',$bill->id)
			->leftJoin('scanning_details', 'investigation_details.modality_id', '=', 'scanning_details.id')
			->select('scanning_details.*','investigation_details.*')
			->get();
		      // dd($inv);

			$bd->scanningdetails=$inv;

			
			$invoice_date = Carbon::now()->format('d-m-Y');//date('jS F Y', strtotime($order->invoice_date)); 
	   
   $pdf = PDF::loadView('invoice_template1',array('order'=>$bd));
   return $pdf->download('Invoice_'.config('app.name').'_Order_No # '.$id.' Date_'.$invoice_date.'.pdf');


	}
}
