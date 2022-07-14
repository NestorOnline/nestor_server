<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoiceproduct extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
             'invoice_id',
             'order_id',
             'product_code',
             'Scheme_Code',
             'Order_Qty',
             'Rate',
             'Subtotal',
             'Discount',
    ];
}
