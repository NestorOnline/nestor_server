<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class FrontendController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function scanner_page()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if ($groups) {
            return view('frontend.scanner_page', compact('groups'));
        }
    }

    public function group_page(Request $request, $request_group_name)
    {
        $single_group = \App\Group::where('url_name', '=', $request_group_name)->first();
        $groupcategories_list = \App\Groupcategory::where('group_id', '=', $single_group->id)->get();
        $product_group_categories = \App\ProductGroupCategories::whereIn('groupcategory_id', $groupcategories_list->map(function ($groupcategory) {
            return $groupcategory->id;
        }))->get();

        $categories = \App\Category::all();
        $uses = \App\Productuse::all();
        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                if ($request->sort == 'ASC') {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                        ->where('productprice.ProductPriceType_Code', '=', '7')
                        ->orderBy('productprice.Price', 'ASC')
                        ->select('products.*')
                        ->with('productprices')
                        ->paginate(20);
                } elseif ($request->sort == 'DESC') {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                        ->where('productprice.ProductPriceType_Code', '=', '7')
                        ->orderBy('productprice.Price', 'DESC')
                        ->select('products.*')
                        ->with('productprices')
                        ->paginate(20);
                } else {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->paginate(20);
                }
            } else {
                if ($request->sort == 'ASC') {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                        ->where('productprice.ProductPriceType_Code', '=', '9')
                        ->orderBy('productprice.Price', 'ASC')
                        ->select('products.*')
                        ->with('productprices')
                        ->paginate(20);
                } elseif ($request->sort == 'DESC') {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                        ->where('productprice.ProductPriceType_Code', '=', '9')
                        ->orderBy('productprice.Price', 'DESC')
                        ->select('products.*')
                        ->with('productprices')
                        ->paginate(20);
                } else {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->paginate(20);
                }
            }
        } else {
            if ($request->sort == 'ASC') {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', '9')
                    ->orderBy('productprice.Price', 'ASC')
                    ->select('products.*')
                    ->with('productprices')
                    ->paginate(20);
            } elseif ($request->sort == 'DESC') {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', '9')
                    ->orderBy('productprice.Price', 'DESC')
                    ->select('products.*')
                    ->with('productprices')
                    ->paginate(20);
            } else {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->paginate(20);
            }
        }

        $main_sliders = \App\Slider::where('slider_type', '=', 'group_page')->where('group_id', '=', $request->group_id)->get();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();

        if ($single_group) {
            if (\Auth::user()) {
                if (\Auth::user()->role == 'User') {
                    return view('frontend.users.group_page', compact('uses', 'categories', 'main_sliders', 'single_group', 'products', 'groups'));
                } elseif (\Auth::user()->role == 'Chemist') {

                    return view('frontend.chemists.group_page', compact('uses', 'categories', 'main_sliders', 'products', 'single_group', 'groups'));
                } else {
                    return view('frontend.group_page', compact('uses', 'categories', 'main_sliders', 'single_group', 'products', 'groups'));
                }
            } else {
                return view('frontend.group_page', compact('uses', 'categories', 'main_sliders', 'single_group', 'products', 'groups'));
            }
        }
        return redirect()->back();
    }

    public function group_testing_page(Request $request)
    {

        $order = \App\Order::with('orderproducts')->find(353);

        $OrderDetails = [
            "id" => 489,
            "Order_No" => "NSRID-489",
            "Order_Code" => null,
            "Order_Date" => "2021-07-26 13:33:51",
            "Party_ID" => 7,
            "Party_Code" => 67141,
            "Party_Name" => "Chemist Name",
            "GSTIN" => "06AAACN1547Q1Z6",
            "Address1" => "Address 1",
            "Address2" => "address 2",
            "Address3" => "address 3",
            "PIN" => 844118,
            "City_Code" => 433,
            "State_Code" => 11,
            "Mobile_No" => "6264534669",
            "Product_Amount" => "1449.29",
            "Discount_Amount" => "0.00",
            "Taxable_Amount" => "1449.29",
            "Tax_Amount" => "173.91",
            "Delivery_Amount" => "50.00",
            "Grand_Total" => "1673.20",
            "WalletAmount" => "0.00",
            "Payment_Status" => "TXN_SUCCESS",
            "Payment_Amount" => "1673.20",
            "Return_Amount" => null,
            "OrderStatus_Code" => 5,
            "Shipment_ID" => null,
            "AWB_Code" => null,
            "Courier_Company_ID" => null,
            "Invoice_Code" => null,
            "UpdatedBy" => null,
            "Updated_Date" => null,
            "ExpectedOn" => null,
            "ProcessingOn" => null,
            "PackedOn" => null,
            "DispatchedOn" => null,
            "DeliveredOn" => null,
            "ReturnRequested" => null,
            "ReturnApproval" => null,
            "Refund" => null,
            "OrderFrom_Code" => 2,
            "Office_Code" => 1,
            "Testing_Order" => "1",
            "is_update" => 0,
            "orderproducts" => [
                [
                    "id" => 827,
                    "Order_Id" => 489,
                    "Product_Code" => 714,
                    "MRP" => "240.00",
                    "Rate" => "45.00",
                    "Order_Qty" => 2,
                    "Free_Qty" => null,
                    "Amount" => "90",
                    "Discount" => null,
                    "Taxable" => "90.00",
                    "TaxRate" => "12.00",
                    "Tax" => "10.8",
                    "Total" => "100.8",
                ],
                [
                    "id" => 828,
                    "Order_Id" => 489,
                    "Product_Code" => 2044,
                    "MRP" => "250.00",
                    "Rate" => "73.83",
                    "Order_Qty" => 2,
                    "Free_Qty" => null,
                    "Amount" => "147.66",
                    "Discount" => null,
                    "Taxable" => "147.66",
                    "TaxRate" => "12.00",
                    "Tax" => "17.7192",
                    "Total" => "165.3792",
                ],
                [
                    "id" => 829,
                    "Order_Id" => 489,
                    "Product_Code" => 2045,
                    "MRP" => "450.00",
                    "Rate" => "132.00",
                    "Order_Qty" => 1,
                    "Free_Qty" => 0,
                    "Amount" => "132",
                    "Discount" => null,
                    "Taxable" => "132.00",
                    "TaxRate" => "12.00",
                    "Tax" => "15.84",
                    "Total" => "147.84",
                ],
                [
                    "id" => 830,
                    "Order_Id" => 489,
                    "Product_Code" => 2051,
                    "MRP" => "20.50",
                    "Rate" => "12.63",
                    "Order_Qty" => 1,
                    "Free_Qty" => null,
                    "Amount" => "12.63",
                    "Discount" => null,
                    "Taxable" => "12.63",
                    "TaxRate" => "12.00",
                    "Tax" => "1.5156",
                    "Total" => "14.1456",
                ],
                [
                    "id" => 831,
                    "Order_Id" => 489,
                    "Product_Code" => 2568,
                    "MRP" => "555.00",
                    "Rate" => "65.00",
                    "Order_Qty" => 1,
                    "Free_Qty" => null,
                    "Amount" => "65",
                    "Discount" => null,
                    "Taxable" => "65.00",
                    "TaxRate" => "12.00",
                    "Tax" => "7.8",
                    "Total" => "72.8",
                ],
                [
                    "id" => 832,
                    "Order_Id" => 489,
                    "Product_Code" => 2897,
                    "MRP" => "280.00",
                    "Rate" => "204.00",
                    "Order_Qty" => 1,
                    "Free_Qty" => null,
                    "Amount" => "204",
                    "Discount" => null,
                    "Taxable" => "204.00",
                    "TaxRate" => "12.00",
                    "Tax" => "24.48",
                    "Total" => "228.48",
                ],
                [
                    "id" => 833,
                    "Order_Id" => 489,
                    "Product_Code" => 2751,
                    "MRP" => "550.00",
                    "Rate" => "399.00",
                    "Order_Qty" => 2,
                    "Free_Qty" => null,
                    "Amount" => "798",
                    "Discount" => null,
                    "Taxable" => "798.00",
                    "TaxRate" => "12.00",
                    "Tax" => "95.76",
                    "Total" => "893.76",
                ],
            ],
        ];
        $data['OrderDetails'] = json_encode($order);
        $data['API_KEY'] = 'fdAu52PaUI1';
        $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);
        $url = "http://nestorpharmaceuticals.in/API/NestorOnline.asmx/OrderAdd";
