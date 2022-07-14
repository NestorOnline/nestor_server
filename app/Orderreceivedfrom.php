<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderreceivedfrom extends Model
{
    protected $fillable = [
        'OrderReceivedFrom_Code', 'OrderReceivedFrom_Name',
    ];
}