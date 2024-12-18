@extends('layouts.app', [
    'namePage' => 'Edit Part Payment',
    'class' => 'sidebar-mini',
    'activePage' => 'editpayment',
])

@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Payment</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('updatepayment', $partPayment->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="bill_no">Bill Number</label>
                            <input type="text" name="bill_no" class="form-control" value="{{ $partPayment->bill_no }}" required disabled>
                        </div>
                        <div class="form-group">
                            <label for="payment_status">Payment Status</label>
                            <input type="text" name="payment_status" class="form-control" value="{{ $partPayment->payment_status }}" required disabled>
			</div>
			<div class="form-group">
                            <label for="payment_mode">Payment Mode</label>
				<select name="payment_mode" class="form-control" required>
                                <option value="netbanking" {{ $partPayment->payment_mode == 'netbanking' ? 'selected' : '' }}>Netbanking</option>
				<option value="debit_card" {{ $partPayment->payment_mode == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
<option value="cc" {{ $partPayment->payment_mode == 'cc' ? 'selected' : '' }}>CC</option>		  
<option value="upi" {{ $partPayment->payment_mode == 'upi' ? 'selected' : '' }}>UPI</option>
<option value="cash" {{ $partPayment->payment_mode == 'cash' ? 'selected' : '' }}>Cash</option>
<option value="cheque" {{ $partPayment->payment_mode == 'cheque' ? 'selected' : '' }}>Cheque</option>
</select>
	    <!--input type="text" name="payment_mode" class="form-control" value="{{ $partPayment->payment_mode }}" required-->
                        </div>
                        <div class="form-group">
                            <label for="partpayment_amount">Payment Amount</label>
                            <input type="number" name="partpayment_amount" class="form-control" value="{{ $partPayment->partpayment_amount }}" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_details">Payment Details</label>
                            <textarea name="payment_details" class="form-control">{{ $partPayment->payment_details }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('paymentlist') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

