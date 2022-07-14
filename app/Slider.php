<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'image', 'title', 'url_link', 'slider_type', 'group_id', 'groupcategory_id', 'mobile_image', 'brand_id', 'product_id',
    ];
}