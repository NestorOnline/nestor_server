<?php

namespace App\Imports;

use App\Productprice;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductpricesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Productprice([
            'Product_Code'=>$row[0], 
            'ProductPriceType_Code'=>$row[1], 
            'Price'=>$row[2], 
            'GST'=>$row[3],
            'Effective_From'=>$row[4],
            'Effective_To'=>$row[5],
        ]);
    }
}
