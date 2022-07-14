<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'user_id'];
    protected $fillable = [
        'Order_No',
        'Order_Code',
        'Order_Date',
        'Party_Code',
        'GSTIN',
        'user_role',
        'user_id',
        'Party_Name',
        'Address1',
        'Address2',
        'Address3',
        'Mobile_No',
        'PIN',
        'City_Code',
        'State_Code',
        'Product_Amount',
        'Discount_Amount',
        'Taxable_Amount',
        'Tax_Amount',
        'Delivery_Amount',
        'Grand_Total',
        'WalletAmount',
        'Payment_Status',
        'Payment_Amount',
        'Product_Amount',
        'Return_Amount',
        'OrderStatus_Code',
        'UpdatedBy',
        'Updated_Date',
        'is_update',
        'ProcessingOn',
        'PackedOn',
        'DispatchedOn',
        'DeliveredOn',
        'OrderFrom_Code',
        'Office_Code',
        'DoctorConsult_id',
        'petient_id',
        'DL_No',
        'Contact_Person',
        'Tracking_ID',
        'Transport_ID',
        'Account_ID',
        'Invoice_Code',
        'Invoice_No',
        'Invoice_Date',
        'Invoice_Amount',
        'doctorappointment_id',
    ];

    protected $dates = ['ProcessingOn', 'PackedOn', 'DispatchedOn', 'DeliveredOn', 'CancelOn', 'Invoice_Date'];
    public function orderproducts()
    {
        return $this->hasMany('\App\OrderProduct', 'Order_Id');
    }

    public function payment_detail()
    {
        return $this->hasOne('\App\Payment', 'Order_ID');
    }

    public function orderreceivedfroms()
    {
        return $this->belongsTo('\App\Orderreceivedfrom', 'OrderFrom_Code');
    }
    public function cities()
    {
        return $this->belongsTo('\App\City', 'City_Code');
    }
    public function states()
    {
        return $this->belongsTo('\App\State', 'State_Code');
    }

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }

    public function order_status()
    {
        return $this->belongsTo('\App\OrderStatus', 'OrderStatus_Code');
    }
}