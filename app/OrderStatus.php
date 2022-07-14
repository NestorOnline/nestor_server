<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
     protected $fillable=[
            'OrderStatus_Code',
            'OrderStatus_Name',          
        ];
}
