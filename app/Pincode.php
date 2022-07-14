<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'office_code','pincode','Serviceable','state_id','city_id',
    ];
    
       public function city(){
    return $this->belongsTo('\App\City','city_id');
   }
   
      public function state(){
    return $this->belongsTo('\App\State','state_id');
   }
}
