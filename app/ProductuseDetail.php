<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductuseDetail extends Model
{
    protected $fillable = [
        'Product_Code', 'ProductUse_Code',
    ];
}