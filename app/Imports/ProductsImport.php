<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
             'product_code'=>$row[0], 
             'generic_name'=>$row[1], 
             'brand_name'=>$row[2], 
             'HSN_code'=>$row[3], 
             'category_id'=>$row[4], 
             'package_id'=>$row[5], 
             'group_id'=>$row[6], 
             'groupcategory_id'=>$row[7], 
             'OrderQtyMultipleOf_Chemist'=>$row[8], 
             'OrderQtyMultipleOf_Customer'=>$row[9],
             'is_display_expiry'=>$row[10], 
             'go_live'=>$row[11], 
        ]);
    }
}
