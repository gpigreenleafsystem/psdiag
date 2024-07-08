<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investigation_details extends Model
{
	use HasFactory;
	protected $table = 'investigation_details';

	protected $fillable = [
		'id',
		'modality_id',
		'study',
		'qty',
		'rate',
		'amount',
		'discount',
		'report_status',
		'scanning_status',
		'created_at',
		'updated_at',
	];
}
