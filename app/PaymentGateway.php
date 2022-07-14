<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'url_name'];
    protected $fillable = [
        'PaymentGateway_Code',
        'PaymentGateway_Name',
        'PaymentGateway_MKey',
        'PaymentGateway_MId',
        'PaymentGateway_MWebsite',
        'PaymentGateway_Channel',
        'PaymentGateway_IndustryType',
        'PaymentGateway_Callback_Url',
        'PaymentGateway_Mode',
        'is_active',
    ];
}