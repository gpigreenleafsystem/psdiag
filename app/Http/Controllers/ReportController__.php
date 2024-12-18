<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Bill_details;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Reports\MyReport;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
public function __contruct()
    {
        $this->middleware("guest");
    }
   
 
/*public function index(Request $request)
    {

//dd("hi");	    
	    $startDate =   Carbon::now()->format('MM/DD/YYYY');;
        $endDate =   Carbon::now()->format('MM/DD/YYYY');

       if ($request->ajax()) {

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $startDate = $request->from_date;
                $endDate = $request->to_date;
            }
	           $data = DB::select(
                'SELECT DISTINCT(bill_details.bill_no),bill_details.id as billid, bill_details.created_at as bill_date, patients_details.name, patients_details.age, patients_details.gender, patients_details.mobileno, referer_details.referer_name, 
        appointment_details.modality_id as scantype,bill_details.bill_amount, bill_details.bill_discount, 
        bill_details.netamount,bill_details.paid_amount,bill_details.due_amount,bill_details.amt_paid_date as paid_date, bill_details.payment_details,bill_details.generated_by
        FROM bill_details, patients_details, appointment_details, referer_details
	WHERE 
	bill_details.appointment_id = appointment_details.id 
	AND appointment_details.patient_id = patients_details.id
        AND appointment_details.referer_id = referer_details.id 
        AND appointment_details.patient_id = patients_details.id 
        AND 

           DATE(bill_details.created_at) BETWEEN ? AND ?',
                [$startDate, $endDate]
	   );

           
            foreach ($data as $row) {
                $payments = DB::select(
                    "SELECT SUM(partpayment_amount) as total_amount, payment_mode 
                     FROM part_payment_details 
                     WHERE bill_no = ? 
                     GROUP BY payment_mode",
                    [$row->billid]
                );

                $row->cash_amount = 0;
                $row->cheque_amount = 0;
                $row->cc_amount = 0;
                $row->net_banking_amount = 0;
                $row->upi_amount = 0;

                foreach ($payments as $payment) {
                    // echo $payment->payment_mode;
                    //echo $payment->total_amount;
                    if ($payment->payment_mode == 'cash') {
                        $row->cash_amount = $row->cash_amount + $payment->total_amount;
                    } elseif ($payment->payment_mode == 'cheque') {
                        $row->cheque_amount = $row->cheque_amount + $payment->total_amount;
                    } elseif ($payment->payment_mode == 'debit_card') {
                        $row->cc_amount = $row->cc_amount + $payment->total_amount;
                    } elseif ($payment->payment_mode == 'netbanking') {
                        $row->net_banking_amount = $row->net_banking_amount + $payment->total_amount;
                    } elseif ($payment->payment_mode == 'upi') {
                        $row->upi_amount = $row->upi_amount + $payment->total_amount;
                    }
                }
            }
            return Datatables::of($data)
		      ->addIndexColumn()
                ->make(true);
        }

        return view('pages.reports');
}*/
/*public function index(Request $request)
    {

       $startDate =   Carbon::now()->format('MM/DD/YYYY');;

        $endDate =   Carbon::now()->format('MM/DD/YYYY');
//dd($startDate);
//$startDate="2024-09-10";
//$endDate="2024-09-11";
$rearrangedData = [];
        if ($request->ajax()) {

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $startDate = $request->from_date;
                $endDate = $request->to_date;
	    }
	//dd($startDate);
	//dd($endDate);
       /*     $data = DB::select(
                'SELECT ROW_NUMBER() OVER (ORDER BY bd.created_at ASC) as sno, bd.bill_no,bd.id as billid,
        bd.created_at As bill_date,pd.name, pd.mobileno,pd.gender ,pd.age,
        rd.referer_name,
        GROUP_CONCAT(ind.study SEPARATOR ", ") AS modalitytype,
        CASE WHEN ad.modality_id=1 THEN "CT" ELSE "MR" END AS scan_type,
        COALESCE(FORMAT(IFNULL(bd.bill_amount as billamount,0),2),0.00),   
        FORMAT(IFNULL(bd.netamount AS netamount,0),2),
        FORMAT(IFNULL(bd.bill_discount,0),2) as bill_discount,
        FORMAT(IFNULL(SUM(ppd.partpayment_amount), 0),2) AS paidamount,
        FORMAT((bd.netamount - IFNULL(SUM(ppd.partpayment_amount), 0)),2) AS balanceamount,
        GROUP_CONCAT(ppd.payment_details ORDER BY ppd.payment_details ASC SEPARATOR ", ") AS paymentdetails,
        bd.generated_by
        FROM bill_details AS bd
        LEFT JOIN part_payment_details AS ppd ON ppd.bill_no = bd.id
        JOIN appointment_details AS ad ON bd.appointment_id = ad.id
        JOIN patients_details AS pd ON ad.patient_id = pd.id
        JOIN referer_details AS rd ON ad.referer_id = rd.id
        LEFT JOIN investigation_details AS ind ON FIND_IN_SET(ind.id, bd.required_investigations)
        where DATE(bd.created_at) BETWEEN ? AND ?
        GROUP BY bd.id ',
                [$startDate, $endDate]

       );*/
  /*     $data = DB::select('
	       SELECT
    ROW_NUMBER() OVER (ORDER BY bd.created_at ASC) AS sno,
    bd.bill_no,
    bd.id AS billid,
    bd.created_at AS bill_date,
    pd.name,
    pd.mobileno,
    pd.gender,
    pd.age,
    rd.referer_name,
    GROUP_CONCAT(ind.study SEPARATOR ", ") AS modalitytype,
    CASE WHEN ad.modality_id = 1 THEN "CT" ELSE "MR" END AS scan_type,
    FORMAT(COALESCE(bd.bill_amount, 0), 2) AS billamount,
    FORMAT(COALESCE(bd.netamount, 0), 2) AS netamount,
    FORMAT(COALESCE(bd.bill_discount, 0), 2) AS bill_discount,
    FORMAT(COALESCE(SUM(ppd.partpayment_amount), 0), 2) AS paidamount,
    FORMAT(COALESCE(bd.netamount - SUM(ppd.partpayment_amount), 0), 2) AS balanceamount,
    GROUP_CONCAT(ppd.payment_details ORDER BY ppd.payment_details ASC SEPARATOR ", ") AS paymentdetails,
    bd.generated_by
FROM
    bill_details AS bd
LEFT JOIN
    part_payment_details AS ppd ON ppd.bill_no = bd.id
JOIN
    appointment_details AS ad ON bd.appointment_id = ad.id
JOIN
    patients_details AS pd ON ad.patient_id = pd.id
JOIN
    referer_details AS rd ON ad.referer_id = rd.id
LEFT JOIN
    investigation_details AS ind ON FIND_IN_SET(ind.id, bd.required_investigations)
WHERE
    DATE(bd.created_at) BETWEEN ? AND ?
GROUP BY
    bd.id',[$startDate, $endDate]);
dd($data);
            foreach ($data as $row) {


                $payments = DB::select(
                    "SELECT partpayment_amount as total_amount, payment_mode,payment_details as paydet
                             FROM part_payment_details
                             WHERE bill_no = ?
                             ",
                    [$row->billid]
                );

                $paid = 0.00;
                $row->cash_amount = 0.00;
                $row->cheque_amount = 0.00;
                $row->cc_amount = 0.00;
                $row->net_banking_amount = 0.00;
                $row->upi_amount = 0.00;
                $row->billamount = $row->billamount == null ? '0.00' : $row->billamount;
                $row->netamount = $row->netamount == null ? '0.00' : $row->netamount;
                $row->balanceamount = $row->balanceamount == null ? '0.00' : $row->balanceamount;
                $row->cheque_amount = $row->cheque_amount == null ? '0.00' : $row->cheque_amount;
                $row->cash_amount = $row->cash_amount == null ? '0.00' : $row->cash_amount;
                $row->cc_amount = $row->cc_amount == null ? '0.00' : $row->cc_amount;
                $row->net_banking_amount = $row->net_banking_amount == null ? '0.00' : $row->net_banking_amount;
                $row->upi_amount = $row->upi_amount == null ? '0.00' : $row->upi_amount;
                $row->paymentdetails = $row->paymentdetails == null ? '-' : $row->paymentdetails;
                $row->generated_by = $row->generated_by == null ? '-' : $row->generated_by;


                foreach ($payments as $payment) {
                    $paid = $paid + $payment->total_amount;
                    if ($payment->payment_mode == 'cash') {
                        $row->cash_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'cheque') {
                        $row->cheque_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'debit_card') {
                        $row->cc_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'netbanking') {
                        $row->net_banking_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'upi') {
                        $row->upi_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'credit') {
                        $row->upi_amount = $payment->total_amount;
                    }
                }




                $rearrangedData[] =
                    [
                        'sno' => $row->sno,
                        'bill_no' => $row->bill_no,
                        'bill_id' => $row->billid,
                        'bill_date' =>  Carbon::createFromFormat('Y-m-d H:i:s', $row->bill_date)->format('d/m/Y H:i:s'),
                        'name' => $row->name,
                        'age' => $row->age,
                        'gender' => $row->gender,
                        'mobileno' => $row->mobileno,
                        'referer_name' => $row->referer_name,
                        'scantype' =>  $row->scan_type,
                        'bill_amount' => $row->billamount,
                        'bill_discount' => $row->bill_discount,
                        'netamount' => $row->netamount,
                        'paid_amount' => $row->paidamount,
                        'due_amount' => $row->balanceamount,
                        'cash_amount' => $row->cash_amount,
                        'cheque_amount' => $row->cheque_amount,
                        'cc_amount' => $row->cc_amount,
                        'net_banking_amount' => $row->net_banking_amount,
                        'upi_amount' => $row->upi_amount,
                        'payment_details' => $row->paymentdetails,
                        'generated_by' => $row->generated_by,

                    ];
            }
       //    dd($rearrangedData);
            return Datatables::of($rearrangedData)
		   ->make(true);
     
       	}

        return view('pages.reports');
}*/
   /* public function index(Request $request)
    {

        $startDate =   Carbon::now()->format('MM/DD/YYYY');;
        $endDate =   Carbon::now()->format('MM/DD/YYYY');



        $rearrangedData = [];
        if ($request->ajax()) {

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $startDate = $request->from_date;
                $endDate = $request->to_date;
            }

            $data = DB::select(
                'SELECT ROW_NUMBER() OVER (ORDER BY bd.created_at ASC) as sno, CAST(bd.bill_no AS CHAR) as bill_no,bd.id as billid,
        bd.created_at As bill_date,pd.name, pd.mobileno,pd.gender ,pd.age,
        rd.referer_name,
        GROUP_CONCAT(DISTINCT ind.study SEPARATOR ", ") AS modalitytype,
        CASE WHEN ad.modality_id=1 THEN "CT" ELSE "MR" END AS scan_type,
        FORMAT(IFNULL(bd.bill_amount,0),2) as billamount,
        FORMAT(IFNULL(bd.netamount,0),2) AS netamount,
        FORMAT(IFNULL(bd.bill_discount,0),2) as bill_discount,
        FORMAT(IFNULL(SUM(ppd.partpayment_amount), 0),2) AS paidamount,
        FORMAT((bd.netamount - IFNULL(SUM(ppd.partpayment_amount), 0)),2) AS balanceamount,
        GROUP_CONCAT(ppd.payment_details ORDER BY ppd.payment_details ASC SEPARATOR ", ") AS paymentdetails,
        bd.generated_by
        FROM bill_details AS bd
        LEFT JOIN part_payment_details AS ppd ON ppd.bill_no = bd.id
        JOIN appointment_details AS ad ON bd.appointment_id = ad.id
        JOIN patients_details AS pd ON ad.patient_id = pd.id
        JOIN referer_details AS rd ON ad.referer_id = rd.id
        LEFT JOIN investigation_details AS ind ON FIND_IN_SET(ind.id, bd.required_investigations)
        where DATE(bd.created_at) BETWEEN ? AND ?
        GROUP BY bd.id ',
                [$startDate, $endDate]

            );

            foreach ($data as $row) {


                $payments = DB::select(
                    "SELECT partpayment_amount as total_amount, payment_mode,payment_details as paydet
                             FROM part_payment_details
                             WHERE bill_no = ?
                             ",
                    [$row->billid]
                );

                $paid = 0.00;
                $row->cash_amount = 0.00;
                $row->cheque_amount = 0.00;
                $row->cc_amount = 0.00;
                $row->net_banking_amount = 0.00;
                $row->upi_amount = 0.00;
                $row->billamount = $row->billamount == null ? '0.00' : $row->billamount;
                $row->netamount = $row->netamount == null ? '0.00' : $row->netamount;
                $row->balanceamount = $row->balanceamount == null ? '0.00' : $row->balanceamount;
                $row->cheque_amount = $row->cheque_amount == null ? '0.00' : $row->cheque_amount;
                $row->cash_amount = $row->cash_amount == null ? '0.00' : $row->cash_amount;
                $row->cc_amount = $row->cc_amount == null ? '0.00' : $row->cc_amount;
                $row->net_banking_amount = $row->net_banking_amount == null ? '0.00' : $row->net_banking_amount;
                $row->upi_amount = $row->upi_amount == null ? '0.00' : $row->upi_amount;
                $row->paymentdetails = $row->paymentdetails == null ? '-' : $row->paymentdetails;
                $row->generated_by = $row->generated_by == null ? '-' : $row->generated_by;


                foreach ($payments as $payment) {
                    $paid = $paid + $payment->total_amount;
                    if ($payment->payment_mode == 'cash') {
                        $row->cash_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'cheque') {
                        $row->cheque_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'debit_card') {
                        $row->cc_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'netbanking') {
                        $row->net_banking_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'upi') {
                        $row->upi_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'credit') {
                        $row->upi_amount = $payment->total_amount;
                    }
                }




                $rearrangedData[] =
                    [
                        'sno' => $row->sno,
                        'bill_no' => $row->bill_no,
                        'bill_id' => $row->billid,
                        'bill_date' =>  Carbon::createFromFormat('Y-m-d H:i:s', $row->bill_date)->format('d/m/Y H:i:s'),
                        'name' => $row->name,
                        'age' => $row->age,
                        'gender' => $row->gender,
                        'mobileno' => $row->mobileno,
                        'referer_name' => $row->referer_name,
                        'scantype' =>  $row->scan_type,
                        'bill_amount' => $row->billamount,
                        'bill_discount' => $row->bill_discount,
                        'netamount' => $row->netamount,
                        'paid_amount' => $row->paidamount,
                        'due_amount' => $row->balanceamount,
                        'cash_amount' => $row->cash_amount,
                        'cheque_amount' => $row->cheque_amount,
                        'cc_amount' => $row->cc_amount,
                        'net_banking_amount' => $row->net_banking_amount,
                        'upi_amount' => $row->upi_amount,
                        'payment_details' => $row->paymentdetails,
                        'generated_by' => $row->generated_by,

                    ];
            }
            //dd($rearrangedData);
            return Datatables::of($rearrangedData)
                // ->addIndexColumn()
                ->make(true);
        }

        return view('pages.reports');
   }*/