//    $url = "http://demotictechnologies.in/check_ajax_api";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

// In real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS,
        //          http_build_query(array('postvar1' => 'value1')));

// Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $server_output = curl_exec($ch);
        if ($server_output) {
            dd(json_decode(substr($server_output, 0, 92), true)['Reference_Code']);
        }
        curl_close($ch);
        dd(json_decode($json, true));

        $chemist = \App\Chemist::find(7);
        $PartyDetails = ['Party_Code' => $chemist->Party_Code, 'PartyType_Code' => $chemist->PartyType_Code, 'Party_ID' => $chemist->Party_ID, 'GPS' => $chemist->Geolocation, 'Party_Name' => $chemist->Party_Name, 'Address1' => $chemist->Address1, 'Address2' => $chemist->Address2, 'Address3' => $chemist->Address3, 'City_Code' => $chemist->City_Code, 'City_Name' => $chemist->City_Code, 'State_Code' => $chemist->State_Code, 'State_Name' => $chemist->State_Code, 'PIN' => $chemist->PIN, 'Phone' => $chemist->Phone, 'DL_No' => $chemist->DL_No, 'PAN_No' => null, 'GSTIN' => $chemist->GSTIN, 'Contact_Person' => $chemist->Contact_Person, 'Mobile_No' => $chemist->Mobile_No, 'Email' => $chemist->Email_ID, 'Transporter_Code' => 0, 'Transporter_Name' => null, 'Territory_Code' => 0, 'Territory_Name' => null, 'TPArea_Code' => 0, 'Area_Code' => 0, 'Area_Name' => null, 'DistanceFromCity' => 0, 'Photos' => null, 'LastVisit_Date' => null, 'LastInvoice_Date' => null, 'LastGoodsReceipt_Date' => null, 'LastInvoice_Value' => 0, 'OutStanding_Value' => null, 'ApprovalStatus_Code' => 0, 'Upload_Status' => 0, 'CreatedBy' => 0, 'Created_Date' => null];
        $data = [];
        $data['PartyDetails'] = json_encode($PartyDetails);
        $data['API_KEY'] = 'fdAu52PaUI1';
