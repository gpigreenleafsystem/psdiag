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
                  <th>Id</th>
                  <th>Payment Mode</th>
                  <th>Bill No</th>
		 <th>Payment_status</th>
		 <th>Payment_amount</th>
		<th>Payment_details</th>
		<th>Date</th>
		<!--th>Scanning_status</th-->
                  <th class="disabled-sorting text-right">Actions</th>
                </tr>
	      </thead>
		<tbody>	    
		</tbody>
            </table>

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
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

<script>


$(function () {
var table = $('#datatable').DataTable({
processing: true,
serverSide: true,
ajax: "paymentslist",
columns: [
{data: 'id',name: 'id'},
{data: 'payment_mode',name: 'payment_mode'},
{data: 'bill_no', name: 'bill_no'},
{data: 'payment_status', name: 'payment_status'},
{data: 'partpayment_amount', name: 'partpayment_amount'},
{data: 'payment_details', name: 'payment_details'},
{data: 'created_at', name: 'created_at'},
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

