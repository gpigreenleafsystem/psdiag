<!DOCTYPE html>
<html>

<head>
    <title>PadmaShree-Reports</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>



    <div class="content">
	<div class="container">
 
	<div >
<div>   <a href="{{ url()->previous() }}">Back</a></div>
            <h4 class="text-center">{{ __('Reports') }}</h4>
</div>

            <div style="margin: 20px 0px;">
                <strong>Date Filter:</strong>
                <input type="text" name="daterange" value="" />
                <button class="btn btn-success filter">Filter</button>
            </div>
<div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Bill No</th>
                        <th>Billed On</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Mob No</th>
			<th>Ref By</th>
			<th>Scan Type</th>
                        <th>Bill Amt</th>
                        <th>Dis</th>
                        <th>Total Amt</th>
                        <th>Paid Amt</th>
                        <th>Due Amt</th>
                        <th>Paid Mode</th>
                        <th>Due-paid on</th>
                        <th>Payment Info</th>
                        <th>Gen By</th>


                    </tr>
                </thead>
                <tbody>
		</tbody>
 <tfoot>
                        <tr>
                            <th colspan="7" style="text-align:right">Total:</th>
                            <th id="totalBillAmount"></th>
                            <th id="totalDiscount"></th>
                            <th id="totalNetAmount"></th>
                            <th id="totalPaidAmount"></th>
                            <th id="totalDueAmount"></th>
                            <th colspan="4"></th>
                        </tr>
                    </tfoot>
	    </table>
</div>
        </div>
    </div>
</div>
<div></div>
</body>

<script type="text/javascript">
$(function() {

    $('input[name="daterange"]').daterangepicker({
        startDate: moment().subtract(1, 'M'),
        endDate: moment()
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('reports') }}",
            data: function(d) {
                d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format(
                    'YYYY-MM-DD');
                d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format(
                    'YYYY-MM-DD');
            }
        },
        columns: [{
                data: 'bill_no',
                name: 'bill_no'
            },
            {
                data: 'bill_date',
                render: function(data, type, row) {
                    // Format the date in dd-mm-yyyy format
                    if (data) {
                        var date = new Date(data);
                        var day = String(date.getDate()).padStart(2, '0');
                        var month = String(date.getMonth() + 1).padStart(2,
                            '0'); // Months are zero-based
                        var year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                    return '';
                }
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'age',
                name: 'age'
            },
            {
                data: 'sex',
                name: 'sex'
            },
            {
                data: 'mobile_no',
                name: 'mobile_no'
            },
            {
                data: 'ref_by',
                name: 'ref_by'
		},
			{
                data: 'scantype',
                render: function(data, type, row) {
                    return data == 1 ? 'CT' : 'MRI';
                }

            },
	
            {
                data: 'bill_amount',
                name: 'bill_amount'
            },
            {
                data: 'discount',
                name: 'discount'
            },
            {
                data: 'total_amount',
                name: 'total_amount'
            },
            {
                data: 'paid_amount',
                name: 'paid_amount'
            },
            {
                data: 'due_amount',
                name: 'due_amount'
            },
            {
                data: 'payment_mode',
                name: 'payment_mode'
            },

            {
                data: 'paid_date',
                render: function(data, type, row) {
                    // Format the date in dd-mm-yyyy format
                    if (data) {
                        var date = new Date(data);
                        var day = String(date.getDate()).padStart(2, '0');
                        var month = String(date.getMonth() + 1).padStart(2,
                            '0'); // Months are zero-based
                        var year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                    return '';
                }
            },
            {
                data: 'payment_details',
                name: 'payment_details'
            },
            {
                data: 'gen_by',
                name: 'gen_by'
            }
	],
		 "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };
                // Total over all pages
                var totalBillAmount = api
                    .column(7)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var totalDiscount = api
                    .column(8)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var totalNetAmount = api
                    .column(9)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var totalPaidAmount = api
                    .column(10)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var totalDueAmount = api
                    .column(11)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(7).footer()).html(totalBillAmount.toFixed(2));
                $(api.column(8).footer()).html(totalDiscount.toFixed(2));
                $(api.column(9).footer()).html(totalNetAmount.toFixed(2));
                $(api.column(10).footer()).html(totalPaidAmount.toFixed(2));
                $(api.column(11).footer()).html(totalDueAmount.toFixed(2));

            }


    });

    $(".filter").click(function() {
        table.draw();
    });

});
</script>

</html>
