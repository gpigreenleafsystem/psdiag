@extends('layouts.apptable', [
    'namePage' => 'Outpatient Report',
    'class' => 'sidebar-mini',
    'activePage' => 'outpatientdetails',
  ])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
	    <h4 class="card-title"> Outpatient Report</h4>
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
            <h4 class=" text-center"">{{ __('Daily Reports') }}</h4>
        </div>
        <div style=" margin: 20px 0px;">
                <strong>Date Filter:</strong>
                <input type="text" name="daterange" id="daterange" value="" />
                <button class="btn btn-success filter">Filter</button>
                <button class="btn btn-primary" id="todayFilter">Today</button>

        </div>
    </div>

    <div class="table-responsive">
        <table class=" table table-bordered data-table">
            <thead>
                <tr>
                    <th>sl.no</th>
                    <th>Bill no</th>
                    <th>Bill date</th>
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
                    <th>Cash Amt</th>
                    <th>Cheque amt</th>
                    <th>CC Amt</th>
                    <th>NetBank Amt</th>
                    <th>Upi amt</th>
                    <!-- <th>Due-paid on</th> -->
                    <th>Payment Info</th>
                    <th>Gen By</th>


                </tr>
		<tr>
<th></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Bill No" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Billed On" /></th>
                    <th><input type="text" class="form-control column-search" placeholder="Name" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Age" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Sex" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Mob No" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Ref By" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Scan Type" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Bill Amt" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Dis" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Total Amt" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Paid Amt" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Due Amt" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Cash Amt" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" Cheque Amt" />
                    </th>
                    <th><input type="text" class="form-control column-search" placeholder=" CC Amt" /></th>
                    <th><input type="text" class="form-control column-search" placeholder=" NetBanking Amt" />
                    </th>
                    <th><input type="text" class="form-control column-search" placeholder=" UPI Amt" /></th>
                    <!--th><input type="text" class="form-control column-search" placeholder=" Due-paid on" />
                    </th-->
                    <th><input type="text" class="form-control column-search" placeholder="Payment Info" />
                    </th>
                    <th><input type="text" class="form-control column-search" placeholder=" Gen By" /></th>
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
                    <th id="totalPaidAmount"></th>
                    <th id="totalDueAmount"></th>
                    <th id="totalCashAmount"></th>
                    <th id="totalChequeAmount"></th>
                    <th id="totalCCAmount"></th>
                    <th id="totalNetbankAmount"></th>
                    <th id="totalUpiAmount"></th>
                    <th colspan="3"></th>
                </tr>
            </tfoot>

        </table>

    </div>
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
                $('.column-search').each(function(index) {
                    d['columns[' + index + '][search][value]'] = this.value;
                });
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
                data: 'gender',
                name: 'gender'
            },
            {
                data: 'mobileno',
                name: 'mobileno'
            },
            {
                data: 'referer_name',
                name: 'referer_name'
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
                data: 'bill_discount',
                name: 'bill_discount'
            },
            {
                data: 'netamount',
                name: 'netamount'
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
                data: 'cash_amount',
                name: 'cash_amount'
            },
            {
                data: 'cheque_amount',
                name: 'cheque_amount'
            },
            {
                data: 'cc_amount',
                name: 'cc_amount'
            },
            {
                data: 'net_banking_amount',
                name: 'net_banking_amount'
            },
            {
                data: 'upi_amount',
                name: 'upi_amount'
            },

            {
                data: 'payment_details',
                name: 'payment_details'
            },
            {
                data: 'generated_by',
                name: 'generated_by'
            },


        ],
        dom: 'lBfrtip', // Include the Buttons container in the DataTable
        buttons: [{

	text: 'Export as HTML',
    action: function(e, dt, button, config) {
	  var allData = dt.rows({ search: 'applied' }).data().toArray();

        // Generate the HTML for the entire table
        var html = '<table border="1"><thead>' + dt.table().header().innerHTML + '</thead><tbody>';
        
        // Iterate over all rows and construct the HTML
	allData.forEach(function(rowData) {
            html += '<tr>';
            // Use Object.values to get the cell data
            Object.values(rowData).forEach(function(cellData) {
                html += '<td>' + cellData + '</td>';
            });
            html += '</tr>';
        });

        html += '</tbody></table>';
        /*
        // Create a blob and download link for the HTML file
        var blob = new Blob([html], { type: 'text/html' });
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'Report_' + new Date().toISOString().slice(0, 10) + '.html';
        document.body.appendChild(link);
        link.click();
	document.body.removeChild(link);    */

	// Open a new window/tab
        var newWindow = window.open('', '_blank');
        newWindow.document.write('<html><head><title>Report</title></head><body>');
        newWindow.document.write(html);
        newWindow.document.write('</body></html>');
        newWindow.document.close(); // Close the document to finish writing

}





        }],
        columnDefs: [{
            targets: 0,
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
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
                .column(9)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalDiscount = api
                .column(10)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalNetAmount = api
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
            var totalDueAmount = api
                .column(13)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalCashAmount = api
                .column(14)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalChequeAmount = api
                .column(15)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalCCAmount = api
                .column(16)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalNetbankAmount = api
                .column(17)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalUpiAmount = api
                .column(18)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);



            $(api.column(9).footer()).html(totalBillAmount.toFixed(2));
            $(api.column(10).footer()).html(totalDiscount.toFixed(2));
            $(api.column(11).footer()).html(totalNetAmount.toFixed(2));
            $(api.column(12).footer()).html(totalPaidAmount.toFixed(2));
            $(api.column(13).footer()).html(totalDueAmount.toFixed(2));
            $(api.column(14).footer()).html(totalCashAmount.toFixed(2));
            $(api.column(15).footer()).html(totalChequeAmount.toFixed(2));
            $(api.column(16).footer()).html(totalCCAmount.toFixed(2));
            $(api.column(17).footer()).html(totalNetbankAmount.toFixed(2));
            $(api.column(18).footer()).html(totalUpiAmount.toFixed(2));

        }



    });

    // Apply the search for each column
    $('.column-search').on('keyup change', function() {
        table.draw();
    });
    $(".filter").click(function() {
        table.draw();
    });
    // Today's data filter
    $('#todayFilter').click(function() {
        // var today = moment().format('YYYY-MM-DD');
        var today = moment().format('MM/DD/YYYY');

        $('#daterange').data('daterangepicker').setStartDate(today);
        $('#daterange').data('daterangepicker').setEndDate(today);
        table.draw();
    });




});
</script>

@endpush
@push('styles')
<link href="{{ asset('assets/css/tablestyles.css') }}" rel="stylesheet">
@endpush

