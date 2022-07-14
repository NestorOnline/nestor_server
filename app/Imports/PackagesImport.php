<?php

namespace App\Imports;

use App\Package;
use Maatwebsite\Excel\Concerns\ToModel;

class PackagesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Package([
             'id'=>$row[0], 
             'name'=>$row[1], 
             'Primary_Packing'=>$row[2], 
             'PrimaryPack_Qty'=>$row[3],
             'Unit_Name'=>$row[4],
             'Packing_Description'=>$row[5],
        ]);
    }
}
