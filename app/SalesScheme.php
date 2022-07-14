<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesScheme extends Model
{
  protected $fillable = [
       'SalesScheme_Code',
      'SalesScheme_Name',
      'Category_Code',
      'SchemeOn_Code',
      'Product_Code',
      'SchemeOn',
      'DiscountType_Code',
      'Discount',
      'NextMinSaleQty_ForScheme',
      'Free_Qty',
      'Effective_From',
      'Effective_To',
      'Office_Code',
      'Image'
    ];

      protected $dates = [
      'Effective_From',
      'Effective_To'
    ];
}
