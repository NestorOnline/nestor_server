<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
     protected $fillable=[            
            'name',
            'description',
            'image',
            'valid_till',
            'eligibility',
            'how_you_get',
            'cancellation_condition', 
            'code'          
        ];
protected $dates = ['valid_till'];
}
