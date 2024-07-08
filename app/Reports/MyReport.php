<?php
namespace App\Reports;

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    // By adding above statement, you have claim the friendship between two frameworks
    // As a result, this report will be able to accessed all databases of Laravel
    // There are no need to define the settings() function anymore
    // while you can do so if you have other datasources rather than those
    // defined in Laravel.
    

    function setup()
    {
        // Let say, you have "sale_database" is defined in Laravel's database settings.
        // Now you can use that database without any futher setitngs.
        $this->src("mysql")
       ->query("SELECT * FROM bill_details") // , appointment_details,patients_details where bill_details.appointment_id=appointment_details.id and appointment_details.patient_id=patients_details.id")
       ->pipe($this->dataStore("bill_details"));


	$this->src("mysql")
      ->query("SELECT * FROM appointment_details")
	->pipe($this->dataStore("appointment_details"));

	$this->src("mysql")
      ->query("SELECT * FROM patients_details")
        ->pipe($this->dataStore("patients_details"));
    }
}
