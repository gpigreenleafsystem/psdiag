<?php
use Carbon\Carbon;
?>
<!--link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"--> 
<!--link href="{{asset('public/css/custom.css')}}" rel="stylesheet"-->
<style type="text/css">
 body{
width:50%!important;
font-size:12px;

}
*{
}
.container{
  width: 400px;
}
.outer_border{
border:1px solid #999999!important;
padding:4%!important;
margin-bottom:2%!important;
}
.top_box{
width:47%; padding:0%
 }
.table_pad{
padding:0% 2%;
}
.border{
border:1px solid #CCCCCC!important;
}
.small_text{
font-size:10px!important;
}
.bg_color1{
  background:#3a5082;
  color: #fff;
 }
.text_color1{
  color:#3a5082;
 }
 td{
 padding:4px;
 } </style>
<body>
<div class="container"><div class="outer_border"> 
<div class="row">
<div  class=" pull-left top_box   p-4">
PADMASREE ADVANCE IMAGING SERVICES<br/>
#97,17TH Cross,M C Layout, <br/>
Near Telephone Exchange,Vijayanagar,<br/>
Bangalore-560040<br/>
Phone : 8050022311/8050022411/8050022511<br/>
Email : xyz@gmail.com <br/>
Website : {{config('app.url')}}<br/> 
</div>
<div style="" class=" pull-right top_box   p-4"> 
<h2 style="color:#687cbf;font-weight: bold;font-size:30px; text-align:right; padding-right: 30px;" style="color:#687cbf;font-weight: bold;font-size:30px; text-align:right; padding-right: 30px;" id="invoice">RECEIPT</h2> 
*******************************************<br/>
Bill No :  <?php echo $order->bill_no?><br/>
Date	:  <?php echo Carbon::now()->format('d-m-Y');?><br/>
Name	:  <?php echo $order->Patient_name?><br/>
Ref. Dr :  <?php echo $order->drref?><br/>
AGE	:  <?php echo $order->Patient_age?><br/>
SEX	:  <?php echo $order->gender?><br/>
<br/>
*******************************************<br/>

<!--table width="100%" height="70" border="0" class="table_pad"> <tr> <td > Date</td> <td> -->
</div>
<div>
No. <t/> Investigation <t/> Charges <br/>
*******************************************<br/>
<?php 
$i=1;
foreach($order->scanningdetails as $inv){ ?>
<?php echo $i ?> <t/>
<?php echo $inv->description?> <t/>
<?php echo $inv->cost ?> <t/>
<?php } ?><br/><br/>
*******************************************<br/>
Total Charges<t/><t/><?php echo $order->netamount; ?><br/>
Advance Rs. <t/><t/><?php echo $order->partialpaymentamount; ?><br/>
Total paid Rs. <t/><t/><?php echo $order->totpaidamount; ?><br/>
Balance Rs <t/><t/><?php echo $order->balanceamount; ?><br/>
<br/>
Received by <t/><?php echo $order->paymentdetails;; ?><br/>
*******************************************<br/>
<t/><t/>For PADMASREE ADVANCE IMAGING SERVICES<br/>
<br/>
------------------admin--------------------<br/>
*******************************************<br/>
ALL REPORTS TO BE COLLECTED WITH IN 30 DAYS<br/>
FROM THE DATE OF INVESTIGATION<br/>

</div>

</div></div>
</div>
</div>
</body>
