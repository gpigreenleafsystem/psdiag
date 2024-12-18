@extends('layouts.app', [
'namePage' => 'Edit Bill Payment',
'class' => 'sidebar-mini',
'activePage' => 'editBill',
])

@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Edit Bill Payment</h4>
                </div>
                <div class="card-body">
                    <h6> Bill Details:</h6>

                    <table class="table table-borderless">
                        <tr>
                            <td>Name</td>
                            <td>:&nbsp;<?php echo ucfirst($bd->Patient_name) ?></td>
                            <td>Bill No</td>
                            <td>:&nbsp;<?php echo $bd->bill_no ?></td>
                        </tr>
                        <tr>
                            <td>Sex</td>
                            <td>:&nbsp;<?php echo ucfirst($bd->gender) ?></td>
                            <td>Date & Time</td>
                            <td>:&nbsp;<?php echo $bd->bill_date; ?></td>
                        </tr>
                        <tr>
                            <td>Age (In Yrs)</td>
                            <td>:&nbsp;<?php echo  ucfirst($bd->Patient_age) ?> </td>
                            <td>Ref. Dr</td>
                            <td>:&nbsp;<?php echo ucfirst($bd->drref) ?></td>
                        </tr>
                    </table>

                    </hr>
                    <h6>Investigation Details</h6>


                    <form method="POST" action="{{ route('submitTable') }}">
		    @csrf
		     @if(count($bd->scanningdetails) > 0)
                        <input type="hidden" id="billno" name="billno" value="<?php echo $bd->bill_no ?>" />
                        <input type="hidden" id="billid" name="billid" value="<?php echo $bd->bill_id ?>" />
                        <button type="button" class="btn btn-primary" style="float:right;" onclick="addRow()">Add
                            Investigation</button>
                        <table class="table table-striped table-bordered" style="font-size:12px;">
                            <tr>
                                <th class="sl-no">Sl.No</th>
                                <th class="modality">Modality</th>
                                <th class="invest">Investigation</th>
                                <th class="qty">Qty</th>
                                <th class="rate">Rate</th>
                                <th class="disc">Discount</th>
                                <th class="amt">Amount(Rs)</th>
                                <th colspan="2" style="text-align:center;">Action</th>

                            </tr>
                            <?php $i = 1;
                            $totalCharges = 0;
                            $rowcount = 0;
                            $totalRate = 0;
                            $totalDiscount = 0;
                            // echo count($bd->scanningdetails);
                            foreach ($bd->scanningdetails as $inv) { ?>
                            <tr>
                                <input type="hidden" name="inv_row_edited[]" class="inv-row-edited" value="0">
                                <!-- 0 means not edited -->
                                <td><?php echo $i++ ?> </td>
                                <td><span class="modtext"><?php echo $inv->modality ?></span>
                                    <select class="modinput" name="modality[]"
                                        onchange="populateInvestigation(this, <?php echo $rowcount ?>)"
                                        style=" display: none;">
                                        <option value="CT">CT</option>
                                        <option value="MR">MR</option>
                                    </select>
                                </td>

                                <td><span class="investigationText"><?php echo $inv->description ?></span>
                                    <select class="investigationInput" id="investigation[]" name="investigation[]"
                                        style=" display: none;">
                                        <option value="">Select Investigation</option>
                                    </select>
                                </td>
                                <!-- <td><?php echo $inv->qty ?></td> -->
                                <td class=" qty"><span class="qty-text">{{ $inv->qty }}</span>
                                    <input type="number" step="0.01" class="qty-input" name="qty[]"
                                        value="{{ $inv->qty }}"
                                        style="display:none;width:50px;padding:2px;text-align:center;">&nbsp;&nbsp;
                                </td>
                                <td class="rate"><span class="rate-text">

                                        {{ $inv->rate }}</span>
                                    <input type="number" step="0.01" class="rate-input" name="rate[]"
                                        value="{{ $inv->rate }}"
                                        style="display:none;width:100px;padding:2px;text-align:center;">&nbsp;&nbsp;
                                </td>
                                <td class="disc"><span class="disc-text">{{ $inv->discount }}</span>
                                    <input type="number" step="0.01" class="disc-input" name="disc[]"
                                        value="{{ $inv->discount }}"
                                        style="display:none;width:100px;padding:2px;text-align:center;">&nbsp;&nbsp;
                                </td>
                                <td class="amt"><span class="charge-text">{{ $inv->amount}}</span>
                                    <input type="number" step="0.01" class="charge-input" name="charges[]"
                                        value="{{ $inv->amount }}"
                                        style="display:none;width:100px;padding:2px;text-align:center;">&nbsp;&nbsp;
                                </td>

                                <?php $totalCharges = $totalCharges + $inv->amount; ?>
                                <?php $totalRate = $totalRate +  $inv->rate; ?>
                                <?php $totalDiscount = $totalDiscount +  $inv->discount; ?>
                                <td>
                                    <button type="button" class="btn btn-primary editInv-btn" id=""
                                        onclick="makeInvestigationEditable(this.parentElement.parentElement)">Edit
                                        Scan</button>
                                    <button type="button" class="btn btn-primary saveInv-btn"
                                        onclick="saveInvestigationRow(this.parentElement.parentElement)"
                                        style="display:none;">Save</button>
                                </td>

                                <td>
                                    <button type="button" class="btn btn-primary edit-btn"
                                        onclick="makeNumEditable(this.closest('tr'))">Edit</button>
                                    <button type="button" class="btn btn-primary save-btn" style="display: none;"
                                        onclick="saveNoRow(this.closest('tr'))">Save</button>
                                </td>

                                <input type="hidden" name="investigation_ids[]" value="{{ $inv->id }}">
                                <!-- Hidden field for investigation ID -->

                            </tr>
                            <input type="hidden" name="updateinvCount" value="{{ count($bd->scanningdetails) }}">
                            <input type="hidden" name="totalinvCount" value="{{ $i }}">


                            <?php } ?>

                            <input type="hidden" name="newinvcount" value="0" id="newinvcount">
                            <tr class="total-row">
                                <td colspan="4" style="text-align:right;"><strong>Total</strong></td>
                                <td class="rate">
                                    <input type="text" id="totalRate" name="totalRate" value="{{$totalRate}}" readonly
                                        style="width: 100px; text-align: left;border:0px;font-weight: bold;">
                                </td>
                                <td class="disc">

                                    <input type="text" id="totalDiscount" name="totalDiscount"
                                        value="{{$totalDiscount }}" readonly
                                        style="width: 100px; text-align: left;border:0px;font-weight: bold;">
                                </td>
                                <td class="amt">

                                    <input type="text" id="totalAmount" name="totalAmount" value="{{ $totalCharges }}"
                                        readonly style="width: 100px; text-align: left;border:0px;font-weight: bold;">

                                </td>
                            </tr>
			</table>
  @else
                        <p>No Investigation Details available.</p>
                        @endif

                        </hr>

			<h6>Payment Details</h6>
  @if(count($payments) > 0)
                        <button type="button" class="btn btn-primary" style="float:right;" onclick="addPaymentRow()">Add
                            Payment</button>
                        <table class="table table-striped table-bordered " style="font-size:12px;" id="payDetails">
                            <tr>
                                <th>Date</th>
                                <th>PaymentMode</th>
                                <th>Amount</th>
                                <th>Payment Details</th>
                                <th>Action</th>
                            </tr>
                            <?php $totalPayDetailsAmount = 0 ?>
                            @foreach($payments as $data)
                            <tr>
                                <input type="hidden" name="id[]" value="{{ $data->id }}">

                                <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i:s') }}</td>
                                <td><span class="paymentModeText">{{ucfirst($data->payment_mode)}}</span>
                                    <select class="paymentModeInput" name="payment_mode[]" style="display:none;">
                                        <option value="netbanking">Netbanking</option>
                                        <option value="credit">Credit</option>
					<option value="cash">Cash</option>
					  <option value="cheque">Cheque</option>
                                        <option value="debit_card">Debit Card</option>
                                        <option value="upi">UPI</option>
                                    </select>
                                </td>
                                <td><span
                                        class="paymentAmtText">{{ number_format($data->partpayment_amount, 2) }}</span>
                                    <input type="number" class="paymentAmtInput" step="0.01" name="amount[]"
                                        value="{{ $data->partpayment_amount }}" style="display:none;">
                                </td>
                                <td><span class="paymentDetailsText">{{ $data->payment_details }}</span>
                                    <input type="text" class="paymentDetailsInput" name="details[]"
                                        value="{{ $data->payment_details }}" style="display:none;">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary editPay-btn" id=""
                                        onclick="makeEditable(this.parentElement.parentElement)">Edit</button>
                                    <button type="button" class="btn btn-primary savePay-btn"
                                        onclick="saveRow(this.parentElement.parentElement)"
					style="display:none;">Save</button>
					<input type="hidden" id="payEdited[]" name="payEdited[]" value="0">
                                </td>
                            </tr>
                            <?php $totalPayDetailsAmount = $totalPayDetailsAmount + $data->partpayment_amount ?>
                            @endforeach
                            <tbody id="paymentRows"></tbody>
                            <tr class="total-row">
                                <td colspan="2" style="text-align:right;"><strong>Total</strong></td>
                                <td><input type="text" id="totalPayDetailsAmount" name="totalPayDetailsAmount" readonly
                                        style="width: 100px; text-align: left; border:0px; font-weight: bold;"
                                        value="{{ number_format($totalPayDetailsAmount, 2) }}"></td>
                                <td colspan="2"></td>
                            </tr>

			</table>
 @else
                        <p>No Payment Details available.</p>
                        @endif
                        <input type="hidden" name="newpaycount" value="0" id="newpaycount">
                        <input type="hidden" id="oldpaycount" name="oldPayRow" value="{{ count($payments) }}" />
                        <span>
                            Total Billed Amount Rs.<input type="text" class="billTotal" name="billTotal" id="billTotal"
                                value="{{$bd->netamount }}"
                                style="width: 80px; text-align: left;border:0px;font-weight: bold;">
                            Paid Amount Rs.
                            <input type="text" class="billPaidAmt" name="billPaidAmt" id="billPaidAmt"
                                value="{{ $bd->totpaidamount }}" style="width: 100px; border:0px;font-weight: bold;">
                            and Due Amount Rs.
                            <input type="text" class="billDueAmt" name="billDueAmt" id="billDueAmt"
                                value="{{$bd->balanceamount}}"
                                style="width: 100px; text-align: left;border:0px;font-weight: bold;">

                        </span>
                        <br>
			<button type="submit" class="btn btn-primary" disabled id="submitbtn">Save</button>
                        <button  class="btn btn-default " a href="{{ route('billList') }}" >Cancel</button>
                        <!-- <button type="button" class="btn " onclick="cancelEdit()">Cancel</button> -->
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@pushscript
<script>
function makeEditable(row) {
    document.getElementById("submitbtn").disabled = false;

    var cells = row.getElementsByTagName('td');
    /*alert(
        "makeeditable"
    );*/
    var paymentModeText = cells[1].getElementsByClassName('paymentModeText')[0];
    var paymentModeInput = cells[1].getElementsByClassName('paymentModeInput')[0];



    // Show input box and hide text
    paymentModeText.style.display = 'none';
    paymentModeInput.style.display = 'inline';


    var paymentDetailsText = cells[3].getElementsByClassName('paymentDetailsText')[0];
    var paymentDetailsInput = cells[3].getElementsByClassName('paymentDetailsInput')[0];
    // Show input box and hide text
    paymentDetailsText.style.display = 'none';
    paymentDetailsInput.style.display = 'inline';

    row.getElementsByClassName('editPay-btn')[0].style.display = 'none';
    row.getElementsByClassName('savePay-btn')[0].style.display = 'inline';

    var paymentAmtText = cells[2].getElementsByClassName('paymentAmtText')[0];
    var paymentAmtInput = cells[2].getElementsByClassName('paymentAmtInput')[0];

    // // Show input box and hide text
    paymentAmtText.style.display = 'none';
    paymentAmtInput.style.display = 'inline';

     const inputs = row.querySelectorAll('input');
    // Set payEdited input value to 1
    const payEditedInput = row.querySelector('input[name="payEdited[]"]');
    if (payEditedInput) {
        payEditedInput.value = '1';
    }


}

