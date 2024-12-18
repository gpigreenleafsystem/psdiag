@extends('layouts.app', [
    'namePage' => 'Appointments List',
    'class' => 'sidebar-mini',
    'activePage' => 'viewappointment',
  ])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
	    <h4 class="card-title"> Appointments</h4>
		@if(isset($message))
		 <div class="alert alert-success">
		<p>{{ $message }}</p>
		</div>
		@endif
          </div>
	  <div class="card-body">

	<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Patient</th>
                  <th>Date</th>
                  <th>Status</th>
		  <!--th></th>
		 <th>Amount</th>
		 <th>Discount</th>
		<th>Report_status</th>
		<th>Scanning_status</th-->
                  <th class="disabled-sorting text-right">Actions</th>
                </tr>
	      </thead>
	@foreach($apdetails as $data)
		<tr>
                    <td>
                      <!--span class="avatar avatar-sm rounded-circle">
                        <img src="{{asset('assets')}}/img/default-avatar.png" alt="" style="max-width: 80px; border-radiu: 100px">
                      </span--> {{ $data->patient->name }}
                    </td>
                    <td>{{$data->appointment_date}}</td>
                    <td>{{$data->appointment_status}}</td>
		    <!--td></td>
		<td>2dsa</td>
		<td>2dsa</td>
		<td>2dsa</td>
		<td>2dsa</td-->
                      <td>
                                             <a  href="{{ route('vwappointment', ['id' => $data->id]) }}" rel="tooltip" class="btn btn-primary" title="View Appointment">VIEW  </a>
@if($data->appointment_status != 'COMPLETED')
<a href="{{url('editappointment/'.$data->id)}}" class="btn " title="Reschedule/Cancel Appointment">RESCHEDULE/CANCEL</a>
@endif
                                                              </td>
		  </tr>
		@endforeach
			      </tbody>

	    </table>
<div class="d-flex justify-content-center">
                        {{ $apdetails->links() }}
                    </div>

          </div> <!--card body-->
        </div> <!--card -->
      </div> <!--col -->

      </div> <!-- row -->
    </div>  <!-- content -->
  @endsection


@section('scripts')
<script src="{{ asset('assets') }}/js/core/jquery.min.js"></script>
  <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
  <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<script>


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
});
</script>
@endsection

