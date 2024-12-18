<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
	use HasFactory;
	protected $table = 'patients_details';

	protected $fillable = [
		'name',
		'age',
		'mobileno',
		'address',
		'alt_phoneno',
		'visit_no',
		'patienttype',
	];
}
