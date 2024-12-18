<?php
 $admin_email=config('app.admin_email');
$admin_mobile=config('app.admin_mobile');
$shop_address=config('app.shop_address');
  ?> <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> <link href="{{asset('public/css/custom.css')}}" rel="stylesheet"> <!------ Include the above in your HEAD tag ----------> <style type="text/css"> body{
width:100%!important;
font-size:12px;
font-family: "Helvetica Neue",Helvetica,Arial,sans-serif!important;
}
*{
 font-family: "Helvetica Neue",Helvetica,Arial,sans-serif!important;
}
.container{
  width: 700px;
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
 } </style> <?php
//$OrderController=new App\Http\Controllers\Admin\OrderController;
  
?><div class="container"><div class="outer_border"> <div class="row"> <div  class=" pull-left top_box   p-4"> <h 2 class="text_color1" style="font-size:30px">{{config('app.name')}}</h 2> {{$shop_address}} 
   Phone : {{$admin_mobile}}
   Email : {{$admin_email}}
   Website : {{config('app.url')}} </div> 
</div></div>

?>
