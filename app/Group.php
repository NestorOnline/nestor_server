<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'url_name'];
    protected $fillable = [
        'name', 'url_name', 'image',
    ];
    public function groupcategories()
    {
        return $this->hasMany('\App\Groupcategory', 'group_id')->orderBy('name','ASC');
    }

    public function brand_group_groupcategories()
    {
        return $this->hasMany('\App\BrandGroupGroupcategory', 'group_id');
    }

    public function product()
    {
        return $this->hasMany('\App\Product', 'group_id');
    }
}