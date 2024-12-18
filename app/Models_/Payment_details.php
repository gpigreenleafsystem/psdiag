<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_details extends Model
{
	use HasFactory;
	protected $table = 'payment_details';

	protected $fillable = [
		'payment_type',
		'payment_mode',
		'remarks',
		'net_amount',
		'paid_amount',
		'remaining_amount',
		'part_payment_id',
		
	];
}
