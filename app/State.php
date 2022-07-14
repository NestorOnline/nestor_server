<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
  protected $hidden = ['created_at', 'updated_at'];
      protected $fillable = [
       'id','name','state_code','country_code'
    ];
    
             public function cities() {
        return $this->hasMany('\App\City', 'state_id')->orderBy('name','ASC');
    }

                public function serviceable_pincode() {
        return $this->hasMany('\App\Pincode', 'state_id')->where('Serviceable','=',1);
    }

                    public function nonserviceable_pincode() {
        return $this->hasMany('\App\Pincode', 'state_id')->where('Serviceable','=',0);
    }
}
