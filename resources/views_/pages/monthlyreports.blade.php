@extends('layouts.apptable', [
    'namePage' => 'Summary Details',
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
	    <h4 class="card-title"> Summary Details</h4>
		@if(isset($message))
		 <div class="alert alert-success">
		<p>{{ $message }}</p>
		</div>
		@endif
          </div>
	  <div class="card-body">

<div>
<label for="startDate">Month :</label>
    <input name="startDate" id="startDate" class="date-picker" />
 <button class="btn btn-success filter">Filter</button>
    <!-- Display Total Balance Amount -->

    </div>

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
		<th>MR_Contrast</th>
                  <th>Disc</th>
                 <th>Net</th>
		 <th>CT</th>
                  <th>Disc</th>
                 <th>Net</th>
                 <th>Contrast</th>
                <th>Disc</th>
                <th>Net</th>
                <th>CT_Contrast</th>
                  <th>Disc</th>
		 <th>Net</th>
		<th>Total Gross</th>
                  <th>Total Disc</th>
                 <th>Total Net</th>
		</tr>
	      </thead>
	
	@foreach($dataarr as $data)
		<tr>

		<td>{{$data->date}}</td>
                    <td>{{$data->mr}}</td>
                    <td>{{$data->mr_disc}}</td>
		    <td>{{$data->mr_net}}</td>
		<td>{{$data->mr_contrast}}</td>
		<td>{{$data->mr_contrast_disc}}</td>
		<td>{{$data->mr_contrast_net}}</td>
		<td>{{$data->mr - $data->mr_contrast}}</td>
		<td>{{$data->mr_disc - $data->mr_contrast_disc}}</td>
		<td>{{$data->mr_net - $data->mr_contrast_net}}</td>
			<td>{{$data->ct}}</td>
                    <td>{{$data->ct_disc}}</td>
                    <td>{{$data->ct_net}}</td>
                <td>{{$data->ct_contrast}}</td>
                <td>{{$data->ct_contrast_disc}}</td>
		<td>{{$data->ct_contrast_net}}</td>
		<td>{{$data->ct - $data->ct_contrast}}</td>
                <td>{{$data->ct_disc - $data->ct_contrast_disc}}</td>
                <td>{{$data->ct_net - $data->ct_contrast_net}}</td>
		 <td>{{$data->totalgross}}</td>
		<td>{{$data->totaldiscount}}</td>
		<td>{{$data->totalnet}}</td>
		  </tr>
		  @endforeach
		  <tr>
<td> Total Amount:</td>
<td>{{$totalamount}}</td>
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



/*
$(function () {
var table = $('#datatable').DataTable({
processing: true,
serverSide: true,
ajax: "investigations.index",
columns: [
{data: 'id',name: 'Id'},
{data: 'modality_id',name: 'Id'},
{data: 'study', name: 'Study'},
{data: 'qty', name: 'Qty'},
{data: 'rate', name: 'Rate'},
{data: 'amount', name: 'Amount'},
{data: 'discount', name: 'Discount'},
{data: 'report_status', name: 'Report_status'},
{data: 'scanning_status', name: 'Scanng_status'},

{
data: 'action',
name: 'action',
orderable: false,
searchable: false
}

],

});
});*/
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

<script type="text/javascript">
    $(function () {
	    $('#date-picker').datepicker({
            format: 'YYYY-MM'
    });
	    $('#time').timepicker({
        timeFormat: 'h:i a',
        interval: 30,
        minTime: '6:30am',
        maxTime: '10:00pm',
        defaultTime: '6:30',
        startTime: '6:30',
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        disableTimeRanges: [
            ['12:00pm', '12:01pm']
        ]
    });

    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

@endpush
	@push('styles')
	<link href="{{ asset('assets/css/tablestyles.css') }}" rel="stylesheet">
	@endpush
