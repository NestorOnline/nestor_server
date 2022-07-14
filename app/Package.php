<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $hidden = ['updated_at','created_at'];
   protected $fillable = [
        'id','name','Primary_Packing','PrimaryPack_Qty','Unit_Name','Packing_Description','TotalQtyInPacking'
    ];
}
