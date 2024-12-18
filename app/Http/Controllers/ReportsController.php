<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Patients;
use DB;
use App\Providers\MonthlyReportData;
use App\Models\Investigation_details;
use Carbon\Carbon;


class ReportsController extends Controller
{
    
    //
    public function balancereportfun(Request $request)
    {
      /* 
	$join = $this->dataStore("bill_details")->join($this->dataStore("appointment_details"),array("appointment_id"=>"id"));
            return datatables()->of($patient)
                ->make(true);
       */
	
		$startDate =   Carbon::now()->format('YYYY-MM-DD');;
	    $endDate =   Carbon::now()->format('YYYY-MM-DD');

//	$startDate =   "2024-07-01";
//        $endDate =   "2024-07-30";
//	$month=$request->month;
//        $year=$request->year;

		   // if ($request->ajax()) {

	  if ($request->filled('from_date') && $request->filled('to_date')) {
                $startDate = $request->from_date;
                $endDate = $request->to_date;
            }

	    $data = DB::select('SELECT ROW_NUMBER() OVER (ORDER BY bd.created_at ASC) as sno, CAST(bd.bill_no as CHAR) as bill_no,
	   CAST(bd.id AS CHAR) as billid,

	  DATE_FORMAT(bd.created_at,"%d/%m/%Y %H:%i:%s") as bill_date, 
	   pd.name,
	   pd.mobileno,
           rd.referer_name,
	   
GROUP_CONCAT(DISTINCT ind.modality_type SEPARATOR ",") AS scan_type,
  GROUP_CONCAT(DISTINCT ind.study SEPARATOR ", ") AS modalitytype,
         bd.netamount as netamount,	   
	   FORMAT(IFNULL(bd.bill_discount,0),2) as bill_discount,
           FORMAT(IFNULL(SUM(ppd.partpayment_amount), 0),2) AS paidamount,
	   FORMAT((bd.netamount - IFNULL(SUM(ppd.partpayment_amount), 0)),2) AS balanceamount,
		GROUP_CONCAT(ppd.payment_details ORDER BY ppd.payment_details ASC SEPARATOR ", ") AS paymentdetails
    FROM bill_details AS bd
    LEFT JOIN part_payment_details AS ppd ON ppd.bill_no = bd.id
    JOIN appointment_details AS ad ON bd.appointment_id = ad.id
    JOIN patients_details AS pd ON ad.patient_id = pd.id
    JOIN referer_details AS rd ON ad.referer_id = rd.id
    LEFT JOIN investigation_details AS ind ON FIND_IN_SET(ind.id, bd.required_investigations)
    WHERE  bd.netamount > IFNULL(bd.paid_amount,0) AND
	 DATE(bd.created_at) BETWEEN ? AND ?                
    GROUP BY bd.id ',[$startDate, $endDate] );

       //	[$month, $year]
   // );
	//WHERE MONTH(bd.created_at) = ? AND YEAR(bd.created_at) = ?
	//dd($data);
	$totalBalanceAmount = array_sum(array_column($data, 'balanceamount'));

 foreach ($data as $row) {
                $payments = DB::select(
                    "SELECT partpayment_amount as total_amount, payment_mode,payment_details as paydet
                     FROM part_payment_details
                     WHERE bill_no = ?
                     ",
                    [$row->billid]
		);
	$row->paymentdetails = "";
     foreach ($payments as $payment) {
	$row->paymentdetails =$row->paymentdetails.$payment->payment_mode."-Rs".$payment->total_amount."-".$payment->paydet." ,";
	}
}	

return Datatables::of($data)
     ->with('totalBalanceAmount', $totalBalanceAmount)
     ->make(true);
	// }
 

    }


/*public function monthlyreportfun(Request $request)
{
//	dd($request);
	$month=date('m');
	$year=date('Y');
	if($request->filled('startDate')){
		$dm=explode(" ",$request->startDate);//$request->month;
		$month=$dm[0];
	//	dd($month);
        $year=$dm[1];//$request->year;
	}

//	$query = DB::table('investigation_details')
	$querymr= Investigation_details::whereRaw('modality_type= (\'MR\')')
		->whereYear('created_at', $year)
		->whereMonth('created_at', '=', $month)
		->selectRaw("SUM(rate) rate")
		->selectRaw("SUM(amount) amount")
		->selectRaw(DB::Raw('DATE(created_at) day'))
		->selectRaw("SUM(discount) discount")
		->groupBy('day')
		->get();
//	dd($querymr);
	$queryct= Investigation_details::whereRaw('modality_type= (\'CT\')' ) //and study!= (\'CONTRAST\')')
		 ->whereYear('created_at', $year)
                ->whereMonth('created_at', '=', $month)
		->selectRaw("SUM(rate) rate")
		->selectRaw("SUM(amount) amount")
                ->selectRaw(DB::Raw('DATE(created_at) day'))
                ->selectRaw("SUM(discount) discount")
                ->groupBy('day')
		->get();
//	dd($queryct);
	$querymr_contr= Investigation_details::whereRaw('modality_type= (\'MR\') and study= (\'CONTRAST\')')
		 ->whereYear('created_at', $year)
                ->whereMonth('created_at', '=', $month)
		->selectRaw("SUM(rate) rate")
		->selectRaw("SUM(amount) amount")
                ->selectRaw(DB::Raw('DATE(created_at) day'))
                ->selectRaw("SUM(discount) discount")
                ->groupBy('day')
		->get();
//	dd($querymr_contr);
	$queryct_contr= Investigation_details::whereRaw('modality_type= (\'CT\') and study= (\'CONTRAST\')')
		 ->whereYear('created_at', $year)
                ->whereMonth('created_at', '=', $month)
		->selectRaw("SUM(rate) rate")
		->selectRaw("SUM(amount) amount")
                ->selectRaw(DB::Raw('DATE(created_at) day'))
                ->selectRaw("SUM(discount) discount")
                ->groupBy('day')
		->get();

	//	dd($queryct_contr);
	$dataarr  = array();
	$totalamount=0;
	$nodays=cal_days_in_month(CAL_GREGORIAN,$month,$year);//31;
	for($j=1;$j<=$nodays;$j++){
		$monthlydetails = new MonthlyReportData();
		
		//Carbon::createFromDate($year, $month, $day, $tz); 
		$monthlydetails->date=Carbon::createFromDate($year, $month, $j)->format('Y-m-d'); ;
                $monthlydetails->mr=0.00;
                $monthlydetails->mr_disc=0.00;
		$monthlydetails->mr_net=0.00;
		$monthlydetails->mr_contrast=0.00;
                $monthlydetails->mr_contrast_disc=0.00;
		$monthlydetails->mr_contrast_net=0.00;
		$monthlydetails->mrcontrast=0.00;
		$monthlydetails->mrcontrast_disc=0.00;
		$monthlydetails->mrcontrast_net=0.00;
		$monthlydetails->ct=0.00;
                $monthlydetails->ct_disc=0.00;
                $monthlydetails->ct_net=0.00;
                $monthlydetails->ct_contrast=0.00;
                $monthlydetails->ct_contrast_disc=0.00;
		$monthlydetails->ct_contrast_net=0.00;
		$monthlydetails->ctcontrast=0.00;
                $monthlydetails->ctcontrast_disc=0.00;
                $monthlydetails->ctcontrast_net=0.00;
		$monthlydetails->totalgross=0.00;
		$monthlydetails->totaldiscount=0.00;
		$monthlydetails->totalnet=0.00;

	foreach($querymr as $data){
	$dt=$data->day;
	$dt_day= explode('-',$dt);
	//	dd($dt_day[2]);
	
	if($dt_day[2]==$j){
		$monthlydetails->date=$dt;
		$monthlydetails->mr=(float)$data->rate;
		$monthlydetails->mr_disc=$data->discount;
		$monthlydetails->mr_net=$data->amount;
		$monthlydetails->totalgross+=$data->rate;
                $monthlydetails->totaldiscount+=$data->discount;
		$monthlydetails->totalnet+=$data->amount;
	

	}

	}
		
	foreach($queryct as $data){
        $dt=$data->day;
        $dt_day= explode('-',$dt);
        //      dd($dt_day[2]);

        if($dt_day[2]==$j){
        //      $monthlydetails->date=$dt;
                $monthlydetails->ct=$data->rate;
                $monthlydetails->ct_disc=$data->discount;
		$monthlydetails->ct_net=$data->amount;
		 $monthlydetails->totalgross+=$data->rate;
                $monthlydetails->totaldiscount+=$data->discount;
                $monthlydetails->totalnet+=$data->amount;

        }

	}

	foreach($querymr_contr as $data){
        $dt=$data->day;
        $dt_day= explode('-',$dt);
        //      dd($dt_day[2]);

        if($dt_day[2]==$j){
                $monthlydetails->mr_contrast=$data->rate;
                $monthlydetails->mr_contrast_disc=$data->discount;
		$monthlydetails->mr_contrast_net=$data->amount;
		
       
	}

        }

	foreach($queryct_contr as $data){
        $dt=$data->day;
        $dt_day= explode('-',$dt);
        //      dd($dt_day[2]);

        if($dt_day[2]==$j){
                $monthlydetails->ct_contrast=$data->rate;
                $monthlydetails->ct_contrast_disc=$data->discount;
		$monthlydetails->ct_contrast_net=$data->amount;


        }

	}
	$monthlydetails->mrcontrast=$monthlydetails->mr-$monthlydetails->mr_contrast;
                $monthlydetails->mrcontrast_disc=$monthlydetails->mr_disc-$monthlydetails->mr_contrast_disc;
                $monthlydetails->mrcontrast_net=$monthlydetails->mr_net-$monthlydetails->mr_contrast_net;


		$monthlydetails->ctcontrast=$monthlydetails->ct-$monthlydetails->ct_contrast;
                $monthlydetails->ctcontrast_disc=$monthlydetails->ct_disc-$monthlydetails->ct_contrast_disc;
                $monthlydetails->ctcontrast_net=$monthlydetails->ct_net-$monthlydetails->ct_contrast_net;

		$totalamount+=(float)$monthlydetails->mr_net + (float)$monthlydetails->ct_net;
		$dataarr[]=$monthlydetails;
	}
	$totaldiscount=number_format($monthlydetails->totaldiscount,2);
	$totalgross=number_format($monthlydetails->totalgross,2);
	//dd($dataarr);
	$message ="Summary details of month  ".$month." - ".$year;
//	return view('pages.monthlyreports', compact('dataarr', 'message','totalamount','totalgross','totaldiscount'));
     return  DataTables()->of($dataarr)
                ->make(true);
 
   // return DataTables::of($query)
	    /*->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Review</button>';
                   // $button .= '   <button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
	    })* /
		    ->toJson();*/
 
    //}
    //

    public function monthlyreportfun(Request $request)
	{
		if ($request->ajax()) {

			$startDate =   Carbon::now()->format('YYYY-MM-DD');;
			$endDate =   Carbon::now()->format('YYYY-MM-DD');
			$month = Carbon::now()->format('m'); // 'Y-m' gives you 'YYYY-MM'
			$year = Carbon::now()->format('Y');;

			if ($request->filled('from_date') && $request->filled('to_date')) {
				$startDate = $request->from_date;
				$endDate = $request->to_date;
				$month = Carbon::parse($request->to_date)->format('m');
				//$month = Carbon::now()->format('m'); // 'Y-m' gives you 'YYYY-MM'
				//$month = date('m');
				$year = Carbon::parse($request->to_date)->format('Y');
			}


			//	$query = DB::table('investigation_details')
			$querymr = Investigation_details::whereRaw('modality_type= (\'MR\')')
				->whereYear('created_at', $year)
				->whereMonth('created_at', '=', $month)
				->selectRaw("SUM(rate) rate")
				->selectRaw("SUM(amount) amount")
				->selectRaw(DB::Raw('DATE(created_at) day'))
				->selectRaw("SUM(discount) discount")
				->groupBy('day')
				->get();
			//	dd($querymr);
			$queryct = Investigation_details::whereRaw('modality_type= (\'CT\')') //and study!= (\'CONTRAST\')')
				->whereYear('created_at', $year)
				->whereMonth('created_at', '=', $month)
				->selectRaw("SUM(rate) rate")
				->selectRaw("SUM(amount) amount")
				->selectRaw(DB::Raw('DATE(created_at) day'))
				->selectRaw("SUM(discount) discount")
				->groupBy('day')
				->get();
			//	dd($queryct);
			$querymr_contr = Investigation_details::whereRaw('modality_type= (\'MR\') and study= (\'CONTRAST\')')
				->whereYear('created_at', $year)
				->whereMonth('created_at', '=', $month)
				->selectRaw("SUM(rate) rate")
				->selectRaw("SUM(amount) amount")
				->selectRaw(DB::Raw('DATE(created_at) day'))
				->selectRaw("SUM(discount) discount")
				->groupBy('day')
				->get();
			//	dd($querymr_contr);
			$queryct_contr = Investigation_details::whereRaw('modality_type= (\'CT\') and study= (\'CONTRAST\')')
				->whereYear('created_at', $year)
				->whereMonth('created_at', '=', $month)
				->selectRaw("SUM(rate) rate")
				->selectRaw("SUM(amount) amount")
				->selectRaw(DB::Raw('DATE(created_at) day'))
				->selectRaw("SUM(discount) discount")
				->groupBy('day')
				->get();

			//	dd($queryct_contr);
			$dataarr  = array();
			$totalamount = 0;
			$nodays = cal_days_in_month(CAL_GREGORIAN, $month, $year); //31;
			for ($j = 1; $j <= $nodays; $j++) {
				$monthlydetails = new MonthlyReportData();

				//Carbon::createFromDate($year, $month, $day, $tz);
				$monthlydetails->date = Carbon::createFromDate($year, $month, $j)->format('Y-m-d');;
				$monthlydetails->mr = 0.00;
				$monthlydetails->mr_disc = 0.00;
				$monthlydetails->mr_net = 0.00;
				$monthlydetails->mr_contrast = 0.00;
				$monthlydetails->mr_contrast_disc = 0.00;
				$monthlydetails->mr_contrast_net = 0.00;
				$monthlydetails->mrcontrast = 0.00;
				$monthlydetails->mrcontrast_disc = 0.00;
				$monthlydetails->mrcontrast_net = 0.00;
				$monthlydetails->ct = 0.00;
				$monthlydetails->ct_disc = 0.00;
				$monthlydetails->ct_net = 0.00;
				$monthlydetails->ct_contrast = 0.00;
				$monthlydetails->ct_contrast_disc = 0.00;
				$monthlydetails->ct_contrast_net = 0.00;
				$monthlydetails->ctcontrast = 0.00;
				$monthlydetails->ctcontrast_disc = 0.00;
				$monthlydetails->ctcontrast_net = 0.00;
				$monthlydetails->totalgross = 0.00;
				$monthlydetails->totaldiscount = 0.00;
				$monthlydetails->totalnet = 0.00;

				foreach ($querymr as $data) {
					$dt = $data->day;
					$dt_day = explode('-', $dt);
					//	dd($dt_day[2]);

					if ($dt_day[2] == $j) {
						$monthlydetails->date = $dt;
						$monthlydetails->mr = (float)$data->rate;
						$monthlydetails->mr_disc = (float)$data->discount;
						$monthlydetails->mr_net = $data->amount;
						$monthlydetails->totalgross += $data->rate;
						$monthlydetails->totaldiscount += $data->discount;
						$monthlydetails->totalnet += $data->amount;
					}
				}

				foreach ($queryct as $data) {
					$dt = $data->day;
					$dt_day = explode('-', $dt);
					//      dd($dt_day[2]);

					if ($dt_day[2] == $j) {
						//      $monthlydetails->date=$dt;
						$monthlydetails->ct = (float)$data->rate;
						$monthlydetails->ct_disc = (float) $data->discount;
						$monthlydetails->ct_net = (float) $data->amount;
						$monthlydetails->totalgross += (float) $data->rate;
						$monthlydetails->totaldiscount += (float)$data->discount;
						$monthlydetails->totalnet += (float)$data->amount;
					}
				}

				foreach ($querymr_contr as $data) {
					$dt = $data->day;
					$dt_day = explode('-', $dt);
					//      dd($dt_day[2]);

					if ($dt_day[2] == $j) {
						$monthlydetails->mr_contrast = (float)$data->rate;
						$monthlydetails->mr_contrast_disc = (float)$data->discount;
						$monthlydetails->mr_contrast_net = (float)$data->amount;
					}
				}

				foreach ($queryct_contr as $data) {
					$dt = $data->day;
					$dt_day = explode('-', $dt);
					//      dd($dt_day[2]);

					if ($dt_day[2] == $j) {
						$monthlydetails->ct_contrast = (float)$data->rate;
						$monthlydetails->ct_contrast_disc = (float)$data->discount;
						$monthlydetails->ct_contrast_net = (float)$data->amount;
					}
				}
				$monthlydetails->mrcontrast = $monthlydetails->mr - $monthlydetails->mr_contrast;
				$monthlydetails->mrcontrast_disc = $monthlydetails->mr_disc - $monthlydetails->mr_contrast_disc;
				$monthlydetails->mrcontrast_net = $monthlydetails->mr_net - $monthlydetails->mr_contrast_net;


				$monthlydetails->ctcontrast = $monthlydetails->ct - $monthlydetails->ct_contrast;
				$monthlydetails->ctcontrast_disc = $monthlydetails->ct_disc - $monthlydetails->ct_contrast_disc;
				$monthlydetails->ctcontrast_net = $monthlydetails->ct_net - $monthlydetails->ct_contrast_net;

				$totalamount += (float)$monthlydetails->mr_net + (float)$monthlydetails->ct_net;

				$monthlydetails->mr =   number_format($monthlydetails->mr,2);
                                $monthlydetails->mr_disc =  number_format($monthlydetails->mr_disc,2);
                                $monthlydetails->mr_net =  number_format($monthlydetails->mr_net,2);
                                $monthlydetails->mr_contrast = number_format($monthlydetails->mr_contrast,2);
                                $monthlydetails->mr_contrast_disc =  number_format($monthlydetails->mr_contrast_disc,2) ;
                                $monthlydetails->mr_contrast_net =  number_format($monthlydetails->mr_contrast_net,2) ;
                                $monthlydetails->mrcontrast =  number_format($monthlydetails->mrcontrast,2) ;
                                $monthlydetails->mrcontrast_disc =  number_format($monthlydetails->mrcontrast_disc,2);
                                $monthlydetails->mrcontrast_net =  number_format($monthlydetails->mrcontrast_net,2);
                                $monthlydetails->ct =  number_format($monthlydetails->ct,2) ;
                                $monthlydetails->ct_disc =  number_format($monthlydetails->ct_disc,2);
                                $monthlydetails->ct_net =  number_format($monthlydetails->ct_net,2) ;
                                $monthlydetails->ct_contrast =  number_format($monthlydetails->ct_contrast,2);
                                $monthlydetails->ct_contrast_disc =  number_format($monthlydetails->ct_contrast_disc,2) ;
                                $monthlydetails->ct_contrast_net =  number_format($monthlydetails->ct_contrast_net,2) ;
                                $monthlydetails->ctcontrast =  number_format($monthlydetails->ctcontrast,2) ;
                                $monthlydetails->ctcontrast_disc =  number_format($monthlydetails->ctcontrast_disc,2);
                                $monthlydetails->ctcontrast_net =  number_format( $monthlydetails->ctcontrast_net,2);

				$monthlydetails->date = Carbon::createFromDate($year, $month, $j)->format('d/m/Y');
				$dataarr[] = $monthlydetails;
			}
			$totaldiscount = number_format($monthlydetails->totaldiscount, 2);
			$totalgross = number_format($monthlydetails->totalgross, 2);
			//dd($dataarr);
			$message = "Summary details of month  " . $month . " - " . $year;




			return  DataTables()->of($dataarr)
				->make(true);
		}
		return view('pages.monthlyreports', compact('dataarr', 'message', 'totalamount', 'totalgross', 'totaldiscount'));
	}
}
