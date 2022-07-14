<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chemist extends Model
{
    protected $fillable = [
        'Party_Name',
        'Mobile_No',
        'user_id',
        'Contact_Person',
        'DL_No',
        'DL_No_21',
        'DL_File',
        'DL_File_21',
        'GSTIN',
        'Email_ID',
        'Address1',
        'Address2',
        'Address3',
        'City_Code',
        'State_Code',
        'PIN',
        'Geolocation',
        'PartyType_Code',
        'Party_Code',
        'Location_Code',
        'Area_Code',
        'Geolocation',
        'Status',
        'ApprovalSatus_Code',
        'is_update',
        'admin_approval',
        'DL_Valid_From',
        'DL_Valid_From_21',
        'Referral_Code'
    ];
    protected $dates = ['DL_Valid_From', 'DL_Valid_From_21'];

    public function addresses()
    {
        return $this->hasMany('\App\Address', 'user_id', 'user_id');
    }

    public function city()
    {
        return $this->belongsTo('\App\City', 'City_Code');
    }

    public function state()
    {
        return $this->belongsTo('\App\State', 'State_Code');
    }
}