<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
      'Office_Code',
      'Product_Code',
      'Batch_No',
      'MRP',
      'EXP_Date',
      'Stock',
      'Ordered_Qty',
      'QtyForNewOrder',
      'Hold_Qty'
    ];
}
