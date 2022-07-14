<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /** Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function admindashboard()
    {
        $data['products'] = \App\Product::all();
        $data['orders'] = \App\Order::all();
        $data['offers'] = \App\Offer::all();
        $data['chemists'] = \App\Chemist::all();
        $data['states'] = \App\State::all();
        return view('backend.admindashboard', $data);
    }

    public function doctordashboard()
    {
        $data['total_pending_prescribed_orders']  =0;
        $data['petient_details']  = \App\PatientDetail::count();
        $data['total_prescribed_orders'] = \App\Order::whereNotNull('doctorappointment_id')->count();
        $data['doctor_appointments']  = \App\Doctorappointment::where('status',6)->get();
        foreach($data['doctor_appointments'] as $doctor_appointment){
            $order =\App\Order::where('doctorappointment_id',$doctor_appointment->id)->first();
            if($order){
            }else{
                $data['total_pending_prescribed_orders']  = $data['total_pending_prescribed_orders'] + 1;
            }
         
        }
        
        return view('backend.doctordashboard', $data);
    }

    public function business_operations()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('business_operations', compact('groups'));
        }
    }
    public function notification()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('notification', compact('groups'));
        }
    }

    public function competitive_strength()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('competitive_strength', compact('groups'));
        }
    }

    public function research_development()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('research_development', compact('groups'));
        }
    }

    public function prescriptions()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('prescriptions', compact('groups'));
        }
    }

    public function about_us()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('about_us', compact('groups'));
        }
    }

    public function mock_up()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('mock_up', compact('groups'));
        }
    }

    public function bdeflyer()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $main_sliders = \App\Slider::where('slider_type', '=', 'home_page_main')->get();
        if ($groups) {
            return view('bdeflyer', compact('groups', 'main_sliders'));
        }
    }

    public function terms_conditions()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('terms_conditions', compact('groups'));
        }
    }

    public function return_policy()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('return_policy', compact('groups'));
        }
    }

    public function get_latitude_longitude(Request $request)
    {
        $ip = \Request::ip();
        $ip = "103.58.40.71";
        $data = \Location::get($ip);
        $latitude_longitude = $data->latitude . ',' . $data->longitude;
        echo $latitude_longitude;
    }

    public function get_location_zip(Request $request)
    {
        $ip = \Request::ip();
        $data = \Location::get($ip);
        $pincode_issue = $request->cookie('zip_code');
        return redirect()->back()->withCookie(cookie('zip_code', $data->zipCode, 120));

        return response(redirect()->back())->cookie($cookie);
        // return response(redirect()->route('get_location_zip'))->cookie($cookie);
    }

    public function submit_zip_code(Request $request)
    {
        if ($request->pin_code) {
            $search_pincode = \App\Pincode::where('pincode',$request->pin_code)->first();
            if($search_pincode){
                $pincode_issue = $request->cookie('zip_code');
            }else{
                return redirect()->back()->with('error','Delivery is not available at this location.');
            }
            return redirect()->back()->withCookie(cookie('zip_code', $request->pin_code, 120));
        } else {
            return redirect()->back();
        }

        // return response(redirect()->route('get_location_zip'))->cookie($cookie);
    }

    public function apply_for_chemist()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $states = \App\State::with('cities')->where('country_code', '=', '1')->orderBy('name', 'ASC')->get();
        $ip = \Request::ip();
        $ip = "103.58.40.71";

        $data = \Location::get($ip);

        $latitude_longitude = $data->latitude . ',' . $data->longitude;

        if ($groups) {
            return view('apply_for_chemist', compact('groups', 'states', 'latitude_longitude'));
        }
    }

    public function search_product(Request $request)
    {

        $site_route = $request->getSchemeAndHttpHost();
        $abcd = null;
        $products = \App\Product::where('brand_name', 'LIKE', $request->search_names . '%')->orWhere('generic_name', 'LIKE', $request->search_names . '%')->limit(5)->get();
        if (strlen($request->search_names) >= 1) {
            $product1s = \App\Product::where('go_live',1)->where('brand_name', 'LIKE', '%' . $request->search_names . '%')->where('ProductBrand_Code', 2)->limit(5)->get();
            if ($product1s) {
                $products = $products->merge($product1s);
            }
            $product2s = \App\Product::where('go_live',1)->where('brand_name', 'LIKE', '%' . $request->search_names . '%')->where('ProductBrand_Code', 3)->limit(5)->get();
            if ($product1s) {
                $products = $products->merge($product2s);
            }
        }
        if (strlen($request->search_names) >= 3) {
            $ProductHashTags = \App\ProductHashTag::where('ProductHashtag_Name', 'LIKE', $request->search_names . '%')->get();
            if (count($ProductHashTags)) {
                $ProductHashTagDetails = \App\ProductHashTagDetail::whereIn('ProductHashtag_Code', $ProductHashTags->map(function ($ProductHashTag) {
                    return $ProductHashTag->ProductHashtag_Code;
                }))->get();
                $product1s = \App\Product::where('go_live',1)->whereIn('product_code', $ProductHashTagDetails->map(function ($ProductHashTagDetail) {
                    return $ProductHashTagDetail->Product_Code;
                }))->limit(5)->get();
                $products = $products->merge($product1s);
            }
        }

        if (strlen($request->search_names) >= 3) {
            $product_uses = \App\Productuse::where('ProductUse_Name', 'LIKE', $request->search_names . '%')->get();
            if (count($product_uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $product_uses->map(function ($product_use) {
                    return $product_use->ProductUse_Code;
                }))->distinct()->get(['Product_Code']);

                $product1s = \App\Product::where('go_live',1)->whereIn('product_code', $productuse_details->map(function ($productuse_detail) {
                    return $productuse_detail->Product_Code;
                }))->limit(5)->get();

                $products = $products->merge($product1s);

            }

        }
        if (strlen($request->search_names) >= 3) {
            $group = \App\Group::where('name', 'LIKE', $request->search_names . '%')->first();
            if ($group) {
                $groupcategories_list = \App\Groupcategory::where('group_id', $group->id)->get();

                $product_group_categories = \App\ProductGroupCategories::whereIn('groupcategory_id', $groupcategories_list->map(function ($groupcategory) {
                    return $groupcategory->id;
                }))->get();
                $product1s = \App\Product::where('products.go_live',1)->whereIn('products.product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->limit(5)->get();

                $products = $products->merge($product1s);
            }
        }

        if (strlen($request->search_names) >= 3) {
            $single_groupcategory = \App\Groupcategory::where('name', 'LIKE', $request->search_names . '%')->first();

            if ($single_groupcategory) {
                $product_group_categories = \App\ProductGroupCategories::where('groupcategory_id', $single_groupcategory->id)->get();

                $product1s = \App\Product::where('products.go_live',1)->whereIn('products.product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->limit(5)->get();

                $products = $products->merge($product1s);
            }

        }

        // if (strlen($request->search_names) >= 3) {
        //     $comparative_products = \App\ComparativeProduct::where('product_name', 'LIKE', '%' . $request->search_names . '%')->get();
        //     $product1s = \App\Product::whereIn('product_code', $comparative_products->map(function ($comparative_product) {
        //         return $comparative_product->product_code;
        //     }))->limit(5)->get();
        //     $products = $products->merge($product1s);

        // }

        foreach ($products as $product) {
            if($product->go_live==1){


            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
            if ($product_image) {
                $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }

            $group = \App\Group::find($product->group_id);
            $group_category = \App\Groupcategory::find($product->groupcategory_id);
            if ($product->ProductBrand_Code == 1) {
                $product_name = $product->generic_name . " (" . $product->brand_name . ")";
            } else {
                $product_name = $product->brand_name;

            }

            if (\Auth::user()) {

                if (\Auth::user()->role == 'Chemist') {
                    if ($product->chemist_price) {
                        $purchase_price = $product->chemist_price->Price;
                    } else {
                        $purchase_price = 0;
                    }
                    $abcd .= "<li>
                               <a href='" . $site_route . "/" . $group->url_name . "/" . $group_category->url_name . "/" . $product->url_name . "'>
                                                <div class='row'>
                                                    <div class='col-1 p-0'>
                                                        <img src='" . $product->image . "' alt='' class='w-100'>
                                                    </div>
                                                    <div class='col-6'>
                                                        <h4>" . $product_name . "</h4>
                                                    </div>
                                                    <div class='item-prices col-4  text-right'>
                                                        <div class='discount-val'><span id=''>Purchase Price <i class='fa fa-inr'></i>" . number_format($purchase_price, 2, '.', '') . "</span></div>
                                                        <div class='add-shopping'><img src='" . $site_route . "/img/icons/shopping-bag.png' alt='' onclick='add_cart_from_search({$product->id},{$purchase_price})'></div>
                                                    </div>
                                                </div>
                                            </a>
                            </li>";
                } else {
                    if ($product->customer_price) {
                        $current_price = $product->customer_price->Price + ($product->customer_price->Price * $product->customer_price->GST) / 100;
                        if ($product->sales_schame_customer) {
                            $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                            $purchase_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                        } else {
                            $purchase_price = $current_price;
                        }
                     } else {
                        $purchase_price = 0;
                    }
                    $abcd .= "<li>
                                <a href='" . $site_route . "/" . $group->url_name . "/" . $group_category->url_name . "/" . $product->url_name . "'>
                                                <div class='row'>
                                                    <div class='col-1 p-0'>
                                                       <img src='" . $product->image . "' alt='' class='w-100'>
                                                    </div>
                                                    <div class='col-6'>
                                                        <h4>" . $product_name . "</h4>
                                                    </div>
                                                    <div class='item-prices col-4  text-right'>
                                                        <div class='discount-val'><span id=''>Price <i class='fa fa-inr'></i>" . number_format($purchase_price, 2, '.', '') . "</span></div>
                                                         <div class='add-shopping'><img src='" . $site_route . "/img/icons/shopping-bag.png' alt='' onclick='add_cart_from_search({$product->id},{$purchase_price},0,1)'></div>
                                                    </div>
                                                </div>
                                            </a>
                            </li>";
                }

            } else {
                if ($product->customer_price) {
                    $current_price = $product->customer_price->Price + ($product->customer_price->Price * $product->customer_price->GST) / 100;
                    if ($product->sales_schame_customer) {
                        $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                        $purchase_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                    } else {
                        $purchase_price = $current_price;
                    }
                 } else {
                    $purchase_price = 0;
                }

                $abcd .= "<li>
                       <a href='" . $site_route . "/" . $group->url_name . "/" . $group_category->url_name . "/" . $product->url_name . "'>
                                                <div class='row'>
                                                    <div class='col-1 p-0'>
                                                        <img src='" . $product->image . "' alt='' class='w-100 img-responsive'>
                                                    </div>
                                                    <div class='col-6'>
                                                        <h4 style='display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
text-overflow: ellipsis;'>" . $product_name . "</h4>
                                                    </div>
                                                    <div class='item-prices col-4  text-right'>
                                                        <div class='discount-val'><span id=''>Price <i class='fa fa-inr'></i>" . number_format($purchase_price, 2, '.', '') . "</span></div>
                                                         <div class='add-shopping'><img src='" . $site_route . "/img/icons/shopping-bag.png' alt='' onclick='add_cart_from_search({$product->id},{$purchase_price})'></div>
                                                    </div>
                                                </div>
                                            </a>
                            </li>";
            }
        }
        }
        $cd = "";
        $cd = "<ul class='list-unstyled' >" . $abcd . "</ul>";
        return response()->json(['status' => true, 'data' => $cd], 200);

    }

    public function index(Request $request)
    {

        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $nestor_products = \App\Product::where('ProductBrand_Code', 1)->limit('10')->get();
        $steriheal_products = \App\Product::where('ProductBrand_Code', 2)->limit('10')->get();
        $nectarine_products = \App\Product::where('ProductBrand_Code', 3)->limit('10')->get();
        $popular_products = \App\Product::whereIn('product_code',['3272','6671','6670','6679','6678','3253','6674','6681','6677','3158'])->get();

        $similer_products = \App\Product::whereIn('product_code',['3272','6671','6670','6679','6678','3253','6674','6681','6677','3158'])->get();

        $healthareas_groupcategories = \App\Groupcategory::where('is_home', '=', 1)->get();
        $main_sliders = \App\Slider::whereNotNull('sn')->where('slider_type', '=', 'home_page_main')->orderBy('sn','ASC')->get();
        $mobile_sliders = \App\Slider::whereNotNull('mobile_image')->get();

        $second_top_mail_sliders = \App\Slider::where('slider_type', '=', 'home_page_second_top')->get();
        $home_page_similars = \App\Slider::where('slider_type', '=', 'home_page_similar')->get();
        $home_page_trendings = \App\Slider::where('slider_type', '=', 'home_page_trending')->get();
        $offers = \App\Offer::all();

        if (\Auth::user()) {
            if (\Auth::user()->role == 'User') {
                return view('frontend.users.home', compact('home_page_trendings', 'home_page_similars', 'nestor_products', 'steriheal_products', 'nectarine_products', 'similer_products', 'groups', 'second_top_mail_sliders', 'main_sliders', 'offers', 'healthareas_groupcategories', 'mobile_sliders'));
            } elseif (\Auth::user()->role == 'Chemist') {
                return view('frontend.chemists.home', compact('home_page_trendings', 'home_page_similars', 'nestor_products', 'steriheal_products', 'nectarine_products', 'similer_products', 'groups', 'second_top_mail_sliders', 'main_sliders', 'offers', 'healthareas_groupcategories', 'mobile_sliders'));
            } else {
                return view('frontend.home', compact('home_page_trendings', 'home_page_similars', 'nestor_products', 'steriheal_products', 'nectarine_products', 'similer_products', 'groups', 'second_top_mail_sliders', 'main_sliders', 'offers', 'healthareas_groupcategories', 'mobile_sliders'));
            }
        } else {
            $value = request()->cookie('add_cart');
            $check_add_to_cart_datas = json_decode($value);
            return view('frontend.home', compact('home_page_trendings', 'home_page_similars', 'popular_products', 'similer_products', 'groups', 'second_top_mail_sliders', 'main_sliders', 'offers', 'healthareas_groupcategories', 'check_add_to_cart_datas', 'nestor_products', 'steriheal_products', 'nectarine_products', 'mobile_sliders'));
        }
    }

}