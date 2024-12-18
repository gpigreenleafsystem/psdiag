@extends('layouts.app', [
'namePage' => 'View Bill Payment',
'class' => 'sidebar-mini',
'activePage' => 'viewBill',
])

@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">View Bill</h4>
                </div>
                <div class="card-body">
                    <h6>Bill Details:</h6>

                    <table class="table table-borderless">
                        <tr>
                            <td>Name</td>
                            <td>:&nbsp;{{ ucfirst($bd->Patient_name) }}</td>
                            <td>Bill No</td>
                            <td>:&nbsp;{{ $bd->bill_no }}</td>
                        </tr>
                        <tr>
                            <td>Sex</td>
                            <td>:&nbsp;{{ ucfirst($bd->gender) }}</td>
                            <td>Date & Time</td>
                            <td>:&nbsp;{{ $bd->bill_date }}</td>
                        </tr>
                        <tr>
                            <td>Age (In Yrs)</td>
                            <td>:&nbsp;{{ $bd->Patient_age }}</td>
                            <td>Ref. Dr</td>
                            <td>:&nbsp;{{ ucfirst($bd->drref) }}</td>
                        </tr>
                    </table>

                    <h6>Investigation Details</h6>

                    @if(count($bd->scanningdetails) > 0)
                    <table class="table table-striped table-bordered" style="font-size:12px;">
                        <tr>
                            <th class="sl-no">Sl.No</th>
                            <th class="modality">Modality</th>
                            <th class="invest">Investigation</th>
                            <th class="qty">Qty</th>
                            <th class="rate">Rate</th>
                            <th class="disc">Discount</th>
                            <th class="amt">Amount(Rs)</th>
                        </tr>
                        <?php $i = 1;
                        $totalCharges = 0;
                        $totalRate = 0;
                        $totalDiscount = 0; ?>
                        @foreach($bd->scanningdetails as $inv)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $inv->modality }}</td>
                            <td>{{ $inv->description }}</td>
                            <td>{{ $inv->qty }}</td>
                            <td>{{ $inv->rate > 0 ? number_format($inv->rate, 2): '0.00' }}</td>
                            <td>{{ $inv->discount  > 0 ? number_format($inv->discount , 2): '0.00' }}</td>
                            <td>{{ $inv->amount > 0 ? number_format($inv->amount, 2): '0.00' }}</td>
                            <?php $totalCharges += $inv->amount;
                            $totalRate += $inv->rate;
                            $totalDiscount += $inv->discount; ?>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="4" style="text-align:right;"><strong>Total</strong></td>

                            <td>{{ $totalRate > 0 ? number_format($totalRate, 2): '0.00' }}</td>
                            <td>{{ $totalDiscount > 0 ? number_format($totalDiscount, 2): '0.00' }}</td>
                            <td>{{ $totalCharges > 0 ? number_format($totalCharges, 2): '0.00' }}</td>
                        </tr>
                    </table>
                    @else
                    <p>No Investigation Details available.</p>
                    @endif

                    <h6>Payment Details</h6>

                    @if(count($payments) > 0)
                    <table class="table table-striped table-bordered" style="font-size:12px;" id="payDetails">
                        <tr>
                            <th>Date</th>
                            <th>Payment Mode</th>
                            <th>Amount</th>
                            <th>Payment Details</th>
                        </tr>
                        <?php $totalPayDetailsAmount = 0; ?>
                        @foreach($payments as $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i:s') }}</td>
                            <td>{{ ucfirst($data->payment_mode) }}</td>
                            <td>{{ number_format($data->partpayment_amount, 2) }}</td>
                            <td>{{ $data->payment_details }}</td>
                        </tr>
                        <?php $totalPayDetailsAmount += $data->partpayment_amount; ?>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="2" style="text-align:right;"><strong>Total</strong></td>
                            <td>{{ number_format($totalPayDetailsAmount, 2) }}</td>
                            <td></td>
                        </tr>
                    </table>
                    @else
                    <p>No Payment Details available.</p>
                    @endif

                    <span>
                        Total Billed Amount Rs.<input type="text" class="billTotal" name="billTotal" id="billTotal"
                            value="{{ number_format($bd->netamount, 2) }}" readonly
                            style="width: 80px; text-align: left;border:0px;font-weight: bold;">
                        Paid Amount Rs.
                        <input type="text" class="billPaidAmt" name="billPaidAmt" id="billPaidAmt"
                            value="{{ count($payments) > 0 ? number_format($bd->totpaidamount, 2): '0.00' }}" readonly
                            style="width: 100px; border:0px;font-weight: bold;">
                        and Due Amount Rs.
                        <input type="text" class="billDueAmt" name="billDueAmt" id="billDueAmt"
                            value="{{ count($payments) > 0 ? number_format($bd->balanceamount, 2) : number_format($bd->netamount, 2)}}"
                            readonly style="width: 100px; text-align: left;border:0px;font-weight: bold;">
                    </span>

                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
