@extends('layouts.app', [
'namePage' => 'Table List',
'class' => 'sidebar-mini',
'activePage' => 'table',
])
@section('styles')
<link href="app.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet">
@endsection
@section('content')
<div class="panel-header panel-header-sm">
</div>
<?php  if ($apdetails->modality_id == 1) {
    $mod_type = "CT";
} elseif ($apdetails->modality_id == 2) {
    $mod_type = "MRI";
} ?>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12  mr-auto">
                <div class="card card-signup text-center">
		    <div class="card-header ">
  <h4 class="card-title">{{ __('Out Patient Bill') }}</h4>
  
                        <div class="card-body">
                            <form class="row " method="POST" action="{{ route('createnewbill') }}"
                                onsubmit="validateForm(event)">
                                @csrf

                                <!-- Patient Details :-->
                                <div class=" col-md-12 text-left"><b>Patient Details : </b>
                                </div>
                                <input type="hidden" id="apt_id" name="apt_id" value="{{$apdetails->id}}" />
                                <!-- Name-->
                                <div class="col-md-6 ">
                                    <div class="input-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <div class="input-group-text">
                                            Name
                                        </div>
                                        <input class="form-control " placeholder="{{ __('Patient Name') }}" type="text"
                                            name="patient_name" value="{{ $patient->name }}" disabled>
                                        <input type="hidden" name="bill_pt_name" value="{{ $patient->name }}" />
                                    </div>
                                </div>
                                <!-- Contact No-->
                                <div class=" col-md-6">
                                    <div class="input-group {{ $errors->has('mobileno') ? ' has-danger' : '' }}">
                                        <div class="input-group-text">
                                            Contact Number
                                        </div>
                                        <input class="form-control{{ $errors->has('mobileno') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Patient Mobileno') }}" type="number"
                                            name="patient_mobileno" value="{{ $patient->mobileno }}" disabled>
                                        <input type="hidden" name="bill_pt_contactno" value="{{$patient->mobileno}}" />
                                    </div>
                                </div>
                                <!-- Age-->
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-text"> Gender
                                        </div>
                                        <input class="form-control {{ $errors->has('gender') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Gender') }}" type="text" name="patient_gender"
                                            value="{{ $patient->gender }}" disabled />
                                        <input type="hidden" name="bill_pt_gender" value="{{$patient->age}}" />

                                    </div>
                                </div>
                                <!--Gender-->
                                <div class="col-md-6">
                                    <div class="input-group {{ $errors->has('age') ? ' has-danger' : '' }}">
                                        <div class="input-group-text"> Age
                                        </div>
                                        <input class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Patient Age') }}" type="number" name="patient_age"
                                            value="{{ $patient->age }}" disabled>
                                        <input type="hidden" name="bill_pt_age" value="{{$patient->age}}" />

                                    </div>
                                </div>
                                <!-- Address-->
                                <div class="col-12">
                                    <div class="input-group ">
                                        <div class="input-group-text"> Address
                                        </div>
                                        <input class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Patient Address') }}" type="text" name="patient_address"
                                            value="{{ $patient->address }}" disabled>
                                        <input type="hidden" name="bill_pt_address" value="{{$patient->address}}" />

                                    </div>
                                </div>

                                <!-- end of Patient Details-->
                                <hr>
                                <!-- Reffer Details-->
                                <div class="col-md-12 text-left"><b>Referr Details : </b>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-text"> Doctor Name
                                                </div>
                                                <input
                                                    class="form-control {{ $errors->has('drname') ? ' is-invalid' : '' }}"
                                                    placeholder="{{ __('Doctor Name') }}" type="text" name="drname"
                                                    value="{{$referer->referer_name }}" disabled>
                                                <input type="hidden" name="bill_ref_name"
                                                    value="{{$referer->referer_name}}" />

                                            </div>

                                        </div>
                                        <div class="col">
                                            <div
                                                class="input-group {{ $errors->has('drmobileno') ? ' has-danger' : '' }}">
                                                <div class="input-group-text">
                                                    Doctor Contact </div>
                                                <input
                                                    class="form-control{{ $errors->has('drmobileno') ? ' is-invalid' : '' }}"
                                                    placeholder="{{ __('Doctor Mobileno') }}" type="number"
                                                    name="drmobileno" value="{{ $referer->referer_phno }}" disabled>
                                                <input type="hidden" name="bill_ref_phno"
                                                    value="{{$referer->referer_phno}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end of reffer details-->

                                <!-- Appointmnet Details-->
                                <div class="col-md-12 text-left"><b>Appointment Details: </b>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group {{ $errors->has('drname') ? ' has-danger' : '' }}">
                                                <div class="input-group-text">
                                                    Appointment Date
                                                </div>
                                                <input
                                                    class="form-control {{ $errors->has('apt_date') ? ' is-invalid' : '' }}"
                                                    placeholder="{{ __('Appointment Date') }}" type="text"
                                                    name="apt_date" value="{{$apdetails->appointment_date}}" disabled>

                                            </div>

                                        </div>
                                        <div class="col">
                                            <div
                                                class="input-group {{ $errors->has('apt_status') ? ' has-danger' : '' }}">
                                                <div class="input-group-text" >
                                                    Appointment Status:
                                                </div>
                                                <input
                                                    class="form-control{{ $errors->has('apt_status') ? ' is-invalid' : '' }}"
                                                    placeholder="{{ __('Appointment Status') }}" type="number"
                                                    name="apt_status" value="{{$apdetails->appointment_status}}"
                                                    disabled>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-left"><b>Investigation Details : </b></div>
                                <button class="btn btn-primary mb-3" onclick="addRow()">Add Row</button>
                                <table class="table table-bordered" id="calcTable">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll" class="input-group-text"></th>
                                            <th style="font-size: 1.05em; font-weight: 400;">
                                                Sl No
                                            </th>
                                            <th style="font-size: 1.05em; font-weight: 400;">Scan Type</th>
                                            <th style="font-size: 1.05em; font-weight: 400;">Investigation</th>
                                            <th style="font-size: 1.05em; font-weight: 400;">Rate</th>
                                            <th style="font-size: 1.05em; font-weight: 400;">Quantity</th>
                                            <th style="font-size: 1.05em; font-weight: 400;">Discount Amt</th>                                            <th style="font-size: 1.05em; font-weight: 400;">Amount</th>
                                            <th style="font-size: 1.05em; font-weight: 400;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Rows will be added here dynamically -->

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class="text-right font-weight-bold">Total Amount</td>
                                            <td><input type="number" class="form-control" id="totalAmount"
						    name="totalAmount" readonly>
 <input type="hidden" class="form-control" id="billedamount"
                                                name="billedamount" readonly>
                                            <input type="hidden" class="form-control" id="billdiscount"
                                                name="billdiscount" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
				<input type="hidden" value="" id="rowcounting" name="rowcounting">


                                <input type="hidden" value="{{$apdetails->appointment_date}}" id="apt_date"
				    name="apt_date">
  <input type="hidden" value="{{Auth::user()->name}}" id="gen_by" name="gen_by" />
 <input type="hidden" class="form-control" id="billedamount"
                                                name="billedamount" readonly>
                                            <input type="hidden" class="form-control" id="billdiscount"
                                                name="billdiscount" readonly>
                                   
                                <!--  <button type="button" class="btn btn-danger" onclick="deleteSelectedRows()">Delete Selected Rows</button>-->
                                <!--<button type="button" class="btn btn-success mt-3" onclick="calculateTotal()">Calculate
                                    Total</button>-->
                                <div class="text-right">
                                    <button type="submit" id="submit"
                                        class="btn btn-success mt-3 margin-right pull-right">Submit</button>
                                </div>



                        </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
