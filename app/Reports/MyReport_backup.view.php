<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\datagrid\DataTables;
?>
<html>
    <head>
    <title>My Report</title>
    </head>
    <body>
<?php
	$join = $this->dataStore("bill_details")->join($this->dataStore("appointment_details"),array("appointment_id"=>"id"));
        Table::create([
		"dataSource"=>$this->dataStore($join),
		"cssClass"=>array(
			"table"=>"table table-striped table-bordered",
			

		),
	/*	"showFooter"=>"bottom",
		"columns"=>array(
            "netamount"=>array(
                "footer"=>"sum"
	    ),),*/
		"paging"=>array(
            "pageSize"=>1,
            "pageIndex"=>0,
            "align"=>"center"
        )
	]);

/*	\koolreport\datagrid\DataTables::create(array(
        "dataSource"=>$this->dataStore($join),
        "options"=>array(
            "order"=>array(
                array(1,"asc")
            )
        )
));*/
        ?>
    </body>
</html>

