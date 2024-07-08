@extends('layouts.app', [
    'namePage' => 'Reports',
    'class' => 'sidebar-mini',
    'activePage' => 'reports',
  ])
@section('content')
<div class="panel-header panel-header-sm">
PROCESS PAYMENT
  </div>
@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"> Modalities</h4>
          </div>
          <div class="card-body">
<?php $report->render(); ?>

 </div> <!--card body-->
        </div> <!--card -->
      </div> <!--col -->

      </div> <!-- row -->
    </div>  <!-- content -->
  @endsection

