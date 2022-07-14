<?php

namespace App\Imports;

use App\Groupcategory;
use Maatwebsite\Excel\Concerns\ToModel;

class GroupcategorysImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Groupcategory([
            
            'group_id'=>$row[0], 
            'id'=>$row[1], 
            'name'=>$row[2], 
        ]);
    }
}
