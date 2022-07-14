<?php

namespace App\Imports;

use App\Description;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class descriptionsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {    
       
        return new Description([
             'product_code'=>$row[0], 
             'description_type_code'=>$row[1], 
             'sr_no'=>$row[2], 
             'heading'=>$row[3], 
             'description'=>$row[4],
        ]);
    }
}
