@extends('layouts.apptable', [
    'namePage' => 'Monthly Report',
    'class' => 'sidebar-mini',
    'activePage' => 'monthlydetails',
  ])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
	    <h4 class="card-title"> Monthly Report</h4>
		@if(isset($message))
		 <div class="alert alert-info">
		<p>{{ $message }}</p>
		</div>
		@endif
          </div>
	  <div class="card-body">
<div>   <a href="{{ url()->previous() }}">Back</a></div>
<!--div>
<label for="startDate">Month :</label>
    <input name="startDate" id="startDate" class="date-picker" />
 <button class="btn btn-success filter">Filter</button>
    <!-- Display Total Balance Amount - ->

    </div-->
<form method="POST" action="{{ route('monthlyreport') }}">
@csrf
 <label for="datepicker">Select Date:</label>
    <div class="input-group date" id="datepick" data-target-input="nearest">
        <input type="text" id="datetimepicker1" class="form-control datetimepicker-input"  name="selected_date" />
        <div class="input-group-append" data-target="#datepicker" >
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
<button type="submit" class="btn btn-success filter">Filter</button>
</form>
<!--div class="input-group date" id="datepick">
    <input type="text" id="datetimepicker1" class="form-control" name="selected_date" />
    <div class="input-group-append" data-target="#datepick">
        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
    </div>
</div-->

	<table id="datatable" class="table table-striped table-bordered" cellspacing="0">
              <thead>
                <tr>
              
                  <th>Summary Date</th>
                  <th>MR</th>
		  <th>Disc</th>
		 <th>Net</th>
		 <th>Contrast</th>
		<th>Disc</th>
		<th>Net</th>
		<th>MR Contrast</th>
                  <th>Disc</th>
                 <th>Net</th>
		 <th>CT</th>
                  <th>Disc</th>
                 <th>Net</th>
                 <th>Contrast</th>
                <th>Disc</th>
                <th>Net</th>
                <th>CT Contrast</th>
                  <th>Disc</th>
		 <th>Net</th>
		<th>Total Gross</th>
                  <th>Total Disc</th>
                 <th>Total Net</th>
		</tr>
	      </thead>
	
<td colspan=1> Total Amount:</td>
<td></td>
<td></td>
</tfoot>
                              </tbody>
            </table>

          </div> <!--card body-->
        </div> <!--card -->
      </div> <!--col -->

      </div> <!-- row -->
    </div>  <!-- content -->
  @endsection


@section('scripts')
<!--script src="{{ asset('assets') }}/js/core/jquery.min.js"></script>
  <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
  <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
- ->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
-->




$(function () {
var table = $('#datatable').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('monthlyreport') }}",
columns: [
{data: 'date',name: 'date'},
{data: 'mr',name: 'mr'},
{data: 'mr_disc', name: 'mr_disc'},
{data: 'mr_net', name: 'mr_net'},
{data: 'mr_contrast', name: 'mr_contrast'},
{data: 'mr_contrast_disc', name: 'mr_contrast_disc'},
{data: 'mr_contrast_net', name: 'mr_contrast_net'},
{data: 'ct', name: 'ct'},
{data: 'ct_disc', name: 'ct_disc'},
{data: 'ct_net', name: 'ct_net'},
{data: 'ct_contrast', name: 'ct_contrast'},
{data: 'ct_contrast_disc', name: 'ct_contrast_disc'},
{data: 'ct_contrast_net', name: 'ct_contrast_net'},
{data: 'totalgross', name: 'totalgross'},
{data: 'totaldiscount', name: 'totaldiscount'},
{data: 'totalnet', name: 'totalnet'},

],

});
});
</script>
@endsection

@push('scripts')

<link href=
'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
          rel='stylesheet'>

    <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
    </script>

    <script src=
"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
    </script>
<link rel="stylesheet"
href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.css">
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.css"></script-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>


