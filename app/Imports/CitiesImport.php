<?php

namespace App\Imports;

use App\City;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CitiesImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $key=>$row) 
        {
            if($key > 0){
                $city = \App\City::where('name','=',$row[1])->first();
                if($city){
                    $city->id = $row[0];
                    $city->state_id = $row[2];
                    $city->city_code = $row[0];
                    $city->state_code = $row[2];
                    $city->country_code = $row[3];
                    $city->save();
                }else{
                    $city = \App\City::create([
                        'id'=>$row[0],
                        'state_id'=>$row[2],
                        'city_code'=>$row[0],
                        'state_code'=>$row[2],
                        'country_code'=>$row[3],
                        'name'=>$row[1],
                    ]); 
                }
            }
        }        
    }
}
