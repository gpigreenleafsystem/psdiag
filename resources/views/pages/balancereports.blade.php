@extends('layouts.apptable', [
    'namePage' => 'Balance Report',
    'class' => 'sidebar-mini',
    'activePage' => 'balancereports',
  ])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
		@if(isset($message))
		 <div class="alert alert-info">
		<p>{{ $message }}</p>
		</div>
		@endif
          </div>
	  <div class="card-body">

<div class="content">
    <div class="container">
<div>   <a href="{{ url()->previous() }}">Back</a></div>
<h4 class="text-center" >PADMASHREE ADVANCED IMAGING SERVICES</h4>
<h5 class="text-center" >#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h5><br/>
<h4 class="text-center" id="heading">Balance Report</h4>

<div>
<!--label for="startDate">Date :</label>
    <input name="startDate" id="startDate" class="date-picker" />
 <button class="btn btn-success filter">Filter</button>

    </div-->
<div style=" margin: 20px 0px;">
                <strong>Date Filter:</strong>
                <input type="text" name="daterange" id="daterange" value="" />
                <button class="btn btn-success filter">Filter</button>
                <button class="btn btn-primary" id="todayFilter">Today</button>

</div>

        <table class="table table-bordered data-table">
            <thead>
                <tr>
                     <th><strong>Sl.No</strong></th>
<!--                    <th>patient_phoneno</th>-->
		    <th><strong>Bill No</strong></th>
			<th><strong>Bill Id</strong></th>
			<th><strong> Bill Date </strong></th>
			<th><strong>Patient Name</strong></th>
			<th><strong>Patient Mobileno</strong></th>
			<th><strong>Referer Name </strong></th>
			<!--th>Payment Details </th-->
			<th><strong>Modality</strong></th>
			<th><strong>Study </strong></th>
			<!--th>Referer Name </th-->
			<th><strong>Bill Amt </strong></th>
			<th><strong>Discount</strong></th>
			<th><strong>Paid Amt </strong></th>
			<th><strong>Balance/Due  Amt</strong> </th>
			<th><strong>Payment Details </strong></th>
                    <!--th width="100px">Action</th-->
                </tr>
            </thead>
            <tbody>
	    </tbody>
<tfoot>
                        <tr>
                            <th colspan="9" style="text-align:right">Total:</th>
			    <th id="totalBillAmount"></th>
				<th id="discount"></th>
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
</div> <!--card body-->
        </div> <!--card -->
      </div> <!--col -->

      </div> <!-- row -->
    </div>  <!-- content -->
  @endsection
  @push('scripts')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>  

    <link rel="stylesheet" type="text/css" media="screen" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
