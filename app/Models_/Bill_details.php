<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_details extends Model
{
	use HasFactory;
	protected $table = 'bill_details';

	protected $fillable=[
		'patient_phoneno',
		'bill_no',
		'appointment_id',
		'required_investigations',
		'payment_ids',
		'netamount',
		'bill_amount',
		'bill_discount',
		'paid_amount',
		'due_amount',
		'payment_mode',
		'payment_details',
		'amt_paid_date',
		'generated_by'
	];
public function appointment()
	{
		return $this->belongsTo(Appointment::class, 'appointment_id');
	}

	// Method to fetch bill number by appointment_id
	public static function getBillNumberByAppointmentId($appointment_id)
	{
		return self::where('appointment_id', $appointment_id)->value('id');
	}
	
}
