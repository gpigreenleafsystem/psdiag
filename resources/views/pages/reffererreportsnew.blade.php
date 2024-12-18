
@extends('layouts.apptable', [
    'namePage' => 'Referer Report',
    'class' => 'sidebar-mini',
    'activePage' => 'refererdetails',
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
<div>
	    <div><a href="{{ url()->previous() }}">Back</a></div>
<h4 class="text-center" >PADMASHREE ADVANCED IMAGING SERVICES</h4>
<h5 class="text-center" >#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h5><br/>
            <h4 class=" text-center"" id="heading">{{ __('Refferer Reports') }}</h4>
        </div>
        <div style=" margin: 20px 0px;">
                <strong>Date Filter:</strong>
                <input type="text" name="daterange" id="daterange" value="" />
		<button class="btn btn-success filter">Filter</button>
		<button class="btn btn-primary" id="todayFilter">Today</button>
	</div>
<div class="table-responsive">
            <table class=" table table-bordered data-table">
                <thead>
                    <tr>
                        <th><strong>Sl.No</strong></th>
			<th><strong>Bill No</strong></th>
			<th><strong>Bill Id</strong></th>
			<th><strong>Referrer Bill Date</strong></th>
			<th><strong>Patient Name</strong></th>
			<th><strong>Referrer Name</strong></th>
                        <th><strong>Modality</strong></th>                     
                        <th><strong>Study</strong></th>
                        <th><strong>Bill Amt</strong></th>
                        <th><strong>Dis</strong></th>
                        <th><strong>Net Amt</strong></th>
                        <th><strong>Due Amt</strong></th>
			<th><strong>Paid Amt</strong></th>
			<th><strong>Ref Amt</strong></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="8" style="text-align:right">Total:</th>
                        <th id="totalBillAmount"></th>
                        <th id="totalDiscount"></th>
                        <th id="totalNetAmount"></th>
                         <th id="totalDueAmount"></th>
			<th id="totalPaidAmount"></th>
<th id="totalRefAmount"> </th>
                    </tr>
                </tfoot>

            </table>
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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" />

    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <!-- JSZip for Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.0/jszip.min.js"></script>
    <!-- DataTables Excel HTML5 Export JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script type="text/javascript">
$(function() {

    $('input[name="daterange"]').daterangepicker({
        startDate: moment().subtract(1, 'M'),
	endDate: moment(),
locale: {
            format: 'DD/MM/YYYY'
        }
    });

	var dateRange = $('input[name="daterange"]').val();

        // Append the date range to the heading
        $('#heading').html('Referrer Reports - ' + dateRange);

    var table = $('.data-table').DataTable({
	 lengthMenu: [
            [ 10,25, 50, 100,-1],
            [ 10,25, 50, 100,'All']
        ],
	processing: true,
        serverSide: true,
        ajax: {
	    url: "{{ route('referreport') }}",
 data: function(d) {
                d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format(
                    'YYYY-MM-DD');
                d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format(
                    'YYYY-MM-DD');

            }

        },
        columns: [{
                data: 'sno',
                name: 'sl_no',
                orderable: false,
                searchable: false
            }, // For Sl. No,
            {
                data: 'bill_no',
		name: 'bill_no',
		searchable: true
	    },
	    {
                data: 'billid',
                name: 'billid'
            },
 {
                data: 'bill_date',
		name: 'bill_date'
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
                    return '';
		}*/
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
                data: 'modality',
                name: 'modality'
            },
            
            {
                data: 'study',
                name: 'study'
            },


            {
                data: 'bill_amount',
		name: 'bill_amount',
/* render: function(data, type, row) {
                     return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}*/

            },
            {
                data: 'bill_discount',
		name: 'bill_discount',
/* render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}*/
            },
            {
                data: 'netamount',
		name: 'netamount',
/* render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}*/
            },
       
       
       
            {
                data: 'due_amount',
		name: 'due_amount',
/* render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}*/
            },
            {
                data: 'paid_amount',
		name: 'paid_amount',
/* render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}*/
	    },
  {
                data: 'referer_amount',
		name: 'referer_amount',
/* render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}*/
            }




	],


        columnDefs: [{
            targets: 0,
           /* render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
	    }*/
	}]
,
dom: 'lBfrtip', // Include the Buttons container in the DataTable
        buttons: [{
/*            extend: 'excelHtml5',
	    title: 'Refferer Reports',
 filename: 'Refferer Report_' + new Date().toISOString().slice(0, 10),
            exportOptions: {
		columns: ':visible', // Include all visible columns in export
header:true,
                format: {
                    header: function(data, columnIdx) {
                        // Customize the header format
                        return $(data).text();
                    }
                },
columnDefs: [ { targets: -1, visible: false } ],		
modifier: {
                    page: 'all' // Export all data, not just the visible page
                }

	    }*/
	text: 'Export as HTML',
	action: function(e, dt, button, config) {
	  
	var allData = dt.rows({ search: 'applied' }).data().toArray();

	// Generate the HTML for the entire table
	/*var html = '<br/><br/><br/><div align=\"center\"><p><h4 class="text-center" >PADMASHREE ADVANCED IMAGING SERVICES</h4><h5 class="text-center" >#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h5><br/><br/>' + $('#heading').text() + '</p><br/></div>';
            html += '<table align=\"center\" border="1"><thead>' + dt.table().header().innerHTML + '</thead><tbody>';
*/
  // Generate the HTML for the entire table
                        var html =
                            '<div align="center"><h4 class="text-center" >PADMASHREE ADVANCED IMAGING SERVICES</br>#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h4>' +
                            $('#heading').text() + '</div></br>';
                        html +=
                            '<table align="center" border="1" style="border-collapse: collapse; border: 1px solid black;padding:5px; font-size:12px;"><thead>';

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
                .column(8)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalDiscount = api
                .column(9)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalNetAmount = api
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
            var totalPaidAmount = api
                .column(12)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
		}, 0);
  var totalRefferAmount = api
                .column(13)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


            $(api.column(8).footer()).html(totalBillAmount.toFixed(2));
            $(api.column(9).footer()).html(totalDiscount.toFixed(2));
            $(api.column(10).footer()).html(totalNetAmount.toFixed(2));
	    $(api.column(11).footer()).html(totalDueAmount.toFixed(2));
            $(api.column(12).footer()).html(totalPaidAmount.toFixed(2));
            $(api.column(13).footer()).html(totalRefferAmount.toFixed(2));

        }



    });


    $(".filter").click(function() {
	table.draw();
	var dateRange = $('input[name="daterange"]').val();

	// Append the date range to the heading
	$('#heading').html('Referrer Reports - ' + dateRange);
    });

// Today's data filter
        $('#todayFilter').click(function() {
            // var today = moment().format('YYYY-MM-DD');
            // var today = moment().format('MM/DD/YYYY');
            var today = moment().format('DD/MM/YYYY');

            $('#daterange').data('daterangepicker').setStartDate(today);
            $('#daterange').data('daterangepicker').setEndDate(today);
	    table.draw();
	 $('#heading').html('Referrer Reports - ' + dateRange);
        });


});
</script>

@endpush
	@push('styles')
	<link href="{{ asset('assets/css/tablestyles.css') }}" rel="stylesheet">
	@endpush

