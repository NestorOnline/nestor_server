<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
   protected $fillable = [
             'product_code', 
             'description_type_code', 
             'sr_no', 
             'heading', 
             'description',
    ];

    public function description_type()
    {
        return $this->belongsTo('\App\Descriptiontype', 'description_type_code');
    }

}
