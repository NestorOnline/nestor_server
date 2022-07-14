<?php

namespace App\Imports;

use App\Stock;
use Maatwebsite\Excel\Concerns\ToModel;

class StocksImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Stock([
            'Office_Code'=>$row[0], 
            'Product_Code'=>$row[1], 
            'Batch_No'=>$row[2], 
            'MRP'=>$row[3], 
            'EXP_Date'=>$row[4], 
            'Stock'=>$row[5], 
        ]);
    }
}
