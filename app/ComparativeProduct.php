<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComparativeProduct extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'manufacturer',
        'product_code',
        'product_name',
        'price',
        'b2c_price',
        'product_id',
    ];
    public function manufacturer_single()
    {
        return $this->belongsTo(Manufacture::class, 'manufacturer');
    }

}