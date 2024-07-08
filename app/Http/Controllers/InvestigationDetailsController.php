<?php

namespace App\Http\Controllers;

use App\Models\Investigation_details;
use App\Models\User;
use Illuminate\Http\Request;

class InvestigationDetailsController extends Controller
{
	//
	 public function index()
	 {
	//	 dd("hi");
	    $invdet = Investigation_details::all();
	    //dd($invdet);
	    return view('pages.investigations')->with('invdet',$invdet);
	    //return view('investigations', ['invdet' => $invdet]);
	 }
	 public function fetchCT_Invest(Request $request){
		 //$data['CTstudy'] = Modality::where("country_id", $request->country_id)
                   //             ->get(["name", "id"]);

        //return response()->json($data);
	 }
	
}
