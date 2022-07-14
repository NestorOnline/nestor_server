<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
            'location',
            'office_code',
            'office_name',
            'address1',
            'address2',
            'city',
            'state',
            'pincode',
            'gst',
    ];
}
