<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
       protected $fillable=[            
            'Location',
            'Office_Code',
            'Office_Name',
            'Address1',
            'Address2',
            'Address3',
            'City_Name', 
            'State_Name',
            'PIN', 
            'GSTIN'         
        ];
}
