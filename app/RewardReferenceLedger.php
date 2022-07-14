<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardReferenceLedger extends Model
{
        protected $fillable = [
'Reference',
'Date_Time',
'Debit',
'Credit',
'Balance',
'user_id',
    ];

    protected $dates = ['Date_Time'];
}
