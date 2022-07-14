<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorConsult extends Model
{
    protected $fillable = [
        'upload_prescription',
        'Party_Code',
        'free_doctor_consult',
        'user_id',
        'order_id',
    ];
}