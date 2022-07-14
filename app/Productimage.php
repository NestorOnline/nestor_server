<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productimage extends Model
{
   protected $hidden = ['created_at', 'updated_at'];
      protected $fillable = [
            'Product_Code', 
            'PhotoFile_Name', 
            'Display_Sequence',
            'provided_by',
            'image_type'
    ];
}