function saveRow(row) {
    var cells = row.getElementsByTagName('td');
    var paymentModeText = cells[1].getElementsByClassName('paymentModeText')[0];
    var paymentModeInput = cells[1].getElementsByClassName('paymentModeInput')[0];

    paymentModeText.innerHTML = paymentModeInput.value;
    // Show input box and hide text
    paymentModeText.style.display = 'inline';
    paymentModeInput.style.display = 'none';

    var paymentDetailsText = cells[3].getElementsByClassName('paymentDetailsText')[0];
    var paymentDetailsInput = cells[3].getElementsByClassName('paymentDetailsInput')[0];

    paymentDetailsText.innerHTML = paymentDetailsInput.value;
    // Show input box and hide text
    paymentDetailsText.style.display = 'inline';
    paymentDetailsInput.style.display = 'none';

    var paymentAmtText = cells[2].getElementsByClassName('paymentAmtText')[0];
    var paymentAmtInput = cells[2].getElementsByClassName('paymentAmtInput')[0];
    var amountValue = parseFloat(paymentAmtInput.value);
    if (isNaN(amountValue)) {
        alert('Please enter a valid float value for the amount.');

        return;
    }
    paymentAmtText.innerHTML = amountValue.toFixed(2);
    // // Show input box and hide text
    paymentAmtText.style.display = 'inline';
    paymentAmtInput.style.display = 'none';

    // var paymentDetailsText = cells[3].getElementsByClassName('paymentDetailsText')[0];
    // var paymentDetailsInput = cells[3].getElementsByClassName('paymentDetailsInput')[0];

    // paymentDetailsText.innerHTML = paymentDetailsInput.value;
    // // Show input box and hide text
    // paymentDetailsText.style.display = 'inline';
    // paymentDetailsInput.style.display = 'none';

    row.getElementsByClassName('editPay-btn')[0].style.display = 'inline';
    row.getElementsByClassName('savePay-btn')[0].style.display = 'none';

    updateTotalPaidAmount();
}


