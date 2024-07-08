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
		'appointment_id',
		'required_investigations',
		'payment_ids',
	];	
	
}
