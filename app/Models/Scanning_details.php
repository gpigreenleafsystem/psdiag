<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scanning_details extends Model
{
	use HasFactory;
	protected $table = 'scanning_details';

	protected $fillable=[
		'modality',
		'description',
		'cost',
		'ref_amount',

	];
}
