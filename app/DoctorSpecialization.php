<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorSpecialization extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'Doctor_Type',
        'Specialization_Type',
        'Specialization_Name',
        'icon_image',
    ];
}