<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;; 
use Validator;
use Hash;
use Illuminate\Http\Request;

class APIController extends Controller
{
   public $successStatus = 200; 
   
public function home_App()
    {   
         $main_sliders = \App\Slider::where('slider_type','=','home_page_main')->get();
         $shop_by_healthareas_groupcategories = \App\Groupcategory::whereIn('id',['34','28','29','32','43','26'])->get();   

         $deal_of_the_day_sliders = \App\Slider::where('slider_type','=','home_page_second_top')->get();       
         $hot_seller_products = \App\Product::all(); 
         $trending_today_products = \App\Product::all();         
         $shop_by_category_groups = \App\Group::get();
         

         $offers = \App\Offer::all();
            $a1['main_sliders'] = array("$main_sliders");
            $a1['shop_by_healthareas'] = array("$shop_by_healthareas_groupcategories");
            $a1['deal_of_the_day'] = array("$deal_of_the_day_sliders");
            $a1['hot_seller'] = array("$hot_seller_products");
            $a1['trending_today'] = array("$trending_today_products");
            $a1['shop_by_category'] = array("$shop_by_category_groups");
            echo json_encode($a1);
             return response()->json(['status'=>true,'message'=>'Your  Home Page API Work Successfully','data'=>$a1], $this-> successStatus); 
    }
/*            
            $list = Product::
leftJoin('categories as mainCategory','products.category_id','mainCategory.id')
->leftJoin('categories as subCategory','products.sub_category_id','subCategory.id')
->leftJoin('categories as additionalCategory','products.additional_category','additionalCategory.id')
->select(['products.*','mainCategory.name as mainCategoryName','subCategory.name as subCategoryName','additionalCategory.name as additionalCategoryName'])->get();
           $parents = Category::where('parent_id', 0)->get();
 
 
            return Group::with('Category')->get();
        $groups = \App\Group::all();           
        foreach ($groups as $group) {            
            $groupcategories = \App\Groupcategory::where('group_id',$group->id)->get();
            if (count($groupcategories) > 0) {
                $subCat = array();
                $players = array();
                $roster[$group->name] = $players;
                        foreach ($categories as $i=> $category) {                                                          
                                $subcategories = \App\Subcategory::where('category_id', $category->id)->get();
                            if (count($subcategories) > 0) {
                                $roster[$group->name][$category->name] = $subCat;
                                foreach ($subcategories as $subcategory) {
                                    $roster[$parent->name][$category->name][$subcategory->id] = $subchild->name;
                                }
                            }else{
                                $roster[$group->name][$category->name] = $players;  
                            }
                        }
            }
        }
         echo json_encode($roster);
 * 
 */   
        public function product_App()
    {      
         $order_history[] = null;        
         $trending_todays = \App\Product::all();
         $main_sliders = \App\Slider::where('slider_type','=','home_page_main')->get();         
         $deal_of_the_day_sliders = \App\Slider::where('slider_type','=','home_page_second_top')->get();
         $a1['main_slider'] = $main_sliders;
         $a1['deal_of_the_day'] = $deal_of_the_day_sliders;
         $a1['order_history'] = $order_history;
         $a1['trending_today'] = $trending_todays;
         return response()->json(['status'=>true,'message'=>'Your Chemist Home Page API Work Successfully','data'=>$a1], $this-> successStatus); 
    }
    
        public function aboutus_App(Request $request)
    {        
             $success['mobile'] =   '1234567890';
             $success['email'] =  'abc@gmail.com';
             return response()->json(['status'=>true,'message'=>'Your About Us API Work Successfully','data'=>$success], $this-> successStatus); 
       
    }
     
        public function terms_and_conditions_App(Request $request)
    {        
             $success =   'Nestor Pharmaceutical welcomes your interest in our company and your visit to our Website. The following conditions set forth the basic rules that govern to use of our Site.';
             return response()->json(['status'=>true,'message'=>'Your Terms And Conditions API Work Successfully','data'=>$success], $this-> successStatus); 
       
    }
     
        public function group_pages_App($id)
    { 
        $single_group = \App\Group::find($id); 
        $groups = \App\Group::with('groupcategories')->get();
        $products = \App\Product::where('group_id','=',$id)->get();
        $a1['group'] = array($groups);
        $a1['product'] = array($products);
        $a1['single_group'] = array($single_group);
        return response()->json(['status'=>true,'message'=>'Your Group Page API Work Successfully','data'=>$a1], $this-> successStatus);      
     }
          
