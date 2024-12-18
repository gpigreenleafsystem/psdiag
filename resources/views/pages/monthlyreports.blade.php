@extends('layouts.apptable', [
'namePage' => 'Monthly Report',
'class' => 'sidebar-mini',
'activePage' => 'monthlyreports',
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
                        <h4 class=" text-center" id="heading">Monthly Report</h4>

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

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>

                                    <th><strong>Summary Date</strong></th>
                                    <th><strong>MR</strong></th>
                                    <th><strong>Disc</strong></th>
                                    <th><strong>Net</strong></th>
                                    <th><strong>Contrast</strong></th>
                                    <th><strong>Disc</strong></th>
                                    <th><strong>Net</strong></th>
                                    <th><strong>MR Contrast</strong></th>
                                    <th><strong>Disc</strong></th>
                                    <th><strong>Net</strong></th>
                                    <th><strong>CT</strong></th>
                                    <th><strong>Disc</strong></th>
                                    <th><strong>Net</strong></th>
                                    <th><strong>Contrast</strong></th>
                                    <th><strong>Disc</strong></th>
                                    <th><strong>Net Contrast</strong></th>
                                    <th>
                                        <trast>CT Contrast</strong>
                                    </th>
                                    <th><strong>Disc</strong></th>
                                    <th><strong>Net</strong></th>
                                    <th><strong>Total Gross</strong></th>
                                    <th><strong>Total Disc</strong></th>
                                    <th><strong>Total Net</strong></th>
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
    startDate: moment().subtract(2, 'M'),
        endDate: moment(),
        locale: {
            format: 'DD/MM/YYYY'
        }

    });

    var table = $('.data-table').DataTable({
        lengthMenu: [
            [-1, 25, 50, 100],
            ['All', 25, 50, 100]
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('monthlyreport') }}",
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
                $('#heading').html('Monthly Report - ' + startdate + " - " + enddate);
                //$('#heading').html('Outpatient reports from ' + startdate + " to " + enddate);
            }
        },
        columns: [

            {
                data: 'date',
                name: 'date'
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
                data: 'mr',
                name: 'mr'
            },
            {
                data: 'mr_disc',
                name: 'mr_disc'
            },
            {
                data: 'mr_net',
                name: 'mr_net'
            },
            {
                data: 'mr_contrast',
                name: 'mr_contrast'
            },
            {
                data: 'mr_contrast_disc',
                name: 'mr_contrast_disc'
            },
            {
                data: 'mr_contrast_net',
                name: 'mr_contrast_net'
            },
            {
                data: 'mrcontrast',
                name: 'mrcontrast'
            },
            {
                data: 'mrcontrast_disc',
                name: 'mrcontrast_disc'
            },
            {
                data: 'mrcontrast_net',
                name: 'mrcontrast_net'
            },
            {
                data: 'ct',
                name: 'ct'
            },
            {
                data: 'ct_disc',
                name: 'ct_disc'
            },
            {
                data: 'ct_net',
                name: 'ct_net'
            },
            {
                data: 'ct_contrast',
                name: 'ct_contrast'
            },
            {
                data: 'ct_contrast_disc',
                name: 'ct_contrast_disc'
            },
            {
                data: 'ct_contrast_net',
                name: 'ct_contrast_net'
            },
            {
                data: 'ctcontrast',
                name: 'ctcontrast'
            },
            {
                data: 'ctcontrast_disc',
                name: 'ctcontrast_disc'
            },
            {
                data: 'ctcontrast_net',
                name: 'ctcontrast_net'
            },
            {
                data: 'totalgross',
                name: 'totalgross'
            },
            {
                data: 'totaldiscount',
                name: 'totaldiscount'
            },
            {
                data: 'totalnet',
                name: 'totalnet'
            },

        ],
        dom: 'lBfrtip', // Include the Buttons container in the DataTable
        buttons: [{

            text: 'Export as HTML',
            action: function(e, dt, button, config) {
                var allData = dt.rows({
                    search: 'applied'
                }).data().toArray();


                // Generate the HTML for the entire table
                var html =
                    '<div align="center"><h4 class="text-center" >PADMASREE ADVANCED IMAGING SERVICES</br>#97,17th cross, M C Layout, Near Telephone Exchange, Vijayanagar, Bangalore-560040</h4>' +
                    $('#heading').text() + '</div>';
                html +=
                    '<table align="center" border="1" style="border-collapse: collapse; border: 1px solid black;padding:5px;font-size:13px;"><thead>';

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
                        html += '<td>' + cellData + '</td>';
                    });
                    html += '</tr>';
                });

                var footer = dt.table().footer().innerHTML;
                html += '<tfoot>' + footer + '</tfoot>';

                html += '</tbody></table>';
                // Open a new window/tab
                var newWindow = window.open('', '_blank');
                newWindow.document.write(
                    '<html><head><title>Report</title></head><body>');
                newWindow.document.write(html);
                newWindow.document.write('</body></html>');
                newWindow.document.close(); // Close the document to finish writing

            }

        }],
        footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
                data;;

            // Function to calculate the total of a column
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };


            // Calculate the total for each column
            var tmr = api
                .column(1, {
                    page: 'current'
                })
                .data()
                .reduce(function(a, b) {
                    console.log("Current row tmramount: ", b); // Log each value
                    return intVal(a) + intVal(b);
                }, 0);
            var totalmr = api
                .column(2, {
                    page: 'current'
                })
                .data()
                .reduce(function(a, b) {
                    console.log("Current row netamount: ", b); // Log each value
                    return intVal(a) + intVal(b);
                }, 0);

            // Log the final total
            //    console.log("Total Net Amount: ", totalNetAmnt);
            var totalmr_disc = api
                .column(3)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalmr_net = api
                .column(4)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalmr_cont = api
                .column(5)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalmr_cont_disc = api
                .column(6)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalmr_cont_net = api
                .column(7)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalmrcont = api
                .column(8)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalmrcont_disc = api
                .column(9)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalmrcont_net = api
                .column(10)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


            var totalct = api
                .column(11, {
                    page: 'current'
                })
                .data()
                .reduce(function(a, b) {
                    console.log("Current row netamount: ", b); // Log each value
                    return intVal(a) + intVal(b);
                }, 0);

            // Log the final total
            //    console.log("Total Net Amount: ", totalNetAmnt);
            var totalct_disc = api
                .column(12)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalct_net = api
                .column(13)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalct_cont = api
                .column(14)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalct_cont_disc = api
                .column(15)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalct_cont_net = api
                .column(16)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalctcont = api
                .column(17)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalctcont_disc = api
                .column(18)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var totalctcont_net = api
                .column(19)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var total_disc = api
                .column(20)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var total_net = api
                .column(21)
                .data()
                .reduce(function(a, b) {
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
