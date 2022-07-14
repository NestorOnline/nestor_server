<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userloginlog extends Model
{
     protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'user_id',
        'user_role',
        'login_date_time',
        'ip_address',
        'plateform',
        'referral',
        'location',
    ];
}
