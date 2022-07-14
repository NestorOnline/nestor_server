<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHashTagDetail extends Model
{
    protected $hidden = ['updated_at', 'created_at'];
    protected $fillable = [
        'ProductHashtag_Code', 'Product_Code',
    ];

}