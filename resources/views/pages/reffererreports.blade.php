<!DOCTYPE html>
<html>

<head>
    <title>Refferer Reports</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

</head>
<body>
<div>
<div class="container">
<div>
	    <div><a href="{{ url()->previous() }}">Back</a></div>
<h4 class="text-center" >PADMASREE ADVANCED IMAGING SERVICES</h4>
<h5 class="text-center" >#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h5><br/>
            <h4 class=" text-center"">{{ __('Refferer Reports') }}</h4>
        </div>
        <div style=" margin: 20px 0px;">
                <strong>Date Filter:</strong>
                <input type="text" name="daterange" value="" />
                <button class="btn btn-success filter">Filter</button>
	</div>
<div class="table-responsive">
            <table class=" table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Sl.No</th>
			<th>Bill No</th>
			<th>Bill Date</th>
			<th>Patient Name</th>
			<th>Referrer Name</th>
                        <th>Modality</th>                     
                        <th>Study</th>
                        <th>Bill Amt</th>
                        <th>Dis</th>
                        <th>Net Amt</th>
                       
                        <th>Due Amt</th>
			<th>Paid Amt</th>
<th>Ref Amt</th>

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
</body
>
<script type="text/javascript">
$(function() {

    $('input[name="daterange"]').daterangepicker({
        startDate: moment().subtract(1, 'M'),
        endDate: moment()
    });

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
                data: null,
                name: 'sl_no',
                orderable: false,
                searchable: false
            }, // For Sl. No,
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
 render: function(data, type, row) {
                     return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
		}

            },
            {
                data: 'bill_discount',
		name: 'bill_discount',
 render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
                }
            },
            {
                data: 'netamount',
		name: 'netamount',
 render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
                }
            },
       
       
       
            {
                data: 'due_amount',
		name: 'due_amount',
 render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
                }
            },
            {
                data: 'paid_amount',
		name: 'paid_amount',
 render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
                }
	    },
  {
                data: 'ref_amount',
		name: 'ref_amount',
 render: function(data, type, row) {
                    return data !== null && data !== undefined && !isNaN(data) ? parseFloat(data).toFixed(2) : '0.00';
                }
            }




	],


        columnDefs: [{
            targets: 0,
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
	}]
,
dom: 'Bfrtip', // Include the Buttons container in the DataTable
        buttons: [{
            extend: 'excelHtml5',
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
            $(api.column(11).footer()).html(totalRefferAmount.toFixed(2));
            $(api.column(12).footer()).html(totalDueAmount.toFixed(2));
            $(api.column(13).footer()).html(totalPaidAmount.toFixed(2));

        }



    });


    $(".filter").click(function() {
        table.draw();
    });


});
</script>

</html>
