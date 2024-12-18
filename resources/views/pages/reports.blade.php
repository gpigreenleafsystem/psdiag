@extends('layouts.apptable', [
'namePage' => 'Outpatient Report',
'class' => 'sidebar-mini',
'activePage' => 'reports',
])

@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div><a href="{{ route('home') }}">Back</a></div>
                        <h5 class="text-center">PADMASHREE ADVANCED IMAGING SERVICES</h5>
                        <h6 class="text-center">#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar,
                            Bangalore-560040</h6>
                        <h4 class=" text-center" id="heading">Outpatient Report</h4>

                    </div>
                   
                    @if(isset($message))
                    <div class="alert alert-info">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>
                <div class="container">

                    <div style=" margin: 10px 0px;">
                        <strong>Date Filter:</strong>
                        <input type="text" name="daterange" id="daterange" value="" />
                        <button class="btn btn-success filter">Filter</button>
                        <button class="btn btn-primary" id="todayFilter">Today</button>
                    </div>
                    <div class="table-responsive">
                        <table class=" table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th><strong>Sl.no</strong></th>
                                    <th><strong>Bill no</strong></th>
                                    <th><strong>Bill id</strong></th>
                                    <th><strong>Bill date</strong></th>
                                    <th><strong>Name</strong></th>
                                    <th><strong>Age</strong></th>
                                    <th><strong>Sex</strong></th>
                                    <th><strong>Mob No</strong></th>
                                    <th><strong>Ref By</strong></th>
                                    <th><strong>Scan Type</strong></th>
                                    <th><strong>Bill Amt</strong></th>
                                    <th><strong>Dis</strong></th>
                                    <th><strong>Total Amt</strong></th>
                                    <th><strong>Paid Amt</strong></th>
                                    <th><strong>Due Amt</strong></th>
                                    <th><strong>Cash Amt</strong></th>
                                    <th><strong>Cheque amt</strong></th>
                                    <th><strong>CC Amt</strong></th>
                                    <th><strong>NetBank Amt</strong></th>
                                    <th><strong>Upi amt</strong></th>
                                    <th><strong>Payment Info</strong></th>
                                    <th><strong>Gen By</strong></th>


                                </tr>
                             </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="10" style="text-align:right">Total:</th>
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
                                    <th colspan="1"></th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
                <!--container-->
            </div>

            <!--card body-->
        </div>
        <!--card -->
    </div>
    <!--col -->

</div> <!-- row -->
</div> <!-- content -->
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

	var table = $('.data-table').DataTable({
	   lengthMenu: [
            [ 10,25, 50, 100,-1],
            [ 10,25, 50, 100,'All']
        ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('reports') }}",
                data: function(d) {
                    startdate = $('input[name="daterange"]').data('daterangepicker').startDate.format(
                        'DD/MM/YYYY');
                    enddate = $('input[name="daterange"]').data('daterangepicker').endDate.format(
                        'DD/MM/YYYY');
                    d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format(
                        'YYYY-MM-DD');
                    d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format(
                        'YYYY-MM-DD');
                    $('.column-search').each(function(index) {
                        d['columns[' + index + '][search][value]'] = this.value;
                    });
                    $('#heading').html('Outpatient Report - ' + startdate + " - " + enddate);
                  
                }
            },
            columns: [{
                    "data": "sno",
                    "name": "sno"
                },
                {
                    "data": "bill_no",
                    "name": "bill_no"
                },
                {
                    "data": "bill_id",
                    "name": "bill_id",
                },
                {
                    "data": "bill_date",
                    "name": "bill_date"
                },
                {
                    "data": "name",
                    "name": "name"
                },
                {
                    "data": "age",
                    "name": "age"
                },
                {
                    "data": "gender",
                    "name": "gender"
                },
                {
                    "data": "mobileno",
                    "name": "mobileno"
                },
                {
                    "data": "referer_name",
                    "name": "referer_name"
                },
                {
                    "data": "scantype",
                    "name": "scantype"
                },
                {
                    "data": "bill_amount",
                    "name": "bill_amount"
                },
                {
                    "data": "bill_discount",
                    "name": "bill_discount"
                },
                {
                    "data": "netamount",
                    "name": "netamount"
                },
                {
                    "data": "paid_amount",
                    "name": "paid_amount"
                },
                {
                    "data": "due_amount",
                    "name": "due_amount"
                },
                {
                    "data": "cash_amount",
                    "name": "cash_amount"
                },
                {
                    "data": "cheque_amount",
                    "name": "cheque_amount"
                },
                {
                    "data": "cc_amount",
                    "name": "cc_amount"
                },
                {
                    "data": "net_banking_amount",
                    "name": "net_banking_amount"
                },
                {
                    "data": "upi_amount",
                    "name": "upi_amount"
                },
                {
                    "data": "payment_details",
                    "name": "payment_details"
                },
                {
                    "data": "generated_by",
                    "name": "generated_by"
                }

            ],
            dom: 'lBfrtip', // Include the Buttons container in the DataTable
            buttons: [{

                text: 'Export as HTML',
                action: function(e, dt, button, config) {
                    var allData = dt.rows({
                        search: 'applied'
                    }).data().toArray();
                    var html =
                        '<div align="center"><h4 class="text-center" >PADMASHREE ADVANCED IMAGING SERVICES</br>#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h4>' +
                       $('#heading').text() + '</div> </br>';
                    html +=
                        '<table align="center" border="1" style="border-collapse: collapse; border: 1px solid black;padding:5px;font-size:10px;"><thead>';

                    // Modify the header to set the width of the sl.no column
                    html += '<tr>';

                    html += dt.table().header().innerHTML;
                    html += '</tr>';
                    html += '</thead><tbody>';
                    // Iterate over all rows and construct the HTML
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
                    newWindow.document.write(
                        '<html><head><title> Daily Report</title></head><body>');
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
                    .column(10)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var totalDiscount = api
                    .column(11)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var totalNetAmount = api
                    .column(12)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);


                var totalPaidAmount = api
                    .column(13)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var totalDueAmount = api
                    .column(14)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var totalCashAmount = api
                    .column(15)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var totalChequeAmount = api
                    .column(16)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var totalCCAmount = api
                    .column(17)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var totalNetbankAmount = api
                    .column(18)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var totalUpiAmount = api
                    .column(19)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);



                $(api.column(10).footer()).html(totalBillAmount.toFixed(2));
                $(api.column(11).footer()).html(totalDiscount.toFixed(2));
                $(api.column(12).footer()).html(totalNetAmount.toFixed(2));
                $(api.column(13).footer()).html(totalPaidAmount.toFixed(2));
                $(api.column(14).footer()).html(totalDueAmount.toFixed(2));
                $(api.column(15).footer()).html(totalCashAmount.toFixed(2));
                $(api.column(16).footer()).html(totalChequeAmount.toFixed(2));
                $(api.column(17).footer()).html(totalCCAmount.toFixed(2));
                $(api.column(18).footer()).html(totalNetbankAmount.toFixed(2));
                $(api.column(19).footer()).html(totalUpiAmount.toFixed(2));

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
            // var today = moment().format('MM/DD/YYYY');
            var today = moment().format('DD/MM/YYYY');

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
