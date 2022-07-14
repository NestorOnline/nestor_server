<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGroupCategories extends Model
{
    protected $hidden = ['updated_at', 'created_at'];
    protected $fillable = [
        'groupcategory_id', 'Product_Code',
    ];
}