<script type="text/javascript">
    $(function () {
	    $('#datetimepicker1').datepicker({
            format: 'YYYY-MM'
    });

	     $('#datepick').datepicker({
        format: "mm/yyyy",
        startView: "months",
        minViewMode: "months",
        autoclose: true
    });


var totalMR = 0, totalMRDisc = 0, totalMRNet = 0;
var totalMRContrast = 0, totalMRContrastDisc = 0, totalMRContrastNet = 0;
var totalMR_Contrast = 0, totalMR_ContrastDisc = 0, totalMR_ContrastNet = 0;
var totalCT = 0, totalCTDisc = 0, totalCTNet = 0;
var totalCTContrast = 0, totalCTContrastDisc = 0, totalCTContrastNet = 0;
var totalCT_Contrast = 0, totalCT_ContrastDisc = 0, totalCT_ContrastNet = 0;
var totalgross=0, totaldisc=0,totalnet=0;
    // Add variables for other totals
   /* 
    $('#datatable tbody tr').each(function() {
        totalMR += parseFloat($(this).find('td').eq(1).text()) || 0;
        totalMRDisc += parseFloat($(this).find('td').eq(2).text()) || 0;
        totalMRNet += parseFloat($(this).find('td').eq(3).text()) || 0;
        totalMRContrast += parseFloat($(this).find('td').eq(4).text()) || 0;
        totalMRContrastDisc += parseFloat($(this).find('td').eq(5).text()) || 0;
	totalMRContrastNet += parseFloat($(this).find('td').eq(6).text()) || 0;
	totalMR_Contrast += parseFloat($(this).find('td').eq(7).text()) || 0;
        totalMR_ContrastDisc += parseFloat($(this).find('td').eq(8).text()) || 0;
        totalMR_ContrastNet += parseFloat($(this).find('td').eq(9).text()) || 0;
	// Continue for other columns
	totalCT += parseFloat($(this).find('td').eq(10).text()) || 0;
        totalCTDisc += parseFloat($(this).find('td').eq(11).text()) || 0;
        totalCTNet += parseFloat($(this).find('td').eq(12).text()) || 0;
        totalCTContrast += parseFloat($(this).find('td').eq(13).text()) || 0;
        totalCTContrastDisc += parseFloat($(this).find('td').eq(14).text()) || 0;
        totalCTContrastNet += parseFloat($(this).find('td').eq(15).text()) || 0;
        totalCT_Contrast += parseFloat($(this).find('td').eq(16).text()) || 0;
        totalCT_ContrastDisc += parseFloat($(this).find('td').eq(17).text()) || 0;
	totalCT_ContrastNet += parseFloat($(this).find('td').eq(18).text()) || 0;
	totalgross += parseFloat($(this).find('td').eq(19).text()) || 0;
        totaldisc += parseFloat($(this).find('td').eq(20).text()) || 0;
        totalnet += parseFloat($(this).find('td').eq(21).text()) || 0;
    });
    */
    // Append totals to the footer
    $('#datatable tfoot').html(`
        <tr>
            <th colspan="1">Total:</th>
            <th>${totalMR.toFixed(2)}</th>
            <th>${totalMRDisc.toFixed(2)}</th>
            <th>${totalMRNet.toFixed(2)}</th>
            <th>${totalMRContrast.toFixed(2)}</th>
            <th>${totalMRContrastDisc.toFixed(2)}</th>
	    <th>${totalMRContrastNet.toFixed(2)}</th>
	    <th>${totalMR_Contrast.toFixed(2)}</th>
            <th>${totalMR_ContrastDisc.toFixed(2)}</th>
            <th>${totalMR_ContrastNet.toFixed(2)}</th>
	    <!-- Add other totals here -->
	    <th>${totalCT.toFixed(2)}</th>
            <th>${totalCTDisc.toFixed(2)}</th>
            <th>${totalCTNet.toFixed(2)}</th>
            <th>${totalCTContrast.toFixed(2)}</th>
            <th>${totalCTContrastDisc.toFixed(2)}</th>
            <th>${totalCTContrastNet.toFixed(2)}</th>
            <th>${totalCT_Contrast.toFixed(2)}</th>
            <th>${totalCT_ContrastDisc.toFixed(2)}</th>
	    <th>${totalCT_ContrastNet.toFixed(2)}</th>
	    <th>${totalgross.toFixed(2)}</th>
            <th>${totaldisc.toFixed(2)}</th>
            <th>${totalnet.toFixed(2)}</th>
        </tr>
    `);




    });

</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

@endpush
	@push('styles')
	<link href="{{ asset('assets/css/tablestyles.css') }}" rel="stylesheet">
	@endpush
