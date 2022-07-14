<?php

namespace App\Imports;

use App\State;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StatesImport implements ToCollection
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
                $state = \App\State::where('name','=',$row[2])->first();
                if($state){
                    $state->id = $row[0];
                    $state->state_code = $row[0];
                    $state->country_code = $row[1];
                    $state->save();
                }else{
                    $state = \App\State::create([
                        'id'=>$row[0],
                        'name'=>$row[2],
                        'state_code'=>$row[0],
                        'country_code'=>$row[1],
                    ]); 
                }
            }
        }
            
      }         

}

