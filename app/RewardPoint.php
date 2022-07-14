<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardPoint extends Model
{

    protected $fillable = [
        'order_id',
        'user_id',
        'Order_No',
        'Order_Code',
        'Order_Date',
        'Tax_Amount',
        'Reward_Point',
    ];
}