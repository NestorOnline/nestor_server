<?php

namespace App\Exports;

use App\ServicePincode;
use Maatwebsite\Excel\Concerns\FromCollection;

class ServicePincodesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServicePincode::all();
    }
}
