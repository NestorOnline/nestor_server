<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorPrescriptionAbbreviations extends Model
{
    protected $fillable = [
        'abbreviation_code',
        'description',
        'prescription_type',
        'quantity_in_a_day',
        'per_time_taken',
    ];

}