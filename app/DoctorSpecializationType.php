<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorSpecializationType extends Model
{
    protected $fillable = [
        'Doctor_Type',
        'Specialization_Type_Name',
        'icon_image',
    ];

    public function doctor_specializations()
    {
        return $this->hasMany(DoctorSpecialization::class, 'Specialization_Type', 'id');
    }
}