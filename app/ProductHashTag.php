<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHashTag extends Model
{
    protected $hidden = ['updated_at', 'created_at'];
    protected $fillable = [
        'ProductHashtag_Code', 'ProductHashtag_Name',
    ];
}