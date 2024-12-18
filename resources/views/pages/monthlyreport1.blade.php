@extends('layouts.apptable', [
    'namePage' => 'Monthly Report',
    'class' => 'sidebar-mini',
    'activePage' => 'summarydetails',
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
<div>   <a href="{{route('home') }}">Back</a></div>
<h4 class="text-center" >PADMASREE ADVANCED IMAGING SERVICES</h4>
<h5 class="text-center" >#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h5><br/>
<h4 class="text-center" id="heading">Monthly Report</h4>

<div>
<strong>Select Month,Year:</strong>
    <div class="date" id="datepick" data-target-input="nearest">
	<input type="text" id="datetimepicker1" class=" datetimepicker-input"  name="startDate" />
	<button class="btn btn-success filter">Filter</button>
        <div class="input-group-append" data-target="#datepicker" >
            <!--div class="input-group-text"><i class="fa fa-calendar"></i></div-->
	</div>
	<!--button class="btn btn-success filter">Filter</button-->
    </div><br/>
<!--div hidden style=" margin: 20px 0px;">
                <strong>Date Filter:</strong>
                <input type="text" name="daterange" id="daterange" value="" />
                <!--button class="btn btn-success filter">Filter</button- ->
                <button class="btn btn-primary" id="todayFilter">Today</button>

</div-->

        <table class="table table-bordered data-table">
            <thead>
            <tr>
              
              <th>Summary Date</th>
              <th>MR</th>
      <th>Disc</th>
     <th>Net</th>
     <th>Contrast</th>
    <th>Disc</th>
    <th>Net</th>
    <th>MR Contrast</th>
              <th>Disc</th>
             <th>Net</th>
     <th>CT</th>
              <th>Disc</th>
             <th>Net</th>
             <th>Contrast</th>
            <th>Disc</th>
            <th>Net</th>
            <th>CT Contrast</th>
              <th>Disc</th>
     <th>Net</th>
    <th>Total Gross</th>
              <th>Total Disc</th>
             <th>Total Net</th>
    </tr>
            </thead>
            <tbody>
	    </tbody>
<tfoot>
                        <tr>
                        <td colspan=1> Total Amount:</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
$(function() {

	    $('#datetimepicker1').datepicker({
            format: 'YYYY-MM'
    });

	     $('#datepick').datepicker({
        format: "mm yyyy",
        startView: "months",
        minViewMode: "months",
        autoclose: true
    });

	
	
	$('input[name="daterange"]').daterangepicker({
        startDate: moment().subtract(1, 'M'),
        endDate: moment()
    });

	var table = $('.data-table').DataTable({
	pageLength: 31,
        processing: true,
        serverSide: true,
	searching: false,	
	ajax: {
	url: "{{ route('monthlyreport') }}",
		data: function(d) {

	//		d.startDate=$('input#startDate').val();
		/*	if($('input#startDate').val()!=""){
			var start_date=$('input#startDate').val().split(" ");
			d.month = start_date[0];
			d.year = start_date[1];
			}
			else
			d.month=07;
			d.year = 2024;
		 */	
            },
            dataSrc: function (json) {
                // Update total balance amount
               // $('#totalBalanceAmount').text(json.totalBalanceAmount);
                return json.data;
            }
        },
	columns: [
	   
{data: 'date',name: 'date'},
{data: 'mr',name: 'mr'},
{data: 'mr_disc', name: 'mr_disc'},
{data: 'mr_net', name: 'mr_net'},
{data: 'mr_contrast', name: 'mr_contrast'},
{data: 'mr_contrast_disc', name: 'mr_contrast_disc'},
{data: 'mr_contrast_net', name: 'mr_contrast_net'},
{data: 'mrcontrast', name: 'mrcontrast'},
{data: 'mrcontrast_disc', name: 'mrcontrast_disc'},
{data: 'mrcontrast_net', name: 'mrcontrast_net'},
{data: 'ct', name: 'ct'},
{data: 'ct_disc', name: 'ct_disc'},
{data: 'ct_net', name: 'ct_net'},
{data: 'ct_contrast', name: 'ct_contrast'},
{data: 'ct_contrast_disc', name: 'ct_contrast_disc'},
{data: 'ct_contrast_net', name: 'ct_contrast_net'},
{data: 'ctcontrast', name: 'ctcontrast'},
{data: 'ctcontrast_disc', name: 'ctcontrast_disc'},
{data: 'ctcontrast_net', name: 'ctcontrast_net'},
{data: 'totalgross', name: 'totalgross'},
{data: 'totaldiscount', name: 'totaldiscount'},
{data: 'totalnet', name: 'totalnet'},
       
	],
	 dom: 'lBfrtip', // Include the Buttons container in the DataTable
        buttons: [{

	text: 'Export as HTML',
    action: function(e, dt, button, config) {
	  var allData = dt.rows({ search: 'applied' }).data().toArray();

	 
	  // Generate the HTML for the entire table
	  var html = '<br/><br/><div align=\"center\"><p><h4 class="text-center" >PADMASREE ADVANCED IMAGING SERVICES</h4><h5 class="text-center" >#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h5><br/><br/>' + $('#heading').text() + '</p><br/></div>';
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
        var tmr = api
        .column(1, { page: 'current' })
        .data()
        .reduce(function (a, b) {
            console.log("Current row tmramount: ", b); // Log each value
            return intVal(a) + intVal(b);
        }, 0);
	var totalmr = api
        .column(2, { page: 'current' })
        .data()
        .reduce(function (a, b) {
            console.log("Current row netamount: ", b); // Log each value
            return intVal(a) + intVal(b);
        }, 0);

    // Log the final total
//    console.log("Total Net Amount: ", totalNetAmnt);
        var totalmr_disc = api
            .column(3)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
	}, 0);
	var totalmr_net = api
            .column(4)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

       var totalmr_cont = api
            .column(5)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalmr_cont_disc = api
            .column(6)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
	var totalmr_cont_net = api
            .column(7)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
	    }, 0);

	var totalmrcont = api
            .column(8)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalmrcont_disc = api
            .column(9)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
        var totalmrcont_net = api
            .column(10)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);


	var totalct = api
        .column(11, { page: 'current' })
        .data()
        .reduce(function (a, b) {
            console.log("Current row netamount: ", b); // Log each value
            return intVal(a) + intVal(b);
        }, 0);

    // Log the final total
//    console.log("Total Net Amount: ", totalNetAmnt);
        var totalct_disc = api
            .column(12)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
        }, 0);
        var totalct_net = api
            .column(13)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
	    }, 0);

	var totalct_cont = api
            .column(14)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalct_cont_disc = api
            .column(15)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
        var totalct_cont_net = api
            .column(16)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
	    }, 0);
	var totalctcont = api
            .column(17)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalctcont_disc = api
            .column(18)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
        var totalctcont_net = api
            .column(19)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
	    }, 0);

	var total_disc = api
            .column(20)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
        var total_net = api
            .column(21)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);



	// Update the footer with the calculated totals
	$(api.column(1).footer()).html(tmr.toFixed(2));
	$(api.column(2).footer()).html(totalmr.toFixed(2));
	$(api.column(3).footer()).html(totalmr_disc.toFixed(2));
	$(api.column(4).footer()).html(totalmr_net.toFixed(2));
        $(api.column(5).footer()).html(totalmr_cont.toFixed(2));
	$(api.column(6).footer()).html(totalmr_cont_disc.toFixed(2));
	 $(api.column(7).footer()).html(totalmr_cont_net.toFixed(2));
        $(api.column(8).footer()).html(totalmrcont.toFixed(2));
	$(api.column(9).footer()).html(totalmrcont_disc.toFixed(2));
	$(api.column(10).footer()).html(totalmrcont_net.toFixed(2));
	$(api.column(11).footer()).html(totalct.toFixed(2));
        $(api.column(12).footer()).html(totalct_disc.toFixed(2));
        $(api.column(13).footer()).html(totalct_net.toFixed(2));
	 $(api.column(14).footer()).html(totalct_cont.toFixed(2));
        $(api.column(15).footer()).html(totalct_cont_disc.toFixed(2));
	$(api.column(16).footer()).html(totalct_cont_net.toFixed(2));
	$(api.column(17).footer()).html(totalctcont.toFixed(2));
        $(api.column(18).footer()).html(totalctcont_disc.toFixed(2));
	$(api.column(19).footer()).html(totalctcont_net.toFixed(2));
	$(api.column(20).footer()).html(total_disc.toFixed(2));
        $(api.column(21).footer()).html(total_net.toFixed(2));
//	$(api.column(13).footer()).html("");*/
    }
});

// Today's data filter
/*    $('#todayFilter').click(function() {
        // var today = moment().format('YYYY-MM-DD');
        var today = moment().format('MM/DD/YYYY');

        $('#daterange').data('daterangepicker').setStartDate(today);
        $('#daterange').data('daterangepicker').setEndDate(today);
        table.draw();
    });
 */


 var today = new Date();
$('input[name="startDate"]').val(today.getMonth()+" "+ today.getFullYear());
var dateRange = $('input[name="startDate"]').val();

        // Append the date range to the heading
$('#heading').html('Balance reports - ' + dateRange);

$(".filter").click(function() {
//	alert("hi");
//	$('#datepick').close();
	table.draw();
	var dateRange = $('input[name="startDate"]').val();

        // Append the date range to the heading
	$('#heading').html('Balance reports - ' + dateRange);
    });

});
</script>
<style>
/*    .ui-datepicker-calendar {
        display: none;
    }*/
    </style>
@endpush
	@push('styles')
	<link href="{{ asset('assets/css/tablestyles.css') }}" rel="stylesheet">
	@endpush