//   $data['PartyDetails']="{'Party_Code':1,'PartyType_Code':13,'Party_ID':101,'GPS':null,'Party_Name':'Test','Address1':'AddressLine1','Address2':'AddressLine2','Address3':'AddressLine3','City_Code':1,'City_Name':null,'State_Code':0,'State_Name':null,'PIN':null,'Phone':null,'DL_No':null,'PAN_No':null,'GSTIN':null,'Contact_Person':null,'Mobile_No':null,'Email':null,'Transporter_Code':0,'Transporter_Name':null,'Territory_Code':0,'Territory_Name':null,'TPArea_Code':0,'Area_Code':0,'Area_Name':null,'DistanceFromCity':0,'Photos':null,'LastVisit_Date':null,'LastInvoice_Date':null,'LastGoodsReceipt_Date':null,'LastInvoice_Value':0,'OutStanding_Value':null,'ApprovalStatus_Code':0,'Upload_Status':0,'CreatedBy':0,'Created_Date':null}";
        $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);

        $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/PartyAdd";
//    $url = "http://demotictechnologies.in/check_ajax_api";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

// In real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS,
        //          http_build_query(array('postvar1' => 'value1')));

// Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $server_output = curl_exec($ch);
        var_dump($server_output);
        curl_close($ch);

        //        $ch = curl_init();
        //  $data1 = http_build_query($data);

        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_URL, "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/PartyAdd");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_POST, 1);

        // $output = curl_exec($ch);
        //    dd($output);
    }

    public function groupcategory_page(Request $request, $group_url_name, $groupcategory_url_name)
    {

        $page_no = "";
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $single_group = \App\Group::where('url_name', '=', $group_url_name)->first();
        $single_groupcategory = \App\Groupcategory::where('group_id', '=', $single_group->id)->where('url_name', '=', $groupcategory_url_name)->first();
        $product_group_categories = \App\ProductGroupCategories::where('groupcategory_id', $single_groupcategory->id)->get();

        $categories = \App\Category::all();
        $uses = \App\Productuse::all();
        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                if ($request->sort == 'ASC') {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                        ->where('productprice.ProductPriceType_Code', '=', '7')
                        ->orderBy('productprice.Price', 'ASC')
                        ->select('products.*')
                        ->with('productprices')
                        ->paginate(20);
                } elseif ($request->sort == 'DESC') {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                        ->where('productprice.ProductPriceType_Code', '=', '7')
                        ->orderBy('productprice.Price', 'DESC')
                        ->select('products.*')
                        ->with('productprices')
                        ->paginate(20);
                } else {

                    $products = \App\Product::where('groupcategory_id', '=', $single_groupcategory->id)
                        ->paginate(20);
                }
            } else {
                if ($request->sort == 'ASC') {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                        ->where('productprice.ProductPriceType_Code', '=', '9')
                        ->orderBy('productprice.Price', 'ASC')
                        ->select('products.*')
                        ->with('productprices')
                        ->paginate(20);
                } elseif ($request->sort == 'DESC') {
                    $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                        ->where('productprice.ProductPriceType_Code', '=', '9')
                        ->orderBy('productprice.Price', 'DESC')
                        ->select('products.*')
                        ->with('productprices')
                        ->paginate(20);
                } else {
                    $products = \App\Product::where('groupcategory_id', '=', $single_groupcategory->id)
                        ->paginate(20);
                }
            }
        } else {
            if ($request->sort == 'ASC') {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', '9')
                    ->orderBy('productprice.Price', 'ASC')
                    ->select('products.*')
                    ->with('productprices')
                    ->paginate(20);
            } elseif ($request->sort == 'DESC') {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', '9')
                    ->orderBy('productprice.Price', 'DESC')
                    ->select('products.*')
                    ->with('productprices')
                    ->paginate(20);
            } else {
                $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->paginate(20);
            }
        }

        $main_sliders = \App\Slider::where('slider_type', '=', 'group_category_page')->where('groupcategory_id', '=', $request->groupcategory_id)->get();
        if ($single_groupcategory) {
            if (\Auth::user()) {
                if (\Auth::user()->role == 'User') {
                    return view('frontend.users.groupcategory_page', compact('uses', 'categories', 'main_sliders', 'single_group', 'single_groupcategory', 'products', 'groups'));
                } elseif (\Auth::user()->role == 'Chemist') {
                    return view('frontend.chemists.groupcategory_page', compact('uses', 'categories', 'main_sliders', 'single_group', 'single_groupcategory', 'products', 'groups'));
                } else {
                    return view('frontend.groupcategory_page', compact('uses', 'categories', 'main_sliders', 'single_group', 'single_groupcategory', 'products', 'groups', 'single_group'));
                }
            } else {
                return view('frontend.groupcategory_page', compact('uses', 'categories', 'main_sliders', 'single_group', 'single_groupcategory', 'products', 'groups', 'single_group'));
            }
        }
        return redirect()->back();
    }

    public function apply_for_chemist_store(Request $request)
    {

        $this->validate($request, [
            'chemist_name' => 'required',
            'contact_person' => 'required',
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'confirmation_password' => 'required|same:password',
            'drug_license_no' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);

        $user = \App\User::create([
            'mobile' => $request->input('mobile'),
            'role' => 'Chemist',
            'password' => bcrypt($request->input('password')),
            'status' => 'not_verify',
            'landmark' => $request->input('landmark'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'wallet' => 1000,
        ]);

        $chemist = \App\Chemist::create([
            'chemist_name' => $request->input('chemist_name'),
            'user_id' => $user->id,
            'contact_person' => $request->input('contact_person'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'drug_license_no' => $request->input('drug_license_no'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'gst' => $request->input('gst'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'status' => 'Deactivate',
        ]);

        $address = \App\Address::create([
            'full_name' => $request->input('chemist_name'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'pincode' => $request->input('pincode'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'phone_no' => $request->input('mobile'),
            'locality' => $request->input('locality'),
            'landmark' => $request->input('landmark'),
            'is_work' => 'on',
            'set_as_a_current' => 'Yes',
            'set_as_a_default' => 'No',
            'user_id' => \Auth::user()->id,
        ]);

        Auth::login($user);
        $abc = \Auth::user();

        if ($abc) {
            $add_cart = request()->cookie('add_cart');
            $add_cart_datas = json_decode($add_cart);
            if ($add_cart_datas) {
                foreach ($add_cart_datas as $add_cart_data) {
                    $product = \App\Product::find($add_cart_data->product_id);
                    $add_cart_data->amount = $product->chemist_amount;
                    $product1[] = $add_cart_data;
                }
                $array_json = json_encode($product1);
                $cookie = cookie('add_cart', $array_json, 4500);
                return redirect()->route('home')->cookie($cookie);
            }
            session()->flash('success', 'New Chemist is create Successfully');
            return redirect()->back();
        }
    }

    public function product_detail($group_url_name, $groupcategory_url_name, $brand_name)
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $value = request()->cookie('add_cart');
        $add_cart_datas = json_decode($value);

        $product = \App\Product::where('url_name', '=', $brand_name)->first();
        $comparative_products = \App\ComparativeProduct::where('product_id', '=', $product->id)->get();
        $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product->product_code)->first();
        if ($product->ProductUse_Code) {
            $products = \App\Product::where('id', '!=', $product->id)->where('ProductUse_Code', '=', $product->ProductUse_Code)->get();
        } else {
            $products = [];
        }

        $descriptiontypes = \App\Descriptiontype::all();
        $user = \Auth::user();

        if (\Auth::user()) {
            if (\Auth::user()->role == 'User') {
                return view('frontend.users.product_detail', compact('user', 'sales_scheme', 'descriptiontypes', 'products', 'product', 'groups', 'comparative_products'));
            } elseif (\Auth::user()->role == 'Chemist') {
                return view('frontend.chemists.product_detail', compact('user', 'sales_scheme', 'descriptiontypes', 'products', 'product', 'groups', 'comparative_products'));
            } else {
                return view('frontend.product_detail', compact('user', 'sales_scheme', 'descriptiontypes', 'products', 'product', 'groups', 'comparative_products'));
            }
        } else {
            return view('frontend.product_detail', compact('user', 'sales_scheme', 'descriptiontypes', 'products', 'product', 'groups', 'comparative_products'));
        }
    }

    public function checkout_upload_prescription(Request $request)
    {

        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $add_to_cards = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        $order_setting = \App\OrderSetting::orderBy('id', 'ASC')->first();
        $add_to_card_total = 0;
        $is_precription_required = null;
        foreach ($add_to_cards as $add_to_card) {
            $add_to_card_total = $add_to_card_total + $add_to_card->amount * $add_to_card->Qty + $add_to_card->amount * $add_to_card->Qty * 12 / 100;
            $product = \App\Product::find($add_to_card->product_id);
            if ($product->Prescription_Required == 1) {
                $is_precription_required = 1;
            }
        }

        foreach ($add_to_cards as $add_to_card) {
            $add_to_card_total = $add_to_card_total + $add_to_card->amount * $add_to_card->Qty + $add_to_card->amount * $add_to_card->Qty * 12 / 100;
        }
        $add_to_card_total = $add_to_card_total + 50;
        $host = request()->getHost();

        $wallet = 0;
        if (\Auth::user()) {
            if (\Auth::user()->wallet > 500) {
                $wallet = 500;
            } else {
                $wallet = \Auth::user()->wallet;
            }
        }
        if (\Auth::user()) {
            if (\Auth::User()->role == 'Chemist' && $add_to_card_total < $order_setting->MinimumOrderValueForChemist) {

                session()->flash('error', 'Minmum Order Value is ' . $order_setting->MinimumOrderValueForChemist . '');

                return redirect()->route('frontend.cart');
            } elseif (\Auth::User()->role == 'User' && $add_to_card_total < $order_setting->MinimumOrderValueForCustomer) {
                session()->flash('error', 'Minmum Order Value is ' . $order_setting->MinimumOrderValueForCustomer . '');
                return redirect()->route('frontend.cart');
            } else {

            }
            $address = \App\Address::where('user_id', '=', \Auth::user()->id)->where('set_as_a_current', '=', 'Yes')->first();

            if (\Auth::user()->role == 'User') {
                if ($is_precription_required == 1) {
                    return view('frontend.users.checkout_upload_prescription', compact('address', 'host', 'add_to_cards', 'wallet', 'groups'));
                } else {
                    return redirect()->route('frontend.checkout');
                }

                return view('frontend.users.checkout_upload_prescription', compact('address', 'host', 'add_to_cards', 'wallet', 'groups'));
            } elseif (\Auth::user()->role == 'Chemist') {
                return view('frontend.chemists.checkout_upload_prescription', compact('address', 'host', 'add_to_cards', 'wallet', 'groups'));
            } else {
                return view('frontend.checkout_upload_prescription', compact('address', 'host', 'groups'));
            }
        } else {
            return view('frontend.checkout_upload_prescription', compact('address', 'host', 'groups'));
        }
        return view('frontend.checkout_upload_prescription', compact('address', 'host', 'add_to_cards', 'groups', 'wallet'));
    }

    public function checkout_upload_prescription_store(Request $request)
    {

        if ($request->free_doctor_consult) {

        } else {
            $this->validate($request, [
                'upload_prescription' => 'required',
            ]);
        }
        $chemist = \App\Chemist::where('user_id', \Auth::user()->id)->first();
        $doctor_consult = \App\DoctorConsult::create([
            'Party_Code' => $chemist->Party_Code,
            'free_doctor_consult' => $request->input('free_doctor_consult'),
            'user_id' => \Auth::user()->id,
        ]);
        if (isset($request->upload_prescription)) {
            foreach ($request->file('upload_prescription') as $upload_prescription_file) {
                $image = $upload_prescription_file;
                $filename = $image->getClientOriginalName();
                $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
                $image->move("upload", $fullname);
                $upload_prescription_files[] = 'upload/' . $fullname;
            }
            $str_upload_prescription = implode(",", $upload_prescription_files);
            $doctor_consult->upload_prescription = $str_upload_prescription;
            $doctor_consult->save();
        }
        $cookie = cookie('DoctorConsult', $doctor_consult->id, 120);
        return redirect()->route('frontend.checkout')->cookie($cookie);
    }

    public function checkout(Request $request)
    {

        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $add_to_cards = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        $order_setting = \App\OrderSetting::orderBy('id', 'ASC')->first();
        $add_to_card_total = 0;
        foreach ($add_to_cards as $add_to_card) {
            $add_to_card_total = $add_to_card_total + $add_to_card->amount * $add_to_card->Qty + $add_to_card->amount * $add_to_card->Qty * 12 / 100;
        }

        $add_to_card_total = $add_to_card_total + 50;
        $host = request()->getHost();

        $wallet = 0;
        if (\Auth::user()) {
            if (\Auth::user()->wallet > 500) {
                $wallet = 500;
            } else {
                $wallet = \Auth::user()->wallet;
            }
        }
        $address = \App\Address::where('user_id', '=', \Auth::user()->id)->where('set_as_a_current', '=', 'Yes')->first();

        if (\Auth::user()) {
            if (\Auth::User()->role == 'Chemist' && $add_to_card_total < $order_setting->MinimumOrderValueForChemist) {

                session()->flash('error', 'Minmum Order Value is ' . $order_setting->MinimumOrderValueForChemist . '');

                return redirect()->route('frontend.cart');
            } elseif (\Auth::User()->role == 'User' && $add_to_card_total < $order_setting->MinimumOrderValueForCustomer) {
                session()->flash('error', 'Minmum Order Value is ' . $order_setting->MinimumOrderValueForCustomer . '');
                return redirect()->route('frontend.cart');
            } else {

            }

            if (\Auth::user()->role == 'User') {
                return view('frontend.users.checkout', compact('address', 'host', 'add_to_cards', 'wallet', 'groups'));

            } elseif (\Auth::user()->role == 'Chemist') {
                return view('frontend.chemists.checkout', compact('address', 'host', 'add_to_cards', 'wallet', 'groups'));
            } else {
                return view('frontend.checkout', compact('address', 'host', 'groups'));
            }
        } else {
            return view('frontend.checkout', compact('address', 'host', 'groups'));
        }
        return view('frontend.checkout', compact('address', 'host', 'add_to_cards', 'groups', 'wallet'));
    }

    public function cart(Request $request)
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $value = request()->cookie('add_cart');
        $add_cart_datas = json_decode($value);

        $order_setting = \App\OrderSetting::orderBy('id', 'ASC')->first();
        $wallet = 0;
        if (\Auth::user()) {
            if (\Auth::user()->wallet > 500) {
                $wallet = 500;
            } else {
                $wallet = \Auth::user()->wallet;
            }
        }

        if (\Auth::user()) {
            if (\Auth::user()->role == 'User') {
                return view('frontend.users.cart', compact('add_cart_datas', 'groups', 'wallet', 'order_setting'));
            } elseif (\Auth::user()->role == 'Chemist') {

                return view('frontend.chemists.cart', compact('add_cart_datas', 'groups', 'wallet', 'order_setting'));
            } else {
                if ($add_cart_datas) {

                } else {
                    $add_cart_datas = [];
                }
                return view('frontend.cart', compact('add_cart_datas', 'groups', 'wallet', 'order_setting'));
            }
        } else {
            if ($add_cart_datas) {

            } else {
                $add_cart_datas = [];
            }

            return view('frontend.cart', compact('add_cart_datas', 'groups', 'wallet', 'order_setting'));
        }

        return redirect()->back();
    }

    public function pincode_check(Request $request)
    {
        $pincode = \App\Pincode::where('pincode', '=', $request->pincode)->get();
        if (count($pincode)) {
            $delivery_date = date("Y-m-d", strtotime("+4  day"));
            echo "Delivery by " . date("y M D", strtotime("+4  day")) . " | Free ₹50";
        } else {
            echo "Delivery Not Available";
        }
    }

    public function order_tracking(Request $request)
    {
        dd($request->all());
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('frontend.order_tracking', compact('groups'));
    }

    public function show_pagination_filter_data(Request $request)
    {
        $main_sliders = \App\Slider::where('slider_type', '=', 'group_page')->where('group_id', '=', $request->group_id)->get();

        $single_group = \App\Group::find($request->group_id);
        if ($request->groupcategory_id) {
            $single_groupcategory = \App\Groupcategory::find($request->groupcategory_id);
        } else {
            $single_groupcategory = null;
        }
        $categories = \App\Category::all();
        $uses = \App\Productuse::all();

        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                $price_code = 7;
            } else {
                $price_code = 9;
            }
        } else {
            $price_code = 9;
        }
        if ($request->groupcategory_id) {
            if (isset($request->category) && isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category) && isset($request->prescription_required)) {
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('ProductUse_Code', $request->uses)
                    ->whereIn('Prescription_Required', $request->prescription_required)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses) && isset($request->category)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('category_id', $request->category)
                    ->whereIn('ProductUse_Code', $request->uses)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category)) {
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('category_id', $request->category)
                    ->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->orderBy('id', 'DESC')->paginate(20);

            } else if (isset($request->prescription_required)) {
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses)) {

                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);

            } else {
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->where('productprice.Price', '<=', number_format($request->maxval, 2, '.', ''))
                    ->where('productprice.Price', '>=', number_format($request->minval, 2, '.', ''))
                    ->select('products.*')->paginate(20);

            }
        } else if ($request->group_id) {
            if (isset($request->category) && isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category) && isset($request->prescription_required)) {
                $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('group_id', $request->group_id)->whereIn('ProductUse_Code', $request->uses)
                    ->whereIn('Prescription_Required', $request->prescription_required)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses) && isset($request->category)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                    ->whereIn('ProductUse_Code', $request->uses)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category)) {
                $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                    ->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->orderBy('id', 'DESC')->paginate(20);

            } else if (isset($request->prescription_required)) {
                $products = \App\Product::where('group_id', $request->group_id)->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses)) {

                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('group_id', $request->group_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);

            } else {
                $products = \App\Product::where('group_id', $request->group_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
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
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

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
                    ->select('products.*')->orderBy('id', 'DESC')->paginate(100);

            } else if (isset($request->prescription_required)) {
                $products = \App\Product::whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if ($request->uses) {

                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
                $products = \App\Product::join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(100);

            } else {
                $products = \App\Product::join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->where('productprice.Price', '<=', number_format($request->maxval, 2, '.', ''))
                    ->where('productprice.Price', '>=', number_format($request->minval, 2, '.', ''))
                    ->select('products.*')->paginate(20);
            }
        }

        $products->appends(['groupcategory_id' => $request->groupcategory_id,
            'group_id' => $request->group_id,
            'category' => $request->category,
            'groupcategory_id' => $request->groupcategory_id,
            'ProductUse_Code' => $request->ProductUse_Code,
            'uses' => $request->uses,
            'maxval' => $request->maxval,
            'minval' => $request->minval]);

        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();

        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                return view('frontend.chemists.show_pagination_filter_data', compact('products', 'groups', 'single_group', 'single_groupcategory', 'categories', 'uses', 'main_sliders'));
            } elseif (\Auth::user()->role == 'User') {
                return view('frontend.users.show_pagination_filter_data', compact('products', 'groups', 'single_group', 'single_groupcategory', 'categories', 'uses', 'main_sliders'));
            } else {
                return view('frontend.show_pagination_filter_data', compact('products', 'groups', 'single_group', 'single_groupcategory', 'categories', 'uses', 'main_sliders'));
            }
        } else {
            return view('frontend.show_pagination_filter_data', compact('products', 'groups', 'single_group', 'single_groupcategory', 'categories', 'uses', 'main_sliders'));
        }
    }

    public function sidebar_filter_data(Request $request)
    {
        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                $price_code = 7;
            } else {
                $price_code = 9;
            }
        } else {
            $price_code = 9;
        }
        if ($request->groupcategory_id) {
            if (isset($request->category) && isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category) && isset($request->prescription_required)) {
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('ProductUse_Code', $request->uses)
                    ->whereIn('Prescription_Required', $request->prescription_required)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses) && isset($request->category)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('category_id', $request->category)
                    ->whereIn('ProductUse_Code', $request->uses)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category)) {
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('category_id', $request->category)
                    ->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->orderBy('id', 'DESC')->paginate(20);

            } else if (isset($request->prescription_required)) {
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses)) {

                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);

            } else {
                $products = \App\Product::where('groupcategory_id', $request->groupcategory_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->where('productprice.Price', '<=', number_format($request->maxval, 2, '.', ''))
                    ->where('productprice.Price', '>=', number_format($request->minval, 2, '.', ''))
                    ->select('products.*')->paginate(20);

            }
        } else if ($request->group_id) {
            if (isset($request->category) && isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category) && isset($request->prescription_required)) {
                $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                    ->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->prescription_required) && isset($request->uses)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('group_id', $request->group_id)->whereIn('ProductUse_Code', $request->uses)
                    ->whereIn('Prescription_Required', $request->prescription_required)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses) && isset($request->category)) {
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                    ->whereIn('ProductUse_Code', $request->uses)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->category)) {
                $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                    ->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->orderBy('id', 'DESC')->paginate(20);

            } else if (isset($request->prescription_required)) {
                $products = \App\Product::where('group_id', $request->group_id)->whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if (isset($request->uses)) {

                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

                $products = \App\Product::where('group_id', $request->group_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);

            } else {
                $products = \App\Product::where('group_id', $request->group_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
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
                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

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
                    ->select('products.*')->orderBy('id', 'DESC')->paginate(100);

            } else if (isset($request->prescription_required)) {
                $products = \App\Product::whereIn('Prescription_Required', $request->prescription_required)
                    ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(20);
            } else if ($request->uses) {

                $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
                $products = \App\Product::join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                    ->select('products.*')->paginate(100);

            } else {
                $products = \App\Product::join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->where('productprice.Price', '<=', number_format($request->maxval, 2, '.', ''))
                    ->where('productprice.Price', '>=', number_format($request->minval, 2, '.', ''))
                    ->select('products.*')->paginate(20);
            }
        }

        $products->appends(['groupcategory_id' => $request->groupcategory_id,
            'group_id' => $request->group_id,
            'category' => $request->category,
            'groupcategory_id' => $request->groupcategory_id,
            'ProductUse_Code' => $request->ProductUse_Code,
            'uses' => $request->uses,
            'maxval' => $request->maxval,
            'minval' => $request->minval]);

        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                return view('frontend.chemists.sidebar_filter_data', compact('products'));
            } elseif (\Auth::user()->role == 'User') {
                return view('frontend.users.sidebar_filter_data', compact('products'));
            } else {
                return view('frontend.sidebar_filter_data', compact('products'));
            }
        } else {
            return view('frontend.sidebar_filter_data', compact('products'));
        }
    }

    public function upload_prescription(Request $request)
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('frontend.upload_prescription', compact('groups'));
    }

    public function upload_prescription_store(Request $request)
    {
        $this->validate($request, [
            'upload_prescription' => 'required',
        ]);

        foreach ($request->file('upload_prescription') as $upload_prescription_file) {
            $image = $upload_prescription_file;
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $upload_prescription_files[] = 'upload/' . $fullname;
        }
        $str_upload_prescription = implode(",", $upload_prescription_files);
        $upload_prescription = \App\Upoadprescription::create([
            'upload_prescription' => $str_upload_prescription,
            'user_id' => \Auth::user()->id,
        ]);
        if ($request->input('get_data') == 'add_medicine') {
            $upload_prescription->add_medicine = 'on';
            $upload_prescription->save();
        } else {
            $upload_prescription->get_call = 'on';

            $upload_prescription->save();
        }
        return redirect()->route('home');
    }

    public function buy_now(Request $request, $id)
    {

        $product = \App\Product::find($id);
        $add_to_card = \App\Addtocard::where('product_id', '=', $id)->where('user_id', '=', \Auth::user()->id)->first();
        $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
        $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
        $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();
        if (\Auth::user()) {
            if (count($request->all())) {

                if (\Auth::user()->role == 'User') {

                    if ($add_to_card) {
                        $add_to_card->Qty = $add_to_card->Qty + $request->Qty;
                        $add_to_card->save();
                    } else {
                        $add_to_card = \App\Addtocard::create([
                            'user_id' => \Auth::user()->id,
                            'product_id' => $product->id,
                            'Qty' => $request->Qty,
                            'amount' => $product_price->Price,
                        ]);
                    }
                    return redirect()->route('frontend.checkout');
                } elseif (\Auth::user()->role == 'Chemist') {

                    if ($add_to_card) {
                        $add_to_card->Qty = $add_to_card->Qty + $request->Qty;
                        $add_to_card->save();
                    } else {
                        $add_to_card = \App\Addtocard::create([
                            'user_id' => \Auth::user()->id,
                            'product_id' => $product->id,
                            'Qty' => $request->Qty,
                            'amount' => $chemist_product_price->Price,
                        ]);
                    }

                    return redirect()->route('frontend.checkout');
                } else {
                    return redirect()->back();
                }
            } else {

                if (\Auth::user()->role == 'User') {

                    if ($add_to_card) {
                        $add_to_card->Qty = $add_to_card->Qty + 1;
                        $add_to_card->save();
                    } else {
                        $add_to_card = \App\Addtocard::create([
                            'user_id' => \Auth::user()->id,
                            'product_id' => $product->id,
                            'Qty' => '1',
                            'amount' => $product_price->Price,
                        ]);
                    }
                    return redirect()->route('frontend.checkout');
                } elseif (\Auth::user()->role == 'Chemist') {

                    if ($add_to_card) {
                        $add_to_card->Qty = $add_to_card->Qty + 1;
                        $add_to_card->save();
                    } else {
                        $add_to_card = \App\Addtocard::create([
                            'user_id' => \Auth::user()->id,
                            'product_id' => $product->id,
                            'Qty' => '1',
                            'amount' => $chemist_product_price->Price,
                        ]);
                    }

                    return redirect()->route('frontend.checkout');
                } else {
                    return redirect()->back();
                }
            }
        }
    }

    public function add_address(Request $request)
    {
        $address = \App\Address::create([
            'full_name' => $request->full_name,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'state' => $request->state,
            'phone_no' => $request->phone_no,
            'set_as_a_current' => 'Yes',
            'set_as_a_default' => 'No',
            'user_id' => \Auth::user()->id,
        ]);
        $addresses = \App\Address::where('user_id', '=', $address->user_id)->whereNotIn('id', [$address->id])->get();
        foreach ($addresses as $address) {
            $address->set_as_a_current = 'No';
            $address->save();
        }
        if ($address) {
            $abc = "<div class='product-itemdetails row' valign='middle' id='itemid-922086'>
                         <div class='rightside-details col pr-0'>
                                                <div class='row m-0'>
                                                    <div class='product-item-name col pl-0'>
                                                        <a href='#'>" . $address->full_name . "</a>
                                                    </div>
                                                </div>
                                                <div class='row m-0 mt-2'>
                                                    <div class='catag-name col pl-0'>
                                                        <p class='form m-0'>" . $address->address1 . "</p>
                                                    </div>
                                                </div>
                                                <div class='row m-0 mt-2'>
                                                    <div class='catag-name col pl-0'>
                                                        <p class='form m-0'>" . $address->address2 . "</p>
                                                    </div>
                                                </div>
                                                <div class='row m-0 mt-1'>
                                                    <div class='catag-name col pl-0'>
                                                        <p class='form m-0'>" . $address->city . "</p>
                                                    </div>
                                                </div>
                                                <div class='row m-0 mt-1'>
                                                    <div class='catag-name col pl-0'>
                                                        <p class='form m-0'>" . $address->state . "</p>
                                                    </div>
                                                </div>
                                                <div class='deliveryby row m-0 mt-2'>
                                                    <div class='date deldate col pl-0'>
                                                        <div class='deliveryby'>" . $address->phone_no . "</div>
                                                    </div>
                                                    <div class='item-prices col-2 p-0 text-right'>
                                                        <div class='discount-val'><a href='javascript:void(0)' data-toggle='modal' data-target='#modify_address'><span id='row_itmdiscprice_922086'>Change</span></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>";
            echo $abc;
        } else {
            echo "Delivery Not Available";
        }
    }

    public function payment_gateway(Request $request)
    {
        /*
         * import checksum generation utility
         * You can get this utility from https://developer.paytm.com/docs/checksum/
         */

        $paytmParams = array();

        $paytmParams["body"] = array(
            "requestType" => "Payment",
            "mid" => "YOUR_MID_HERE",
            "websiteName" => "http://nestor_update.testing/",
            "orderId" => "ORDERID_98765",
            "callbackUrl" => "http://nestor_update.testing/frontend/thanks_page",
            "txnAmount" => array(
                "value" => "1.00",
                "currency" => "INR",
            ),
            "userInfo" => array(
                "custId" => "CUST_001",
            ),
        );

        /*
         * Generate checksum by parameters we have in body
         * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
         */
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "zTU5qr5NnXmcmTy5");

        $paytmParams["head"] = array(
            "signature" => $checksum,
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";

        /* for Production */
// $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
        print_r($response);
    }

    public function thanks_page(Request $request)
    {
        dd('Thanks Page');
        return view('frontend.thanks_page', compact('groups'));
    }

}
