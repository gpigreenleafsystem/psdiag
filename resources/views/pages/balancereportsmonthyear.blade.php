@extends('layouts.apptable', [
    'namePage' => 'Balance Report',
    'class' => 'sidebar-mini',
    'activePage' => 'balancedetails',
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
<h4 class="text-center" id="heading">Balance Report</h4>

<div>
<label for="startDate">Date :</label>
    <input name="startDate" id="startDate" class="date-picker" />
 <button class="btn btn-success filter">Filter</button>
    <!-- Display Total Balance Amount -->

    </div>

        <table class="table table-bordered data-table">
            <thead>
                <tr>
                     <th>Sl.No</th>
<!--                    <th>patient_phoneno</th>-->
		    <th>Bill No</th>
			<th> Bill Date </th>
			<th>Patient Name</th>
			<th>Patient Mobileno</th>
			<th>Referer Name </th>
			<!--th>Payment Details </th-->
			<th>Modality</th>
			<th>Study </th>
			<!--th>Referer Name </th-->
			<th>Bill Amt </th>
			<th>Discount</th>
			<th>Paid Amt </th>
			<th>Balance/Due  Amt </th>
			<th>Payment Details </th>
                    <!--th width="100px">Action</th-->
                </tr>
            </thead>
            <tbody>
	    </tbody>
<tfoot>
                        <tr>
                            <th colspan="8" style="text-align:right">Total:</th>
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

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>  

    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
<link rel="stylesheet"
href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.js"></script>
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
			render: function(data, type, row) {
                     return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}
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
	var html = '<br/><br/><br/><div align=\"center\"><p>' + $('#heading').text() + '</p><br/></div>';
        html += '<table align=\"center\" border="1"><thead>' + dt.table().header().innerHTML + '</thead><tbody>';

        // Iterate over all rows and construct the HTML
	allData.forEach(function(rowData) {
            html += '<tr>';
            // Use Object.values to get the cell data
            Object.values(rowData).forEach(function(cellData) {
                html += '<td>' + cellData + '</td>';
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
        var totalNetAmount = api
            .column(8)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
	    }, 0);
	var discount = api
            .column(9)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalPaidAmount = api
            .column(10)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalBalanceAmount = api
            .column(11)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
	
        // Update the footer with the calculated totals
	$(api.column(8).footer()).html(totalNetAmount.toFixed(2));
	$(api.column(9).footer()).html(discount.toFixed(2));
        $(api.column(10).footer()).html(totalPaidAmount.toFixed(2));
	$(api.column(11).footer()).html(totalBalanceAmount.toFixed(2));
	$(api.column(12).footer()).html("");
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

 var today = new Date();
$('input[name="startDate"]').val(today.getMonth()+" "+ today.getFullYear());

var dateRange = $('input[name="startDate"]').val();

        // Append the date range to the heading
$('#heading').html('Balance reports - ' + dateRange);

$(".filter").click(function() {
	table.draw();
	var dateRange = $('input[name="startDate"]').val();

        // Append the date range to the heading
	$('#heading').html('Balance reports - ' + dateRange);
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

