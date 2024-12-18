@extends('layouts.app', [
    'namePage' => 'Table List',
    'class' => 'sidebar-mini',
    'activePage' => 'table',
  ])

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

	<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Study</th>
                  <th>Qty</th>
		  <th>Rate</th>
		 <th>Amount</th>
		 <th>Discount</th>
		<th>Report_status</th>
		<th>Scanning_status</th>
                  <th class="disabled-sorting text-right">Actions</th>
                </tr>
	      </thead>
<?php $i=0;?>
	@foreach($invdet as $data)
<?php $i++;?>
		<tr>
                    <td>
                      <!--span class="avatar avatar-sm rounded-circle">
                        <img src="{{asset('assets')}}/img/default-avatar.png" alt="" style="max-width: 80px; border-radiu: 100px">
			</span--> <?php echo $i;?>
                    </td>
                    <td>{{$data->study}}</td>
                    <td>{{$data->qty}}</td>
		    <td>{{$data->amount}}</td>
<td>{{$data->rate}}</td>
		<td>{{$data->discount}}</td>
		<td>{{$data->report_status}}</td>
		<td>{{$data->scanning_status}}</td>
		 <td class="text-right">
                                             <a type="button" href="#" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                        <i class="now-ui-icons ui-2_settings-90"></i>
                      </a>
                                                              </td>
		  </tr>
		@endforeach
                              </tbody>
            </table>
	<div class="d-flex justify-content-center">
                        {{ $invdet->links() }}
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

