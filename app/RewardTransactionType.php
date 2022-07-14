<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardTransactionType extends Model
{
     protected $fillable = [
         'RewardTransactionType_Code',
'RewardTransactionType_Name',
'Remark'
    ];
}