public function index(Request $request)
    {

        $startDate =   Carbon::now()->format('MM/DD/YYYY');;
        $endDate =   Carbon::now()->format('MM/DD/YYYY');

        $rearrangedData = [];
        if ($request->ajax()) {

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $startDate = $request->from_date;
                $endDate = $request->to_date;
            }
            $data = DB::select('SELECT ROW_NUMBER() OVER (ORDER BY bd.created_at ASC) as sno, CAST(bd.bill_no as CHAR) as bill_no,
            CAST(bd.id AS CHAR) as billid,
            bd.created_at As bill_date,
            pd.name,
            pd.mobileno,
            pd.gender ,pd.age,
                rd.referer_name,
          GROUP_CONCAT(  ind.modality_type SEPARATOR ",") AS scan_type,
       GROUP_CONCAT( ind.study SEPARATOR ", ") AS modalitytype,
       bd.bill_amount as billamount,
              bd.netamount as netamount,
            FORMAT(IFNULL(bd.bill_discount,0),2) as bill_discount,
                FORMAT(IFNULL(SUM(ppd.partpayment_amount), 0),2) AS paidamount,
            FORMAT((bd.netamount - IFNULL(SUM(ppd.partpayment_amount), 0)),2) AS balanceamount,
            bd.generated_by,
             GROUP_CONCAT(ppd.payment_details ORDER BY ppd.payment_details ASC SEPARATOR ", ") AS paymentdetails
         FROM bill_details AS bd
         LEFT JOIN part_payment_details AS ppd ON ppd.bill_no = bd.id
         JOIN appointment_details AS ad ON bd.appointment_id = ad.id
         JOIN patients_details AS pd ON ad.patient_id = pd.id
         JOIN referer_details AS rd ON ad.referer_id = rd.id
         LEFT JOIN investigation_details AS ind ON FIND_IN_SET(ind.id, bd.required_investigations)
         WHERE DATE(bd.created_at) BETWEEN ? AND ?
         GROUP BY bd.id
     ', [$startDate, $endDate]);


            foreach ($data as $row) {


                $payments = DB::select(
                    "SELECT partpayment_amount as total_amount, payment_mode,payment_details as paydet
                             FROM part_payment_details
                             WHERE bill_no = ?
                             ",
                    [$row->billid]
                );

                $paid = 0.00;
                $row->cash_amount = 0.00;
                $row->cheque_amount = 0.00;
                $row->cc_amount = 0.00;
                $row->net_banking_amount = 0.00;
                $row->upi_amount = 0.00;
                $row->billamount = $row->billamount == null ? '0.00' : $row->billamount;
                $row->netamount = $row->netamount == null ? '0.00' : $row->netamount;
                $row->balanceamount = $row->balanceamount == null ? '0.00' : $row->balanceamount;
                $row->cheque_amount = $row->cheque_amount == null ? '0.00' : $row->cheque_amount;
                $row->cash_amount = $row->cash_amount == null ? '0.00' : $row->cash_amount;
                $row->cc_amount = $row->cc_amount == null ? '0.00' : $row->cc_amount;
                $row->net_banking_amount = $row->net_banking_amount == null ? '0.00' : $row->net_banking_amount;
                $row->upi_amount = $row->upi_amount == null ? '0.00' : $row->upi_amount;
                $row->paymentdetails = $row->paymentdetails == null ? '-' : $row->paymentdetails;
                $row->generated_by = $row->generated_by == null ? '-' : $row->generated_by;


                foreach ($payments as $payment) {
                    $paid = $paid + $payment->total_amount;
                    if ($payment->payment_mode == 'cash') {
                        $row->cash_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'cheque') {
                        $row->cheque_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'debit_card') {
                        $row->cc_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'netbanking') {
                        $row->net_banking_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'upi') {
                        $row->upi_amount = $payment->total_amount;
                    } elseif ($payment->payment_mode == 'credit') {
                        $row->upi_amount = $payment->total_amount;
                    }
                }




                $rearrangedData[] =
                    [
                        'sno' => $row->sno,
                        'bill_no' => $row->bill_no,
                        'bill_id' => $row->billid,
                        'bill_date' =>  Carbon::createFromFormat('Y-m-d H:i:s', $row->bill_date)->format('d/m/Y H:i:s'),
                        'name' => ucfirst($row->name),
                        'age' => $row->age,
                        'gender' => ucfirst($row->gender),
                        'mobileno' => $row->mobileno,
                        'referer_name' => $row->referer_name,
                        'scantype' =>  $row->scan_type,
                        'bill_amount' => $row->billamount,
                        'bill_discount' => $row->bill_discount,
                        'netamount' => $row->netamount,
                        'paid_amount' => $row->paidamount,
                        'due_amount' => $row->balanceamount,
                        'cash_amount' => $row->cash_amount,
                        'cheque_amount' => $row->cheque_amount,
                        'cc_amount' => $row->cc_amount,
                        'net_banking_amount' => $row->net_banking_amount,
                        'upi_amount' => $row->upi_amount,
                        'payment_details' => $row->paymentdetails,
                        'generated_by' => $row->generated_by,

                    ];
            }

            return Datatables::of($rearrangedData)
                // ->addIndexColumn()
                ->make(true);
        }

        return view('pages.reports');
    }
