<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    protected $hidden = ['updated_at', 'created_at'];
    protected $fillable = [
        'user_id',
        'Patient_Name',
        'Patient_Age',
        'Sex',
        'Mobile_No',
        'Food_Allergies',
        'Tendency_Bleed',
        'Heart_Disease',
        'High_Blood_Pressure',
        'Diabetic',
        'Surgery',
        'Accident',
        'Others',
        'Family_Medical_History',
        'Current_Medication',
        'Female_Pregnancy',
        'Breast_Feeding', 'doctorappointment_id',
    ];
}