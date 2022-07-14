<?php

namespace App\Imports;

use App\ServicePincode;
use Maatwebsite\Excel\Concerns\ToModel;

class ServicePincodesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ServicePincode([
            //
        ]);
    }
}
