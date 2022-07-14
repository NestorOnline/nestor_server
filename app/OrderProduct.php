<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'Order_Id',
        'product_id',
        'Order_Code',
        'Product_Code',
        'SR_No',
        'Order_Qty',
        'Scheme_Discount',
        'Free_Qty',
        'MRP',
        'Rate',
        'Taxable',
        'TaxRate',
        'Discount',
        'Amount',
        'Tax',
        'Total',
        'DoctorConsult_id',
    ];

    public function product_category()
    {
        return $this->hasMany('\App\Product', 'groupcategory_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}