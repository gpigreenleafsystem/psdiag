
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
<div class="container mt-5">
 <form action="{{ route('createnewbill') }}" method="POST">
            @csrf
    <button class="btn btn-primary mb-3" onclick="addRow()">Add More Rows</button>
    <table class="table table-bordered" id="calcTable">
        <thead>
            <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>Sl No</th>
                <th>Scan Type</th>
                <th>Investigation</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Discount (%)</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Rows will be added here dynamically -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="text-right font-weight-bold">Total Amount</td>
                <td><input type="number" class="form-control" id="totalAmount" readonly></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    
 
            <button type="button" class="btn btn-danger" onclick="deleteSelectedRows()">Delete Selected Rows</button>
            <button type="button" class="btn btn-success mt-3" onclick="calculateTotal()">Calculate Total</button>
            <button type="submit" class="btn btn-success mt-3">Submit</button>
        </form>
</div>

<script>
let rowCount = 0;

function addRow() {
    rowCount++;
    const table = document.getElementById('calcTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();

    newRow.innerHTML = `
                <td><input type="checkbox" class="rowCheckbox"></td>
                <td>${rowCount}</td>
                <td>
                    <select class="form-control scan-type" onchange="fetchInvestigations(this, ${rowCount})">
                        <option value="">Select Scan Type</option>
                        <option value="CT">CT</option>
                        <option value="MR">MRI</option>
                    </select>
                </td>
                <td>
                    <select class="form-control investigation" id="investigation-${rowCount}" onchange="updateRate(this, ${rowCount})">
                        <option value="">Select Investigation</option>
                    </select>
                </td>
                <td><input type="number" step="0.01" class="form-control rate" oninput="calculateAmount(this)" readonly></td>
                <td><input type="number" class="form-control qty" value="1" oninput="calculateAmount(this)"></td>
                <td><input type="number" class="form-control discount" value="0" oninput="calculateAmount(this)"></td>
                <td><input type="number" class="form-control amount" readonly></td>
                <td><button class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
            `;
}

function fetchInvestigations(selectElement, rowId) {
	const scanType = selectElement.value;
	alert(scanType);
    if (scanType) {
        $.ajax({
	url: `http:/www.modulecoders.com/psdiag/public/get-investigations/${scanType}`,
            type: 'GET',
	    success: function(response) {
		    alert(response);
                const investigationSelect = document.getElementById(`investigation-${rowId}`);
                investigationSelect.innerHTML = '<option value="">Select Investigation</option>';
                response.forEach(investigation => {
                    investigationSelect.innerHTML +=
                        `<option value="${investigation.id}" data-cost="${investigation.cost}">${investigation.description}</option>`;
                });
            },
            error: function(xhr) {
                console.error(xhr.responseText);
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

    let amount = rate * qty;
    amount -= (amount * discount / 100);

    row.cells[7].getElementsByTagName('input')[0].value = amount.toFixed(2);
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

    for (let i = 0; i < rows.length; i++) {
        const amount = parseFloat(rows[i].cells[7].getElementsByTagName('input')[0].value) || 0;
        totalAmount += amount;
    }

    document.getElementById('totalAmount').value = totalAmount.toFixed(2);
}

// Initialize with one row
addRow();
</script>

@endsection


@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@endpush