let rowCount = 0;

function validateForm(event) {
    // Calculate the total amount
    let totalAmount = 0;
    let allInvestigationsSelected = true;

    document.querySelectorAll('tbody tr').forEach(function(row) {
        const investigationSelect = row.querySelector('.investigation');
        if (!investigationSelect.value) {
            allInvestigationsSelected = false;
        }
        const amount = parseFloat(row.querySelector('.amount').value) || 0;
        totalAmount += amount;
    });

    // Validate if all investigations are selected
    if (!allInvestigationsSelected) {
        alert('Please select an Investigation for all rows.');
        event.preventDefault(); // Prevent form submission
        return;
    }

    // Get the total amount input field
    let totalAmountField = document.getElementById('total_amount');
    totalAmountField.value = totalAmount;

    // Validate the total amount
    if (!totalAmountField.value || totalAmountField.value <= 0) {
        alert('The total amount must be greater than zero.');
        event.preventDefault(); // Prevent form submission
    }
}


function addRow() {
   //event.preventDefault(); // Prevent form submission
    rowCount++;
    document.getElementById('rowcounting').value = rowCount;
    const table = document.getElementById('calcTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();

    newRow.innerHTML = `
                <td><input type="checkbox" class="rowCheckbox"></td>
                <td>${rowCount}</td>
                <td>
                    <select class="form-control scan-type" id="scantype-${rowCount}" name="scantype-${rowCount}"onchange="fetchInvestigations(this, ${rowCount})">
                        <option value="">Select Scan Type</option>
                        <option value="CT">CT</option>
                        <option value="MR">MRI</option>
                    </select>
                </td>
                <td>
                    <select class="form-control investigation" id="investigation-${rowCount}" name="investigation-${rowCount}" onchange="updateRate(this, ${rowCount})">
                        <option value="">Select Investigation</option>
                    </select>
                </td>
                <td><input type="number" step="0.01" class="form-control rate" id="rate-${rowCount}" name="rate-${rowCount}"oninput="calculateAmount(this)" readonly></td>
                <td><input type="number" class="form-control qty" value="1" id="qty-${rowCount}" name="qty-${rowCount}" oninput="calculateAmount(this)"></td>
                <td><input type="number" class="form-control discount" value="0" id="discount-${rowCount}" name="discount-${rowCount}"oninput="calculateAmount(this)"></td>
                <td><input type="number" class="form-control amount" id="amount-${rowCount}" name="amount-${rowCount}"readonly></td>
                <td><button class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
            `;
}

function fetchInvestigations(selectElement, rowId) {

    const scanType = selectElement.value;
    //alert(scanType);
    if (scanType) {
        $.ajax({
	url: `/get-investigations/${scanType}`,
            type: 'GET',
            crossDomain:true,
           async:false,
            success: function(response) {
                // alert(response);
                const investigationSelect = document.getElementById(`investigation-${rowId}`);
                investigationSelect.innerHTML = '<option value="">Select Investigation</option>';
                response.forEach(investigation => {
                    investigationSelect.innerHTML +=
                        `<option value="${investigation.id},${investigation.description}" data-cost="${investigation.cost}">${investigation.description}</option>`;
                });

            },
            error: function(xhr) {
             //   console.error(xhr.responseText);
            }
        });
    }
}

function updateRate(selectElement, rowId) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const rate = selectedOption.getAttribute('data-cost');
    document.querySelector(`#calcTable tbody tr:nth-child(${rowId}) .rate`).value = rate;
    calculateAmount(selectElement);
}