function cancelEdit() {
    var rows = document.querySelectorAll('table tr');
    rows.forEach(function(row, index) {
        if (index > 0) { // Skip header row
            var cells = row.getElementsByTagName('td');
            if (cells[3].getElementsByClassName('charge-input').length > 0) {
                cells[3].getElementsByClassName('charge-text')[0].style.display = 'inline';
                cells[3].getElementsByClassName('charge-input')[0].style.display = 'none';
            }
            if (cells[2].getElementsByTagName('input').length > 0) {
                cells[2].innerText = '$' + parseFloat(cells[2].getElementsByTagName('input')[0].value).toFixed(
                    2);
                cells[3].innerText = cells[3].getElementsByTagName('input')[0].value;
                cells[1].innerText = cells[1].getElementsByTagName('select')[0].value;
            }
            row.getElementsByClassName('edit-btn')[0].style.display = 'inline';
            row.getElementsByClassName('save-btn')[0].style.display = 'none';
        }
    });
}

function makeInvestigationEditable(row) {
    row.querySelector('.inv-row-edited').value = "1"; // Set to 1 meaning row is edited

    //alert("makeInvestigationEditable");
    var cells = row.getElementsByTagName('td');

    document.getElementById("submitbtn").disabled = false;

    // alert("inv_row_edited set to 1");
    var modtext = cells[1].getElementsByClassName('modtext')[0];
    var modinput = cells[1].getElementsByClassName('modinput')[0];

    // Show input box and hide text
    modtext.style.display = 'none';
    modinput.style.display = 'inline';


    var investigationText = cells[2].getElementsByClassName('investigationText')[0];
    var investigationInput = cells[2].getElementsByClassName('investigationInput')[0];

    // // Show input box and hide text
    investigationText.style.display = 'none';
    investigationInput.style.display = 'inline';



    var qtyText = cells[3].getElementsByClassName('qty-text')[0];
    var qtyInput = cells[3].getElementsByClassName('qty-input')[0];
    // Show input box and hide text
    qtyText.style.display = 'none';
    qtyInput.style.display = 'inline';

    var rateText = cells[4].getElementsByClassName('rate-text')[0];
    var rateInput = cells[4].getElementsByClassName('rate-input')[0];
    // Show input box and hide text
    rateText.style.display = 'none';
    rateInput.style.display = 'inline';

    var discText = cells[5].getElementsByClassName('disc-text')[0];
    var discInput = cells[5].getElementsByClassName('disc-input')[0];
    // Show input box and hide text
    discText.style.display = 'none';
    discInput.style.display = 'inline';

    var chargeText = cells[6].getElementsByClassName('charge-text')[0];
    var chargeInput = cells[6].getElementsByClassName('charge-input')[0];

    // Show input box and hide text
    chargeText.style.display = 'none';
    chargeInput.style.display = 'inline';


    row.getElementsByClassName('editInv-btn')[0].style.display = 'none';
    row.getElementsByClassName('saveInv-btn')[0].style.display = 'inline';
    row.querySelector('.inv_row_edited').value = "1"; /* Set to 1 meaning row is edited*/
    document.getElementById("submitbtn").disabled = false;
}

