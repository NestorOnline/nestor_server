<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addtocard extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'user_id'];
    protected $fillable = [
        'user_id',
        'product_id',
        'Qty',
        'amount',
        'doctor_description_id',
    ];

    public function product()
    {
        return $this->belongsTo('\App\Product', 'product_id', 'id');
    }
}