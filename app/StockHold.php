<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockHold extends Model
{
   protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'User_Id',
        'Product_Code',
        'Hold_Qty',
        'Office_Code'
    ];
}
