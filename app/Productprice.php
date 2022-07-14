<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productprice extends Model
{
    protected $hidden = ['updated_at', 'created_at', 'Effective_From', 'Effective_To'];
    protected $fillable = [
        'Product_Code', 'product_id', 'ProductPriceType_Code', 'Price', 'GST', 'Effective_From', 'Effective_To',
    ];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_code')->where('ProductPriceType_Code', '=', '9')->where('Price', '>=', $min_price)->where('Price', '<=', $max_price)->first();
    }

}