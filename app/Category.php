<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $hidden = ['created_at', 'updated_at'];
   protected $fillable = [
        'name'
    ];
   public function group(){
    return $this->belongsTo('\App\Group','group_id');
}
public function medicine_category(){
            return $this->hasMany('\App\Medicine', 'category_id');
        }

  public function products(){
            return $this->hasMany('\App\Product', 'category_id');
        }
        
        public function group_products($group_id){
            return $this->hasMany('\App\Product', 'category_id')->where('group_id','=',$group_id);
        }
        
         public function groupcategory_products($groupcategory_id){
            return $this->hasMany('\App\Product', 'category_id')->where('groupcategory_id','=',$groupcategory_id);
        }
}