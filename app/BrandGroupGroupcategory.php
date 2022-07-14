<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandGroupGroupcategory extends Model
{
    protected $fillable = [
        'group_id',
        'group_category_id',
        'group_category_code',
        'ProductBrand_Code',
    ];
}