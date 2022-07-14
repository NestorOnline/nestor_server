<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'ProductBrand_Code', 'ProductBrand_Name', 'url_name',
    ];
}