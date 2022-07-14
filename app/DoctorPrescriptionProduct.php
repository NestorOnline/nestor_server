<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorPrescriptionProduct extends Model
{
    protected $fillable = [
        'patient_detail_id',
        'order_id',
        'doctor_id',
        'chemist_user_id',
        'product_code',
        'product_id',
        'doses_id',
        'taken_id',
        'qty',
        'price_per_qty',
        'doctorappointment_id',
        'no_of_day',
        'user_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function doctor_prescription_abbreviation_doses()
    {
        return $this->belongsTo(DoctorPrescriptionAbbreviations::class, 'doses_id');
    }

    public function doctor_prescription_abbreviation_takes()
    {
        return $this->belongsTo(DoctorPrescriptionAbbreviations::class, 'taken_id');
    }

}