function saveInvestigationRow(row) {
    var cells = row.getElementsByTagName('td');
    row.querySelector('.inv_row_edited').value = "1"; // Set to 1 meaning row is edited

    var modtext = cells[1].getElementsByClassName('modtext')[0];
    var modinput = cells[1].getElementsByClassName('modinput')[0];

    modtext.innerHTML = modinput.value;
    // Show input box and hide text
    modtext.style.display = 'inline';
    modinput.style.display = 'none';

    var investigationText = cells[2].getElementsByClassName('investigationText')[0];
    var investigationInput = cells[2].getElementsByClassName('investigationInput')[0];

    investigationText.innerHTML = investigationInput.value;
    var str = investigationInput.value;
    let result = str.split(",")[1];
    //alert(result);
    investigationText.innerHTML = result;
    // // Show input box and hide text
    investigationText.style.display = 'inline';
    investigationInput.style.display = 'none';

    var qtyText = cells[3].getElementsByClassName('qty-text')[0];
    var qtyInput = cells[3].getElementsByClassName('qty-input')[0];

    qtyText.innerHTML = qtyInput.value;
    // Show input box and hide text
    qtyText.style.display = 'inline';
    qtyInput.style.display = 'none';

    var rateText = cells[4].getElementsByClassName('rate-text')[0];
    var rateInput = cells[4].getElementsByClassName('rate-input')[0];

    rateText.innerHTML = rateInput.value;
    // Show input box and hide text
    rateText.style.display = 'inline';
    rateInput.style.display = 'none';

    var discText = cells[5].getElementsByClassName('disc-text')[0];
    var discInput = cells[5].getElementsByClassName('disc-input')[0];

    discText.innerHTML = discInput.value;
    // Show input box and hide text
    discText.style.display = 'inline';
    discInput.style.display = 'none';


    var chargeText = cells[6].getElementsByClassName('charge-text')[0];
    var chargeInput = cells[6].getElementsByClassName('charge-input')[0];

    // Update text with new charge and hide input box
    chargeText.innerHTML = chargeInput.value;
    chargeText.style.display = 'inline';
    chargeInput.style.display = 'none';

    row.getElementsByClassName('editInv-btn')[0].style.display = 'inline';
    row.getElementsByClassName('saveInv-btn')[0].style.display = 'none';
}

