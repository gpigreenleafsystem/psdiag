@extends('layouts.app', [
    'namePage' => 'Payment',
    'class' => 'sidebar-mini',
    'activePage' => 'payment',
  ])
@section('content')
<div class="panel-header panel-header-sm">
PROCESS PAYMENT
  </div>

<div class="content">
    <div class="container">
      <div class="row">
        <!--div class="col-md-5 ml-auto">
          <!--div class="info-area info-horizontal mt-5">
       	</div-->
        <div class="col-md-8  mr-auto">
          <div class="card card-signup text-center">
            <div class="card-header ">
              <h4 class="card-title">{{ __('Process Payment') }}</h4>
            <div class="card-body">
<div>
<div>
<!--div class="grid2">
<a href={{ url('/download_invoice/'. $bill->id) }} ><button class="btn btn-outline-primary btn-custom-outline-primary btn-custom">Download Receipt</button></a>
	</div-->
Payment details:<br/>
<?php $payids= $payments; //explode(",",$payments->part_payment_id);
                        //dd($payments);
      foreach ($payids as $payment) {

?>
	Date: <?php echo $payment->created_at; ?><t/>Amount: <?php echo $payment->partpayment_amount ?><t/> Mode: <?php echo $payment->payment_mode ?><br/>

<?php } ?>

</div>
<div class="alert alert-info">
<span>
{{ $message }}
</span></div>
</div>
@if ($bal !=0)
<form action="{{ route('process_payment') }}" method="POST">
@csrf
<input type="hidden" name="bill_no" value={{ $bill->id }}>
<div class="input-group">	
    <label for="payment_mode">Select Payment Mode:</label>
    <select name="payment_mode" id="payment_mode">
        <option value="full">Full Payment</option>
        <option value="partial">Part Payment</option>
    </select>
	</div>
 	<div class="input-group">
	<label for="payment_method">Select Payment Method:</label>
        <select name="payment_method" id="payment_method">
            <option value="netbanking">Netbanking</option>
	    <option value="upi">UPI</option>
		<option value="debit_card">Debit card</option>
		<option value="credit_card">Credit card</option>
		<option value="cash">Cash</option>
		<option value="cheque">Cheque</option>
            <!-- Add more options as needed -->
	</select>
	</div>
	<div class="input-group">
	<label for="partial_amount">Enter Amount:</label>
        <input type="number" name="partial_amount" placeholder="Enter Amount">

	</div>
	<div class="input-group">
        <label for="partial_method">Payment details:</label>
        <input type="text" name="payment_details" placeholder="Enter Payment details">

	</div>

	<div class="input-group">
        <label for="payment_status">Payment status:</label>
        <input type="text" name="payment_status" placeholder="Enter Payment details">

        </div>

    <!-- Include other necessary input fields -->
    <button type="submit">Add Payment</button>
</form>
@endif
<div>
<div class="grid2">
<a href={{ url('/download_invoice/'. $bill->id) }} ><button class="btn btn-outline-primary btn-custom-outline-primary btn-custom">Download Receipt</button></a>
        </div>
</div>
  </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
