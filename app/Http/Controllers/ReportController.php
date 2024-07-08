<?php

namespace App\Http\Controllers;

use App\Reports\MyReport;

class ReportController extends Controller
{
public function __contruct()
    {
        $this->middleware("guest");
    }
    public function index()
    {
        $report = new MyReport;
        $report->run();
        return view("pages.reports",["report"=>$report]);
    }
}
