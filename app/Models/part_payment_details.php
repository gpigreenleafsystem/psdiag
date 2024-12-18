<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class part_payment_details extends Model
{
	use HasFactory;
	protected $table = 'part_payment_details';

	protected $fillable=[
			'payment_type',
		'payment_mode',
		'bill_no',
		'payment_status',
		'partpayment_amount',
		'payment_details',
		'created_at',

	];
}
