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
	$month=$request->month;
        $year=$request->year;

//	    if ($request->ajax()) {
	    $data = DB::select('
    SELECT bd.bill_no,
	
           ad.appointment_date,
           pd.name,
           rd.referer_name,
           GROUP_CONCAT(ppd.payment_details ORDER BY ppd.payment_details ASC SEPARATOR ", ") AS paymentdetails,
           GROUP_CONCAT(ind.study SEPARATOR ", ") AS modalitytype,
           bd.netamount,
           IFNULL(SUM(ppd.partpayment_amount), 0) AS paidamount,
           bd.netamount - IFNULL(SUM(ppd.partpayment_amount), 0) AS balanceamount
    FROM bill_details AS bd
    LEFT JOIN part_payment_details AS ppd ON ppd.bill_no = bd.id
    JOIN appointment_details AS ad ON bd.appointment_id = ad.id
    JOIN patients_details AS pd ON ad.patient_id = pd.id
    JOIN referer_details AS rd ON ad.referer_id = rd.id
    LEFT JOIN investigation_details AS ind ON FIND_IN_SET(ind.id, bd.required_investigations)
    WHERE MONTH(bd.created_at) = ? AND YEAR(bd.created_at) = ?
    GROUP BY bd.id HAVING bd.netamount > IFNULL(SUM(ppd.partpayment_amount),0)
    ', [$month, $year]
    );
	    $totalBalanceAmount = array_sum(array_column($data, 'balanceamount'));

return Datatables::of($data)
    ->addIndexColumn()
    ->addColumn('action', function ($row) {
        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
        return $btn;
    })
    ->rawColumns(['action'])
    ->with('totalBalanceAmount', $totalBalanceAmount)
    ->make(true);
  //  }
 

    }


public function monthlyreportfun(Request $request)
{
	$month=7;//$request->month;
	$year=2024;//$request->year;

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
	for($j=1;$j<=31;$j++){
		$monthlydetails = new MonthlyReportData();
		
		//Carbon::createFromDate($year, $month, $day, $tz); 
		$monthlydetails->date=Carbon::createFromDate($year, $month, $j)->format('Y-m-d'); ;
                $monthlydetails->mr=0;
                $monthlydetails->mr_disc=0;
		$monthlydetails->mr_net=0;
		$monthlydetails->mr_contrast=0;
                $monthlydetails->mr_contrast_disc=0;
		$monthlydetails->mr_contrast_net=0;
		$monthlydetails->ct=0;
                $monthlydetails->ct_disc=0;
                $monthlydetails->ct_net=0;
                $monthlydetails->ct_contrast=0;
                $monthlydetails->ct_contrast_disc=0;
		$monthlydetails->ct_contrast_net=0;
		$monthlydetails->totalgross=0;
		$monthlydetails->totaldiscount=0;
		$monthlydetails->totalnet=0;

	foreach($querymr as $data){
	$dt=$data->day;
	$dt_day= explode('-',$dt);
	//	dd($dt_day[2]);
	
	if($dt_day[2]==$j){
		$monthlydetails->date=$dt;
		$monthlydetails->mr=$data->rate;
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

		$totalamount+=$monthlydetails->mr_net + $monthlydetails->ct_net;
		$dataarr[]=$monthlydetails;
	}
	//dd($dataarr);
	$message ="SUmmary details of month".$month." year".$year;
	return view('pages.monthlyreports', compact('dataarr', 'message','totalamount'));
/*      dd(datatables()->of($query)
                ->make(true));
 
    return DataTables::of($query)
	    /*->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Review</button>';
                   // $button .= '   <button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
	    })* /
		    ->toJson();*/
 
}

}
