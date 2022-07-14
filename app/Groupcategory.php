<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupcategory extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'group_id', 'is_home', 'url_name'];
    protected $fillable = [
        'id', 'name', 'group_id', 'is_home', 'url_name', 'image', 'brand_id','sn','status'
    ];

    public function group()
    {
        return $this->belongsTo('\App\Group', 'group_id');
    }

    public function product()
    {
        return $this->hasMany('\App\Product', 'groupcategory_id');
    }

}