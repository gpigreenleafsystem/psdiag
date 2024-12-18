<?php

use Carbon\Carbon; ?>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 10px;
    line-height: 1.2;
    font-size: 14px;
}

.header-table {
    width: 100%;
    margin-bottom: 10px;
}

.header-table td {
    vertical-align: top;
}

.header-table img {
    max-width: 150px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;

}

.header img {
    max-width: 130px;
}

.header .address {
    text-align: right;
}

.details{
   /* width: 80%;*/
	width:100%;
    border-collapse: collapse;
    margin-bottom: 10px;
    border: 1px;
}
.charges {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

.payment-details {
    width:80%;
   /*position: absolute;*
    bottom: 100px;
    /*width: 100%;*/
/*width:98%;*/
}

.details td,

.charges td,

.charges th {

    padding: 6px;
}
.charges .invest {
    float: left;
    text-align: left;
}
.payment-details {
    width: 80%;
}
.payment-details th {
    padding: 6px;
}

.charges .sl-no {
    width: 50px;
text-align:left;
}

.charges .modality {
    width: 50px;
}

.charges .amt {
    float: right;
    text-align: right;
}

.charges .investigation {}

.charges th {
    float: left;
    text-align: center;
}

.total {
    text-align: right;
}

.total .amt {
    float: left;
    text-align: left;
}


.footer-table {
    position: absolute;
    bottom: 50px;
	width:90%;

}
.footer {
    position: absolute;
    bottom: 5px;
    width: 98%;
}
</style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td> <img src="assets/img/pdlogo1.jpeg" alt="Image">
            </td>
            <td style="text-align: right;">
                <h2>PADMASHREE ADVANCED IMAGING SERVICES</h2>
                <p>#97, 17th Cross, M C Layout, Near Telephone Exchange,
                    Vijayanagar, Bangalore - 560040.</p>
                <p>Tel : +91 80500 22311 / 80500 22411/ 80500 22511</p>
            </td>
        </tr>
    </table>

    <hr>
    <h3 style="text-align: center;">BILL/RECEIPT</h3>
    <hr>
    <table class="details">
        <tr>
            <td>Name</td>
            <td>:&nbsp;<?php echo $order->Patient_name ?></td>
            <td>Bill No</td>
            <td>:&nbsp;<?php echo $order->bill_no ?></td>
        </tr>
        <tr>
            <td>Sex</td>
            <td>:&nbsp;<?php echo $order->gender ?></td>
            <td>Date & Time</td>
            <td>:&nbsp;<?php echo Carbon::now()->format('d-m-Y h:i:s'); ?></td>
        </tr>
        <tr>
            <td>Age (In Yrs)</td>
            <td>:&nbsp;<?php echo $order->Patient_age ?> </td>
            <td>Ref. Dr</td>
            <td>:&nbsp;<?php echo $order->drref ?></td>
        </tr>
    </table>
    <hr>
    <h3 style="text-align: center;">Investigation Details</h3>
    <hr>
<div style="height:25%">
    <table class="charges">
        <tr>
            <th class="sl-no">Sl.No</th>
            <th class="modality">Modality</th>
            <th class="invest">Investigation</th>
            <th class="amt">Charges</th>
        </tr>

        <?php $i = 1;
        $totalCharges = 0;
        foreach ($order->scanningdetails as $inv) { ?>
        <tr>
            <td><?php echo $i++ ?> </td>
            <td><?php echo $inv->modality ?></td>
            <td><?php echo $inv->description ?></td>
            <td class="amt"><?php echo $inv->cost ?>&nbsp;&nbsp;Rs.</td>

        </tr>
        <?php } ?>
    </table>
</div>
    <hr>
    <table class="charges">


        <tr class="total">
            <td colspan="3">Charges</td>
            <td><?php echo $order->netamount; ?>&nbsp;&nbsp;Rs.</td>
	</tr>
<?php if($order->discount >0){?>
        <tr class="total">
    <td colspan="3">Discount</td>
            <td><?php echo $order->discount; ?>&nbsp;&nbsp;Rs.</td>
	</tr>
<?php } ?>

        <tr class="total">
            <td colspan="3"></td>
            <td>
                <hr>
            </td>
        </tr>
        <tr class="total">
            <td colspan="3">Total Charges</td>
	    <td> <<?php echo $order->partialpaymentamount;?>&nbsp;&nbsp;Rs.</td>
        </tr>
        <tr class="total">
	    <td colspan="3">Advance paid</td>
	   <td><?php echo $order->totpaidamount;?>&nbsp;&nbsp;Rs.</td>
        </tr>
        <tr class="total">
            <td colspan="3"></td>
            <td>
                <hr>
            </td>
        </tr>
        <tr class="total">
            <td colspan="3">Balance</td>
            <td><?php echo $order->balanceamount?>&nbsp;&nbsp;Rs.</td>
        </tr>
    </table>
    <table class="payment-details">
        <tr>
            <td style="width:15%;">Received by</td>
	    <td style="width:60%;text-align:left;">:&nbsp; <?php echo $order->generated_by; ?></td>
        </tr>
        <tr>
            <td style="width:15%"; >Payment Details</td>
            <td style="width:60%;text-align:left;">:&nbsp;<?php echo $order->paymentdetails; ?></td>
        </tr>

    </table>
    <hr>
    <br>
    <p style="text-align:right;"><strong> Padmashree Advanced Imaging Services</strong></p>
    <table class="footer-table">
        <tr>
            <td style="text-align: left;">Billed by :&nbsp;<?php echo $order->generated_by; ?></td>
            <td style="text-align: right;">Authorised Signatory</td>
        </tr>
    </table>

    <div class="footer">

        <hr>
        <strong>All Reports to be collected within 30 days from the Date of Investigation</strong>
    </div>
</body>

</html>
