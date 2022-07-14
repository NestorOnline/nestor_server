<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function group_product_by_price(Request $request)
    {
        // $products = \App\Product::where('category_id','=',$request->category_id)->get();
        // return response()->json(['status'=>true,'message'=>'Data Fetch Successfully','data'=>$products], 201);
        $host = request()->getHost();
        $min_price = $request->minval;
        $max_price = $request->maxval;
        $group_id = $request->group_id;
        $abcd = "";
        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                if ($request->category_id) {
                    $products = \App\Product::where('category_id', '=', $request->category_id)->get();
                    $product_maxs = $products;
                } else {
                    $products = DB::table('products')->where('group_id', '=', $group_id)
                        ->join('productprices', function ($join) use ($min_price, $max_price) {
                            $join->on('products.product_code', '=', 'productprices.product_code')
                                ->where('productprices.ProductPriceType_Code', '=', 7)
                                ->where('productprices.Price', '>', $min_price)
                                ->where('productprices.Price', '<', $max_price);
                        })->get();

                    $product_maxs = DB::table('products')->where('group_id', '=', $group_id)
                        ->join('productprices', function ($join) use ($min_price, $max_price) {
                            $join->on('products.product_code', '=', 'productprices.product_code')
                                ->where('productprices.ProductPriceType_Code', '=', 7)
                                ->where('productprices.Price', '>', $min_price)
                                ->where('productprices.Price', '<', $max_price);
                        })->get();
                }

            }
        } else {

            if ($request->category_id) {
                $products = \App\Product::where('category_id', '=', $request->category_id)->get();
                $product_maxs = $products;
            } else {
                $products = DB::table('products')->where('group_id', '=', $group_id)
                    ->join('productprices', function ($join) use ($min_price, $max_price) {
                        $join->on('products.product_code', '=', 'productprices.product_code')
                            ->where('productprices.ProductPriceType_Code', '=', 9)
                            ->where('productprices.Price', '>', $min_price)
                            ->where('productprices.Price', '<', $max_price);
                    })->get();

                $product_maxs = DB::table('products')->where('group_id', '=', $group_id)
                    ->join('productprices', function ($join) use ($min_price, $max_price) {
                        $join->on('products.product_code', '=', 'productprices.product_code')
                            ->where('productprices.ProductPriceType_Code', '=', 9)
                            ->where('productprices.Price', '>', $min_price)
                            ->where('productprices.Price', '<', $max_price);
                    })->get();
            }
        }

        $title = "Showing " . count($products) . " of " . count($product_maxs) . " Items";
        if (count($products)) {
            $dividend = count($product_maxs);
            $divisor = count($products);
            $output = intdiv($dividend, $divisor);
            $no_page = $output + 1;
        } else {
            $no_page = 1;
        }
        $active = 1;

        foreach ($products as $product) {
            if ($request->category_id) {
                $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
                $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();
            } else {
                $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->where('Price', '>=', $min_price)->where('Price', '<=', $max_price)->first();
                $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->whereBetween('Price', [$min_price, $max_price])->first();
                $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->whereBetween('Price', [$min_price, $max_price])->first();
            }

            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();

            if ($product_image) {
                $product->image = "http://" . $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }
            if ($product_price) {
                $product->actual_amount = number_format($product_price->Price, 2, '.', '');
            } else {
                $product->actual_amount = null;
            }

            if ($chemist_product_price) {
                $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
            } else {
                $product->chemist_amount = null;
            }

            if ($mrp_product_price) {
                $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                $product->gst = $mrp_product_price->GST . " %";
            } else {
                $product->mrp_amount = null;
                $product->gst = null;
            }

            $group = \App\Group::find($product->group_id);
            $group_category = \App\Groupcategory::find($product->groupcategory_id);

            if (\Auth::user()) {
                if (\Auth::user()->role == 'Chemist') {
                    $abcd .= "<div class='col-md-3'>
                        <div class='diag-section'>
                            <span class='diag-img'>
                                <a href='http://" . $host . "/" . $group->url_name . "/" . $group_category->url_name . "/" . $product->url_name . "'>
                                    <img src='" . $product->image . "' class='img-responsive category_image' alt='Nestor Immunity Care'>
                                </a>
                            </span>
                            <div class='diag-txt'>
                                <span class='clsgetname ellipsis'>" . $product->brand_name . "</span>
                                <span class='drug-varients ellipsis'>" . $product->generic_name . "</span>
                            </div>
                               <div class='diag-price'>
                                <span class='final_price'><s>MRP  <i class='fa fa-inr'></i>." . $mrp_product_price->mrp_amount . "</s></span>
                                <span class='price'>Your Price <i class='fa fa-inr'></i>" . $product->chemist_amount . "</span>
                             </div>
                             <div class='diag-price'>
                                <span class='price'> Margin " . number_format($margin, 2, '.', ',') . "%</span>
                             </div>
                            <div class='dia-bottom'>
                               <span class='book-now'><a href='http://" . $host . "/frontend/buy_now/" . $product->id . "'>Buy Now</a></span>
                               <span class='book-now'><button  class='book-now-cart' type='button'   onclick='add_cart_from_search({$product->id},{$product->actual_amount})'>Add to Cart</button></span>
                           </div>
                        </div>
                    </div>";
                } else {
                    $abcd .= "<div class='col-md-3'>
                        <div class='diag-section'>
                            <span class='diag-img'>
                                <a href='http://" . $host . "/" . $group->url_name . "/" . $group_category->url_name . "/" . $product->url_name . "'>
                                    <img src='" . $product->image . "' class='img-responsive category_image' alt='Nestor Immunity Care'>
                                </a>
                            </span>
                            <div class='diag-txt'>
                                <span class='clsgetname ellipsis'>" . $product->brand_name . "</span>
                                <span class='drug-varients ellipsis'>" . $product->generic_name . "</span>
                            </div>
                            <div class='diag-price'>
                                <span class='price'>Rs. " . $product->actual_amount . "</span>
                             </div>
                            <div class='dia-bottom'>
                                <span class='book-now'><a href='http://" . $host . "/frontend/buy_now/" . $product->id . "'>Buy Now</a></span>

                                <span class='book-now'><button class='book-now-cart' type='button'   onclick='add_cart_from_search({$product->id},{$product->actual_amount})'>Add to Cart</button></span>
                           </div>
                        </div>
                    </div>";
                }
            } else {
                if ($product_price) {
                    $abcd .= "<div class='col-md-3'>
                        <div class='diag-section'>
                            <span class='diag-img'>
                                <a href='http://" . $host . "/" . $group->url_name . "/" . $group_category->url_name . "/" . $product->url_name . "'>
                                    <img src='" . $product->image . "' class='img-responsive category_image' alt='Nestor Immunity Care'>
                                </a>
                            </span>
                            <div class='diag-txt'>
                                <span class='clsgetname ellipsis'>" . $product->brand_name . "</span>
                                <span class='drug-varients ellipsis'>" . $product->generic_name . "</span>
                            </div>
                            <div class='diag-price'>
                                <span class='price'>Rs. " . $product->actual_amount . "</span>
                             </div>
                            <div class='dia-bottom'>
                               <span class='book-now'><a href='http://" . $host . "/frontend/buy_now/" . $product->id . "'>Buy Now</a></span>
                                <span class='book-now'><button class='book-now-cart' type='button' onclick='add_cart_from_search({$product->id},{$product->actual_amount})'>Add to Cart</button></span>
                           </div>
                        </div>
                    </div>";
                }
            }
        }

        echo $abcd;
    }

    public function groupcategory_product_by_price(Request $request)
    {

        $host = request()->getHost();
        $min_price = $request->minval;
        $max_price = $request->maxval;
        $groupcategory_id = $request->groupcategory_id;
        $abcd = "";
        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                $products = DB::table('products')->where('groupcategory_id', '=', $groupcategory_id)
                    ->join('productprices', function ($join) use ($min_price, $max_price) {
                        $join->on('products.product_code', '=', 'productprices.product_code')
                            ->where('productprices.ProductPriceType_Code', '=', 7)
                            ->where('productprices.Price', '>', $min_price)
                            ->where('productprices.Price', '<', $max_price);
                    })->get();

                $product_maxs = DB::table('products')->where('groupcategory_id', '=', $groupcategory_id)
                    ->join('productprices', function ($join) use ($min_price, $max_price) {
                        $join->on('products.product_code', '=', 'productprices.product_code')
                            ->where('productprices.ProductPriceType_Code', '=', 7)
                            ->where('productprices.Price', '>', $min_price)
                            ->where('productprices.Price', '<', $max_price);
                    })->get();
            }
        } else {
            $products = DB::table('products')->where('groupcategory_id', '=', $groupcategory_id)
                ->join('productprices', function ($join) use ($min_price, $max_price) {
                    $join->on('products.product_code', '=', 'productprices.product_code')
                        ->where('productprices.ProductPriceType_Code', '=', 9)
                        ->where('productprices.Price', '>', $min_price)
                        ->where('productprices.Price', '<', $max_price);
                })->get();

            $product_maxs = DB::table('products')->where('groupcategory_id', '=', $groupcategory_id)
                ->join('productprices', function ($join) use ($min_price, $max_price) {
                    $join->on('products.product_code', '=', 'productprices.product_code')
                        ->where('productprices.ProductPriceType_Code', '=', 9)
                        ->where('productprices.Price', '>', $min_price)
                        ->where('productprices.Price', '<', $max_price);
                })->get();

        }

        $title = "Showing " . count($products) . " of " . count($product_maxs) . " Items";
        if (count($products)) {
            $dividend = count($product_maxs);
            $divisor = count($products);
            $output = intdiv($dividend, $divisor);
            $no_page = $output + 1;
        } else {
            $no_page = 1;
        }
        $active = 1;

        foreach ($products as $product) {
            if ($request->category_id) {
                $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
                $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();
            } else {
                $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->where('Price', '>=', $min_price)->where('Price', '<=', $max_price)->first();
                $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->whereBetween('Price', [$min_price, $max_price])->first();
                $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->whereBetween('Price', [$min_price, $max_price])->first();
            }

            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();

            if ($product_image) {
                $product->image = "http://" . $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }
            if ($product_price) {
                $product->actual_amount = number_format($product_price->Price, 2, '.', '');
            } else {
                $product->actual_amount = null;
            }

            if ($chemist_product_price) {
                $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
            } else {
                $product->chemist_amount = null;
            }

            if ($mrp_product_price) {
                $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                $product->gst = $mrp_product_price->GST . " %";
            } else {
                $product->mrp_amount = null;
                $product->gst = null;
            }

            $group = \App\Group::find($product->group_id);
            $group_category = \App\Groupcategory::find($product->groupcategory_id);

            if (\Auth::user()) {
                if (\Auth::user()->role == 'Chemist') {
                    if ($mrp_product_price && $chemist_product_price) {
                        $margin = 0.00;
                        $margin = ($prod->mrp_price->Price - $prod->chemist_price->Price) * 100 / $prod->chemist_price->Price;

                    } else {
                        $margin = 0.00;

                    }
                    $abcd .= "<div class='col-md-3'>
                        <div class='diag-section'>
                            <span class='diag-img'>
                                <a href='http://" . $host . "/" . $group->url_name . "/" . $group_category->url_name . "/" . $product->url_name . "'>
                                    <img src='" . $product->image . "' class='img-responsive category_image' alt='Nestor Immunity Care'>
                                </a>
                            </span>
                            <div class='diag-txt'>
                                <span class='clsgetname ellipsis'>" . $product->brand_name . "</span>
                                <span class='drug-varients ellipsis'>" . $product->generic_name . "</span>
                            </div>
                            <div class='diag-price'>
                                <span class='final_price'><s>MRP  <i class='fa fa-inr'></i>." . $mrp_product_price->mrp_amount . "</s></span>
                                <span class='price'>Your Price <i class='fa fa-inr'></i>" . $product->chemist_amount . "</span>
                             </div>
                             <div class='diag-price'>
                                <span class='price'> Margin " . number_format($margin, 2, '.', ',') . "%</span>
                             </div>
                            <div class='dia-bottom'>
                                <span class='book-now'><a href='http://" . $host . "/product_detail/" . $product->id . "'>Buy Now</a></span>

                                <input type='hidden' class='amount" . $product->id . "' value='" . $product->actual_amount . "'>

                                <input type='hidden' class='product_id" . $product->id . "' value='" . $product->id . "'>
                                <input type='hidden' class='Qty" . $product->id . "' value='1'>
                                <span class='book-now'><a type='button'  class='add-to-your-cart" . $product->id . "'>Add to Cart</a></span>
                           </div>
                        </div>
                    </div>";
                } else {
                    $abcd .= "<div class='col-md-3'>
                        <div class='diag-section'>
                            <span class='diag-img'>
                                <a href='http://" . $host . "/" . $group->url_name . "/" . $group_category->url_name . "/" . $product->url_name . "'>
                                    <img src='" . $product->image . "' class='img-responsive category_image' alt='Nestor Immunity Care'>
                                </a>
                            </span>
                            <div class='diag-txt'>
                                <span class='clsgetname ellipsis'>" . $product->brand_name . "</span>
                                <span class='drug-varients ellipsis'>" . $product->generic_name . "</span>
                            </div>
                            <div class='diag-price'>
                                <span class='price'>Rs. " . $product->actual_amount . "</span>
                             </div>
                            <div class='dia-bottom'>
                                <span class='book-now'><a href='http://" . $host . "/product_detail/" . $product->id . "'>Buy Now</a></span>

                                <input type='hidden' class='amount" . $product->id . "' value='" . $product->actual_amount . "'>

                                <input type='hidden' class='product_id" . $product->id . "' value='" . $product->id . "'>
                                <input type='hidden' class='Qty" . $product->id . "' value='1'>
                                <span class='book-now'><a type='button'  class='add-to-your-cart" . $product->id . "'>Add to Cart</a></span>
                           </div>
                        </div>
                    </div>";
                }
            } else {
                if ($product_price) {
                    $abcd .= "<div class='col-md-3'>
                        <div class='diag-section'>
                            <span class='diag-img'>
                               <a href='http://" . $host . "/" . $group->url_name . "/" . $group_category->url_name . "/" . $product->url_name . "'>
                                    <img src='" . $product->image . "' class='img-responsive category_image' alt='Nestor Immunity Care'>
                                </a>
                            </span>
                            <div class='diag-txt'>
                                <span class='clsgetname ellipsis'>" . $product->brand_name . "</span>
                                <span class='drug-varients ellipsis'>" . $product->generic_name . "</span>
                            </div>
                            <div class='diag-price'>
                                <span class='price'>Rs. " . $product->actual_amount . "</span>
                             </div>
                            <div class='dia-bottom'>
                                <span class='book-now'><a href='http://" . $host . "/product_detail/" . $product->id . "'>Buy Now</a></span>

                                <input type='hidden' class='amount" . $product->id . "' value='" . $product->actual_amount . "'>

                                <input type='hidden' class='product_id" . $product->id . "' value='" . $product->id . "'>
                                <input type='hidden' class='Qty" . $product->id . "' value='1'>
                                <span class='book-now'><a type='button'  class='add-to-your-cart" . $product->id . "'>Add to Cart</a></span>
                           </div>
                        </div>
                    </div>";
                }
            }
        }
        echo $abcd;
    }

    public function get_search_data_after_filter_App(Request $request)
    {

        $login_user = $request->user();
        $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
            ->where('set_as_a_default', '=', 'Yes')
            ->where('set_as_a_current', '=', 'Yes')
            ->first();
        if ($pincode1) {
            $pincode = \App\Pincode::where('pincode', $pincode1->PIN)->first();
            if ($pincode) {
                $office_state = \App\OfficeState::where('State_Code', $pincode->state_id)->first();
                if ($office_state) {
                    $Global_Office_Code = $office_state->Office_Code;
                } else {
                    $Global_Office_Code = 1;
                }

            } else {
                $Global_Office_Code = 1;
            }

        } else {
            $Global_Office_Code = 1;

        }

        $price_code = 7;
        $site_route = $request->getSchemeAndHttpHost();
        if (isset($request->groupcategory_id)) {

            $product_group_categories = \App\ProductGroupCategories::whereIn('groupcategory_id', $request->groupcategory_id)->get();

            if (isset($request->category) && isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::where('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category) && isset($request->prescription_required)) {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::where('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->whereIn('ProductUse_Code', $request->uses)
                    ->whereIn('Prescription_Required', $request->prescription_required)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses) && isset($request->category)) {
                $productuse_details = \App\ProductuseDetail::where('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->whereIn('category_id', $request->category)
                    ->whereIn('ProductUse_Code', $request->uses)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category)) {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->whereIn('category_id', $request->category)
                    ->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->orderBy('id', 'DESC')->paginate(20);

            } else if (isset($request->prescription_required)) {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses)) {

                $productuse_details = \App\ProductuseDetail::where('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);

            } else {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->where('productprice.Price', '<=', number_format($request->maxval, 2, '.', ''))
                    ->where('productprice.Price', '>=', number_format($request->minval, 2, '.', ''))
                    ->select('products.*')->paginate(20);
            }
        } else {
            if (isset($request->category) && isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
                $products = \App\Product::whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category) && isset($request->prescription_required)) {
                $products = \App\Product::whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);

            } else if (isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
                $products = \App\Product::whereIn('ProductUse_Code', $request->uses)
                    ->whereIn('Prescription_Required', $request->prescription_required)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses) && isset($request->category)) {
                $productuse_details = \App\ProductuseDetail::where('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
                $products = \App\Product::whereIn('category_id', $request->category)
                    ->whereIn('ProductUse_Code', isset($request->uses))
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);

            } else if (isset($request->category)) {
                $products = \App\Product::whereIn('category_id', $request->category)
                    ->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->orderBy('id', 'DESC')->paginate(20);

            } else if (isset($request->prescription_required)) {
                $products = \App\Product::whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if ($request->uses) {

                $productuse_details = \App\ProductuseDetail::where('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
                $products = \App\Product::join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);

            } else {
                $products = \App\Product::join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->where('productprice.Price', '<=', number_format($request->maxval, 2, '.', ''))
                    ->where('productprice.Price', '>=', number_format($request->minval, 2, '.', ''))
                    ->select('products.*')->paginate(20);
            }

        }

        if (count($products)) {
            foreach ($products as $product) {

                $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
                $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                if ($product_image) {
                    $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                } else {
                    $product->image = "";
                }
                $group = \App\Group::find($product->group_id);
                if ($group) {
                    $product->group = $group->name;
                }
                $group_category = \App\Groupcategory::find($product->groupcategory_id);
                if ($group_category) {
                    $product->group_category = $group_category->name;
                }
                $product->offer = "10 % Off";

                if ($product_price) {
                    $product->actual_amount = number_format($product_price->Price, 2, '.', '');

                } else {
                    $product->actual_amount = null;
                }

                if ($chemist_product_price) {
                    $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
                } else {
                    $product->chemist_amount = null;
                }

                if ($mrp_product_price) {
                    $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                    $product->gst = $mrp_product_price->GST . " %";
                } else {
                    $product->mrp_amount = null;
                    $product->gst = null;
                }

                if ($mrp_product_price && $chemist_product_price) {
                    $total = $chemist_product_price->Price + $chemist_product_price->Price * $chemist_product_price->GST / 100;
                    $margin = 0.00;
                    $margin = ($mrp_product_price->Price - $total) * 100 / $total;
                } else {
                    $margin = 0.00;
                }
                $product->margin = number_format($margin, 2, '.', '');

                $group = \App\Group::find($product->group_id);
                if ($group) {
                    $product->group = $group->name;
                }
                $group_category = \App\Groupcategory::find($product->groupcategory_id);
                if ($group_category) {
                    $product->group_category = $group_category->name;
                }

                if ($product->stock_by_office($Global_Office_Code)) {
                    if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                        $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                    } else {
                        $product->stock_in = "0.00";
                    }
                } else {
                    $product->stock_in = "0.00";
                }

                $package = \App\Package::find($product->package_id);
                if ($package) {
                    $product->package = $package->name;
                }

                $product_list[] = $product;
            }
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'total_page' => $products->lastPage(), 'data' => $product_list], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 200);
        }

    }

    public function all(Request $request)
    {
       $products = \App\Product::where('brand_name', 'LIKE', '%' . $request->search_names . '%')->orWhere('generic_name', 'LIKE', '%' . $request->search_names . '%')->limit(5)->get();

if (strlen($request->search_names) >= 3) {
    $product_uses = \App\Productuse::where('ProductUse_Name', 'LIKE', '%' . $request->search_names . '%')->get();

    $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $product_uses->map(function ($product_use) {
        return $product_use->ProductUse_Code;
    }))->distinct()->get(['Product_Code']);

    $product1s = \App\Product::whereIn('product_code', $productuse_details->map(function ($productuse_detail) {
        return $productuse_detail->Product_Code;
    }))->limit(5)->get();

    $products = $products->merge($product1s);
}
if (strlen($request->search_names) >= 3) {
    $group = \App\Group::where('name', 'LIKE', '%' . $request->search_names . '%')->get();
    if ($group) {
        $groupcategories_list = \App\Groupcategory::where('group_id', $group->id)->get();

        $product_group_categories = \App\ProductGroupCategories::whereIn('groupcategory_id', $groupcategories_list->map(function ($groupcategory) {
            return $groupcategory->id;
        }))->get();
        $product1s = \App\Product::whereIn('products.product_code', $product_group_categories->map(function ($product_group_category) {
            return $product_group_category->Product_Code;
        }))->limit(5)->get();

        $products = $products->merge($product1s);
    }
}

if (strlen($request->search_names) >= 3) {
    $single_groupcategory = \App\Groupcategory::where('name', 'LIKE', '%' . $request->search_names . '%')->get();

    if ($single_groupcategory) {
        $product_group_categories = \App\ProductGroupCategories::where('groupcategory_id', $single_groupcategory->id)->get();
        $product1s = \App\Product::whereIn('products.product_code', $product_group_categories->map(function ($product_group_category) {
            return $product_group_category->Product_Code;
        }))->limit(5)->get();

        $products = $products->merge($product1s);
    }

}

        $categories = \App\Category::all();
        $uses = \App\Productuse::all();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();

        if (\Auth::user()) {
            if (\Auth::user()->role == 'User') {
                return view('frontend.users.all', compact('products', 'categories', 'uses', 'groups'));
            } elseif (\Auth::user()->role == 'Chemist') {
                return view('frontend.chemists.all', compact('products', 'categories', 'uses', 'groups'));
            } else {
                return view('frontend.users.all', compact('products', 'categories', 'uses', 'groups'));
            }
        } else {
            return view('frontend.all', compact('products', 'categories', 'uses', 'groups'));
        }
    }

}
