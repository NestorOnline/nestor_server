<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficeState extends Model
{
     protected $fillable=[            
            'Office_Code',
            'State_Code',         
        ];
          public function pincodes() {
        return $this->hasMany(Pincode::class,'state_id','State_Code');
    }
}
