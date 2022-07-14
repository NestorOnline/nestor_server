<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'PaymentRequest_Code',
        'PaymentRequest_Time',
        'PaymentGateway_Code',
        'Party_Code',
        'Order_Code',
        'Requested_Amount',
        'Channel_Id',
        'CheckSumHash',
        'Mobile_No',
        'Email',
        'Industry_Type_Id',
        'Callback_URL',
        'ResponseTransID',
        'BankTransID',
        'Received_Amount',
        'TransStatus',
        'Response_Code',
        'Response_ID',
        'TransactionTime',
        'GatewayName',
        'BankName',
        'PaymentMode',
        'CheckSumHashResponse',
        'BIN_Number',
        'Card_Last_Nums',
        'PaymentReceipt_Code',
        'Updated_Date',
        'User_ID',
        'DoctorConsult_id',
        'Wallet_Amount',
        'COMMISSION',
        'PAYOUT_DATE',
        'SETTLED_DATE',
        'SETTLEDAMOUNT',
        'UTR',
        'SETTLED_ORDERID',
        'GST',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User', 'User_ID');
    }
}