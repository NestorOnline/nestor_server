<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AddToCardController extends Controller
{

    public $successStatus = 200;

    public function change_qty(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $value = request()->cookie('add_cart');
        $product = json_decode($value);
        $date1 = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
        $date5 = date('Y-m-d', strtotime("+4 day", strtotime(date('Y-m-d'))));
        $period = date('M', strtotime($date1)) . " " . date('d', strtotime($date1)) . " " . "-" . date('M', strtotime($date5)) . " " . date('d', strtotime($date5));
        foreach ($product as $key => $prod) {
            $subtotal = 0;
            if ($prod->product_id == $request->key_value) {
                $prod->Qty = $request->Qty;
                $subtotal = $request->Qty * $prod->amount;
                $card_product = \App\Product::find($request->product_id);
                if ($card_product->Prescription_Required == '1') {
                    $precription = "<button class='tag-detail' style='background-color: #7bd9ba;color: white;display: inline-block;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 4px;
    margin-bottom: 10px;'>Rx</button>";
                } else {
                    $precription = "";
                }

                if ($card_product->package) {
                    $package_detail = "<span class='drug-varients ellipsis' style='white-space: nowrap;
  width: 220px;
  overflow: hidden;
  text-overflow: ellipsis;'>Packing:
" . $card_product->package->Packing_Description . "</span>";
                } else {
                    $package_detail = "";
                }

                $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $card_product->product_code)->first();
                $gst = "";
                $customer_mrp = "";
                if ($card_product->customer_price) {
                    $gst = "<input type='hidden' id='gst" . $prod->product_id . "' value='" . $card_product->customer_price->GST . "'>";
                }
                if ($card_product->customer_mrp_price) {
                    $customer_mrp = "<input type='hidden' id='mrp_product_price" . $prod->product_id . "' value='" . number_format($card_product->customer_mrp_price->Price, 2, '.', ',') . "'>";
                }
                if ($sales_scheme) {

                    $dividend = $prod->Qty;

                    $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                    $output = intdiv($dividend, $divisor);
                    $produc_qty = $output * $sales_scheme->Free_Qty;
                    if ($produc_qty > 0) {
                        $sheme = "<p class='form m-0' style='color: #d76666'><b>You Will Get Free" . $produc_qty . " Extra Product With This Product</b></p>";
                    }
                } else {
                    $sheme = "";
                }
                $product_image = \App\Productimage::where('Product_Code', '=', $card_product->product_code)->first();
                if ($product_image) {

                    $image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                }
                $abcd = "<div class='product-details delete_mem" . $prod->product_id . "'>
                                        <div class='product-itemdetails row' valign='middle' id='itemid-922086'>
                                            <div class='leftside-icons col-md-2 p-0'>
                                                <a class='product-item-photo' title='" . $card_product->brand_name . "'>
                                                    <img src='" . $image . "' alt='' class='pro-img'>
                                                </a>
                                            </div>
                                            <div class='rightside-details col pr-0'>
                                                <div class='row m-0'>
                                                    <div class='product-item-name col pl-0'>
                                                        <a href='#'>" . $card_product->generic_name . "(" . $card_product->brand_name . ")" . "</a>
                                                    </div>
                                                    <div class='item-prices col-2 p-0 text-right'>
                                                        <div class='discount-val'><span id='row_itmdiscprice_922086'><b style='color: black'>Rs." . number_format($subtotal, 2, '.', ',') . "</b></span></div>
                                                    </div>
                                                </div>
                                                <div class='row m-0 mt-3'>
                                                    <div class='catag-name col pl-0'>
                                                     <p class='form m-0'>
                                                " . $precription . " " . $package_detail . "
                                                </p>
                                                        <p class='form m-0'><b style='color: black'>Purchase Price : Rs. " . number_format($prod->amount, 2, '.', ',') . "/-</b></p>
                                                            " . $sheme . "
                                                    </div>
                                                    <div class='item-qty col-3 p-0'>
                                                        <div>
                                                            <div class='form-group align-select m-0'>
                                                                <h5>QTY:- </h5>
                                                                <div class='qty-div'>
                                                                    <span class='qty_minus' data-id='" . $prod->product_id . "' onclick='quantity" . $prod->product_id . "_change_minus()'>-</span>
                                                                    <input type='number' required='' name='Qty' class='qty_" . $prod->product_id . "' min='1' max='10' onchange='quantity" . $prod->product_id . "_change()' value='" . $prod->Qty . "'  id='quantity_id" . $prod->product_id . "'>
                                                                    <span class='qty_plus' data-id='" . $prod->product_id . "' onclick='quantity" . $prod->product_id . "_change_plus()'>+</span>
                                                                </div>
                                                                 <input type='hidden' id='product_id" . $prod->product_id . "' value='" . $card_product->id . "'>
                                                                <input type='hidden' id='price_amount" . $prod->product_id . "' value='" . number_format($prod->amount, 2, '.', ',') . "'>
                                                                " . $customer_mrp . "
                                                                    " . $gst . "
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='deliveryby row m-0 mt-2'>
                                                    <div class='date deldate col pl-0'>

                                                    </div>
                                                    <div class='remove-drug col-2 p-0 text-right'>
                                                        <input type='hidden' id='sub_total" . $prod->product_id . "' class='form-control' name='total_amt' value='" . $subtotal . "'>
                                                        <button  type='button' onclick='remove" . $prod->product_id . "_function()' class='removeitem" . $prod->product_id . "' value='" . $prod->product_id . "' title='Remove item'>Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> ";
            }
            $product1[] = $prod;
        }
        $array_json = json_encode($product1);
        $cookie = cookie('add_cart', $array_json, 120);
        return response($abcd)->cookie($cookie);
        //     $response->cookie('add_cart',$array_json1, 120);
        //     return $response;
        //    return response(redirect()->route('frontend.single_product_detail',$request->product_id))->cookie($cookie);

    }

    public function change_qty_chemist(Request $request)
    {
        $date1 = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
        $date5 = date('Y-m-d', strtotime("+4 day", strtotime(date('Y-m-d'))));
        $period = date('M', strtotime($date1)) . " " . date('d', strtotime($date1)) . "" . "-" . date('M', strtotime($date5)) . " " . date('d', strtotime($date5));
        $host = $request->getSchemeAndHttpHost();
        $add_to_cards = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        foreach ($add_to_cards as $key => $prod) {
            $mrp_subtotal = 0;
            $subtotal = 0;
            if ($prod->product_id == $request->key_value) {
                $prod->Qty = $request->Qty;
                $prod->save();
                $subtotal = $prod->Qty * $prod->amount;

                $card_product = \App\Product::find($request->product_id);
                $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $card_product->product_code)->first();
                $gst = "";
                $customer_mrp = "";
                if ($card_product->chemist_price) {
                    $gst = "<input type='hidden' id='gst" . $prod->product_id . "' value='" . $card_product->chemist_price->GST . "'>";
                }
                if ($card_product->mrp_price) {
                    $mrp_price = "<input type='hidden' id='mrp_product_price" . $prod->product_id . "' value='" . number_format($card_product->mrp_price->Price, 2, '.', ',') . "'>";
                }
                if ($card_product->mrp_price && $card_product->chemist_price) {
                    $total1 = $card_product->chemist_price->Price + $card_product->chemist_price->Price * $card_product->chemist_price->GST / 100;

                    $margin = ($card_product->mrp_price->Price - $total1) * 100 / $total1;
                    $total_margin_on_mrp = "<strong> Margin On MRP " . number_format($margin, 2, '.', ',') . "% </strong>";
                } else {
                    $total_margin_on_mrp = "<strong> Margin Update Soon</strong>";
                }

                if ($sales_scheme) {
                    $sheme = "";
                    if ($sales_scheme->NextMinSaleQty_ForScheme <= $prod->Qty) {
                        $dividend = $prod->Qty;

                        $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                        $output = intdiv($dividend, $divisor);
                        $produc_qty = $output * $sales_scheme->Free_Qty;
                        if ($produc_qty > 0) {
                            $sheme = "<p class='form m-0' style='color: #d76666'><b>You Will Get Free" . $produc_qty . " Extra Product With This Product</b></p>";
                        }
                    }
                } else {
                    $sheme = "";
                }
                $mrp_product_price = \App\Productprice::where('Product_Code', '=', $card_product->product_code)->where('ProductPriceType_Code', '=', '8')->first();
                if ($mrp_product_price) {
                    $mrp_subtotal = "<span class='final_price' style='color: black; display: none'><strong>Rs." . number_format($mrp_product_price->Price * $prod->Qty, 2, '.', ',') . "</strong><span>";
                    $unit_price = "<span class='final_price' style='color: black'>Rs." . number_format($mrp_product_price->Price, 2, '.', ',') . "<span>";
                } else {
                    $mrp_subtotal = "";
                    $unit_price = "";
                }
                $product_image = \App\Productimage::where('Product_Code', '=', $card_product->product_code)->first();
                if ($product_image) {

                    $image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                }

                if ($card_product->Prescription_Required == '1') {
                    $precription = "<button class='tag-detail' style='background-color: #7bd9ba;color: white;display: inline-block;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 4px;
    margin-bottom: 10px;'>Rx</button>";
                } else {
                    $precription = "";
                }

                if ($card_product->package) {
                    $package_detail = "<span class='drug-varients ellipsis' style='white-space: nowrap;
  width: 220px;
  overflow: hidden;
  text-overflow: ellipsis;'>Packing:
" . $card_product->package->name . "</span>";
                } else {
                    $package_detail = "";
                }
                $abcd = "<div class='product-details delete_mem" . $prod->product_id . "'>
                                        <div class='product-itemdetails row' valign='middle' id='itemid-922086'>
                                            <div class='leftside-icons col-md-2 p-0'>
                                                <a class='product-item-photo' title='" . $card_product->brand_name . "'>
                                                    <img src='" . $image . "' alt='' class='pro-img'>
                                                </a>
                                            </div>
                                            <div class='rightside-details col pr-0'>
                                                <div class='row m-0'>
                                                    <div class='product-item-name col pl-0'>
                                                        <a href='#'>" . $card_product->generic_name . "(" . $card_product->brand_name . ")" . "</a>
                                                    </div>
                                                    <div class='item-prices text-right'>
                                                        <div class='discount-val'><span id='row_itmdiscprice_922086' style='color: black'><b>Rs." . number_format($subtotal, 2, '.', ',') . "</b>" . $mrp_subtotal . "</span></div>
                                                    </div>
                                                </div>
                                                <div class='row m-0 mt-3'>

                                                    <div class='catag-name col pl-0'>
                                                     <p class='form m-0'>
                                                " . $precription . " " . $package_detail . "
                                                </p>
                                                        <p class='form m-0'><b style='color: black'>MRP :" . $unit_price . " | Purchase Price : Rs." . number_format($prod->amount, 2, '.', ',') . "</b></p>
                                                        <p class='form m-0'><span class='price' style='color: #eb3b65'>" . $total_margin_on_mrp . "</span></p>
                                                             " . $sheme . "
                                                    </div>
                                                    <div class='item-qty col-3 p-0'>
                                                        <div>
                                                            <div class='form-group align-select m-0'>
                                                                <h5>QTY:- </h5>
                                                                <div class='qty-div'>
                                                                    <span class='qty_minus' data-id='" . $prod->product_id . "' onclick='quantity" . $prod->product_id . "_change_minus()'>-</span>
                                                                    <input type='number' required='' name='Qty' class='qty_" . $prod->product_id . "' min='1' max='10' onchange='quantity" . $prod->product_id . "_change()' value='" . $prod->Qty . "'  id='quantity_id" . $prod->product_id . "'>
                                                                    <span class='qty_plus' data-id='" . $prod->product_id . "' onclick='quantity" . $prod->product_id . "_change_plus()'>+</span>
                                                                </div>
                                                                 <input type='hidden' id='product_id" . $prod->product_id . "' value='" . $card_product->id . "'>
                                                                <input type='hidden' id='price_amount" . $prod->product_id . "' value='" . number_format($prod->amount, 2, '.', ',') . "'>
                                                                    " . $mrp_price . "
                                                                " . $gst . "
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='deliveryby row m-0 mt-2'>
                                                    <div class='date deldate col pl-0'>
                                                        <div class='deliveryby' style='display: none'> Dispatched in 2 to 3 days</div>
                                                    </div>
                                                    <div class='remove-drug col-2 p-0 text-right'>
                                                        <input type='hidden' id='sub_total" . $prod->product_id . "' class='form-control' name='total_amt' value='" . $subtotal . "'>
                                                        <button  type='button' onclick='remove" . $prod->product_id . "_function()' class='removeitem" . $prod->product_id . "' value='" . $prod->product_id . "' title='Remove item'>Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> ";
            }
        }
        // echo $abcd;
        return response()->json(['status' => true, 'message' => 'Add to Cart Successfully', 'data' => $abcd], $this->successStatus);
    }

    public function change_qty_user(Request $request)
    {
        $date1 = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
        $date5 = date('Y-m-d', strtotime("+4 day", strtotime(date('Y-m-d'))));
        $period = date('M', strtotime($date1)) . " " . date('d', strtotime($date1)) . "" . "-" . date('M', strtotime($date5)) . " " . date('d', strtotime($date5));
        $host = $request->getSchemeAndHttpHost();
        $add_to_cards = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        foreach ($add_to_cards as $key => $prod) {
            $subtotal = 0;
            if ($prod->product_id == $request->key_value) {
                $prod->Qty = $request->Qty;
                $prod->save();
                $subtotal = $prod->Qty * $prod->amount;

                $card_product = \App\Product::find($request->product_id);
                $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $card_product->product_code)->first();
                $gst = "";
                $customer_mrp = "";
                if ($card_product->customer_price) {
                    $gst = "<input type='hidden' id='gst" . $prod->product_id . "' value='" . $card_product->customer_price->GST . "'>";
                }
                if ($card_product->customer_mrp_price) {
                    $customer_mrp = "<input type='hidden' id='mrp_product_price" . $prod->product_id . "' value='" . number_format($card_product->customer_mrp_price->Price, 2, '.', ',') . "'>";
                    $mrp_subtotal = "<span class='final_price' style='color: black;display: none'><s>Rs." . number_format($card_product->customer_mrp_price->Price * $prod->Qty, 2, '.', ',') . "</s><span>";
                    $unit_price = "<span class='final_price' style='color: black;display: none'><s>Rs." . number_format($card_product->customer_mrp_price->Price, 2, '.', ',') . "</s><span>";
                } else {
                    $mrp_subtotal = "";
                    $unit_price = "";
                }

                if ($sales_scheme) {

                    $dividend = $prod->Qty;

                    $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                    $output = intdiv($dividend, $divisor);
                    $produc_qty = $output * $sales_scheme->Free_Qty;
                    if ($produc_qty > 0) {
                        $sheme = "<p class='form m-0' style='color: #d76666'><b>You Will Get Free" . $produc_qty . " Extra Product With This Product</b></p>";
                    }
                } else {
                    $sheme = "";
                }
                $product_image = \App\Productimage::where('Product_Code', '=', $card_product->product_code)->first();
                if ($product_image) {

                    $image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                }
                if ($card_product->Prescription_Required == '1') {
                    $precription = "<button class='tag-detail' style='background-color: #7bd9ba;color: white;display: inline-block;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 4px;
    margin-bottom: 10px;'>Rx</button>";
                } else {
                    $precription = "";
                }

                if ($card_product->package) {
                    $package_detail = "<span class='drug-varients ellipsis' style='white-space: nowrap;
  width: 220px;
  overflow: hidden;
  text-overflow: ellipsis;'>" . $card_product->package->Packing_Description . "</span>";
                } else {
                    $package_detail = "";
                }

                $abcd = "<div class='product-details delete_mem" . $prod->product_id . "'>
                                        <div class='product-itemdetails row' valign='middle' id='itemid-922086'>
                                            <div class='leftside-icons col-md-2 p-0'>
                                                <a class='product-item-photo' title='" . $card_product->brand_name . "'>
                                                    <img src='" . $image . "' alt='' class='pro-img'>
                                                </a>
                                            </div>
                                            <div class='rightside-details col pr-0'>
                                                <div class='row m-0'>
                                                    <div class='product-item-name col pl-0'>
                                                        <a href='#'>" . $card_product->generic_name . "(" . $card_product->brand_name . ")" . "</a>
                                                    </div>
                                                    <div class='item-prices text-right'>
                                                        <div class='discount-val'><span id='row_itmdiscprice_922086' style='color: black'><b>Rs. " . number_format($subtotal, 2, '.', ',') . "</b> " . $mrp_subtotal . "</span></div>
                                                    </div>
                                                </div>
                                                <div class='row m-0 mt-3'>
                                                    <div class='catag-name col pl-0'>
                                                        <p class='form m-0'>
                                                " . $precription . " " . $package_detail . "
                                                </p>
                                                        <p class='form m-0'><b style='color: black'>Purchase Price : Rs. " . number_format($prod->amount, 2, '.', ',') . "/-</b> " . $unit_price . "</p>
                                                             " . $sheme . "
                                                    </div>
                                                    <div class='item-qty col-3 p-0'>
                                                        <div>
                                                            <div class='form-group align-select m-0'>
                                                                <h5>QTY:- </h5>
                                                                <div class='qty-div'>
                                                                    <span class='qty_minus' data-id='" . $prod->product_id . "' onclick='quantity" . $prod->product_id . "_change_minus()'>-</span>
                                                                    <input type='number' required='' name='Qty' class='qty_" . $prod->product_id . "' min='1' max='10' onchange='quantity" . $prod->product_id . "_change()' value='" . $prod->Qty . "'  id='quantity_id" . $prod->product_id . "'>
                                                                    <span class='qty_plus' data-id='" . $prod->product_id . "' onclick='quantity" . $prod->product_id . "_change_plus()'>+</span>
                                                                </div>
                                                                 <input type='hidden' id='product_id" . $prod->product_id . "' value='" . $card_product->id . "'>
                                                                <input type='hidden' id='price_amount" . $prod->product_id . "' value='" . number_format($prod->amount, 2, '.', ',') . "'>
                                                                  " . $customer_mrp . "
                                                                " . $gst . "
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='deliveryby row m-0 mt-2'>
                                                    <div class='date deldate col pl-0'>
                                                        <div class='deliveryby' style='display: none'> Delivery between " . $period . " </div>
                                                    </div>
                                                    <div class='remove-drug col-2 p-0 text-right'>
                                                        <input type='hidden' id='sub_total" . $prod->product_id . "' class='form-control' name='total_amt' value='" . $subtotal . "'>
                                                        <button  type='button' onclick='remove" . $prod->product_id . "_function()' class='removeitem" . $prod->product_id . "' value='" . $prod->product_id . "' title='Remove item'>Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> ";
            }
        }
        echo $abcd;
        // return response()->json(['status' => true, 'message' => 'Add to Cart Successfully', 'data' => $abcd], $this->successStatus);
        // return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $abcd], $this->successStatus);
    }

    public function add_cart(Request $request)
    {

        $host = $request->getSchemeAndHttpHost();
        $value = request()->cookie('add_cart');
        $product = json_decode($value);
        $totalqty_data = 0;

        $qty_data = 0;
        $xyz = 0;
        if ($value) {
            foreach ($product as $pro) {
                if ($pro->product_id == $request->product_id) {
                    $pro->Qty = $pro->Qty + $request->Qty;
                    $xyz = 1;
                    $qty_data = $qty_data + $pro->Qty;
                }
                $totalqty_data = $totalqty_data + $pro->Qty;

                $product1[] = $pro;
            }
        }
        if ($xyz == 1) {
        } else {
            $req_arr_je = json_encode($request->all());
            $product1[] = json_decode($req_arr_je);
        }
        $bcd = "";

        $grand_total = 0;
        foreach ($product1 as $prod) {
            $grand_total = $grand_total + $prod->Qty * $prod->amount;
            $card_product = \App\Product::find($prod->product_id);
            $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $card_product->product_code)->first();

            $bcd .= "<div class='cart-list-drop'>
                            <div class='drop-des'>
                                <p class='drop-p-name'><a href='cart.php'>" . $card_product->brand_name . "</a></p>
                                <p class='drop-pri'><em class='fa fa-inr'></em>" . number_format($prod->amount, 2, '.', ',') . " <span>X  " . $prod->Qty . "</span></p>
                            </div>
                        </div>";
        }

        $abcd = "<a href='" . $host . "/frontend/cart'>
                            <div class='text'>
                        <span class='counter-number' id='counter-number'>" . $totalqty_data . "</span>
                    </div>
                    </a>
                    <div class='cart-dropdown'>
                    <div>" . $bcd . "<div class='pl-3 pr-3'>
                            <div class='totalamt'>
                            <span class='float-left'>TOTAL AMOUNT</span><span class='save-price'><b>Rs." . number_format($grand_total, 2, '.', ',') . "</b></span>
                            </div>
                        </div>
                        <p class='drop-p-name mt-0 m-3'>
                            <a href='" . $host . "/frontend/cart' class='add-to-cart'>View Cart</a>
                        </p>
                    </div>
                </div>";
        $array_json = json_encode($product1);
        $cookie = cookie('add_cart', $array_json, 120);
        // return response($abcd)->cookie($cookie);
        return response()->json(['status' => true, 'message' => 'Add to Cart Successfully', 'qty_data' => $qty_data, 'data' => $abcd], $this->successStatus)->cookie($cookie);

        //     $response->cookie('add_cart',$array_json1, 120);
        //     return $response;
        //    return response(redirect()->route('frontend.single_product_detail',$request->product_id))->cookie($cookie);

    }

    public function add_cart_chemist(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $addtocard_product = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->where('product_id', '=', $request->product_id)->first();
        if ($addtocard_product) {
            $addtocard_product->Qty = $addtocard_product->Qty + $request->Qty;
            $addtocard_product->save();
        } else {
            $addtocard_product = \App\Addtocard::create([
                'user_id' => \Auth::user()->id,
                'product_id' => $request->input('product_id'),
                'Qty' => $request->input('Qty'),
                'amount' => $request->input('amount'),
            ]);
        }

        $add_to_cards = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        $add_to_cards_qty_sum = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->sum('Qty');

        $bcd = "";
        $qty_data = $addtocard_product->Qty;
        $grand_total = 0;
        foreach ($add_to_cards as $prod) {
            $grand_total = $grand_total + $prod->Qty * $prod->amount;
            $card_product = \App\Product::find($prod->product_id);
            $product_image = \App\Productimage::where('Product_Code', '=', $card_product->product_code)->first();
            if ($product_image) {
                $image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            }
            $bcd .= "<div class='cart-list-drop'>
            <div class='drop-des'>
                <p class='drop-p-name'><a href='cart.php'>" . $card_product->brand_name . "</a></p>
                <p class='drop-pri'><em class='fa fa-inr'></em>" . number_format($prod->amount, 2, '.', ',') . " <span>X  " . $prod->Qty . "</span></p>
            </div>
        </div>";
        }

        $abcd = "<a href='" . $host . "/frontend/cart'>
                            <div class='text'>
                        <span class='counter-number' id='counter-number'>" . $add_to_cards_qty_sum . "</span>
                    </div>
                    </a>
                    <div class='cart-dropdown'>
                    <div>" . $bcd . "<div class='pl-3 pr-3'>
                            <div class='totalamt'>
                            <span class='float-left'>TOTAL AMOUNT</span><span class='save-price'><b>Rs." . number_format($grand_total, 2, '.', ',') . "</b></span>
                            </div>
                        </div>
                        <p class='drop-p-name mt-0 m-3'>
                            <a href='" . $host . "/frontend/cart' class='add-to-cart'>View Cart</a>
                        </p>
                    </div>
                </div>";
        return response()->json(['status' => true, 'message' => 'Add to Cart Successfully', 'qty_data' => $qty_data, 'data' => $abcd], $this->successStatus);

    }

    public function add_cart_user(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $addtocard_product = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->where('product_id', '=', $request->product_id)->first();
        if ($addtocard_product) {
            $addtocard_product->Qty = $addtocard_product->Qty + $request->Qty;
            $addtocard_product->save();
        } else {
            $addtocard_product = \App\Addtocard::create([
                'user_id' => \Auth::user()->id,
                'product_id' => $request->input('product_id'),
                'Qty' => $request->input('Qty'),
                'amount' => $request->input('amount'),
            ]);
        }

        $add_to_cards = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        $bcd = "";
        $qty_data = $addtocard_product->Qty;

        $grand_total = 0;
        foreach ($add_to_cards as $prod) {
            $grand_total = $grand_total + $prod->Qty * $prod->amount;
            $card_product = \App\Product::find($prod->product_id);

            $bcd .= "<div class='cart-list-drop'>
                            <div class='drop-des'>
                                <p class='drop-p-name'><a href='cart.php'>" . $card_product->brand_name . "</a></p>
                                <p class='drop-pri'><em class='fa fa-inr'></em>" . number_format($prod->amount, 2, '.', ',') . " <span>X " . $prod->Qty . "</span></p>
                            </div>
                        </div>";
        }

        $abcd = "<a href='" . $host . "/frontend/cart'>
                            <div class='text'>
                        <span class='counter-number' id='counter-number'>" . count($add_to_cards) . "</span>
                    </div>
                    </a>
                    <div class='cart-dropdown'>
                    <div>" . $bcd . "<div class='pl-3 pr-3'>
                            <div class='totalamt'>
                            <span class='float-left'>TOTAL AMOUNT</span><span class='save-price'><b>Rs." . $grand_total . "</b></span>
                            </div>
                        </div>
                        <p class='drop-p-name mt-0 m-3'>
                            <a href='" . $host . "/frontend/cart' class='add-to-cart'>View Cart</a>
                        </p>
                    </div>
                </div>";
        return response()->json(['status' => true, 'message' => 'Add to Cart Successfully', 'qty_data' => $qty_data, 'data' => $abcd], $this->successStatus);

    }

    public function remove_cart(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $value = request()->cookie('add_cart');
        $products = json_decode($value);

        if (count($products) == 1) {
            $cookie = Cookie::forget('add_cart');
            $xyx = 0;
            $abcd = "<div class='text'>
                        <span class='counter-number' id='counter-number'>" . $xyx . "</span>
                    </div>";
            return response($abcd)->cookie($cookie);
        } else {
            $bcd = "";

            $grand_total = 0;
            foreach ($products as $key => $product) {
                if ($product->product_id == $request->remove_key) {
                    unset($product);
                } else {
                    $grand_total = $grand_total + $product->Qty * $product->amount;
                    $card_product = \App\Product::find($product->product_id);
                    $product_image = \App\Productimage::where('Product_Code', '=', $card_product->product_code)->first();
                    if ($product_image) {
                        $image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    }
                    $bcd .= "<div class='cart-list-drop'>
                                    <div class='drop-img'>
                                        <img src='" . $image . "' alt='' class='w-100'>
                                    </div>
                            <div class='drop-des'>
                                <p class='drop-p-name'><a href='cart.php'>" . $card_product->generic_name . " " . $card_product->brand_name . "</a></p>
                                <p class='drop-p-des'>product description</p>
                                <p class='drop-pri'><em class='fa fa-inr'></em>" . number_format($product->amount, 2, '.', ',') . " <span>X  <b id='Qty_update" . $product->product_id . "'>" . $product->Qty . "</b></span></p>
                            </div>
                        </div>";
                    $product1[] = $product;
                }
            }

            $abcd = "<a href='" . $host . "/frontend/cart'>
                            <div class='text'>
                        <span class='counter-number' id='counter-number'>" . count($product1) . "</span>
                    </div>
                    </a>
                    <div class='cart-dropdown'>
                    <div>" . $bcd . "<div class='pl-3 pr-3'>
                            <div class='totalamt'>
                            <span class='float-left'>TOTAL AMOUNT</span><span class='save-price'>Rs.<b id='total_amount_update'>" . number_format($grand_total, 2, '.', ',') . "</b></span>
                            </div>
                        </div>
                        <p class='drop-p-name mt-0 m-3'>
                            <a href='" . $host . "/frontend/cart' class='add-to-cart'>View Cart</a>
                        </p>
                    </div>
                </div>";
            $array_json = json_encode($product1);
            $cookie = cookie('add_cart', $array_json, 120);
            return response($abcd)->cookie($cookie);
            //     $response->cookie('add_cart',$array_json1, 120);
            //     return $response;
            //    return response(redirect()->route('frontend.single_product_detail',$request->product_id))->cookie($cookie);

        }

    }

    public function remove_cart_chemist(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $add_to_card_pro = \App\Addtocard::where('product_id', '=', $request->remove_key)->where('user_id', '=', \Auth::user()->id)->first();
        if ($add_to_card_pro) {
            $add_to_card_pro->delete();
        }
        $add_to_cards = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        $add_to_cards_qty_sum = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->sum('Qty');

        $bcd = "";
        $grand_total = 0;
        foreach ($add_to_cards as $key => $product) {

            $grand_total = $grand_total + $product->Qty * $product->amount;
            $card_product = \App\Product::find($product->product_id);
            $product_image = \App\Productimage::where('Product_Code', '=', $card_product->product_code)->first();
            if ($product_image) {
                $image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            }
            $bcd .= "<div class='cart-list-drop'>
                                    <div class='drop-img'>
                                        <img src='" . $image . "' alt='' class='w-100'>
                                    </div>
                            <div class='drop-des'>
                                <p class='drop-p-name'><a href='cart.php'>" . $card_product->generic_name . " " . $card_product->brand_name . "</a></p>
                                <p class='drop-p-des'>product description</p>
                                <p class='drop-pri'><em class='fa fa-inr'></em>" . number_format($product->amount, 2, '.', ',') . " <span>Qty: <b id='Qty_update" . $product->product_id . "'>" . $product->Qty . "</b></span></p>
                            </div>
                        </div>";

        }

        $abcd = "<a href='" . $host . "/frontend/cart'>
                            <div class='text'>
                        <span class='counter-number' id='counter-number'>" . $add_to_cards_qty_sum . "</span>
                    </div>
                    </a>
                    <div class='cart-dropdown'>
                    <div>" . $bcd . "<div class='pl-3 pr-3'>
                            <div class='totalamt'>
                            <span class='float-left'>TOTAL AMOUNT</span><span class='save-price'>Rs.<b id='total_amount_update'>" . number_format($grand_total, 2, '.', ',') . "</b></span>
                            </div>
                        </div>
                        <p class='drop-p-name mt-0 m-3'>
                            <a href='" . $host . "/frontend/cart' class='add-to-cart'>View Cart</a>
                        </p>
                    </div>
                </div>";

        echo $abcd;
    }

    public function remove_cart_user(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $add_to_card_pro = \App\Addtocard::where('product_id', '=', $request->remove_key)->where('user_id', '=', \Auth::user()->id)->first();
        if ($add_to_card_pro) {
            $add_to_card_pro->delete();
        }
        $add_to_cards = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        $bcd = "";
        $grand_total = 0;
        foreach ($add_to_cards as $key => $product) {

            $grand_total = $grand_total + $product->Qty * $product->amount;
            $card_product = \App\Product::find($product->product_id);
            $product_image = \App\Productimage::where('Product_Code', '=', $card_product->product_code)->first();
            if ($product_image) {
                $image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            }
            $bcd .= "<div class='cart-list-drop'>
                                    <div class='drop-img'>
                                        <img src='" . $image . "' alt='' class='w-100'>
                                    </div>
                            <div class='drop-des'>
                                <p class='drop-p-name'><a href='cart.php'>" . $card_product->generic_name . " " . $card_product->brand_name . "</a></p>
                                <p class='drop-p-des'>product description</p>
                                <p class='drop-pri'><em class='fa fa-inr'></em>" . number_format($product->amount, 2, '.', ',') . " <span>Qty: <b id='Qty_update" . $product->product_id . "'>" . $product->Qty . "</b></span></p>
                            </div>
                        </div>";

        }

        $abcd = "<a href='" . $host . "/frontend/cart'>
                            <div class='text'>
                        <span class='counter-number' id='counter-number'>" . count($add_to_cards) . "</span>
                    </div>
                    </a>
                    <div class='cart-dropdown'>
                    <div>" . $bcd . "<div class='pl-3 pr-3'>
                            <div class='totalamt'>
                            <span class='float-left'>TOTAL AMOUNT</span><span class='save-price'>Rs.<b id='total_amount_update'>" . $grand_total . "</b></span>
                            </div>
                        </div>
                        <p class='drop-p-name mt-0 m-3'>
                            <a href='" . $host . "/frontend/cart' class='add-to-cart'>View Cart</a>
                        </p>
                    </div>
                </div>";

        echo $abcd;
    }

    public function add_to_cart_App(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $user = \App\User::where('mobile', '=', $request->mobile)->first();
        if ($user) {
            $add_to_card = \App\Addtocard::where('user_id', '=', $user->id)->where('product_id', '=', $request->product_id)->first();
            if ($add_to_card) {
                if ($request->type == 'add') {
                    $add_to_card->Qty = $add_to_card->Qty + $request->Qty;
                    $add_to_card->save();
                    return response()->json(['status' => true, 'message' => 'One Product Qty Add To Your Cart Successfully', 'data' => $add_to_card], $this->successStatus);
                } elseif ($request->type == 'remove') {
                    if ($add_to_card->Qty == 1) {
                        $add_to_card->delete();
                        return response()->json(['status' => true, 'message' => 'Card Product Delete Successfully'], $this->successStatus);
                    } else {
                        $add_to_card->Qty = $add_to_card->Qty - $request->Qty;
                        $add_to_card->save();
                        return response()->json(['status' => true, 'message' => 'One Product Qty  Remove To Your Cart Successfully', 'data' => $add_to_card], $this->successStatus);
                    }
                } else {

                }

            } else {
                $product = \App\Product::find($request->input('product_id'));
                if ($product) {
                    $add_to_card = \App\Addtocard::create([
                        'user_id' => $user->id,
                        'product_id' => $request->input('product_id'),
                        'Qty' => $request->input('Qty'),
                        'amount' => $request->input('amount'),
                    ]);
                } else {
                    return response()->json(['status' => true, 'message' => 'Product_id is not valid. Please Try Again', 'data' => $add_to_card], $this->successStatus);
                }

            }
            return response()->json(['status' => true, 'message' => 'Product Add To Your Cart Successfully', 'data' => $add_to_card], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function my_cart_count_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->first();
        if ($user) {
            $add_to_cards = \App\Addtocard::where('user_id', '=', $user->id)->sum('Qty');
            $data['total_cart_item'] = $add_to_cards;
            if ($add_to_cards) {
                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Your Cart is Empty'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function my_cart_App(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();

        $user = \App\User::where('mobile', '=', $request->mobile)->first();
        if ($user) {
            $add_to_cards = \App\Addtocard::where('user_id', '=', $user->id)->get();
            if (count($add_to_cards)) {
                $total_mrp = 0.00;

                $total = 0.00;
                $gst_total = 0;
                $grand_total = 0;
                $total_margin = 0;
                foreach ($add_to_cards as $add_to_card) {
                    $total_chemist_amount = 0.00;
                    $total_mrp_amount = 0.00;
                    $gst_amount = 0;
                    $subtotal = 0;
                    $subtotal = $add_to_card->amount * $add_to_card->Qty;
                    $sub_total = $subtotal;
                    $total = $total + $sub_total;

                    $product = \App\Product::find($add_to_card->product_id);
                    $add_to_card->brand_name = $product->brand_name;
                    $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
                    $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                    $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                    $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                    if ($product_image) {
                        $add_to_card->image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    } else {
                        $add_to_card->image = "";
                    }

                    if ($product->chemist_price) {
                    } else {
                        $product->chemist_price = null;
                    }
                    $add_to_card->offer = "10 % Off";

                    if ($product->chemist_price) {
                        $add_to_card->chemist_amount = number_format($product->chemist_price->Price, 2, '.', ',');
                        $total_chemist_amount = $product->chemist_price->Price * $add_to_card->Qty;
                        $add_to_card->total_chemist_amount = number_format($total_chemist_amount, 2, '.', ',');
                        $gst_amount = ($product->chemist_price->GST * $sub_total) / 100;
                        $gst_total = $gst_total + $gst_amount;
                        $add_to_card->gst = $product->chemist_price->GST . " %";
                    } else {
                        $add_to_card->chemist_amount = null;
                        $add_to_card->total_chemist_amount = null;
                    }

                    if ($product->mrp_price) {
                        $add_to_card->mrp_amount = number_format($product->mrp_price->Price, 2, '.', ',');
                        $total_mrp_amount = $product->mrp_price->Price * $add_to_card->Qty;
                        $add_to_card->total_mrp_amount = number_format($total_mrp_amount, 2, '.', ',');
                        $total_mrp = $total_mrp + $total_mrp_amount;
                    } else {
                        $add_to_card->mrp_amount = null;
                        $add_to_card->total_mrp_amount = null;
                        $add_to_card->gst = null;

                    }

                    if ($product->mrp_price && $product->chemist_price) {
                        $total1 = $product->chemist_price->Price + $product->chemist_price->Price * $product->chemist_price->GST / 100;
                        $margin = 0.00;
                        $margin = ($product->mrp_price->Price - $total1) * 100 / $total1;
                        $total_margin = $total_margin + ($product->mrp_price->Price - $total1) * $add_to_card->Qty;
                    } else {
                        $margin = 0.00;
                    }
                    $add_to_card->margin = number_format($margin, 2, '.', '');
                }
                $grand_total = $total + $gst_total;
                $data1['type'] = 'Products';
                $data1['data'] = $add_to_cards;
                $data[] = $data1;

                $data2['message'] = 'View Price Detail';
                $data2['type'] = 'Total Amount';
                $data2['data'] = array('total_mrp' => number_format($total_mrp, 2, '.', ','),
                    'item_amount' => number_format($total, 2, '.', ','),
                    'taxable_amount' => number_format($total, 2, '.', ','),
                    'gst_amount' => number_format($gst_total, 2, '.', ','),
                    'delivery_charge' => number_format(0, 2, '.', ','),
                    'payble_amount' => number_format($grand_total, 2, '.', ','),
                    'total_margin' => number_format($total_margin, 2, '.', ','),

                );
                $data[] = $data2;

                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Your Cart is Empty'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function customer_my_cart_App(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();

        $user = \App\User::where('mobile', '=', $request->mobile)->first();
        if ($user) {
            $add_to_cards = \App\Addtocard::where('user_id', '=', $user->id)->get();
            if (count($add_to_cards)) {
                $total = 0.00;
                $gst_total = 0;
                $grand_total = 0;

                foreach ($add_to_cards as $add_to_card) {
                    $gst_amount = 0;
                    $subtotal = 0;
                    $subtotal = $add_to_card->amount * $add_to_card->Qty;
                    $sub_total = $subtotal;
                    $total = $total + $sub_total;

                    $product = \App\Product::find($add_to_card->product_id);
                    $add_to_card->brand_name = $product->brand_name;
                    $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
                    $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                    $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                    $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                    if ($product_image) {
                        $add_to_card->image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    } else {
                        $add_to_card->image = "";
                    }

                    $add_to_card->offer = "10 % Off";

                    if ($product_price) {
                        $add_to_card->actual_amount = number_format($product_price->Price, 2, '.', ',');
                    } else {
                        $add_to_card->actual_amount = null;
                    }

                    if ($chemist_product_price) {
                        $add_to_card->chemist_amount = number_format($chemist_product_price->Price, 2, '.', ',');
                        $gst_amount = ($chemist_product_price->GST * $sub_total) / 100;
                        $gst_total = $gst_total + $gst_amount;
                        $add_to_card->gst = $chemist_product_price->GST . " %";

                    } else {
                        $add_to_card->chemist_amount = null;
                    }

                    if ($mrp_product_price) {
                        $add_to_card->mrp_amount = number_format($mrp_product_price->Price, 2, '.', ',');

                    } else {
                        $add_to_card->mrp_amount = null;
                        $add_to_card->gst = null;

                    }
                }

                $grand_total = $total + $gst_total;
                $data1['type'] = 'Products';
                $data1['data'] = $add_to_cards;
                $data[] = $data1;

                $data2['message'] = 'View Price Detail';
                $data2['type'] = 'Total Amount';
                $data2['data'] = array('taxable_amount' => number_format($total, 2, '.', ','), 'tax_amount' => number_format($gst_total, 2, '.', ','), 'grand_total' => number_format($grand_total, 2, '.', ','));
                $data[] = $data2;

                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Your Cart is Empty'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function re_order($id)
    {
        $order = \App\Order::find($id);

        if ($order) {
            foreach ($order->orderproducts as $orderproduct) {
                $addtocard_product = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->where('product_id', '=', $orderproduct->product_id)->first();
                if ($addtocard_product) {
                    $addtocard_product->Qty = $addtocard_product->Qty + $orderproduct->Order_Qty;
                    $addtocard_product->save();
                } else {
                    $addtocard_product = \App\Addtocard::create([
                        'user_id' => \Auth::user()->id,
                        'product_id' => $orderproduct->product_id,
                        'Qty' => $orderproduct->Order_Qty,
                    ]);
                    $product = \App\Product::find($addtocard_product->product_id);
                    if ($product->chemist_price) {
                        $addtocard_product->amount = $product->chemist_price->Price;
                        $addtocard_product->save();
                    }
                }

            }
            return redirect()->route('frontend.cart');
        }
    }

    public function remove_from_my_cart_App(Request $request)
    {

        $add_to_card = \App\Addtocard::find($request->card_id);
        if ($add_to_card) {
            $add_to_card->delete();
            return response()->json(['status' => true, 'message' => 'Card Product Delete Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

}