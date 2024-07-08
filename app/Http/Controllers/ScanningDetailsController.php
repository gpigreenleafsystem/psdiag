<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scanning_details;

class ScanningDetailsController extends Controller
{
	//
	public function getInvestigations($scanType)
	    {
	            $investigations = Scanning_details::where('modality', $scanType)->get(['id', 'description', 'cost','ref_amount']);
	                    return response()->json($investigations);
	                        }
}