public function duepaidreport(Request $request){
	$startDate =   Carbon::now()->format('MM/DD/YYYY');;
        $endDate =   Carbon::now()->format('MM/DD/YYYY');

	   $startDate =   "2024-07-01";
           $endDate =   "2024-07-30";

//      if ($request->ajax()) {

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $startDate = $request->from_date;
                $endDate = $request->to_date;
	    }
       
	           $data = DB::select(
			   'SELECT ROW_NUMBER() OVER ( ORDER BY bd.created_at ASC ) AS sno, CAST(bd.id AS CHAR) AS billid,CAST(bd.bill_no AS CHAR) AS bill_no,DATE_FORMAT(bd.created_at,"%d/%m/%Y %H:%i:%s") as bill_date, patients_details.name, patients_details.age, patients_details.gender, patients_details.mobileno, referer_details.referer_name, COALESCE(FORMAT(bd.bill_amount,2),0.00) as bill_amount,
 COALESCE(FORMAT(bd.bill_discount,2),0.00) as bill_discount,
 COALESCE(FORMAT(bd.netamount,2),0.00) as netamount,
COALESCE(FORMAT(bd.paid_amount,2),0.00) as total_paid,
FORMAT(bd.paid_amount-part_payment_details.partpayment_amount,2) as last_paid, 
COALESCE(FORMAT(part_payment_details.partpayment_amount,2),0.00) as due_paid, 
COALESCE(FORMAT( bd.due_amount,2),0.00) as due_amount,part_payment_details.payment_mode,part_payment_details.payment_details, DATE_FORMAT(part_payment_details.created_at,"%d/%m/%Y %H:%i:%s") as  due_paid_on FROM bill_details bd JOIN appointment_details ON bd.appointment_id = appointment_details.id JOIN patients_details ON appointment_details.patient_id = patients_details.id JOIN referer_details ON appointment_details.referer_id = referer_details.id JOIN part_payment_details ON part_payment_details.bill_no=bd.id where part_payment_details.created_at = (SELECT MAX(created_at) from part_payment_details where bill_no = bd.id)
	 AND 
	part_payment_details.payment_type !=1 AND 
           DATE(part_payment_details.created_at) BETWEEN ? AND ?',
                [$startDate, $endDate]
	   );
    
		//dd($data);
	/* foreach ($data as $row) {
               /* $payments = DB::select(
                    "SELECT partpayment_amount as total_amount, payment_mode,payment_details as paydet
                     FROM part_payment_details
                     WHERE bill_no = ?
                     ",
                    [$row->billid]
	       );* /
		 $payments = DB::select(
                    "SELECT partpayment_amount as total_amount, payment_mode,payment_details as paydet
                     FROM part_payment_details
                     WHERE bill_no = ?
                     ",
                    [$row->billid]
		);
	   $row->payment_details = "";
	  
     	foreach ($payments as $payment) {
	//	$row->payment_details =$row->payment_details.$payment->payment_mode."-Rs".$payment->total_amount."-".$payment->paydet." ,";
		$row->payment_details =$row->payment_details."-Rs".$payment->total_amount."-".$payment->paydet;
	}
	   }	
 */
	//	dd($data);
	return Datatables::of($data)
		    /*  ->addIndexColumn()*/
                ->make(true);
  //     }
	return view('pages.duepaidreport');

       
}