function calculateAmount(input) {
    const row = input.parentElement.parentElement;
    const rate = parseFloat(row.cells[4].getElementsByTagName('input')[0].value) || 0;
    const qty = parseFloat(row.cells[5].getElementsByTagName('input')[0].value) || 1;
    const discount = parseFloat(row.cells[6].getElementsByTagName('input')[0].value) || 0;
 let amount = (rate * qty) - discount;
   //let amount = rate * qty;
   // amount -= (amount * discount / 100);

    row.cells[7].getElementsByTagName('input')[0].value = amount.toFixed(2);
    calculateTotal();
}

function deleteRow(button) {
    const row = button.parentElement.parentElement;
    row.parentElement.removeChild(row);
    updateRowNumbers();
}

function deleteSelectedRows() {
    const checkboxes = document.getElementsByClassName('rowCheckbox');
    for (let i = checkboxes.length - 1; i >= 0; i--) {
        if (checkboxes[i].checked) {
            checkboxes[i].parentElement.parentElement.remove();
        }
    }
    updateRowNumbers();
}

function updateRowNumbers() {
    const table = document.getElementById('calcTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    rowCount = 0;
    for (let i = 0; i < rows.length; i++) {
        rowCount++;
        rows[i].cells[1].innerText = rowCount;
    }
}

document.getElementById('checkAll').addEventListener('change', function() {
    const checkboxes = document.getElementsByClassName('rowCheckbox');
    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = this.checked;
    }
});

function calculateTotal() {
    const table = document.getElementById('calcTable').getElementsByTagName('tbody')[0];
    const rows = table.getElementsByTagName('tr');
    let totalAmount = 0;
     let totalbilledAmount = 0;
    let totalbilleddiscount = 0;

    for (let i = 0; i < rows.length; i++) {
        const amount = parseFloat(rows[i].cells[7].getElementsByTagName('input')[0].value) || 0;
	totalAmount += amount;
	  const billedamount = parseFloat(rows[i].cells[4].getElementsByTagName('input')[0].value) || 0;
        totalbilledAmount += billedamount;
        const billeddiscount = parseFloat(rows[i].cells[6].getElementsByTagName('input')[0].value) || 0;
        totalbilleddiscount += billeddiscount;
    }

    document.getElementById('totalAmount').value = totalAmount.toFixed(2);
        document.getElementById('billedamount').value = totalbilledAmount.toFixed(2);
    document.getElementById('billdiscount').value = totalbilleddiscount.toFixed(2);
    $(":submit").removeAttr("disabled");

}

// Initialize with one row
addRow();
</script>

@endsection


@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@endpush