<link rel="stylesheet"
href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
$(function() {

	$('input[name="daterange"]').daterangepicker({
        startDate: moment().subtract(1, 'M'),
		endDate: moment(),
		locale: {
            format: 'DD/MM/YYYY'
        }
    });

    var table = $('.data-table').DataTable({
	 lengthMenu: [
            [ 10,25, 50, 100,-1],
            [ 10,25, 50, 100,'All']
        ],
    processing: true,
        serverSide: true,
	//        ajax: "{{ route('getbalancereport') }}",
	ajax: {
	url: "{{ route('getbalancereport') }}",
		data: function(d) {
            d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format(
                    'YYYY-MM-DD');
                d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format(
                    'YYYY-MM-DD');
			
            },
            dataSrc: function (json) {
                // Update total balance amount
                $('#totalBalanceAmount').text(json.totalBalanceAmount);
                return json.data;
            }
        },
	columns: [
	    {
                data: 'sno',
                name: 'sl_no',
                orderable: false,
                searchable: false
            },
	    {
                data: 'bill_no',
			name: 'bill_no'
	    },
           {
                data: 'billid',
                        name: 'billid'
            },
            {
		    data: 'bill_date',
			   
                 /*render: function(data, type, row) {
                    // Format the date in dd-mm-yyyy format
                    if (data) {
                        var date = new Date(data);
                        var day = String(date.getDate()).padStart(2, '0');
                        var month = String(date.getMonth() + 1).padStart(2,
                            '0'); // Months are zero-based
                        var year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
	return '';*/
			name:'bill_date'
                
},
		{
                data: 'name',
                name: 'name'
		},
			{
                data: 'mobileno',
                name: 'mobileno'
	    },
		{
                data: 'referer_name',
                name: 'referer_name'
},
	/*	{
                data: 'paymentdetails',
                name: 'paymentdetails'
},*/
		{data:'scan_type',
		name:'scan_type'},
		 {
                data: 'modalitytype',
                name: 'modalitytype'
},
		{
                data: 'netamount',
			name: 'netamount',
			/*render: function(data, type, row) {
                     return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}*/
		},
		{data:'bill_discount',name:'bill_discount',
	/*	render: function(data, type, row) {
                     return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}*/
		}
			,
		     {
                data: 'paidamount',
		name: 'paidamount',
	/*	render: function(data, type, row) {
                     return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		     }*/
},
		{
                data: 'balanceamount',
			name: 'balanceamount',
		/*	render: function(data, type, row) {
                     return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}*/
		},
		{
                data: 'paymentdetails',
                name: 'paymentdetails'
                },
           /* {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
},*/
	],
	 dom: 'lBfrtip', // Include the Buttons container in the DataTable
        buttons: [{

	text: 'Export as HTML',
    action: function(e, dt, button, config) {
	  var allData = dt.rows({ search: 'applied' }).data().toArray();

	 
	  // Generate the HTML for the entire table
	 /* var html = '<br/><br/><div align=\"center\"><p><h4 class="text-center" >PADMASREE ADVANCED IMAGING SERVICES</h4><h5 class="text-center" >#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h5><br/><br/>' + $('#heading').text() + '</p><br/></div>';
        html += '<table align=\"center\" border="1"><thead>' + dt.table().header().innerHTML + '</thead><tbody>';
	  */
	   // Generate the HTML for the entire table
                var html =
                    '<div align="center"><h4 class="text-center" >PADMASHREE ADVANCED IMAGING SERVICES</br>#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h4>' +
                    $('#heading').text() + '</div>';
                html +=
                    '<table align="center" border="1" style="border-collapse: collapse; border: 1px solid black;padding:5px; font-size:10px;"><thead>';

                // Modify the header to set the width of the sl.no column
                html += '<tr>';

                html += dt.table().header().innerHTML;
                html += '</tr>';
                html += '</thead><tbody>';

        // Iterate over all rows and construct the HTML
	allData.forEach(function(rowData) {
            html += '<tr>';
            // Use Object.values to get the cell data
            Object.values(rowData).forEach(function(cellData) {
                html += '<td style="white-space: nowrap;">' + cellData + '</td>';
            });
            html += '</tr>';
        });

	var footer = dt.table().footer().innerHTML;
            html += '<tfoot>' + footer + '</tfoot>';

        html += '</tbody></table>';
	// Open a new window/tab
        var newWindow = window.open('', '_blank');
        newWindow.document.write('<html><head><title>Report</title></head><body>');
        newWindow.document.write(html);
        newWindow.document.write('</body></html>');
        newWindow.document.close(); // Close the document to finish writing

	}

}],
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
	var totalNetAmnt = api
        .column(10, { page: 'current' })
        .data()
        .reduce(function (a, b) {
            console.log("Current row netamount: ", b); // Log each value
            return intVal(a) + intVal(b);
        }, 0);

    // Log the final total
    console.log("Total Net Amount: ", totalNetAmnt);
        var totalBillAmnt = api
            .column(9)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
	}, 0);
	var discount = api
            .column(11)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalPaidAmount = api
            .column(12)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalBalanceAmount = api
            .column(13)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
	
	// Update the footer with the calculated totals
	$(api.column(9).footer()).html(totalBillAmnt.toFixed(2));
	$(api.column(10).footer()).html(totalNetAmnt.toFixed(2));
	$(api.column(11).footer()).html(discount.toFixed(2));
        $(api.column(12).footer()).html(totalPaidAmount.toFixed(2));
	$(api.column(13).footer()).html(totalBalanceAmount.toFixed(2));
//	$(api.column(13).footer()).html("");
    }
});


 $('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
	showButtonPanel: true,
	defaultDate: new Date(),
        dateFormat: 'mm yy',
        onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
	},
	beforeShow: function(input, inst) {
            // Set the default month and year to the current month and year
            var today = new Date();
	    inst.settings.defaultDate = new Date(today.getFullYear(), today.getMonth(), 1);
            $(this).datepicker('setDate', inst.settings.defaultDate);
        },
});


// Today's data filter
    $('#todayFilter').click(function() {
         var today = moment().format('DD/MM/YYYY');
       //ar today = moment().format('MM/DD/YYYY');

        $('#daterange').data('daterangepicker').setStartDate(today);
        $('#daterange').data('daterangepicker').setEndDate(today);
	table.draw();
	 $('#heading').html('Balance Reports - ' + dateRange);
    });



 var today = new Date();
//$('input[name="startDate"]').val(today.getMonth()+" "+ today.getFullYear());
var dateRange = $('input[name="daterange"]').val(); //$('input[name="startDate"]').val();

        // Append the date range to the heading
$('#heading').html('Balance Reports - ' + dateRange);

$(".filter").click(function() {
	table.draw();
	var dateRange = $('input[name="daterange"]').val(); //$('input[name="startDate"]').val();

        // Append the date range to the heading
	$('#heading').html('Balance Reports - ' + dateRange);
    });

});
</script>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    </style>
@endpush
	@push('styles')
	<link href="{{ asset('assets/css/tablestyles.css') }}" rel="stylesheet">
	@endpush

