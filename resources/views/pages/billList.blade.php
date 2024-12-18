@extends('layouts.app', [
'namePage' => 'Bill List',
'class' => 'sidebar-mini',
'activePage' => 'billList',
])
@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center"> Bill List</h4>
                    @if(isset($message))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>


                <div class="card-body">
                    <div>
                        <form action="billsearch" method="POST" role="search">
                            {{ csrf_field() }}
                            <div class="form-inline float-right">
                                <input type="text" class="form-control mb-2 mr-sm-2" name="q"
                                    placeholder="Search By Bill No">

                                <button type="submit" class="btn btn-primary " style="margin-top:-2px;">{{__('Search')}}
                                </button>
                                <a href="{{ route('billList') }}" class="btn pull-right" style="margin-top:-2px;">
                                    {{ __("Clear Search") }}
                                </a>
                            </div>
                        </form>
		    </div>

                    <table id=" datatable" class="table table-striped table-bordered" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th><strong>Sl.no</strong></th>
                                <th><strong>Id</strong></th>
                                <th><strong>Bill No</strong></th>
                                <th><strong>Bill Date</strong></th>
                                <th><strong>Patient Name</strong></th>
                                
				 <th style="width:100px;"><strong>Patient Phone</strong></th>
				<th><strong>Amount</strong></th>
				  <th style="width:100px;"><strong>Due Amount</strong></th>
                                <th class="disabled-sorting text-left"><strong>Actions</strong></th>
                            </tr>
                        </thead>
			<?php 
			$i = 0;
			if($allBillInfo->count()>0 & $allBills!=null){ ?>

                        @foreach($allBills as $key => $data)
                        <tr>
                            <td>{{ $key + 1 + ($allBillInfo->currentPage() - 1) * $allBillInfo->perPage() }}</td>
                            <td>{{$data['bill_id']}}</td>
                            <td>{{$data['bill_no']}}</td>
                            <td>{{ \Carbon\Carbon::parse($data['bill_date'])->format('d/m/Y H:i:s') }}</td>
                            <td>{{$data['patientName']}}</td>
                            <td>{{$data['patientNo']}}</td>
			    <td>{{$data['bill_amount']}}</td>
				  <td>{{$data['bill_dueamount']}}</td>
                            <td>
                                <a href="{{ route('viewBillPay', ['id' => $data['bill_id']]) }}" rel="tooltip"
                                    class="btn btn-primary" title="View Bll">View </a>
                                <?php
                                if (Auth::user()->usertype == "ADMIN" || Auth::user()->usertype == "LEADFRONTDESK") { ?>
 
                               
                                <a href="{{ route('editBillPay', ['id' => $data['bill_id']]) }}" rel="tooltip"
                                    class="btn btn-primary" title="Edit Payment">Edit Payment </a>
                                <?php } ?>



                            </td>


                        </tr>
			@endforeach
<?php 
			}?>
                        </tbody>

                    </table>

                    <div class="d-flex justify-content-center">

                        {!! $allBillInfo->links() !!}
                    </div>

                </div>

                @endsection
