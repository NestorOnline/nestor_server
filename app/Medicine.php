<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
   protected $fillable = [            
            'generic_name',
            'brand_name',
            'group_id',
            'category_id',
            'subcategory_id',
            'product_code',
            'OrderQtyMultipleOf',
            'storage',
            'image',
            'mrp_amount',
            'offer',
            'manufacture',
            'composition',
            'actual_amount',
            'package_id',
        ];
}
