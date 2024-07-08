<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment_details extends Model
{
	use HasFactory;

	protected $table = 'appointment_details';

	protected $fillable=[
		'patient_id',
		'referer_id',
		'modality_id',
		'appointment_status',
		'comments',
		'appointment_date'];

	public function patient()
    	{
        return $this->hasOne(Patients::class,'id', 'patient_id');
	}

	 public function referer()
    {
        return $this->hasOne(Referer_details::class,'id', 'referer_id');
	 }

	 public function modality()
    {
        return $this->hasOne(Scanning_details::class,'id', 'modality_id');
    }
	
}
