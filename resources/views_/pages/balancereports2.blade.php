<!DOCTYPE html>
<html>
<head>
    <title>Laravel DataTables Example</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>

<div class="container">
    <h2>DataTables Example</h2>

    <!-- Display Total Balance Amount -->
    <div>
        <h4>Total Balance Amount: {{ $totalBalanceAmount }}</h4>
    </div>

    <table class="table table-bordered" id="example">
        <thead>
            <tr>
                <th>Bill No</th>
                <th>Appointment Date</th>
                <th>Patient Name</th>
                <th>Referer Name</th>
                <th>Payment Details</th>
                <th>Modality Type</th>
                <th>Net Amount</th>
                <th>Paid Amount</th>
                <th>Balance Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('getbalancereport') }}",
        columns: [
            { data: 'bill_no', name: 'bill_no' },
            { data: 'appointment_date', name: 'appointment_date' },
            { data: 'name', name: 'name' },
            { data: 'referer_name', name: 'referer_name' },
            { data: 'paymentdetails', name: 'paymentdetails' },
            { data: 'modalitytype', name: 'modalitytype' },
            { data: 'netamount', name: 'netamount' },
            { data: 'paidamount', name: 'paidamount' },
            { data: 'balanceamount', name: 'balanceamount' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>

</body>
</html>

