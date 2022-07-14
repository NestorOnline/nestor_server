<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $hidden = ['updated_at', 'package_id', 'category_id', 'product_code', 'composition', 'storage', 'url_name'];

    protected $fillable = [
        'url_name',
        'generic_name',
        'brand_name',
        'composition',
        'package_id',
        'product_code',
        'HSN_code',
        'OrderQtyMultipleOf_Chemist',
        'OrderQtyMultipleOf_Customer',
        'manufacture',
        'storage',
        'image',
        'mrp_amount',
        'offer',
        'group_id',
        'category_id',
        'groupcategory_id',
        'actual_amount',
        'best_before_date',
        'is_display_expiry',
        'go_live',
        'ProductUse_Code',
        'Prescription_Required',
        'ProductBrand_Code',
        'best_before_date',
    ];
    protected $dates = ['best_before_date'];

    public function productprices()
    {
        return $this->hasMany(Productprice::class, 'Product_Code', 'product_code');
    }

    public function productimages()
    {
        return $this->hasMany(Productimage::class, 'Product_Code', 'product_code');
    }
    public function customer_price()
    {
        return $this->hasOne(Productprice::class, 'Product_Code', 'product_code')->where('ProductPriceType_Code', '=', '9');
    }
    public function customer_mrp_price()
    {
        return $this->hasOne(Productprice::class, 'Product_Code', 'product_code')->where('ProductPriceType_Code', '=', '10');
    }
    public function chemist_price()
    {
        return $this->hasOne(Productprice::class, 'Product_Code', 'product_code')->where('ProductPriceType_Code', '=', '7');
    }
    public function mrp_price()
    {
        return $this->hasOne(Productprice::class, 'Product_Code', 'product_code')->where('ProductPriceType_Code', '=', '8');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function group_category()
    {
        return $this->belongsTo(Groupcategory::class, 'groupcategory_id');
    }

    public function sales_schame()
    {
        return $this->hasOne(SalesScheme::class, 'Product_Code', 'product_code')->where('schemefor',1);
    }
    public function sales_schame_customer()
    {
        return $this->hasOne(SalesScheme::class, 'Product_Code', 'product_code')->where('schemefor',2);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'Product_Code', 'product_code');
    }

    public function stock_by_office_product()
    {
        return $this->hasMany(Stock::class, 'Product_Code', 'product_code');
    }

    public function stock_by_office($office_code)
    {
        return $this->stock_by_office_product()->where('Office_Code', '=', $office_code)->first();
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function comparative_products()
    {
        return $this->hasMany(ComparativeProduct::class, 'product_code', 'product_code');
    }

    public function get_addtocart_item()
    {
        return $this->hasOne(Addtocard::class, 'product_id', 'id')->where('user_id', \Auth::user()->id);
    }

    public function get_addtocart_item_guest($id)
    {
        $value = request()->cookie('add_cart');
        $check_add_to_cart_datas = json_decode($value);
        if ($check_add_to_cart_datas) {
            foreach ($check_add_to_cart_datas as $check_add_to_cart_data) {

                if ($check_add_to_cart_data->product_id == "" . $id . "") {

                    return $check_add_to_cart_data->Qty;
                }
            }
        } else {
            return null;
        }

    }
}