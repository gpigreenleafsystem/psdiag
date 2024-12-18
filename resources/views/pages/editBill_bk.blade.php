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
                            <td>:&nbsp;<?php echo $bd->Patient_name ?></td>
                            <td>Bill No</td>
                            <td>:&nbsp;<?php echo $bd->bill_no ?></td>
                        </tr>
                        <tr>
                            <td>Sex</td>
                            <td>:&nbsp;<?php echo $bd->gender ?></td>
                            <td>Date & Time</td>
                            <td>:&nbsp;<?php echo $bd->bill_date; ?></td>
                        </tr>
                        <tr>
                            <td>Age (In Yrs)</td>
                            <td>:&nbsp;<?php echo $bd->Patient_age ?> </td>
                            <td>Ref. Dr</td>
                            <td>:&nbsp;<?php echo $bd->drref ?></td>
                        </tr>
                    </table>
                    </hr>
                    <h6>Investigation Details</h6>


                    <hr>

                    <table class="table table-striped table-bordered">
                        <tr>
                            <th class="sl-no">Sl.No</th>
                            <th class="modality">Modality</th>
                            <th class="invest">Investigation</th>
                            <th class="amt">Charges</th>
                        </tr>
                        <?php $i = 1;
                        $totalCharges = 0;
                        foreach ($bd->scanningdetails as $inv) { ?>
                        <tr>

                            <td><?php echo $i++ ?> </td>
                            <td><?php echo $inv->modality ?></td>
                            <td><?php echo $inv->description ?></td>
                            <td class="amt"><?php echo $inv->cost ?>&nbsp;&nbsp;Rs.</td>

                        </tr>
                        <?php } ?>
                    </table>
                    </hr>
                    <h6>Payment Details</h6>
                    <form method="POST" action="{{ route('submitTable') }}">
                        @csrf
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Date</th>
                                <th>PaymentMode</th>
                                <th>Amount</th>
                                <th>Payment Details</th>
                                <th>Action</th>
                            </tr>
                            @foreach($payments as $data)
                            <tr>
                                <input type="hidden" name="id[]" value="{{ $data->id }}">
                                <td>{{ $data->created_at }}</td>
                                <td>{{$data->payment_mode}}</td>
                                <td>{{ $data->partpayment_amount }}</td>
                                <td>{{ $data->payment_details }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" id=""
                                        onclick="makeEditable(this.parentElement.parentElement)">Edit</button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="saveRow(this.parentElement.parentElement)"
                                        style="display:none;">Save</button>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                        <br>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn " onclick="cancelEdit()">Cancel</button>
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
    var cells = row.getElementsByTagName('td');
    cells[2].innerHTML = '<input type="number" step="0.01" name="amount[]" value="' + parseFloat(cells[2].innerText
        .replace('$', '')) + '">';
    cells[3].innerHTML = '<input type="text" name="details[]" value="' + cells[3].innerText + '">';
    cells[1].innerHTML = `
                <select name="payment_mode[]">
                    <option value="netbanking">Netbanking</option>
                    <option value="credit">Credit</option>
                    <option value="cash">Cash</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="upi">UPI</option>
                </select>`;
    row.getElementsByClassName('edit-btn')[0].style.display = 'none';
    row.getElementsByClassName('save-btn')[0].style.display = 'inline';
}

function saveRow(row) {
    var cells = row.getElementsByTagName('td');
    var amountInput = cells[2].getElementsByTagName('input')[0];
    var amountValue = parseFloat(amountInput.value);
    if (isNaN(amountValue)) {
        alert('Please enter a valid float value for the amount.');
        return;
    }
    cells[2].innerText = '$' + amountValue.toFixed(2);
    cells[3].innerText = cells[3].getElementsByTagName('input')[0].value;
    cells[1].innerText = cells[1].getElementsByTagName('select')[0].value;
    row.getElementsByClassName('edit-btn')[0].style.display = 'inline';
    row.getElementsByClassName('save-btn')[0].style.display = 'none';
}

function cancelEdit() {
    var rows = document.querySelectorAll('table tr');
    rows.forEach(function(row, index) {
        if (index > 0) { // Skip header row
            var cells = row.getElementsByTagName('td');
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
</script>
@endscript
