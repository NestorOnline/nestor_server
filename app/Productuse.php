<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productuse extends Model
{
    protected $fillable = [
        'ProductUse_Code','ProductUse_Name','Status_code'
    ];

        public function products() {
        return $this->hasMany(Product::class,'ProductUse_Code','ProductUse_Code');
    }
}