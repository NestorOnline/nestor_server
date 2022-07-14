<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardTransaction extends Model
{
       protected $fillable = [
        'Transaction_Date',
'RewardPointOf_Code',
'Reference_Code',
'RewardTransactionType_Code',
'Points',
'user_id',
    ]; //
}
