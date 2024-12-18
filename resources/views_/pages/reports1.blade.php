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

	<table id="datatable" name="datatable"  class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
		<tr>
		<th>id</th>
                  <th>bill_no</th>
                  <th>payment_mode</th>
                  <th>payment_status</th>
		 <th>partpayment_amount</th>
		 <th>payment_details</th>
		<th>created_date</th>
		<!--th>Scanning_status</th- ->
                  <th class="disabled-sorting text-right">Actions</th-->
                </tr>
	      </thead>
<tbody>
</tbody>
		<!--tr>
                    <td>
                      <!--span class="avatar avatar-sm rounded-circle">
                        <img src="{{asset('assets')}}/img/default-avatar.png" alt="" style="max-width: 80px; border-radiu: 100px">
		<!--td>2dsa</td>
		<td>2dsa</td- ->
                      <td>
                                                              </td>
		  </tr>
		
                              </tbody-->
            </table>

          </div> <!--card body-->
        </div> <!--card -->
      </div> <!--col -->

      </div> <!-- row -->
    </div>  <!-- content -->
  @endsection


@section('scripts')
<script>
$(document).ready(function () {
/*var table = $('#datatable').DataTable({
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

	var table = $("#datatable").DataTable({
              serverSide: true,
              ajax: {
                  url: 'reportsnew',
		  data: function (data) {
			alert(data);
                      data.params = {
                          sac: "helo"
                      }
                  }
              },
	      buttons: false,
		order: [[ 0 , "desc" ]],
              searching: true,
              scrollY: 500,
              scrollX: true,
              scrollCollapse: true,
	      columns: [
		{data: "id", className: 'id'},
		  {data: "bill_no", className: 'bill_no'},
                  {data: "payment_mode", className: 'payment_mode'},
                  {data: "payment_status", className: 'payment_status'},
		  {data: "partpayment_amount", className: 'partpayment_amount'},
		{data: "payment_details", className: 'payment_details'},
		{data: "created_at", className: 'created_at'},
		 /* {data: 'action', name: 'action', orderable: false, searchable: false},
		  {data:"checkbox",className: 'users_checkbox',orderable:false,searchable:false},*/
              ]
});
});
</script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
@endsection
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