function populateInvestigation(select, rowCount) {
    let scanType = select.value;
    if (scanType) {
	    $.ajax({
	     url: `/get-investigations/${scanType}`,
            type: 'GET',
            success: function(response) {

                // Clear previous options
                let investigationSelect = select.parentElement.nextElementSibling.querySelector('select');
                investigationSelect.innerHTML = '<option value="">Select Investigation</option>';

                // Populate with new options
                response.forEach(investigation => {
                    investigationSelect.innerHTML +=
                        `<option value="${investigation.id},${investigation.description}" data-cost="${investigation.cost}">${investigation.description}</option>`;
                });

            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
}

function updateFields(row) {
    let cells = row.getElementsByTagName('td');
    let investigationSelect = cells[2].querySelector('select');
    let rateText = cells[4].querySelector('.rate-text');
    let rateInput = cells[4].querySelector('.rate-input');
    let amountText = cells[6].querySelector('.charge-text');
    let amountInput = cells[6].querySelector('.charge-input');
    let qtyInput = cells[3].querySelector('.qty-input');
    let discount = cells[5].querySelector('.disc-input');
    let disc = parseFloat(discount.value);
    //alert("discount");
    //alert(disc);

    //let discount = 0.1; // Assume a discount rate of 10%. Adjust as needed.

    let selectedOption = investigationSelect.options[investigationSelect.selectedIndex];
    // alert(selectedOption);
    // let rate = parseFloat(selectedOption.getAttribute('data-rate'));
    let cost = parseFloat(selectedOption.getAttribute('data-cost'));
    // alert(cost);
    // Update rate
    rateText.innerText = cost.toFixed(2);
    rateInput.value = cost.toFixed(2);

    rateInput.style.display = 'inline';
    rateText.style.display = 'none';



    recalculateAmount(row);
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.investigationInput').forEach(function(select) {
        select.addEventListener('change', function() {
            let row = this.closest('tr');
            updateFields(row);
        });
    });

    // Event listeners for Rate, Quantity, and Discount inputs
    document.querySelectorAll('.rate-input, .qty-input, .disc-input').forEach(function(input) {
        input.addEventListener('input', function() {
            let row = this.closest('tr');
            recalculateAmount(row);
        });
    });
    // Event listeners for Rate, Quantity, and Discount inputs
    document.querySelectorAll('.paymentAmtInput').forEach(function(input) {
        input.addEventListener('input', function() {
            let row = this.closest('tr');
            updateTotalPaidAmount();
        });
    });


});

function updateTotalPaidAmount() {
    // alert("call update");
    var totalPaid = 0;
    var paymentAmtInput;

    const element = document.getElementById("payDetails");
    const list = element.querySelectorAll(".paymentAmtInput");
    // alert(list.length);
    for (let i = 0; i < list.length; i++) {
        console.log("from i loop");
        console.log(list[i].value);

        if (list[i].value) {
            totalPaid += parseFloat(list[i].value) || 0;
        }
    }
    console.log("totalPaid: ", totalPaid);
    document.getElementById('totalPayDetailsAmount').value = totalPaid.toFixed(2);
    document.getElementById('billPaidAmt').value = totalPaid.toFixed(2);

    calculateBillInfo();
    // var totalPaidInput = document.getElementById('totalPayDetailsAmount').value;
    // if (totalPaidInput) {
    //     totalPaidInput.value = totalPaid.toFixed(2);
    // }

    // forEach(list, function(index, value) {
    //     console.log("from function");
    //     console.log(index, value); // passes index + value back!
    // });
    // // var rows = document.querySelectorAll('table.table-dark tbody tr');
    // var rows = document.querySelectorAll('table.table-dark tbody tr');
    // var len = rows.length();
    // alert(len);

    // rows.forEach(function(row) {
    //     var paymentAmtText = row.getElementsByClassName('paymentAmtText')[0];
    //     alert("paymentAmtText");
    //     alert(paymentAmtText);
    //     /* not working check */
    //     console.log("paymentAmtText: ", paymentAmtText);
    //     if (paymentAmtText) {
    //         totalPaid += parseFloat(paymentAmtText.innerHTML) || 0;
    //     }
    // });
    // console.log("totalPaid: ", totalPaid);

    // var totalPaidInput = document.getElementById('totalPayDetailsAmount');
    // var totalPaidInput = document.getElementById('totalPayDetailsAmount');
    // if (totalPaidInput) {
    //     totalPaidInput.value = totalPaid.toFixed(2);
    // }
    /* not working check */
}

function calculateBillInfo() {
    let BillTotal = document.getElementById("billTotal").value;
    console.log("BillTotal: ", BillTotal)


    let BillPaidAmt = document.getElementById("billPaidAmt").value;
    console.log("BillPaidAmt: ", BillPaidAmt);

    let BillDueAmt = document.getElementById("billDueAmt").value;
    console.log("BillDueAmt: ", BillDueAmt);

    let newBillDue = BillTotal - BillPaidAmt;
    console.log("newBillDue: ", newBillDue);
    document.getElementById("billDueAmt").value = newBillDue.toFixed(2);
}

function recalculateAmount(row) {
    let cells = row.getElementsByTagName('td');
    let qtyInput = cells[3].querySelector('.qty-input');
    let rateText = cells[4].querySelector('.rate-text');
    let rateInput = cells[4].querySelector('.rate-input');
    let discountText = cells[5].querySelector('.disc-text');
    let discountInput = cells[5].querySelector('.disc-input');
    let amountText = cells[6].querySelector('.charge-text');
    let amountInput = cells[6].querySelector('.charge-input');

    let qty = parseFloat(qtyInput.value) || 0;
    let rate = parseFloat(rateInput.value) || 0;
    let discount = parseFloat(discountInput.value) || 0;

    // Calculate amount
    let amount = (qty * rate) - discount;

    // Update amount fields
    amountText.innerText = amount.toFixed(2);
    amountInput.value = amount.toFixed(2);
    rateText.innerText = rate;
    discountText.innerHTML = discount;



    // Recalculate the total
    recalculateTotal();
}

function addRow() {

    document.getElementById("newinvcount").value = parseInt(document.getElementById("newinvcount").value) + 1;
    // Get the table body
    let tableBody = document.querySelector('table.table-striped tbody');
    let totalRow = tableBody.querySelector('tr.total-row');

    // Create a new row element
    let newRow = document.createElement('tr');

    // Define default values for the new row
    let rowIndex = tableBody.rows.length + 1; // Assuming row numbering starts from 1
    //let rowIndex = tableBody.rows.length; // Assuming row numbering starts from 1
    //let rowIndex = document.getElementById("invCount").value;
    var slIndex = rowIndex;

    newRow.innerHTML = `
        <td>${rowIndex}</td>
        <td>
            <span class="modtext" style="display:none;">Select Modality</span>
            <select class="modinput" name="modality[]" style="display: inline;">
                <option value="CT">CT</option>
                <option value="MR">MR</option>
            </select>
        </td>
        <td>
            <span class="investigationText" style="display:none;width:100px;padding:2px;text-align:center;">Select Investigation</span>
            <select class="investigationInput" name="investigation[]" style="display: inline;">
                <option value="">Select Investigation</option>
            </select>
        </td>
        <td class="qty">
            <span class="qty-text"  style="display:none;width:100px;padding:2px;text-align:center;">0</span>
            <input type="number" step="0.01" class="qty-input" name="qty[]" value="1" style=" width: 50px;">
        </td>
        <td class="rate">
            <span class="rate-text"  style="display:none;width:100px;padding:2px;text-align:center;">0</span>
            <input type="number" step="0.01" class="rate-input" name="rate[]" value="0" style=" width: 100px;">
        </td>
              <td class="disc">
            <span class="disc-text" style="display:none;width:100px;padding:2px;text-align:center;">0</span>
            <input type="number" step="0.01" class="disc-input" name="disc[]" value="0" style=" width: 100px;">
        </td>
        <td class="amt">
            <span class="charge-text" style="display:none;width:100px;padding:2px;text-align:center;">0</span>
            <input type="number" step="0.01" class="charge-input" name="charges[]" value="0" style=" width: 100px;">
        </td>
        <td>
            <button type="button" class="btn btn-primary editInv-btn" style="display: none;" onclick="makeInvestigationEditable(this.closest('tr'))">Edit</button>
            <button type="button" class="btn btn-primary saveInv-btn"  onclick="saveInvestigationRow(this.closest('tr'))">Save</button>
        </td>
        <td>
            <button type="button" class="btn btn-primary edit-btn" onclick="makeNumEditable(this.closest('tr'))">Edit</button>
            <button type="button" class="btn btn-primary save-btn" style="display: none;" onclick="saveNoRow(this.closest('tr'))">Save</button>
        </td>
    `;
    // Insert the new row before the total row
    if (totalRow) {
        tableBody.insertBefore(newRow, totalRow);
    } else {
        // If no total row is found, just append the new row
        tableBody.appendChild(newRow);
    }

    // Append the new row to the table body
    //tableBody.appendChild(newRow);

    // Optional: Initialize any additional settings or data needed
    initializeNewRow(newRow);
    rateInput.style.display = 'inline';
    rateText.style.display = 'none';


    // Recalculate the total
    recalculateTotal();
}

function recalculateTotal() {
    //alert("recalculateTotal");

    let totalAmount = 0;
    let totalRate = 0;
    let totalDiscount = 0;

    // Loop through each row and sum up the total amount
    let rows = document.querySelectorAll('table.table-striped tbody tr');
    rows.forEach(function(row) {
        let chargeText = row.querySelector('.charge-text');
        console.log("chargeText: ", chargeText);
        if (chargeText) {
            totalAmount += parseFloat(chargeText.innerText) || 0;
        }
        // console.log(row.querySelector('.rate-text'));
        // console.log("Total Amount: ", totalAmount.toFixed(2));
        let rateText = row.querySelector('.rate-text'); // Corrected selector
        console.log("rateText: ", rateText);
        if (rateText) {
            totalRate += parseFloat(rateText.innerText) || 0;
        }

        let discText = row.querySelector('.disc-text');
        console.log("discText: ", discText);
        if (discText) {
            totalDiscount += parseFloat(discText.innerText) || 0;
        }

    });

    // Update the total input field
    let totalInput = document.getElementById('totalAmount');
    if (totalInput) {
        // totalInput.value = totalAmount.toFixed(2) + ' Rs.';
        totalInput.value = totalAmount.toFixed(2);
    }
    let totalInputRate = document.getElementById('totalRate');
    if (totalInputRate) {
        // totalInput.value = totalAmount.toFixed(2) + ' Rs.';
        totalInputRate.value = totalRate.toFixed(2);
    }
    let totalInputDisc = document.getElementById('totalDiscount');
    if (totalInputDisc) {
        // totalInput.value = totalAmount.toFixed(2) + ' Rs.';
        totalInputDisc.value = totalDiscount.toFixed(2);
    }

    let BillTotal = document.getElementById("billTotal");
    if (BillTotal) {
        BillTotal.value = totalAmount.toFixed(2);
    }

    let BillPaidAmt = document.getElementById("billPaidAmt").value;
    console.log("BillPaidAmt: ", BillPaidAmt);

    let BillDueAmt = document.getElementById("billDueAmt").value;
    console.log("BillDueAmt: ", BillDueAmt);

    let newBillDue = totalAmount - BillPaidAmt;
    console.log("newBillDue: ", newBillDue);
    document.getElementById("billDueAmt").value = newBillDue.toFixed(2);




    // Optional: Debugging logs
    console.log("Total Amount: ", totalAmount.toFixed(2));
    console.log("Total Rate: ", totalRate.toFixed(2));
    console.log("Total Discount: ", totalDiscount.toFixed(2));
    document.getElementById("submitbtn").disabled = false;
}

function initializeNewRow(row) {
    // Implement any additional initialization for the new row here
    // For example, populate the Investigation dropdown based on the selected modality
    let modalitySelect = row.querySelector('.modinput');
    modalitySelect.addEventListener('change', function() {
        populateInvestigation(this, row);

    });

    let investigationInput = row.querySelector('.investigationInput');

    investigationInput.addEventListener('input', function() {
        updateFields(row);

    });


    let qtyInput = row.querySelector('.qty-input');
    let rateInput = row.querySelector('.rate-input');
    let discountInput = row.querySelector('.disc-input');

    qtyInput.addEventListener('input', function() {
        recalculateAmount(row);
    });

    rateInput.addEventListener('input', function() {
        recalculateAmount(row);
    });

    discountInput.addEventListener('input', function() {
        recalculateAmount(row);
    });
    // Recalculate the total
    recalculateTotal();
}

function makeNumEditable(row) {
    // Toggle visibility of text and input fields

    row.querySelector('.inv-row-edited').value = "1"; // Set to 1 meaning row is edited
    row.querySelector('.qty-text').style.display = 'none';
    row.querySelector('.qty-input').style.display = 'inline';

    row.querySelector('.rate-text').style.display = 'none';
    row.querySelector('.rate-input').style.display = 'inline';

    row.querySelector('.disc-text').style.display = 'none';
    row.querySelector('.disc-input').style.display = 'inline';

    row.querySelector('.edit-btn').style.display = 'none';
    row.querySelector('.save-btn').style.display = 'inline';
    document.getElementById("submitbtn").disabled = false;
    // Optionally, you can also disable the other buttons or controls if needed
}

function saveNoRow(row) {

    row.querySelector('.inv-row-edited').value = "1"; // Set to 1 meaning row is edited
    let qtyInput = row.querySelector('.qty-input');
    let rateInput = row.querySelector('.rate-input');
    let discInput = row.querySelector('.disc-input');
    let chargeInput = row.querySelector('.charge-input');

    let qty = parseFloat(qtyInput.value) || 0;
    let rate = parseFloat(rateInput.value) || 0;
    let discount = parseFloat(discInput.value) || 0;

    let amount = (qty * rate) - discount; // Adjust this formula as needed

    row.querySelector('.qty-text').innerText = qty;
    row.querySelector('.rate-text').innerText = rate;
    row.querySelector('.disc-text').innerText = discount;
    row.querySelector('.charge-text').innerText = amount.toFixed(2);

    row.querySelector('.qty-input').style.display = 'none';
    row.querySelector('.rate-input').style.display = 'none';
    row.querySelector('.disc-text').style.display = 'none';
    row.querySelector('.charge-input').style.display = 'none';

    row.querySelector('.qty-text').style.display = 'inline';
    row.querySelector('.rate-text').style.display = 'inline';
    row.querySelector('.disc-text').style.display = 'inline';
    row.querySelector('.charge-text').style.display = 'inline';

    row.querySelector('.edit-btn').style.display = 'inline';
    row.querySelector('.save-btn').style.display = 'none';

    // Recalculate the total
    recalculateTotal();
}



function addPaymentRow() {
    const table = document.getElementById('payDetails');
    const totalRow = table.querySelector('tr.total-row'); // Select the total row

    // Create a new row element
    const newRow = table.insertRow(totalRow.rowIndex); // Insert before the total row
    const today = new Date();

    // Format date as dd/mm/yyyy H:mm

    // Format date as dd/mm/yyyy H:mm:ss
    const dateString =
        `${String(today.getDate()).padStart(2, '0')}/${String(today.getMonth() + 1).padStart(2, '0')}/${today.getFullYear()} ${String(today.getHours()).padStart(2, '0')}:${String(today.getMinutes()).padStart(2, '0')}:${String(today.getSeconds()).padStart(2, '0')}`;

    const dateCell = newRow.insertCell(0);
    const paymentModeCell = newRow.insertCell(1);
    const amountCell = newRow.insertCell(2);
    const detailsCell = newRow.insertCell(3);
    const actionCell = newRow.insertCell(4);

    dateCell.innerHTML = dateString;

    document.getElementById("newpaycount").value = parseInt(document.getElementById("newpaycount").value) + 1;


    paymentModeCell.innerHTML = `
        <select class="paymentModeInput" name="payment_mode[]">
            <option value="netbanking">Netbanking</option>
	    <option value="credit">Credit</option>
	    <option value="cheque">Cheque</option>
            <option value="cash">Cash</option>
            <option value="debit card">Debit Card</option>
            <option value="upi">UPI</option>
        </select>
    `;
    amountCell.innerHTML = `
    <input type="number" class="paymentAmtInput" name="amount[]" step="0.01" value="0" style="width: 100%;" value="0" onchange=" updateTotalPaidAmount();">
`;



    detailsCell.innerHTML = `
        <input type="text" class="paymentDetailsInput" name="details[]" style="width: 100%;" value="-">
    `;

    // actionCell.innerHTML = `
    //     <button type="button" class="btn btn-primary editPay-btn" onclick="makeEditable(this.parentElement.parentElement)">Edit</button>
    //     <button type="button" class="btn btn-primary savePay-btn" onclick="saveRow(this.parentElement.parentElement)" style="display:none;">Save</button>
    // `;
    document.getElementById("submitbtn").disabled = false;
}
</script>
@endscript
