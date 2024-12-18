<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Bill_details;
use Yajra\DataTables\Facades\DataTables;

use App\Reports\MyReport;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
public function __contruct()
    {
        $this->middleware("guest");
    }
   /* public function index()
    {
        $report = new MyReport;
        $report->run();
        return view("pages.reports",["report"=>$report]);
   }*/
/*    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Bill_details::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.reports');
}*/
/*public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::select('SELECT DISTINCT(bill_details.bill_no),patients_details.name,patients_details.age,patients_details.gender,patients_details.mobileno,referer_details.referer_name,bill_details.bill_amount,bill_details.bill_discount,bill_details.netamount,bill_details.generated_by,part_payment_details.payment_mode,part_payment_details.created_at,part_payment_details.payment_details
                FROM `bill_details`,patients_details,appointment_details,referer_details,part_payment_details
                where bill_details.patient_phoneno=patients_details.mobileno and appointment_details.referer_id=referer_details.id and appointment_details.patient_id=patients_details.id and part_payment_details.bill_no=bill_details.id and part_payment_details.bill_no=bill_details.id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.reports');
}*/

   public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Bill_details::join('patients_details', 'bill_details.patient_phoneno', '=', 'patients_details.mobileno')
                ->join('appointment_details', 'appointment_details.id', '=', 'bill_details.appointment_id')
                ->join('referer_details', 'referer_details.id', '=', 'appointment_details.referer_id')
                ->select(
                    'bill_details.bill_no',
                    'bill_details.created_at as bill_date',
                    'patients_details.name as name',
                    'patients_details.age',
                    'patients_details.gender as sex',
                    'patients_details.mobileno as mobile_no',
		    'referer_details.referer_name as ref_by'
		    ,'appointment_details.modality_id as scantype',
                    'bill_details.netamount as total_amount',
                    'bill_details.bill_amount as bill_amount',
                    'bill_details.bill_discount as discount',
                    'bill_details.paid_amount as paid_amount',
                    'bill_details.due_amount as due_amount',
                    'bill_details.payment_mode as payment_mode',
                    'bill_details.payment_details as payment_details',
                    'bill_details.amt_paid_date as paid_date',
                    'bill_details.generated_by as gen_by'
                );


	    if ($request->filled('from_date') && $request->filled('to_date')) {
		  //  $fromDate = Carbon::parse($request->from_date)->startOfDay();
		 //   $toDate = Carbon::parse($request->to_date)->endOfDay();
		    // $data=$data->whereBetween('created_at', [$fromDate, $toDate]);
		     $data = $data->whereBetween('bill_details.created_at', [$request->from_date, $request->to_date]);
               // $data = $data->whereBetween('bill_details.created_at', [Request->$from_date, $Request->to_date]);
		   
            }
            //dd($data);

            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.reports');
   }

public function referrerreportfun(Request $request){

	/*$data = DB::select('SELECT bd.bill_no, pd.name,sd.modality,bd.created_at as bill_date,
            rd.referer_name,ind.study,sd.ref_amount,bd.netamount,bd.bill_amount,bd.bill_discount,bd.due_amount,bd.paid_amount
            FROM bill_details AS bd
            JOIN appointment_details AS ad ON bd.appointment_id = ad.id
            JOIN patients_details AS pd ON ad.patient_id = pd.id
            JOIN referer_details AS rd ON ad.referer_id = rd.id
            LEFT JOIN investigation_details AS ind ON FIND_IN_SET(ind.id, bd.required_investigations)
            JOIN scanning_details AS sd ON ind.modality_id = sd.id');
	dd($data);*/
	 if ($request->ajax()) {

            $data = DB::select('SELECT bd.bill_no, pd.name,sd.modality,bd.created_at as bill_date,
            rd.referer_name,ind.study,sd.ref_amount,bd.netamount,bd.bill_amount,bd.bill_discount,bd.due_amount,bd.paid_amount
            FROM bill_details AS bd
            JOIN appointment_details AS ad ON bd.appointment_id = ad.id
            JOIN patients_details AS pd ON ad.patient_id = pd.id
            JOIN referer_details AS rd ON ad.referer_id = rd.id
            LEFT JOIN investigation_details AS ind ON FIND_IN_SET(ind.id, bd.required_investigations)
            JOIN scanning_details AS sd ON ind.modality_id = sd.id');
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->whereBetween('bill_details.created_at', [$request->from_date, $request->to_date]);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);;
	 }
        return view('pages.reffererreports');
   }




    public function indexduepaid(Request $request)
    {
	    // dd("hello");

	     $query = Bill_details::query()
        ->join('appointment_details', 'bill_details.appointment_id', '=', 'appointment_details.id')
        ->select([
            'bill_details.id',
            'bill_details.patient_phoneno',
            'bill_details.bill_no',
	    'appointment_details.start_time'

	]);
	     $data = Bill_details::select('*');
//	     dd(Datatables::of($data)->make(true));
//                dd(Datatables::of($query)->make(true));

	    if ($request->ajax()) {
		$data = Bill_details::select('*');
	//	$join = $this->dataStore("bill_details")->join($this->dataStore("appointment_details"),
	//		array("appointment_id"=>"id"));
	//	dd($join);
		 $query = Bill_details::query()
			 ->join('appointment_details', 'bill_details.appointment_id', '=', 'appointment_details.id')
			 ->join('patients_details','appointment_details.patient_id','=','patients_details.id')
		 	->join('referer_details','appointment_details.referer_id','=','referer_details.id')
        ->select([
            'bill_details.id',
            'bill_details.patient_phoneno',
	    'bill_details.bill_no',
	    'bill_details.appointment_id',
	    'appointment_details.start_time',
	    'patients_details.name',
	    'patients_details.age',
	    'patients_details.gender',
	    'referer_details.referer_name',
	    'bill_details.netamount',
            
	]);
//		dd($query);
            return Datatables::of($query)
              //  ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

//        return view('pages.reports2');
    }



}
