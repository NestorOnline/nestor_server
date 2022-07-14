<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $hidden = ['created_at', 'updated_at','user_id'];
    protected $fillable = [
                'Contact_Person',
                'Address1',
                'Address2',
                'Address3',
                'City_Code',
                'State_Code',
                'PIN',
                'Mobile_No',
                'user_id', 
                'address_type', 
                'set_as_a_default',
        'set_as_a_current'
    ];
      public function city(){
            return $this->belongsTo('\App\City', 'City_Code');
        }
          public function state(){
            return $this->belongsTo('\App\State', 'State_Code');
        }
}