        public function groupcategory_pages_App($id)
    {
        $groups = \App\Group::with('groupcategories')->get();
        $single_groupcategory = \App\Groupcategory::find($id);
        $single_group = \App\Group::find($single_groupcategory->group_id);         
        $products = \App\Product::where('groupcategory_id','=',$single_groupcategory->id)->get();
            $a1['group'] = array($groups);
            $a1['product'] = array($products);
            $a1['single_group'] = array($single_group);
            $a1['single_groupcategory'] = array($single_groupcategory);
            return response()->json(['status'=>true,'message'=>'Your Group Category Page API Work Successfully','data'=>$a1], $this-> successStatus);       
     }
     
               
        public function product_detail_App(Request $request)
        {
            $single_product = \App\Product::find($request->product_id);

            if($single_product){      
            $package = \App\Package::find($single_product->package_id);            
            if($package){
            $single_product->package_name = $package->name;
            }            
            $category = \App\Category::find($single_product->category_id);            
            if($category){
            $single_product->product_type = $category->name;
            }
            $single_product->offer = $single_product->offer."% Off";
            $single_product->image =["http://nestorpharma.in/".$single_product->image];
         $description1 = \App\Description::where('product_code','=',$product->product_code)->where('description_type_code','=','1')->get();
        $description2 = \App\Description::where('product_code','=',$product->product_code)->where('description_type_code','=','2')->get();
        $description3 = \App\Description::where('product_code','=',$product->product_code)->where('description_type_code','=','3')->get();
        $description4 = \App\Description::where('product_code','=',$product->product_code)->where('description_type_code','=','4')->get();
        $description5 = \App\Description::where('product_code','=',$product->product_code)->where('description_type_code','=','5')->get();
        $description6 = \App\Description::where('product_code','=',$product->product_code)->where('description_type_code','=','6')->get();
       $description7 = \App\Description::where('product_code','=',$product->product_code)->where('description_type_code','=','7')->get();

            $title1 = "Therapeutic Indications";
            $description1 = "The Product is recommended for use to treat the following";
            $title2 = "Precautions & Warnings";
            $description2 = "Please consult your doctor before consuming this medicine, in case of:\r\n"
                    . "Upper Respiratory Tract Infection\r\n"
                    . "Injection site reactions (pain, swelling, redness)\r\n"
                    . "Pneumonia\r\n"
                    . "Skin and Structure Infection\r\n"
                    . "Cystitis";
            $title3 = "Usage Directions";
            $description3 = "Follow the doctor’s advice strictly to take the medicine.:\r\n"
                    . "In case of over dose immediately contact to your doctor or nearest hospital.\r\n"
                    . "In case of over dose immediately contact to your doctor or nearest hospital.\r\n";
            $title4 = "Serious\r\n";
            $description4 = "The Product is recommended for use to treat the following\r\n";
            $title5 = "Indicated Side Effects\r\n";
            $description5 = "Rash"
                    . "Injection site reactions (pain, swelling, redness)\r\n"
                    . "Vomiting\r\n"
                    . "Allergic reaction\r\n"
                    . "Nausea";
            $title6 = "Interactions";
            $description6 = "Please inform your doctor if you have recently consumed or are consuming any of the below mention medicine:\r\n"
                    . "Diarrhea may occur as a side effect but should stop when your course is complete. Inform your doctor if it doesn't stop or if you find blood in your stools\r\n";
            $title7 = "Storage Condition";
            $description7 = "Ensure medicine is not within reach of the children.\r\n"
                    . "Store in a cool and dark area at room temperature of (30o C)\r\n"
                    . "Don’t consume this medicine if the date of expiry is over.";
          $single_product->description_data = [['title'=>$title1,'description'=>$description1],
              ['title'=>$title2,'description'=>$description2],
              ['title'=>$title3,'description'=>$description3],
              ['title'=>$title4,'description'=>$description4],
              ['title'=>$title5,'description'=>$description5],
              ['title'=>$title6,'description'=>$description6],
              ['title'=>$title7,'description'=>$description7]];
            $a1['product'] = $single_product;
             $related_products = \App\Product::where('groupcategory_id','=',$single_product->groupcategory_id)->whereNotIn('id', [$single_product->id])->select(['id','generic_name','brand_name','image','mrp_amount','chemist_amount','actual_amount','offer'])->get(); 
            if(count($related_products)){
            foreach($related_products as $related_product){
                     $related_product->image ="http://nestorpharma.in/".$related_product->image; 
                     $related_product->offer =$related_product->offer."% Off"; 
            }
             $a1['Similar_Products'] = array($related_product);
            }else{
             $a1['Similar_Products'] = array(null);   
            }
           
            return response()->json(['status'=>true,'message'=>'Data Fetch Successfully','data'=>array_merge($a1)], $this-> successStatus);                           
            }else{
            return response()->json(['status'=>false,'message'=>'Error Data Does Not Match. Please Try Again'], $this-> successStatus);   
            }
     }
     
