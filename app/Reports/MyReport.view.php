<?php
use \koolreport\widgets\koolphp\Table;
?>
<html>
    <head>
    <title>My Report</title>
    </head>
    <body>
<?php
	$join = $this->dataStore("bill_details")->join($this->dataStore("appointment_details"),array("appointment_id"=>"id"));
        Table::create([
            "dataSource"=>$this->dataStore($join)
        ]);
        ?>
    </body>
</html>

