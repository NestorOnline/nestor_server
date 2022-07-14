<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSetting extends Model
{
      protected $fillable=[            
            'MinimumOrderValueForChemist','MinimumOrderValueForCustomer','update_by'      
        ];
}
