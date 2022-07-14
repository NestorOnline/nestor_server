<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'ProductBrand_Code',
        'ProductBrand_Name'
    ];

     public function group_categories()
    {
        return $this->hasMany(Groupcategory::class, 'brand_id', 'ProductBrand_Code');
    }
}
