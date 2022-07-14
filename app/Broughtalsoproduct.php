<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Broughtalsoproduct extends Model
{
    protected $fillable = [
        'Prodoct_Code',
    'Link_Prodoct_Code',
    'link_group'
    ];
    

    public function product()
    {
        return $this->belongsTo(Product::class, 'Prodoct_Code','product_code');
    }
}
