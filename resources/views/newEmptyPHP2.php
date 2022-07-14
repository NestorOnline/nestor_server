<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class AddToCardController extends Controller
{
              public function add_cart(Request $request)
    {
                  
                $value = request()->cookie('add_cart');
                $product = json_decode($value);
                $product[]= $request->all();
           $bcd="";
           $grand_total =0;
           
                        foreach($product as $prod){                            
                           $grand_total = $grand_total + $prod['amount'];
                           $my_product =\App\Product::find($prod['product_id']);
                           $bcd.= "<div class='cart-list-drop'>
                                    <div class='drop-img'>
                                        <img src='http://nestor_update.testing/".$my_product->image."' alt='' class='w-100'>
                                    </div>
                            <div class='drop-des'>
                                <p class='drop-p-name'><a href='cart.php'>Product heading </a></p>
                                <p class='drop-p-des'>product description</p>
                                <p class='drop-pri'><em class='fa fa-inr'></em>".$my_product->image." <span>Qty: 3</span></p>
                            </div>
                        </div>";
                        }
                        
                $abcd ="<a href='http://nestor_update.testing/frontend/cart'>
                            <div class='text'> 
                        <span class='counter-number' id='counter-number'>".count($product)."</span> 
                    </div>
                    </a>
                    <div class='cart-dropdown'>
                    <div>".$bcd."<div class='pl-3 pr-3'>
                            <div class='totalamt'>
                            <span class='float-left'>TOTAL AMOUNT</span><span class='save-price'><b>Rs.".$grand_total."</b></span>
                            </div>
                        </div>
                        <p class='drop-p-name mt-0 m-3'>
                            <a href='cart.php' class='add-to-cart'>View Cart</a>
                        </p>
                    </div>
                </div>";
                $array_json=json_encode($product);
                $cookie = cookie('add_cart',$array_json, 120);
                return response($abcd)->cookie($cookie);
            //     $response->cookie('add_cart',$array_json1, 120);
            //     return $response;
            //    return response(redirect()->route('frontend.single_product_detail',$request->product_id))->cookie($cookie);
    
   }
                 public function remove_cart(Request $request)
    {
                $value = request()->cookie('add_cart');
                $products = json_decode($value);
    if(count($products)==1){        
   $cookie = Cookie::forget('add_cart');
     $abcd =0; 
      return response($abcd)->cookie($cookie);
    }else{
            foreach ($products as $key =>$product) {                
            if($key==$request->remove_key) {
                unset($product);
            }else{
            $product1[]=$product;  
            }
        }

                $abcd ="<div class='text'> 
                        <span class='counter-number' id='counter-number'>".count($product1)."</span> 
                    </div>";
                $array_json=json_encode($product1);
                $cookie = cookie('add_cart',$array_json, 120);
                return response($abcd)->cookie($cookie);
            //     $response->cookie('add_cart',$array_json1, 120);
            //     return $response;
            //    return response(redirect()->route('frontend.single_product_detail',$request->product_id))->cookie($cookie);
    
   }
   
}
}
