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
	    <h4 class="card-title">  Appointments</h4>
		@if(isset($message))
		 <div class="alert alert-success">
		<p>{{ $message }}</p>
		</div>
		@endif
          </div>
	  <div class="card-body">
 <table id="datatable" class="table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="font-size: 1.05em; font-weight: 600;" class="text-left">Patient Name</th>
                                <th style="font-size: 1.05em; font-weight: 600;" class="text-left">Contact No</th>
                                <th style="font-size: 1.05em; font-weight: 600;" class="text-left">Date</th>
                                <th style="font-size: 1.05em; font-weight: 600;" class="text-left">Status</th>
                                <th style="font-size: 1.05em; font-weight: 600;" class="disabled-sorting text-left">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @for ($i = 0; $i < count($aptInfos); $i++) <tr>
                                <td>{{ $aptInfos[$i]['patientName'] }}</td>
                                <td>{{ $aptInfos[$i]['patientNo'] }}</td>
                                <td>{{ $aptInfos[$i]['aptdate'] }}</td>
                                <td>{{ $aptInfos[$i]['aptstatus'] }}</td>
                                <td class="text-left">
                                    @if($aptInfos[$i]['billstatus']==1)
                                    <a type="button" href="{{ route('newbilling', ['id' => $aptInfos[$i]['id']]) }}"
                                        rel="tooltip" class="btn btn-primary btn-large " data-original-title="" title=""
                                        disabled>
                                        Genarate Bill
                                    </a>

                                    <a type="button"
                                        href="{{ route('newpayment', ['id' => $aptInfos[$i]['bill_no']]) }}"
                                        rel="tooltip" class="btn btn-primary btn-large " data-original-title=""
                                        title="Payment">

                                        PAYMENT
                                    </a>
                                    @else
                                    <a type="button" href="{{ route('newbilling', ['id' => $aptInfos[$i]['id']]) }}"
                                        rel="tooltip" class="btn btn-primary btn-large " data-original-title="" title="">
                                        Genarate Bill
                                    </a>

                                    <a type="button" href="" rel="tooltip" class="btn btn-primary btn-large "
                                        data-original-title="" title="Payment" disabled>

                                        PAYMENT
                                    </a>



                                    @endif
                                </td>

                                </tr>
                                @endfor
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

