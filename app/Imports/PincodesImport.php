<?php

namespace App\Imports;

use App\Pincode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PincodesImport implements ToCollection
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
                $pincode = \App\Pincode::where('pincode','=',$row[0])->first();
                if($pincode){
                    $pincode->city_id = $row[2];
                    $pincode->state_id = $row[1];
                    $pincode->save();
                }else{
                    $pincode = \App\Pincode::create([
                        'pincode'=>$row[0],
                        'city_id'=>$row[2],
                        'state_id'=>$row[1],
                    ]); 
                }
            }
            
        }         

      }
}
