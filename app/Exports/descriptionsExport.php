<?php

namespace App\Exports;

use App\Description;
use Maatwebsite\Excel\Concerns\FromCollection;

class descriptionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Description::all();
    }
}
