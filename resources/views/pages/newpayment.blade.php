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
            <div class="col-md-12  mr-auto">
                <div class="card card-signup text-center">
                    <div class="card-header ">
                        <h4 class="card-title">{{ __('Process Payment') }}</h4>
                        <div class="alert alert-info" role="alert">
			    <?php $array = explode(',', $message);
$tot_amt = substr($array[0], strpos($array[0], "=") + 1);
 if (count($array) == 1) {
                                $paid_amt = 0;
                            } else {
                                $paid_amt = substr($array[1], strpos($array[1], "=") + 1);
                            }
                           
                            ?> 
                            @foreach($array as $item)
                            <strong>{{ $item }} Rs/-</strong>
                            @endforeach
                        </div>
                    </div>
                    @if ($bal !=0)
		    <div class="container">
			 <div class="border border-secondary">
</br>
                        <form action="{{ route('process_payment') }}" method="POST">
			@csrf
			<input type="hidden" name="bill_no" value={{ $bill->id }}>
				<input type="hidden" name="bal_amt" value={{ $bal }}>
  <input type="hidden" name="paid_amt" value={{ $paid_amt }}>
         
                            <input type="hidden" name="bill_no" value={{ $bill->id }}>
                            <div class="form-group row">
                                <label for="payment_mode" class="col-sm-5 col-form-label">Select Payment
                                    Mode</label>
                                <div class="col-sm-5">
                                    <select name="payment_mode" id="payment_mode" class="form-control">
                                        <option value="1">Full Payment</option>
					<option value="2">Part Payment</option>
<option value="3">Credit Payment</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="payment_method" class="col-sm-5 col-form-label">Select Payment
                                    Method</label>
                                <div class="col-sm-5">
                                    <select name="payment_method" id="payment_method" class="form-control">
                                        <option value=" netbanking">Netbanking</option>
                                        <option value="upi">UPI</option>
                                        <option value="cheque">Cheque</option>
i					<option value="cc">Credit/Debit card</option>
					<option value="cash">Cash</option>
					<option value="credit">Credit</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="payment_method" class="col-sm-5 col-form-label">Enter Amount
                                </label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" name="partial_amount"
                                        placeholder="Enter Amount" id="partial_amount">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="payment_details" class="col-sm-5 col-form-label">Payment details</label>
                                <div class="col-sm-5">
                                    <input type="text" name="payment_details"  placeholder="Enter Payment details"
                                        class="form-control" id="payment_details">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="payment_status" class="col-sm-5 col-form-label">Remarks</label>
                                <div class="col-sm-5">
				    <input type="text" name="payment_status" id=
"payment_status"  placeholder="Enter Remarks"  class="form-control" value="-">
                                </div>
                            </div>

                            <!-- Include other necessary input fields -->
                            <button type="submit" class="btn btn-primary">Add Payment</button>

                        </form>
		    </div>
</div>
                    @endif
                    <div class="card-body">
                        <?php if (!$payments->isEmpty()) { ?>

                        <div>
                            <h6 class="float-left">Payment details:</h6>

                            <?php $payids = $payments; ?>
                            <table class="table table-bordered ">
                                <thead>
                                    <th style="font-size: 1.05em; font-weight: 400;">
                                        Date
                                    </th>
                                    <th style="font-size: 1.05em; font-weight: 400;">
                                        Amount(Rs/-)
                                    </th>
                                    <th style="font-size: 1.05em; font-weight: 400;">
                                        Payment Mode
                                    </th>
                                </thead>
                                <tbody>

                                </tbody>


                                <?php foreach ($payids as $payment) { ?>
                                <tr>
				    <!--<td><?php echo $payment->created_at; ?></td>-->
					<td><?php echo DATE_FORMAT($payment->created_at, 'd/m/Y H:i:s')?></td>
                                    <td><?php echo $payment->partpayment_amount ?></td>
                                    <td><?php echo $payment->payment_mode ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div>

                        <div>
                            <div class="grid2">
                                <a href={{ url('/download_invoice/'. $bill->id) }}><button
                                        class="btn btn-default btn-custom-outline-primary btn-custom float-right">Download
                                        Receipt</button></a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Using jQuery
$(document).ready(function() {
    $('#payment_method').on('change', function() {

        if ($(this).val() === 'cash') {
		$('#payment_status').val('-'); // Set the value to '-'
	$('#payment_details').val('-'); // Set the value to '-'
	}
	if ($(this).val() === 'credit') {
            $('#partial_amount').val(0.00);
            $('#payment_details').val('-'); // Set the value to '-'
            $('#payment_status').val('-'); // Set the value to '-'
        }
    });
});
</script>

