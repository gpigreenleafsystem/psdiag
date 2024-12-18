<!DOCTYPE html>
<html>

<head>
    <!--https://www.itsolutionstuff.com/post/laravel-10-yajra-datatables-tutorial-exampleexample.html-->

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script-->
    <!--script src="https://code.jquery.com/jquery-3.5.1.js"></script-->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script-->
    <!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script-->
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
<link rel="stylesheet"
href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.css">
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.css"></script-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.js"></script>
</head>

<body>
<div class="content">
    <div class="container">
<div>   <a href="{{ url()->previous() }}">Back</a></div>
<h4 class="text-center">Balance Report</h4>

<div>
<label for="startDate">Date :</label>
    <input name="startDate" id="startDate" class="date-picker" />
 <button class="btn btn-success filter">Filter</button>
    <!-- Display Total Balance Amount -->

    </div>

        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    
<!--                    <th>patient_phoneno</th>-->
		    <th>Bill No</th>
			<th> Appointment_date </th>
			<th>Patient Name</th>
			<th>Referer Name </th>
			<th>Payment Details </th>
			<th>Study </th>
			<!--th>Referer Name </th-->
			<th>Bill Amount </th>
			<th>Paid Amount </th>
			<th>Balance Amount </th>
                    <!--th width="100px">Action</th-->
                </tr>
            </thead>
            <tbody>
	    </tbody>
<tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right">Total:</th>
                            <th id="totalBillAmount"></th>
                            <th id="totalPaidAmount"></th>
                            <th id="totalBalanceAmount"></th>
                        </tr>
                    </tfoot>
	</table>

<div>

        <!--h4>Total Balance Amount: <span id="totalBalanceAmount"></span></h4-->

    </div>
    </div>
</div>
</body>

<script type="text/javascript">
$(function() {

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
	//        ajax: "{{ route('getbalancereport') }}",
	ajax: {
	url: "{{ route('getbalancereport') }}",
		data: function(d) {
			//alert($('input#startDate').val());
			if($('input#startDate').val()!=""){
			var start_date=$('input#startDate').val().split(" ");
		//	alert(start_date[0]);
			d.month = start_date[0];
			alert(d.month);
			}
			else
			d.month=07;
                d.year = 2024;
            },
            dataSrc: function (json) {
                // Update total balance amount
                $('#totalBalanceAmount').text(json.totalBalanceAmount);
                return json.data;
            }
        },
        columns: [{
                data: 'bill_no',
                name: 'bill_no'
            },
            {
                data: 'appointment_date',
                name: 'appointment_date'
},
		{
                data: 'name',
                name: 'name'
},
		{
                data: 'referer_name',
                name: 'referer_name'
},
		{
                data: 'paymentdetails',
                name: 'paymentdetails'
},
		 {
                data: 'modalitytype',
                name: 'modalitytype'
},
		{
                data: 'netamount',
                name: 'netamount'
},
		{
                data: 'paidamount',
                name: 'paidamount'
},
		{
                data: 'balanceamount',
                name: 'balanceamount'
            },
           /* {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
},*/
	],
	footerCallback: function (row, data, start, end, display) {
        var api = this.api(),
                    data;;

        // Function to calculate the total of a column
        var intVal = function (i) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Calculate the total for each column
        var totalNetAmount = api
            .column(6)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalPaidAmount = api
            .column(7)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalBalanceAmount = api
            .column(8)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Update the footer with the calculated totals
        $(api.column(6).footer()).html(totalNetAmount);
        $(api.column(7).footer()).html(totalPaidAmount);
        $(api.column(8).footer()).html(totalBalanceAmount);
    }
});


 $('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm yy',
        onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
});

$(".filter").click(function() {
        table.draw();
    });

});
</script>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    </style>
</html>