     public function chemist_home_App(Request $request)
    {     
          $user = \App\User::where('role', '=','Chemist')->where('mobile', '=', $request->mobile)->where('status', '=','verify')->first();
          if($user){
         $order_history[] = null;        
         $trending_todays = \App\Product::all();
         $main_sliders = \App\Slider::where('slider_type','=','home_page_main')->select(['id','title','image'])->get();
         
         foreach($main_sliders as $main_slider){
          $main_slider->image ="http://nestorpharma.in/".$main_slider->image;    
         }
         $deal_of_the_day_sliders = \App\Slider::where('slider_type','=','home_page_second_top')->select(['id','title','image'])->get();
         $data1['type'] =  'Slider';
         $data1['data'] = $main_sliders;
         $data[]=$data1;
         
         $call['phoneNo'] ='8070605080706050';
         $call['message'] ='Call to Order Your Medicine';
         $data2['type'] =  'Call';
         $data2['data'] = $call;
         $data[]=$data2;
         
         $nestor_balance['amount'] =$user->wallet;
         $nestor_balance['message'] ='Availble in your Nestor Account';
         $data3['type'] =  'Nestor_Balance';
         $data3['data'] = $nestor_balance;
         $data[]=$data3;
         
         $nestor_balance['amount'] ='1000';
         $nestor_balance['message'] ='Availble in your Nestor Account';
         $data4['type'] =  'Deal_of_the_day';
         $data4['data'] = $deal_of_the_day_sliders;
         $data[]=$data4;
         
              $products = \App\Product::select(['id','generic_name','brand_name','image','mrp_amount','chemist_amount','actual_amount','offer'])->limit('3')->get(); 
            foreach($products as $product){
                     $product->image ="http://nestorpharma.in/".$product->image; 
                     $product->offer =$product->offer."% Off"; 
            }
         $data5['type'] =  'Order_History';
         $data5['data'] = $products;
         $data[]=$data5;
         
         $products = \App\Product::select(['id','generic_name','brand_name','image','mrp_amount','chemist_amount','actual_amount','offer'])->get();
            foreach($products as $product){
                     $product->image ="http://nestorpharma.in/".$product->image; 
                     $product->offer =$product->offer."% Off"; 
            }
         $data6['type'] =  'Trending_Today';
         $data6['data'] = $products;
         $data[]=$data6;
         
 //        $a1['deal_of_the_day'] = $deal_of_the_day_sliders;
//         $a1['order_history'] = $order_history;
 //        $a1['trending_today'] = $trending_todays;
         return response()->json(['status'=>true,'message'=>'Data Fetch Successfully','data'=>$data], $this-> successStatus); 
          }else{
            return response()->json(['status'=>false,'message'=>'Error Data Does Not Match. Please Try Again'], $this-> successStatus);   
            }
    }
    
        public function our_products_App()
    {             
         $products = \App\Product::select(['id','generic_name','brand_name','image','mrp_amount','chemist_amount','actual_amount','offer'])->get();
         foreach($products as $product){
         $product->image ="http://nestorpharma.in/".$product->image; 
          $product->offer =$product->offer."% Off";   
         }
         $a1 = $products;
         return response()->json(['status'=>true,'message'=>'Data Fetch Successfully','data'=>$a1], $this-> successStatus); 
    }
     
     
     
}
