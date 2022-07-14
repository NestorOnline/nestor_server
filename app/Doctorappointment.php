<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctorappointment extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'email',
        'symptoms',
        'user_id',
        'mobile',
        'file_attechment',
        'patient_detail_id',
        'doctor_type', 'doctor_appointment_schedule_at', 'doctorappointment_id', 'user_id', 'schedule_date', 'schedule_time',
    ];
    protected $dates = ['doctor_appointment_schedule_at', 'schedule_date'];

    public function chemist()
    {
        return $this->belongsTo(Chemist::class, 'user_id', 'user_id');
    }

    public function doctor_prescription_products()
    {
        return $this->hasMany('\App\DoctorPrescriptionProduct', 'doctorappointment_id');
    }

}