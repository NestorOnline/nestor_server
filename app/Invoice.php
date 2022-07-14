<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
   protected $hidden = ['created_at', 'updated_at'];
   protected $fillable = [
             'user_role',
             'user_id',
             'order_id',
             'name',
             'address',
             'alternate_mobile',
             'pincode',
             'city',
             'state',
             'taxable_amount',
             'tax_amount',
             'discount',
             'delivery_amount',
             'grand_total_invoice',
             'wallet',
    ];
}
