@extends('layouts.app', [
    'namePage' => 'Payments List',
    'class' => 'sidebar-mini',
    'activePage' => 'viewpayments',
  ])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
	    <h4 class="card-title"> Payments</h4>
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
                  <th>Bill no</th>
                  <th>Payment Mode</th>
                  <th>Status</th>
		 <th>Amount</th>
		 <th>Details</th>
		<th>Date</th>
		<!--th>Scanning_status</th-->
                  <th class="disabled-sorting text-right">Actions</th>
                </tr>
	      </thead>
	@foreach($payments as $data)
		<tr>
                    <td>
                      <!--span class="avatar avatar-sm rounded-circle">
                        <img src="{{asset('assets')}}/img/default-avatar.png" alt="" style="max-width: 80px; border-radiu: 100px">
                      </span--> {{ $data->bill_no }}
                    </td>
                    <td>{{$data->payment_mode}}</td>
                    <td>{{$data->payment_status}}</td>
		    <td>{{$data->partpayment_amount}}</td>
		<td>{{$data->payment_details }}</td>
		<td>{{\Carbon\Carbon::parse($data->created_at)->format('d/m/Y')}}</td>
		<!--td>2dsa</td>
		<td>2dsa</td-->
                      <td>
                                             <a  href="{{ route('editpayment', ['id' => $data->id]) }}" rel="tooltip" class="btn btn-primary" title="">Edit  </a>
                                                              </td>
		  </tr>
		@endforeach
                              </tbody>
            </table>
		<div class="d-flex justify-content-center">
                        {{ $payments->links() }}
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

/*
$(function () {
var table = $('#datatable').DataTable({
processing: true,
serverSide: true,
ajax: "paymentslist",
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

