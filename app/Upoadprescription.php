<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upoadprescription extends Model
{
   protected $fillable = [
      'upload_prescription',
      'add_medicine',
      'get_call',
      'user_id'
    ];
      public function user(){
    return $this->belongsTo('\App\User','user_id');
}
}
