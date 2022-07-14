<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  protected $hidden = ['created_at','updated_at'];
      protected $fillable = [
        'id','name','state_id','city_code','state_code','country_code'
    ];
}
