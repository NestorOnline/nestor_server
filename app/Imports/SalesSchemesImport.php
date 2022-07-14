<?php

namespace App\Imports;

use App\SalesScheme;
use Maatwebsite\Excel\Concerns\ToModel;

class SalesSchemesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SalesScheme([
            'SalesScheme_Code'=>$row[0], 
            'SalesScheme_Name'=>$row[1], 
            'Category_Code'=>$row[2], 
            'SchemeOn_Code'=>$row[3],
            'Product_Code'=>$row[4],
            'SchemeOn'=>$row[5],
            'DiscountType_Code'=>$row[6], 
            'Discount'=>$row[7], 
            'NextMinSaleQty_ForScheme'=>$row[8], 
            'Free_Qty'=>$row[9],
            'Effective_From'=>$row[10],
            'Effective_To'=>$row[11],
            'Office_Code'=>$row[12],
        ]);
    }
}
