<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockNotification extends Model
{
     protected $hidden = ['created_at','updated_at'];
      protected $fillable = [
    'Product_Code','email',
    ];
}