public function referrerreportfun(Request $request){

 if ($request->ajax()) {
            $startDate =   Carbon::now()->format('YYYY-MM-DD');;
	    $endDate =   Carbon::now()->format('YYYY-MM-DD');
	   // $startDate = Carbon::now()->subDay()->format('Y-m-d');
	   // $endDate = Carbon::now()->subDay()->format('Y-m-d');
           // $startDate =   "2024-07-01";
            //$endDate =   "2024-07-30";
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $startDate = $request->from_date;
		$endDate = $request->to_date;








            }

            /*$data = DB::select(
                "SELECT ROW_NUMBER() OVER (ORDER BY bd.created_at ASC) as sno,bd.id as billid,bd.bill_no, DATE_FORMAT(bd.created_at,'%d/%m/%Y %H:%i:%s') as bill_date,pd.name,
	rd.referer_name,
GROUP_CONCAT(sd.modality SEPARATOR ', ') as modality,
GROUP_CONCAT(ind.study SEPARATOR ', ') as study,
COALESCE(FORMAT(bd.bill_amount,2),0.00) as bill_amount,COALESCE(FORMAT(bd.bill_discount,2),0.00) as bill_discount,COALESCE(FORMAT(bd.netamount,2),0.00) as netamount,COALESCE(FORMAT(bd.due_amount,2),0.00) as due_amount,COALESCE(FORMAT(bd.paid_amount,2),0.00) as paid_amount,FORMAT(SUM(sd.ref_amount),2) as ref_amount 
        FROM bill_details AS bd
        JOIN appointment_details AS ad ON bd.appointment_id = ad.id
        JOIN patients_details AS pd ON ad.patient_id = pd.id
        JOIN referer_details AS rd ON ad.referer_id = rd.id
         JOIN investigation_details AS ind ON FIND_IN_SET(ind.id, bd.required_investigations)
	JOIN scanning_details AS sd ON ind.modality_id = sd.id AND
	 DATE(bd.created_at) BETWEEN ? AND ? 
	 GROUP BY bd.id HAVING netamount=paid_amount",
                [$startDate, $endDate]
	    );*/

$data = DB::select(
                "SELECT ROW_NUMBER() OVER (ORDER BY bd.created_at ASC) as sno,
  
    CAST(bd.bill_no AS CHAR) as bill_no,
    CAST(bd.id AS CHAR) AS billid,
    DATE_FORMAT(bd.created_at, '%d/%m/%Y %H:%i:%s') AS bill_date,
    pd.name,
    rd.referer_name,
    id.modality_type AS modality,
    id.study,
    COALESCE(FORMAT(id.rate, 2), 0.00) AS bill_amount,
    COALESCE(FORMAT(id.discount, 2), 0.00) AS bill_discount,
    COALESCE(FORMAT(id.amount, 2), 0.00) AS netamount,
    COALESCE(FORMAT(id.rate, 2), 0.00) AS paid_amount,
    FORMAT( id.rate-id.amount,2) as due_amount,
	COALESCE(FORMAT(sd.ref_amount, 2), 0.00) AS referer_amount
FROM
    investigation_details AS id
JOIN
    bill_details AS bd ON id.bill_id = bd.id
JOIN
    appointment_details AS ad ON bd.appointment_id = ad.id
JOIN
    patients_details AS pd ON ad.patient_id = pd.id
JOIN
    referer_details AS rd ON ad.referer_id = rd.id
JOIN
    scanning_details AS sd ON sd.id=id.modality_id
WHERE
    bd.netamount = bd.paid_amount AND
	 DATE(bd.created_at) BETWEEN ? AND ?",
[$startDate, $endDate]
            );



	    foreach($data as $row){
	    $inve = DB::select("select * from bill_details where id=?",[$row->billid]);
	//	$reqinv=explode($inve->required_investigations);
	//	dd($reqinv);
	    }

            //dd($data);
            return Datatables::of($data)
               /* ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    return $btn;
                })
		->rawColumns(['action'])*/
                ->make(true);;
        }
        return view('pages.reffererreportsnew');
   }




   


}
