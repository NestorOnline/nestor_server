<?php

namespace App\Imports;

use App\Productimage;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductimagesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Productimage([
            'Product_Code'=>$row[0], 
            'PhotoFile_Name'=>$row[1], 
            'Display_Sequence'=>$row[2],
            'provided_by'=>$row[3],
        ]);
    }
}
