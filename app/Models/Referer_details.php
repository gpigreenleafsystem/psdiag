<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referer_details extends Model
{
	use HasFactory;
	protected $table = 'referer_details';

	protected $fillable = [	
		'referer_name',
		'referer_phno',
		'referer_amount',
		'referer_count',

	];
}
