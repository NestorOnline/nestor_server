<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class AddToCardController extends Controller
{
    
    
         public function change_qty(Request $request)
    {
                 
                $value = request()->cookie('add_cart');
                $product = json_decode($value);               
               
                        foreach($product as $key=>$prod){
                             $subtotal =0;
                            if($key==$request->key_value) {
                                    $prod->Qty = $request->Qty;
                           $subtotal = $request->Qty*$prod->amount;
                           $card_product= \App\Product::find($request->product_id);                          
                           $abcd = "<div class='product-details delete_mem".$key."'>
                                        <div class='product-itemdetails row' valign='middle' id='itemid-922086'>
                                            <div class='leftside-icons col-md-2 p-0'>
                                                <a class='product-item-photo' title='".$card_product->brand_name."'>
                                                    <img src='http://nestor_update.testing/".$card_product->image."' alt='' class='pro-img'>
                                                </a>
                                            </div>
                                            <div class='rightside-details col pr-0'>
                                                <div class='row m-0'>
                                                    <div class='product-item-name col pl-0'>
                                                        <a href='".$card_product->brand_name."'></a>
                                                    </div>
                                                    <div class='item-prices col-2 p-0 text-right'>
                                                        <div class='discount-val'><span id='row_itmdiscprice_922086'>Rs.".$subtotal."</span></div>
                                                    </div>
                                                </div>
                                                <div class='row m-0 mt-3'>
                                                    <div class='catag-name col pl-0'>
                                                        <p class='form m-0'>Mfr: Nestor Pharmaceuticals Limited</p>
                                                        <p class='form m-0'>Unit Price : Rs. ".$card_product->actual_amount."/-</p>
                                                    </div>
                                                    <div class='item-qty col-3 p-0'>
                                                        <div>
                                                            <div class='form-group align-select m-0'>
                                                                <h5>QTY:- </h5>
                                                                <div class='qty-div'>
                                                                    <span class='qty_minus' data-id='".$key."' onclick='quantity".$key."_change_minus()'>-</span>
                                                                    <input type='number' required='' name='Qty' class='qty_".$key."' min='1' max='10' onchange='quantity".$key."_change()' value='".$prod->Qty."'  id='quantity_id".$key."'>
                                                                    <span class='qty_plus' data-id='".$key."' onclick='quantity".$key."_change_plus()'>+</span>
                                                                </div>
                                                                 <input type='hidden' id='product_id".$key."' value='".$card_product->id."'>
                                                                <input type='hidden' id='price_amount".$key."' value='".$card_product->actual_amount."'>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='deliveryby row m-0 mt-2'>
                                                    <div class='date deldate col pl-0'>
                                                        <div class='deliveryby'> Delivery between Oct 22nd-24th </div>
                                                    </div>
                                                    <div class='remove-drug col-2 p-0 text-right'>                                                      
                                                        <input type='hidden' id='sub_total".$key."' class='form-control' name='total_amt' value='".$subtotal."'>  
                                                        <button  type='button' onclick='remove".$key."_function()' class='removeitem".$key."' value='".$key."' title='Remove item'>Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> ";
                            }
                             $product1[]= $prod;
                        }
                $array_json=json_encode($product1);
                $cookie = cookie('add_cart',$array_json, 120);
                return response($abcd)->cookie($cookie);
            //     $response->cookie('add_cart',$array_json1, 120);
            //     return $response;
            //    return response(redirect()->route('frontend.single_product_detail',$request->product_id))->cookie($cookie);
    
   }
    
              public function add_cart(Request $request)
    {
                  
                $value = request()->cookie('add_cart');
                $product = json_decode($value);
                
                $xyz = 0 ;
                if($value){
                foreach($product as $pro){
                if($pro->product_id==$request->product_id){
                        $pro->Qty = $pro->Qty + $request->Qty; 
                    $xyz = 1 ; 
                    }
                    $product1[]= $pro;
                }
                }
     
                if($xyz==1){
                   
                }else{
                 $req_arr_je = json_encode($request->all());
                $product1[]= json_decode($req_arr_je);;    
                }

               
                $bcd="";

                $grand_total =0;
                        foreach($product1 as $prod){
                           $grand_total = $grand_total + $prod->Qty*$prod->amount;
                           $card_product= \App\Product::find($prod->product_id);
                           
                           $bcd .= "<div class='cart-list-drop'>
                                    <div class='drop-img'>
                                        <img src='http://nestor_update.testing/".$card_product->image."' alt='' class='w-100'>
                                    </div>
                            <div class='drop-des'>
                                <p class='drop-p-name'><a href='cart.php'>".$card_product->generic_name." ".$card_product->brand_name."</a></p>
                                <p class='drop-p-des'>product description</p>
                                <p class='drop-pri'><em class='fa fa-inr'></em>".$prod->amount." <span>Qty: ".$prod->Qty."</span></p>
                            </div>
                        </div>";
                        }
                        
                $abcd ="<a href='http://nestor_update.testing/frontend/cart'>
                            <div class='text'> 
                        <span class='counter-number' id='counter-number'>".count($product1)."</span> 
                    </div>
                    </a>
                    <div class='cart-dropdown'>
                    <div>".$bcd."<div class='pl-3 pr-3'>
                            <div class='totalamt'>
                            <span class='float-left'>TOTAL AMOUNT</span><span class='save-price'><b>Rs.".$grand_total."</b></span>
                            </div>
                        </div>
                        <p class='drop-p-name mt-0 m-3'>
                            <a href='http://nestor_update.testing/frontend/cart' class='add-to-cart'>View Cart</a>
                        </p>
                    </div>
                </div>";
                $array_json=json_encode($product1);
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
     $xyx =0; 
     $abcd ="<div class='text'> 
                        <span class='counter-number' id='counter-number'>".$xyx."</span> 
                    </div>";
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
