<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PaytmWallet;

require_once "../vendor/paytm/paytmchecksum/PaytmChecksum.php";

class CustomerAPIController extends Controller
{
    public $successStatus = 200;

    public function customer_home_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();

        if ($request->PIN) {
            $pincode = \App\Pincode::where('pincode', $request->PIN)->first();
        } else {
            $pincode = null;
        }

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

        $main_sliders = \App\Slider::whereNotIn('id',[72])->whereNotNull('mobile_image')->get();

        foreach ($main_sliders as $main_slider) {
            $main_slider->image = $site_route . "/" . $main_slider->mobile_image;
        }
        $deal_of_the_day_sliders = \App\Slider::where('slider_type', '=', 'home_page_second_top')->select(['id', 'title', 'image'])->get();
        foreach ($deal_of_the_day_sliders as $deal_of_the_day_slider) {
            $deal_of_the_day_slider->image = $site_route . "/" . $deal_of_the_day_slider->image;
        }
        $data1['type'] = 'Slider';
        $data1['slider_data'] = $main_sliders;
        $data[] = $data1;

        $data4['type'] = 'Brand';
        $nestor_products = \App\Product::where('ProductBrand_Code', '1')->limit(10)->get();
        foreach ($nestor_products as $product) {

            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
            if ($product_image) {
                $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }

            if ($product->group) {
                $product->group = $product->group->name;
            }

            if ($product->group_category) {
                $product->group_category = $product->group_category->name;
            }

        
            if ($product->customer_price) {
                $product->gst = $product->customer_mrp_price->GST . " %";
                $current_price= $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST/100;
            } else {
                $product->customer_price = null;
                $product->gst = null;
                $current_price = 0;
            }

            
            if ($product->sales_schame_customer) {
                $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                $product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
            } else {
                $product->sales_schame = [];
                $product->offer = "";
                $product->b2c_price =  number_format($current_price, 2, '.', '');
            }

            if ($product->customer_mrp_price) {
            } else {
                $product->customer_mrp_price = [];
            }


            if ($product->stock_by_office($Global_Office_Code)) {
                if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                    $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                } else {
                    $product->stock_in = 0.00;
                }
            } else {
                $product->stock_in = 0.00;
            }

            $package = \App\Package::find($product->package_id);
            if ($product->package) {
                $product->package = $product->package->Packing_Description;
            }

            $nestor_product_list[] = $product;
        }

        $steriheal_products = \App\Product::where('ProductBrand_Code', '2')->limit(10)->get();

        foreach ($steriheal_products as $product) {

            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
            if ($product_image) {
                $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }

            if ($product->group) {
                $product->group = $product->group->name;
            }

            if ($product->group_category) {
                $product->group_category = $product->group_category->name;
            }

            $product->offer = "10 % Off";

            if ($product->customer_price) {
                $product->gst = $product->customer_price->GST . " %";
                $current_price= $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST/100;
            } else {
                $product->customer_price = null;
                $product->gst = null;
                $current_price = 0;
            }

            
            if ($product->sales_schame_customer) {
                $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                $product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
            } else {
                $product->sales_schame = [];
                $product->offer = "";
                $product->b2c_price =  number_format($current_price, 2, '.', '');
            }

            if ($product->customer_mrp_price) {
                $product->customer_mrp_price = number_format($product->customer_mrp_price->Price, 2, '.', '');
            } else {
                $product->customer_mrp_price = [];
            }

            if ($product->stock_by_office($Global_Office_Code)) {
                if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                    $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                } else {
                    $product->stock_in = 0.00;
                }
            } else {
                $product->stock_in = 0.00;
            }

            $package = \App\Package::find($product->package_id);
            if ($product->package) {
                $product->package = $product->package->Packing_Description;
            }

            $steriheal_product_list[] = $product;
        }

        $nectarine_products = \App\Product::where('ProductBrand_Code', '3')->limit(10)->get();

        foreach ($nectarine_products as $product) {

            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
            if ($product_image) {
                $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }

            if ($product->group) {
                $product->group = $product->group->name;
            }

            if ($product->group_category) {
                $product->group_category = $product->group_category->name;
            }

            $product->offer = "10 % Off";

            if ($product->customer_price) {
                $product->gst = $product->customer_mrp_price->GST . " %";
                $current_price= $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST/100;
            } else {
                $product->customer_price = null;
                $product->gst = null;
                $current_price = 0;
            }

            
            if ($product->sales_schame_customer) {
                $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                $product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
            } else {
                $product->sales_schame = [];
                $product->offer = "";
                $product->b2c_price =  number_format($current_price, 2, '.', '');
            }

            if ($product->customer_mrp_price) {
                $product->customer_mrp_price = number_format($product->customer_mrp_price->Price, 2, '.', '');
            } else {
                $product->customer_mrp_price = [];
            }

            if ($product->stock_by_office($Global_Office_Code)) {
                if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                    $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                } else {
                    $product->stock_in = 0.00;
                }
            } else {
                $product->stock_in = 0.00;
            }

            $package = \App\Package::find($product->package_id);
            if ($product->package) {
                $product->package = $product->package->Packing_Description;
            }

            $nectarine_product_list[] = $product;
        }

        $data4['brand_data'] = [
            ['name' => 'OTC Products/Prescription Medicines', 'subname' => 'Nestor', 'image' => $site_route . '/img/nestor_logo.png', 'ProductBrand_Code' => 1, 'data' => $nestor_product_list],
            ['name' => 'Medical Consumable/Home care', 'subname' => 'Steriheal', 'image' => $site_route . '/img/Steriheal.jpg', 'ProductBrand_Code' => 2, 'data' => $steriheal_product_list],
            ['name' => 'Ayurvedic Medicines/Body Care', 'subname' => 'Nectarine', 'image' => $site_route . '/img/NECTARINE.jpg', 'ProductBrand_Code' => 3, 'data' => $nectarine_product_list],
        ];
        $data[] = $data4;

        $button['button'] = 'Make_Order';
        $button['message'] = 'Make Order';
        $data2['type'] = 'Button';
        $data2['Make_Order_data'] = $button;
        $data[] = $data2;

        $call['phoneNo'] = '01244522400';
        $call['message'] = 'Call Us';
        $data3['type'] = 'Call_Us';
        $data3['Call_Us_data'] = $call;
        $data[] = $data3;

        $shop_by_groupcategories = \App\Groupcategory::whereNotNull('sn')->select(['id', 'name', 'image','sn'])->orderBy('sn','ASC')->get();

        foreach ($shop_by_groupcategories as $shop_by_groupcategory) {
            $shop_by_groupcategory->image = $site_route . "/" . $shop_by_groupcategory->image;
        }
        $data4['type'] = 'Shop_By_Category';
        $data4['message'] = 'Shop By Category';
        $data4['Shop_By_Category_data'] = $shop_by_groupcategories;
        $data[] = $data4;

        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);

    }

    public function customer_search_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        if ($request->PIN) {
            $pincode = \App\Pincode::where('pincode', $request->PIN)->first();
        } else {
            $pincode = null;
        }

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

        $site_route = $request->getSchemeAndHttpHost();
        if ($request->name) {
            $product_list = [];
            $products = \App\Product::where('brand_name', 'LIKE', '%' . $request->input('name') . '%')->orWhere('generic_name', 'LIKE', '%' . $request->input('name') . '%')->paginate(20);
            if (count($products)) {
                foreach ($products as $product) {

                    $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                    if ($product_image) {
                        $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    } else {
                        $product->image = "";
                    }

                    if ($product->group) {
                        $product->group = $product->group->name;
                    }

                    if ($product->group_category) {
                        $product->group_category = $product->group_category->name;
                    }

                   

                    if ($product->customer_price) {
                        $product->gst = $product->customer_price->GST . " %";
                        $current_price= $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST/100;
                    } else {
                        $product->customer_price = null;
                        $product->gst = null;
                        $current_price = 0;
                    }
        
                    
                    if ($product->sales_schame_customer) {
                        $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                        $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                        $product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
                    } else {
                        $product->sales_schame = [];
                        $product->offer = "";
                        $product->b2c_price =  number_format($current_price, 2, '.', '');
                    }

                    if ($product->customer_mrp_price) {
                        $product->customer_mrp_price = number_format($product->customer_mrp_price->Price, 2, '.', '');
                    } else {
                        $product->customer_mrp_price = [];
                    }

                    if ($product->stock_by_office($Global_Office_Code)) {
                        if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                            $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                        } else {
                            $product->stock_in = 0.00;
                        }
                    } else {
                        $product->stock_in = 0.00;
                    }

                    $package = \App\Package::find($product->package_id);
                    if ($product->package) {
                        $product->package = $product->package->Packing_Description;
                    }

                    $product_list[] = $product;
                }
                return response()->json(['status' => true, 'message' => 'Data fatch Successfully', 'total_page' => $products->lastPage(), 'data' => $product_list], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function customer_product_detail_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        if ($request->PIN) {
            $pincode = \App\Pincode::where('pincode', $request->PIN)->first();
        } else {
            $pincode = null;
        }

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

        $single_product = \App\Product::find($request->product_id);

        if ($single_product) {
            $group = \App\Group::find($single_product->group_id);
            $groupcategory = \App\Groupcategory::find($single_product->groupcategory_id);
            if ($group) {
                $single_product->group_name = $group->name;
            }
            if ($groupcategory) {
                $single_product->group_category_name = $groupcategory->name;
            }
            if ($single_product) {
                $package = \App\Package::find($single_product->package_id);
                if ($package) {
                    $single_product->package_name = $package->Packing_Description;
                }
                $category = \App\Category::find($single_product->category_id);
                if ($category) {
                    $single_product->product_type = $category->name;
                }

                if ($single_product->customer_price) {
                    $single_product->gst = $single_product->customer_price->GST . " %";
                    $current_price= $single_product->customer_price->Price + $single_product->customer_price->Price * $single_product->customer_price->GST/100;
                } else {
                    $single_product->customer_price = null;
                    $single_product->gst = null;
                    $current_price = 0;
                }
    
                
                if ($single_product->sales_schame_customer) {
                    $single_product->offer =$single_product->sales_schame_customer->SalesScheme_Name; 
                    $b2c_price =$current_price -$current_price*$single_product->sales_schame_customer->Discount/100;
                    $single_product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
                } else {
                    $single_product->sales_schame = [];
                    $single_product->offer = "";
                    $single_product->b2c_price =  number_format($current_price, 2, '.', '');
                }

                if ($single_product->customer_mrp_price) {
                    $single_product->customer_mrp_price = $single_product->customer_mrp_price->Price;
                } else {
                    $single_product->customer_mrp_price = [];
                }

                if ($single_product->stock_by_office($Global_Office_Code)) {
                    if ($single_product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                        $single_product->stock_in = $single_product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                    } else {
                        $single_product->stock_in = "0.00";
                    }
                } else {
                    $single_product->stock_in = "0.00";

                }

                $product_image = \App\Productimage::where('Product_Code', '=', $single_product->product_code)->first();
                if ($product_image) {
                    $single_product->image = [$site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name];
                } else {
                    $single_product->image = [];
                }
                $single_product->offer = "10 % Off";

                $description_types = \App\Descriptiontype::all();

                $description_data = [];
                foreach ($description_types as $description_type) {
                    $description = \App\Description::whereNotIn('description', ['0'])->where('product_code', '=', $single_product->product_code)->where('description_type_code', '=', $description_type->id)->limit(6)->select('description')->get();
                    if (count($description)) {
                        $description_data[] = ['title' => $description_type->name, 'descriptions' => $description];
                    }
                }
                $single_product->description_data = $description_data;
                $a1['product'] = $single_product;
                $related_products = \App\Product::where('groupcategory_id', '=', $single_product->groupcategory_id)->whereNotIn('id', [$single_product->id])->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code'])->get();
                if (count($related_products)) {
                    foreach ($related_products as $product) {
                        $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                        if ($product_image) {
                            $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                        } else {
                            $product->image = "";
                        }

                        if ($product->group) {
                            $product->group = $product->group->name;
                        }

                        if ($product->group_category) {
                            $product->group_category = $product->group_category->name;
                        }

                        if ($product->customer_price) {
                            $product->gst = $product->customer_mrp_price->GST . " %";
                            $current_price= $product->customer_mrp_price->Price + $product->customer_mrp_price->Price * $product->customer_mrp_price->GST/100;
                        } else {
                            $product->customer_price = null;
                            $product->gst = null;
                            $current_price = 0;
                        }
            
                        
                        if ($product->sales_schame_customer) {
                            $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                            $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                            $product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
                        } else {
                            $product->sales_schame = [];
                            $product->offer = "";
                            $product->b2c_price =  number_format($current_price, 2, '.', '');
                        }

                        if ($product->customer_mrp_price) {
                            $product->customer_mrp_price = number_format($product->customer_mrp_price->Price, 2, '.', '');
                        } else {
                            $product->customer_mrp_price = [];
                        }

                        if ($product->stock_by_office($Global_Office_Code)) {
                            if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                                $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                            } else {
                                $product->stock_in = 0.00;
                            }
                        } else {
                            $product->stock_in = 0.00;
                        }

                        $package = \App\Package::find($product->package_id);
                        if ($product->package) {
                            $product->package = $product->package->Packing_Description;
                        }

                        $product_list[] = $product;

                    }
                    $a1['Similar_Products'] = array($product);
                } else {
                    $a1['Similar_Products'] = array(null);
                }
                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => array_merge($a1)], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function our_products_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();

        if ($request->PIN) {
            $pincode = \App\Pincode::where('pincode', $request->PIN)->first();
        } else {
            $pincode = null;
        }

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

        $products = \App\Product::select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'group_id', 'groupcategory_id', 'package_id'])->paginate(20);
        if (count($products)) {
            foreach ($products as $product) {
                $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                if ($product_image) {
                    $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                } else {
                    $product->image = "";
                }

                if ($product->group) {
                    $product->group = $product->group->name;
                }

                if ($product->group_category) {
                    $product->group_category = $product->group_category->name;
                }
                if ($product->customer_price) {
                    $product->gst = $product->customer_price->GST . " %";
                    $current_price= $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST/100;
                } else {
                    $product->customer_price = null;
                    $product->gst = null;
                    $current_price = 0;
                }
    
                
                if ($product->sales_schame_customer) {
                    $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                    $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                    $product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
                } else {
                    $product->sales_schame = [];
                    $product->offer = "";
                    $product->b2c_price =  number_format($current_price, 2, '.', '');
                }

                if ($product->customer_mrp_price) {
                    $product->customer_mrp_price = number_format($product->customer_mrp_price->Price, 2, '.', '');
                } else {
                    $product->customer_mrp_price = [];
                }

                if ($product->stock_by_office($Global_Office_Code)) {
                    if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                        $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                    } else {
                        $product->stock_in = 0.00;
                    }
                } else {
                    $product->stock_in = 0.00;
                }

                $package = \App\Package::find($product->package_id);
                if ($product->package) {
                    $product->package = $product->package->Packing_Description;
                }

                $product_list[] = $product;
            }
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'total_page' => $products->lastPage(), 'data' => $product_list], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function customer_products_by_brand_App(Request $request)
    {

        $brand_data = [];
        $site_route = $request->getSchemeAndHttpHost();
        $groupcategory_by_brand = \App\Groupcategory::where('brand_id', $request->ProductBrand_Code)->orderBy('name', 'ASC')->get();
        if ($request->ProductBrand_Code == 1) {
            $brand_data = ['name' => 'OTC Products/Prescription Medicines', 'subname' => 'Nestor', 'image' => $site_route . '/img/nestor_logo.png', 'ProductBrand_Code' => 1,
                'data' => $groupcategory_by_brand];
        } else if ($request->ProductBrand_Code == 2) {
            $brand_data = ['name' => 'Medical Consumable/Home care', 'subname' => 'Steriheal', 'image' => $site_route . '/img/Steriheal.jpg', 'ProductBrand_Code' => 2,
                'data' => $groupcategory_by_brand];
        } else if ($request->ProductBrand_Code == 3) {
            $brand_data = ['name' => 'Ayurvedic Medicines/Body Care', 'subname' => 'Nectarine', 'image' => $site_route . '/img/NECTARINE.jpg', 'ProductBrand_Code' => 3,
                'data' => $groupcategory_by_brand];
        }

        $data['brand_data'] = $brand_data;

        if ($request->PIN) {
            $pincode = \App\Pincode::where('pincode', $request->PIN)->first();
        } else {
            $pincode = null;
        }

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

        $products = \App\Product::where('ProductBrand_Code', '=', $request->ProductBrand_Code)->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'group_id', 'groupcategory_id', 'package_id', 'ProductBrand_Code'])->paginate(20);
        if (count($products)) {
            foreach ($products as $product) {

                $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                if ($product_image) {
                    $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                } else {
                    $product->image = "";
                }

                if ($product->group) {
                    $product->group = $product->group->name;
                }

                if ($product->group_category) {
                    $product->group_category = $product->group_category->name;
                }

                if ($product->customer_price) {
                    $product->gst = $product->customer_price->GST . " %";
                    $current_price= $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST/100;
                } else {
                    $product->customer_price = null;
                    $product->gst = null;
                    $current_price = 0;
                }
    
                
                if ($product->sales_schame_customer) {
                    $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                    $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                    $product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
                } else {
                    $product->sales_schame = [];
                    $product->offer = "";
                    $product->b2c_price =  number_format($current_price, 2, '.', '');
                }

                if ($product->customer_mrp_price) {
                } else {
                    $product->customer_mrp_price = [];
                }

                if ($product->stock_by_office($Global_Office_Code)) {
                    if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                        $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                    } else {
                        $product->stock_in = 0.00;
                    }
                } else {
                    $product->stock_in = 0.00;
                }

                $package = \App\Package::find($product->package_id);
                if ($product->package) {
                    $product->package = $product->package->Packing_Description;
                }

                $product_list[] = $product;
            }
            $data['product_data'] = $product_list;

            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'total_page' => $products->lastPage(), 'data' => $data], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function customer_group_list_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $groups = \App\Group::orderBy('id', 'DESC')->get();
        foreach ($groups as $group) {
            $group->image = $site_route . "/" . $group->image;
        }

        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $groups], $this->successStatus);

    }

    public function customer_group_category_list_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $groupcategories = \App\Groupcategory::where('status',1)->orderBy('id', 'DESC')->get();
        foreach ($groupcategories as $groupcategory) {
            $groupcategory->image = $site_route . "/" . $groupcategory->image;
        }
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $groupcategories], $this->successStatus);
    }

    public function customer_group_with_groupcategory_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'total_page' => $products->lastPage(), 'data' => $groups], $this->successStatus);
    }

    public function customer_products_by_group_App(Request $request)
    {
        $brand_data = [];
        $site_route = $request->getSchemeAndHttpHost();
        $groupcategory_by_group = \App\Groupcategory::where('group_id', $request->group_id)->orderBy('name', 'ASC')->get();
        $data['group_data'] = $groupcategory_by_group;
        $site_route = $request->getSchemeAndHttpHost();
        if ($request->PIN) {
            $pincode = \App\Pincode::where('pincode', $request->PIN)->first();
        } else {
            $pincode = null;
        }
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

        $group = \App\Group::find($request->group_id);

        $groupcategories_list = \App\Groupcategory::where('group_id', $group->id)->get();

        $product_group_categories = \App\ProductGroupCategories::whereIn('groupcategory_id', $groupcategories_list->map(function ($groupcategory) {
            return $groupcategory->id;
        }))->get();

        if ($group) {
            $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                return $product_group_category->Product_Code;
            }))->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'group_id', 'groupcategory_id', 'package_id', 'ProductBrand_Code'])->paginate(20);
            if (count($products)) {
                foreach ($products as $product) {

                    $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                    if ($product_image) {
                        $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    } else {
                        $product->image = "";
                    }

                    if ($product->group) {
                        $product->group = $product->group->name;
                    }

                    if ($product->group_category) {
                        $product->group_category = $product->group_category->name;
                    }

                    if ($product->customer_price) {
                        $product->gst = $product->customer_price->GST . " %";
                        $current_price= $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST/100;
                    } else {
                        $product->customer_price = null;
                        $product->gst = null;
                        $current_price = 0;
                    }
        
                    
                    if ($product->sales_schame_customer) {
                        $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                        $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                        $product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
                    } else {
                        $product->sales_schame = [];
                        $product->offer = "";
                        $product->b2c_price =  number_format($current_price, 2, '.', '');
                    }

                    if ($product->customer_mrp_price) {
                        $product->customer_mrp_price = number_format($product->customer_mrp_price->Price, 2, '.', '');
                    } else {
                        $product->customer_mrp_price = [];
                    }

                    if ($product->stock_by_office($Global_Office_Code)) {
                        if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                            $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                        } else {
                            $product->stock_in = 0.00;
                        }
                    } else {
                        $product->stock_in = 0.00;
                    }

                    if ($product->package) {
                        $product->package = $product->package->Packing_Description;
                    }

                    $product_list[] = $product;
                }
                $data['product_list'] = $product_list;
                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'total_page' => $products->lastPage(), 'data' => $data], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 401);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 401);
        }

    }

    public function customer_products_by_groupcategory_App(Request $request)
    {

        $site_route = $request->getSchemeAndHttpHost();
        if ($request->PIN) {
            $pincode = \App\Pincode::where('pincode', $request->PIN)->first();
        } else {
            $pincode = null;
        }

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

        $groupcategory = \App\Groupcategory::find($request->groupcategory_id);
        $product_group_categories = \App\ProductGroupCategories::where('groupcategory_id', $groupcategory->id)->get();

        if ($groupcategory) {
            $products = \App\Product::whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                return $product_group_category->Product_Code;
            }))->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'group_id', 'groupcategory_id', 'package_id'])->paginate(20);
            if (count($products)) {
                foreach ($products as $product) {

                    $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                    if ($product_image) {
                        $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    } else {
                        $product->image = "";
                    }

                    if ($product->group) {
                        $product->group = $product->group->name;
                    }

                    if ($product->group_category) {
                        $product->group_category = $product->group_category->name;
                    }

                    if ($product->customer_price) {
                        $product->gst = $product->customer_price->GST . " %";
                        $current_price= $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST/100;
                    } else {
                        $product->customer_price = null;
                        $product->gst = null;
                        $current_price = 0;
                    }
        
                    
                    if ($product->sales_schame_customer) {
                        $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                        $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                        $product->b2c_price =  number_format($b2c_price, 2, '.', ''); 
                    } else {
                        $product->sales_schame = [];
                        $product->offer = "";
                        $product->b2c_price =  number_format($current_price, 2, '.', '');
                    }

                    if ($product->customer_mrp_price) {
                        $product->customer_mrp_price = number_format($product->customer_mrp_price->Price, 2, '.', '');
                    } else {
                        $product->customer_mrp_price = [];
                    }

                    if ($product->stock_by_office($Global_Office_Code)) {
                        if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                            $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                        } else {
                            $product->stock_in = 0.00;
                        }
                    } else {
                        $product->stock_in = 0.00;
                    }

                    $package = \App\Package::find($product->package_id);
                    if ($product->package) {
                        $product->package = $product->package->Packing_Description;
                    }

                    $product_list[] = $product;
                }
                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'total_page' => $products->lastPage(), 'data' => $product_list], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function customer_get_address_App(Request $request)
    {
        $user = \App\User::where('role', 'User')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $addresses = \App\Address::with('city')->with('state')->where('user_id', '=', $user->id)->get();
            if (count($addresses)) {
                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $addresses], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'No Address Found'], $this->successStatus);
            }

        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 401);
        }
    }

    public function customer_add_address_App(Request $request)
    {

        $user = \App\User::where('role', '=', 'User')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {

            $pincode = \App\Pincode::where('pincode', '=', $request->PIN)->first();
            if ($pincode) {
                $address = \App\Address::create([
                    'Contact_Person' => $request->Contact_Person,
                    'Address1' => $request->Address1,
                    'Address2' => $request->Address2,
                    'Address3' => $request->Address3,
                    'City_Code' => $request->City_Code,
                    'State_Code' => $request->State_Code,
                    'PIN' => $request->PIN,
                    'Mobile_No' => $request->Mobile_No,
                    'user_id' => $user->id,
                    'set_as_a_default' => 'Yes',
                    'set_as_a_current' => 'Yes',
                ]);
                if ($request->is_home == 1) {
                    $address->address_type = 'is_home';
                }
                if ($request->is_work == 1) {
                    $address->address_type = 'is_work';
                }
                $address->save();
                $all_addresses = \App\Address::where('id', '!=', $address->id)->where('user_id', $address->user_id)->get();
                foreach ($all_addresses as $all_address) {
                    $all_address->set_as_a_default = 'No';
                    $all_address->set_as_a_current = 'No';
                }

            } else {
                return response()->json(['status' => false, 'message' => 'Delivery is Not Available at this Location. Please Change Your Location'], 401);
            }
            return response()->json(['status' => true, 'message' => 'Your Address save Successfully', 'data' => $address], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 401);
        }
    }

    public function customer_set_as_a_default_address_App(Request $request)
    {
        $address = \App\Address::find($request->address_id);

        if ($address) {
            $address->set_as_a_default = 'Yes';
            $address->save();
            $addresses = \App\Address::where('user_id', '=', $address->user_id)->whereNotIn('id', [$address->id])->get();
            foreach ($addresses as $address) {
                $address->set_as_a_default = 'No';
                $address->save();
            }
            return response()->json(['status' => true, 'message' => 'Selected Address Successfully Set As A Default Address.'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function customer_edit_address_App(Request $request)
    {
        $address = \App\Address::find($request->address_id);
        if ($address) {
            $pincode = \App\Pincode::where('pincode', '=', $request->input('PIN'))->first();
            if ($pincode) {
                $address = \App\Address::find($request->address_id);
                $address->Contact_Person = $request->input('Contact_Person');
                $address->Address1 = $request->input('Address1');
                $address->Address2 = $request->input('Address2');
                $address->Address3 = $request->Address3;
                $address->City_Code = $request->City_Code;
                $address->State_Code = $request->State_Code;
                $address->PIN = $request->PIN;
                $address->Mobile_No = $request->input('Mobile_No');
                if ($request->is_home == 1) {
                    $address->address_type = 'is_home';
                }
                if ($request->is_work == 1) {
                    $address->address_type = 'is_work';
                }
                $address->save();
            } else {
                return response()->json(['status' => false, 'message' => 'Delivery is Not Available at this Location. Please Change Your Location'], $this->successStatus);
            }
            return response()->json(['status' => true, 'message' => 'Your Address Updated Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function customer_change_address_App(Request $request)
    {
        $address = \App\Address::find($request->address_id);
        if ($address) {
            $address->set_as_a_current = 'Yes';
            $address->save();
            $addresses = \App\Address::where('user_id', '=', $address->user_id)->whereNotIn('id', [$address->id])->get();
            foreach ($addresses as $address) {
                $address->set_as_a_current = 'No';
                $address->save();
            }
            return response()->json(['status' => true, 'message' => 'Selected Address Successfully Set As A Current Order Address.'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
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

    public function customer_my_cart_App(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();

        $user = \App\User::where('mobile', '=', $request->mobile)->first();
       
        if ($user) {
            $add_to_cards = \App\Addtocard::where('user_id', '=', $user->id)->get();
            if (count($add_to_cards)) {
                $total = 0;
                $gst_total = 0;
                $grand_total = 0;
                $grand_subtotal = 0;

                foreach ($add_to_cards as $add_to_card) {
                    $gst_amount = 0;
                    $subtotal = 0;
                    $product = \App\Product::find($add_to_card->product_id);
                    if($product->customer_price){
                        $subtotal = $add_to_card->amount * $add_to_card->Qty;
                    }else{
                        $subtotal = $add_to_card->amount * $add_to_card->Qty;
                    }
                    
                    $total = $total +  $subtotal;
                    $add_to_card->brand_name = $product->brand_name;
                    $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                    if ($product_image) {
                        $add_to_card->image = $host . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    } else {
                        $add_to_card->image = "";
                    }
                    $add_to_card->offer = "10 % Off";
                    $add_to_card->Prescription_Required=$product->Prescription_Required;
                    
                    if ($product->customer_price) {
                        $add_to_card->customer_price = $product->customer_price;
                        $add_to_card->gst = $product->customer_price->GST;
                        $current_price= $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST/100;
                    } else {
                        $add_to_card->customer_price = null;
                        $add_to_card->gst = null;
                        $current_price = 0;
                    }
        
                    if ($product->sales_schame_customer) {
                        $add_to_card->offer =$product->sales_schame_customer->SalesScheme_Name; 
                        $b2c_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                        $add_to_card->b2c_price =  number_format($b2c_price, 2, '.', ''); 
                    } else {
                        $product->sales_schame = [];
                        $add_to_card->offer = "";
                        $add_to_card->b2c_price =  number_format($current_price, 2, '.', '');
                    }

                    $add_to_card->subtotal = $add_to_card->b2c_price*$add_to_card->Qty;
                    $grand_subtotal = $grand_subtotal + $add_to_card->b2c_price * $add_to_card->Qty;
                    if ($product->package) {
                        $add_to_card->package = $product->package;
                    }
                    if ($product->customer_mrp_price) {
                        $add_to_card->customer_mrp_price = $product->customer_mrp_price;
                        $gst_amount = (float) $product->customer_mrp_price->GST *$subtotal / 100;
                    } else {
                        $add_to_card->customer_mrp_price = null;
                    }
                    $gst_total = $gst_total + $gst_amount;
                }

                
                if($total<500){
                    $delivery_charge=50;
                }else{
                    $delivery_charge=0;
                }
                $grand_total = $total + $delivery_charge;
                $data1['type'] = 'Products';
                $data1['product_data'] = $add_to_cards;
                $data[] = $data1;

                $data2['message'] = 'View Price Detail';
                $data2['type'] = 'Total Amount';
                $data2['billing_data'] = array('taxable_amount' => number_format($total, 2, '.', ','), 'tax_amount' => number_format($gst_total, 2, '.', ','),'grand_subtotal'=>number_format($grand_subtotal, 2, '.', ','),'delivery_charge'=>number_format($delivery_charge, 2, '.', ','),'grand_total' => number_format($grand_total, 2, '.', ','));
                $data[] = $data2;

                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully','offer_message'=>'Get Free Delivery on orders Rs. 500 and Above !','data' => $data], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Your Cart is Empty'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function customer_add_to_cart_App(Request $request)
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

    public function customer_remove_from_my_cart_App(Request $request)
    {

        $add_to_card = \App\Addtocard::find($request->card_id);
        if ($add_to_card) {
            $add_to_card->delete();
            return response()->json(['status' => true, 'message' => 'Card Product Delete Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function place_your_order_App(Request $request)
    {
        $user = \App\User::where('role', '=', 'User')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $product_carts = \App\Addtocard::where('user_id', '=', $user->id)->get();
            if (count($product_carts)) {

                $site_route = $request->getSchemeAndHttpHost();
                $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
                $payment = \PaytmWallet::with('receive');

                $card_subtotal = 0;
                $wallet = 0;
                $grand_total = 0;
                if ($user) {
                    if ($user->wallet >= 100) {
                        $wallet = 100;
                    } else {
                        $wallet = $user->wallet;
                    }
                }
                $address = \App\Address::where('user_id', '=', $user->id)->where('set_as_a_current', '=', 'Yes')
                    ->where('set_as_a_default', '=', 'Yes')
                    ->first();
                if ($address) {
                    $pincode = \App\Pincode::where('pincode', '=', $address->PIN)->first();
                    $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
                }
                $stock_arr = [];
                foreach ($product_carts as $product_cart) {
                    $subtotal = 0;
                    $amount = 0;
                    $discount = 0;
                    $subtotal = $product_cart->amount * $product_cart->Qty;
                    $card_subtotal = $card_subtotal + $product_cart->amount * $product_cart->Qty;
                    $product_detail = \App\Product::find($product_cart->product_id);
                    $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product_cart->Product_Code)->first();
                    $produc_qty = 0;
                    if ($sales_scheme) {
                        $dividend = $product_cart->Qty;
                        $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                        $output = intdiv($dividend, $divisor);
                        $produc_qty = $product_cart->Qty + $output * $sales_scheme->Free_Qty;
                    } else {
                        $produc_qty = $product_cart->Qty;
                    }

                    if ($office_state) {
                        $stock = \App\Stock::where('Office_Code', '=', $office_state->Office_Code)->where('Product_Code', '=', $product_detail->product_code)->first();
                        $check = 0;
                        if ($stock) {
                            $check = $stock->QtyForNewOrder + $stock->Hold_Qty;
                            if ($check >= $produc_qty) {
                                $stock_arr1 = [];
                                $stock_arr1['Hold_Qty'] = $produc_qty;
                                $stock_arr1['Office_Code'] = $office_state->Office_Code;
                                $stock_arr1['Product_Code'] = $product_detail->product_code;
                                $stock_arr[] = $stock_arr1;
                            } else {
                                return response()->json(['status' => false, 'message' => 'Stock Of ' . $product_detail->brand_name . ' Are Not Available For This Location'], 200);
                            }
                        } else {
                            return response()->json(['status' => false, 'message' => 'Stock Of ' . $product_detail->brand_name . ' Are Not Available For This Location'], 200);
                        }
                    } else {
                        return response()->json(['status' => false, 'message' => 'Stock Are Not Available For This Location'], 200);
                    }

                    if ($product_detail) {
                        if ($user->role == 'Chemist') {
                            $product_price = $product_detail->chemist_price;
                            $mrp_product_price = $product_detail->mrp_price;

                        } else {
                            $product_price = $product_detail->customer_price;
                            $mrp_product_price = $product_detail->customer_mrp_price;
                        }
                    }

                    $amount = $subtotal - $discount;
                    $p_tax = $amount * $product_price->GST / 100;
                    $p_total = $amount + $p_tax;
                    if ($user->role == 'User') {
                        $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
                        $gst_amount = $card_subtotal * $product_price->GST / 100;
                    } else {
                        $order->GSTIN = 'null';
                        $gst_amount = $card_subtotal * $product_price->GST / 100;
                    }
                    $Delivery_Amount = 50;
                    $grand_total = $card_subtotal + $Delivery_Amount + $gst_amount;
                    $grand_total_invoice = $card_subtotal - $wallet + $Delivery_Amount + $gst_amount;
                }
                foreach ($stock_arr as $stock_ar) {
                    $stock1 = \App\Stock::where('Office_Code', '=', $stock_ar['Office_Code'])->where('Product_Code', '=', $stock_ar['Product_Code'])->first();
                    $stock1->Hold_Qty = $stock1->Hold_Qty + $stock_ar['Hold_Qty'];
                    $stock1->save();
                }

                $payment_request = \App\Payment::create([
                    'Order_Code' => "",
                    'ResponseTransID' => '',
                    'Requested_Amount' => number_format($grand_total_invoice, 2, '.', ''),
                    'PaymentMode' => '',
                    'TransactionTime' => date('Y-m-d H:m:s'),
                    'TransStatus' => '',
                    'Response_Code' => '',
                    'RESPMSG' => '',
                    'GatewayName' => '',
                    'BankTransID' => '',
                    'BankName' => '',
                    'User_ID' => $user->id,
                ]);

                require_once "../vendor/paytm/paytmchecksum/PaytmChecksum.php";

                $paytmParams = array();

                $paytmParams["body"] = array(
                    "requestType" => "Payment",
                    "mid" => "YtBoHw17737500171583",
                    "websiteName" => "WEBSTAGING",
                    "orderId" => "NMLID-" . $payment_request->id,
                    "callbackUrl" => "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=NMLID-" . $payment_request->id,
                    "txnAmount" => array(
                        "value" => $payment_request->Requested_Amount,
                        "currency" => "INR",
                    ),
                    "userInfo" => array(
                        "custId" => $chemist->id,
                    ),
                );

/*
 * Generate checksum by parameters we have in body
 * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
 */
                $checksum = \PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "zTU5qr5NnXmcmTy5");

                $paytmParams["head"] = array(
                    "signature" => $checksum,
                );

                $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
                $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=YtBoHw17737500171583&orderId=NMLID-" . $payment_request->id;

/* for Production */
// $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                $response = curl_exec($ch);
                $data['response'] = $response;
                $data['ORDER_ID'] = 'NMLID-' . $payment_request->id;
                $data['callbackUrl'] = "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=NMLID-" . $payment_request->id;
                return response()->json(['status' => true, 'message' => 'you order is initiated, we are waiting for payment submission', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Your Card is Empty, Please Add Alteast One Item'], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 200);
        }
    }

    public function responce_from_paytm_App(Request $request)
    {
        //   require_once("../vendor/paytm/paytmchecksum/PaytmChecksum.php");

        //      $transaction = PaytmWallet::with('receive');

        //     $response = $transaction->response();
        $response = $request->all();
        // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        if ($response['STATUS'] == "TXN_SUCCESS") {

            $payment_id = explode('-', $response['ORDERID']);
            $payment = \App\Payment::find($payment_id[1]);
            $user = \App\User::find($payment->User_ID);
         
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['token_type'] = 'Bearer';
            $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
            if ($chemist) {
                $site_route = $request->getSchemeAndHttpHost();
                $success['chemist_name'] = $chemist->Party_Name;
                $success['Party_Code'] = $chemist->Party_Code;
                $success['ShopPhoto'] = $site_route . "/" . $chemist->ShopPhoto;
                $success['contact_person'] = $chemist->Mobile_No;
            }
            $success['role'] = $user->role;
            $success['mobile'] = $user->mobile;
            $success['status'] = 'verify';
            $success['password'] = $user->password;
            $success['role'] = $user->role;
            $success['wallet'] = $user->wallet;
            if ($user->address) {
                $success['address'] = $user->address . " " . $user->landmark . " " . $user->city . " " . $user->state;
                $success['pincode'] = $user->pincode;
            }
            $payment->Order_Code = $response['ORDERID'];
            $payment->ResponseTransID = $response['TXNID'];
            $payment->Requested_Amount = $response['TXNAMOUNT'];
            $payment->PaymentMode = $response['PAYMENTMODE'];
            $payment->TransactionTime = $response['TXNDATE'];
            $payment->TransStatus = $response['STATUS'];
            $payment->Response_Code = $response['RESPCODE'];
            $payment->GatewayName = $response['GATEWAYNAME'];
            $payment->BankTransID = $response['BANKTXNID'];
            $payment->BankName = $response['BANKNAME'];
            $wallet = 0;
            if ($user) {
                if ($user->wallet > 100) {
                    $wallet = 100;
                } else {
                    $wallet = $user->wallet;
                }
                $user->wallet = $user->wallet - $wallet;
                $user->save();
            }

            $address = \App\Address::where('user_id', '=', $user->id)->where('set_as_a_current', '=', 'Yes')
                ->where('set_as_a_default', '=', 'Yes')
                ->first();
            if ($address) {
            } else {
                $address = \App\Address::where('user_id', '=', $user->id)->where('set_as_a_current', '=', 'Yes')
                    ->where('set_as_a_default', '=', 'Yes')
                    ->first();
            }

            $order = \App\Order::create([
                'user_id' => $user->id,
                'Party_Name' => $address->Contact_Person,
                'Address1' => $address->Address1,
                'Address2' => $address->Address2,
                'Address3' => $address->Address3,
                'Mobile_No' => $address->Mobile_No,
                'PIN' => $address->PIN,
                'City_Code' => $address->City_Code,
                'State_Code' => $address->State_Code,
            ]);
            $payment->Order_ID = $order->id;
            $payment->Testing_Payment = 1;
            $payment->save();
            $product_carts = \App\Addtocard::where('user_id', '=', $user->id)->get();
            $card_subtotal = 0;
            $grand_total = 0;

            foreach ($product_carts as $product_cart) {
                $subtotal = 0;
                $amount = 0;
                $discount = 0;
                $subtotal = $product_cart->amount * $product_cart->Qty;
                $card_subtotal = $card_subtotal + $product_cart->amount * $product_cart->Qty;
                $product_detail = \App\Product::find($product_cart->product_id);

                if ($product_detail) {
                    if ($user->role == 'Chemist') {
                        $product_price = $product_detail->chemist_price;
                        $mrp_product_price = $product_detail->mrp_price;

                    } else {
                        $product_price = $product_detail->customer_price;
                        $mrp_product_price = $product_detail->customer_mrp_price;
                    }
                }
                $amount = $subtotal - $discount;
                $p_tax = $amount * $product_price->GST / 100;
                $p_total = $amount + $p_tax;
                $order_product = \App\OrderProduct::create([
                    'Order_Id' => $order->id,
                    'product_id' => $product_detail->id,
                    'Product_Code' => $product_detail->product_code,
                    'Order_Qty' => $product_cart->Qty,
                    'Rate' => $product_cart->amount,
                    'Amount' => $amount,
                    'Taxable' => $subtotal,
                    'TaxRate' => $product_price->GST,
                    'Tax' => $p_tax,
                    'Total' => $p_total,
                    'Discount' => $product_detail->offer,
                ]);
                $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $order_product->Product_Code)->first();
                if ($sales_scheme) {
                    $dividend = $product_cart->Qty;
                    $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                    $output = intdiv($dividend, $divisor);
                    $order_product->Free_Qty = $output * $sales_scheme->Free_Qty;
                }
                if ($product_detail->customer_mrp_price) {
                    $order_product->MRP = $product_detail->customer_mrp_price->Price;
                } else {
                    $order_product->MRP = 0;
                }
                $order_product->save();
            }
            foreach ($product_carts as $product_cart) {
                if ($product_cart->count()) {
                    $product_cart->delete();
                }
            }
            if ($user->role == 'Chemist') {
                $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
                $order->Party_ID = $chemist->id;
                $order->Party_Code = $chemist->Party_Code;
                $order->Party_Name = $chemist->Party_Name;
                $order->GSTIN = $chemist->GSTIN;
                $gst_amount = $card_subtotal * $product_price->GST / 100;
            } else {
                $order->GSTIN = 'null';
                $gst_amount = $card_subtotal * $product_price->GST / 100;
            }
            $Delivery_Amount = 50;
            $grand_total = $card_subtotal + $Delivery_Amount + $gst_amount;
            $grand_total_invoice = $card_subtotal - $wallet + $Delivery_Amount + $gst_amount;
            $pincode = \App\Pincode::where('pincode', '=', $order->PIN)->first();
            $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
            $order->Delivery_Amount = $Delivery_Amount;
            $order->Taxable_Amount = $card_subtotal;
            $order->Tax_Amount = $gst_amount;
            $order->WalletAmount = $wallet;
            $order->Discount_Amount = 0;
            $order->Grand_Total = $grand_total;

            $order->Order_No = 'NSRID-' . $order->id;
            $order->Order_Date = date('Y-m-d H:i:s');
            $order->Product_Amount = $card_subtotal;
            $order->Payment_Amount = $grand_total_invoice;
            $order->Payment_Status = $response['STATUS'];
            $order->OrderStatus_Code = 5;
            $order->OrderFrom_Code = 1;
            $order->is_update = 0;
            $order->Testing_Order = 1;
            if ($office_state) {
                $order->Office_Code = $office_state->Office_Code;
            } else {
                $order->Office_Code = 31;
            }
            $order->save();
            $reward_point = \App\RewardPoint::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'Order_No' => $order->Order_No,
                'Order_Code' => $order->Order_Code,
                'Order_Date' => $order->Order_Date,
                'Tax_Amount' => $order->Taxable_Amount,
                'Reward_Point' => round($order->Taxable_Amount * 2 / 100),
            ]);
            $balance = \App\RewardReferenceLedger::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
            $reward_reference_ledger_debit1 = null;
            if ($payment->Wallet_Amount) {
                $reward_reference_ledger_debit1 = \App\RewardReferenceLedger::create([
                    'Reference' => $order->Order_No,
                    'Date_Time' => date('Y-m-d H:i:s'),
                    'Debit' => $payment->Wallet_Amount,
                    'Credit' => 0,
                    'user_id' => $user->id,
                ]);
                $reward_reference_ledger_debit1->Balance = $balance->Balance - $payment->Wallet_Amount;
                $reward_reference_ledger_debit1->save();
            }
    
            $reward_reference_ledger_debit2 = \App\RewardReferenceLedger::create([
                'Reference' => $order->Order_No,
                'Date_Time' => date('Y-m-d H:i:s'),
                'Debit' => 0,
                'Credit' => round($order->Taxable_Amount * 2 / 100),
                'user_id' => $user->id,
            ]);
            if ($reward_reference_ledger_debit1) {
                $reward_reference_ledger_debit2->Balance = $reward_reference_ledger_debit1->Balance + round($order->Taxable_Amount * 2 / 100);
            } else {
                $reward_reference_ledger_debit2->Balance = $balance->Balance + round($order->Taxable_Amount * 2 / 100);
            }
            $reward_reference_ledger_debit2->save();
    
            $reard_transaction = \App\RewardTransaction::create([
                'Transaction_Date' => date('Y-m-d H:i:s'),
                'RewardPointOf_Code' => 1,
                'Reference_Code' => $reward_reference_ledger_debit2->id,
                'RewardTransactionType_Code' => 2,
                'Points' => round($order->Taxable_Amount * 2 / 100),
                'user_id' => $user->id,
            ]);
            $order_product_arr = "";
            $order_products = \App\OrderProduct::where('Order_Id', '=', $order->id)->get();
            if ($address) {
                $pincode = \App\Pincode::where('pincode', '=', $order->PIN)->first();
                $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
            }
            foreach ($order_products as $order_product) {
                $sub = 0;
                $sub = $order_product->Rate * $order_product->Order_Qty;
                $product = \App\Product::find($order_product->product_id);
                $stock = \App\Stock::where('Office_Code', '=', $office_state->Office_Code)->where('Product_Code', '=', $order_product->Product_Code)->first();
                if ($stock) {
                    $stock_hold = \App\StockHold::where('User_Id', '=', $user->id)->where('Office_Code', '=', $stock->Office_Code)->where('Product_Code', '=', $stock->Product_Code)->delete();
                    $stock->Ordered_Qty = $stock->Ordered_Qty + $order_product->Order_Qty + $order_product->Free_Qty;
                    $stock->QtyForNewOrder = $stock->QtyForNewOrder - $order_product->Order_Qty - $order_product->Free_Qty;
                    $stock->Hold_Qty = $stock->Hold_Qty - $order_product->Order_Qty - $order_product->Free_Qty;
                    $stock->save();
                }
            }
        }
        $data = [];
        $data['order'] = $order;
        $data['user'] = $success;
        $data['response'] = $response;
        return response()->json(['status' => true, 'message' => 'You Order is Placed', 'data' => $data], 200);
    }

    public function customer_place_your_order_App(Request $request)
    {
        $user = \App\User::where('role', '=', 'User')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $product_carts = \App\Addtocard::where('user_id', '=', $user->id)->get();
            if (count($product_carts)) {

                $site_route = $request->getSchemeAndHttpHost();
                $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
                $payment = \PaytmWallet::with('receive');

                $card_subtotal = 0;
                $wallet = 0;
                $grand_total = 0;
                if ($user) {
                    if ($user->wallet > 100) {
                        $wallet = 100;
                    } else {
                        $wallet = $user->wallet;
                    }
                }
                $address = \App\Address::where('user_id', '=', $user->id)->where('set_as_a_current', '=', 'Yes')
                    ->where('set_as_a_default', '=', 'Yes')
                    ->first();
                if ($address) {
                    $pincode = \App\Pincode::where('pincode', '=', $address->PIN)->first();
                    $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
                }
                $stock_arr = [];
                foreach ($product_carts as $product_cart) {
                    $subtotal = 0;
                    $amount = 0;
                    $discount = 0;
                    $subtotal = $product_cart->amount * $product_cart->Qty;
                    $card_subtotal = $card_subtotal + $product_cart->amount * $product_cart->Qty;
                    $product_detail = \App\Product::find($product_cart->product_id);
                    $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product_cart->Product_Code)->first();
                    $produc_qty = 0;
                    if ($sales_scheme) {
                        $dividend = $product_cart->Qty;
                        $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                        $output = intdiv($dividend, $divisor);
                        $produc_qty = $product_cart->Qty + $output * $sales_scheme->Free_Qty;
                    } else {
                        $produc_qty = $product_cart->Qty;
                    }

                    if ($office_state) {
                        $stock = \App\Stock::where('Office_Code', '=', $office_state->Office_Code)->where('Product_Code', '=', $product_detail->product_code)->first();
                        $check = 0;
                        if ($stock) {
                            $check = $stock->QtyForNewOrder + $stock->Hold_Qty;
                            if ($check >= $produc_qty) {
                                $stock_arr1 = [];
                                $stock_arr1['Hold_Qty'] = $produc_qty;
                                $stock_arr1['Office_Code'] = $office_state->Office_Code;
                                $stock_arr1['Product_Code'] = $product_detail->product_code;
                                $stock_arr[] = $stock_arr1;
                            } else {
                                return response()->json(['status' => false, 'message' => 'Stock Of ' . $product_detail->brand_name . ' Are Not Available For This Location'], 200);
                            }
                        } else {
                            return response()->json(['status' => false, 'message' => 'Stock Of ' . $product_detail->brand_name . ' Are Not Available For This Location'], 200);
                        }
                    } else {
                        return response()->json(['status' => false, 'message' => 'Stock Are Not Available For This Location'], 200);
                    }
                    $p_tax = 0;
                    if ($product_detail) {
                        if ($user->role == 'chemist') {
                            $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                                ->where('ProductPriceType_Code', '=', 7)
                                ->first();
                            if ($product_price) {
                                $p_tax = $amount * $product_price->GST / 100;
                            }

                        } else {
                            $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                                ->where('ProductPriceType_Code', '=', 9)
                                ->first();
                            if ($product_price) {
                                $p_tax = $amount * $product_price->GST / 100;
                            }
                        }
                    }
                    $amount = $subtotal - $discount;
                    $gst_amount = 0;
                    $p_total = $amount + $p_tax;
                    if ($user->role == 'Chemist') {
                        $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
                        if ($product_price) {
                            $gst_amount = $card_subtotal * $product_price->GST / 100;
                        }
                    } else {
                        if ($product_price) {
                            $gst_amount = $card_subtotal * $product_price->GST / 100;
                        }
                    }
                    $grand_total1 = $card_subtotal  + $gst_amount;
                    if($grand_total1 > 500){
                        $Delivery_Amount = 0;
                    }else{
                        $Delivery_Amount = 50;
                    }
                   
                    $grand_total = $card_subtotal + $Delivery_Amount + $gst_amount;
                    $grand_total_invoice = $card_subtotal - $wallet + $Delivery_Amount + $gst_amount;
                }
                foreach ($stock_arr as $stock_ar) {
                    $stock1 = \App\Stock::where('Office_Code', '=', $stock_ar['Office_Code'])->where('Product_Code', '=', $stock_ar['Product_Code'])->first();
                    $stock1->Hold_Qty = $stock1->Hold_Qty + $stock_ar['Hold_Qty'];
                    $stock1->save();
                }

                $payment_request = \App\Payment::create([
                    'Order_Code' => "",
                    'ResponseTransID' => '',
                    'Requested_Amount' => number_format($request->payment_amount, 2, '.', ''),
                    'PaymentMode' => '',
                    'TransactionTime' => date('Y-m-d H:m:s'),
                    'TransStatus' => '',
                    'Response_Code' => '',
                    'RESPMSG' => '',
                    'GatewayName' => '',
                    'BankTransID' => '',
                    'BankName' => '',
                    'User_ID' => $user->id,
                    'Wallet_Amount' => $request->Wallet_Amount,
                ]);

                require_once "../vendor/paytm/paytmchecksum/PaytmChecksum.php";
                $paid_amount = 0;
$paid_amount = $request->payment_amount;
                $paytmParams = array();

                $paytmParams["body"] = array(
                    "requestType" => "Payment",
                    "mid" => "YtBoHw17737500171583",
                    "websiteName" => "WEBSTAGING",
                    "orderId" => "NMLID-" . $payment_request->id,
                    "callbackUrl" => "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=NMLID-" . $payment_request->id,
                    "txnAmount" => array(
                        "value" => number_format($paid_amount, 2, '.', ''),
                        "currency" => "INR",
                    ),
                    "userInfo" => array(
                        "custId" => $chemist->id,
                    ),
                );

/*
 * Generate checksum by parameters we have in body
 * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
 */
                $checksum = \PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "zTU5qr5NnXmcmTy5");

                $paytmParams["head"] = array(
                    "signature" => $checksum,
                );

                $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
                $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=YtBoHw17737500171583&orderId=NMLID-" . $payment_request->id;

/* for Production */
// $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                $response = curl_exec($ch);
                $data['response'] = $response;
                $data['ORDER_ID'] = 'NMLID-' . $payment_request->id;
                $data['callbackUrl'] = "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=NMLID-" . $payment_request->id;
                return response()->json(['status' => true, 'message' => 'you order is initiated, we are waiting for payment submission', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Your Card is Empty, Please Add Alteast One Item'], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 200);
        }
    }

    public function customer_list_of_order_history_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();

        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $data = [];
            $orders = \App\Order::where('user_id', '=', $user->id)->orderBy('id', 'DESC')->get();
            if (count($orders)) {
                foreach ($orders as $order) {
                    $order_prod = [];
                    $order_products = \App\OrderProduct::where('Order_Id', '=', $order->id)->get();
                    foreach ($order_products as $order_product) {
                        $product = \App\Product::find($order_product->product_id);
                        $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                        if ($product_image) {
                            $order_product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                        } else {
                            $order_product->image = "";
                        }
                        $order_product->Rate = number_format($order_product->Rate, 2, '.', '');
                        $order_product->Subtotal = number_format($order_product->Subtotal, 2, '.', '');
                        $order_product->brand_name = $product->brand_name;
                        $order_product->generic_name = $product->generic_name;
                        $order_prod[] = $order_product;
                    }
                    $order['order_product'] = $order_prod;
                    $data[] = $order;
                }
                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Found. Please Try Again'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function customer_responce_from_paytm_App(Request $request)
    {
        //   require_once("../vendor/paytm/paytmchecksum/PaytmChecksum.php");

        //      $transaction = PaytmWallet::with('receive');

        //     $response = $transaction->response();
        $response = $request->all();
        // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        if ($response['STATUS'] == "TXN_SUCCESS") {

            $payment_id = explode('-', $response['ORDERID']);
            $payment = \App\Payment::find($payment_id[1]);
            $user = \App\User::find($payment->User_ID);
            Auth::login($user);
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['token_type'] = 'Bearer';
            $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
            if ($chemist) {
                $site_route = $request->getSchemeAndHttpHost();
                $success['chemist_name'] = $chemist->Party_Name;
                $success['Party_Code'] = $chemist->Party_Code;
                $success['ShopPhoto'] = $site_route . "/" . $chemist->ShopPhoto;
                $success['contact_person'] = $chemist->Mobile_No;
            }
            $success['role'] = $user->role;
            $success['mobile'] = $user->mobile;
            $success['status'] = 'verify';
            $success['password'] = $user->password;
            $success['role'] = $user->role;
            $success['wallet'] = $user->wallet;
            if ($user->address) {
                $success['address'] = $user->address . " " . $user->landmark . " " . $user->city . " " . $user->state;
                $success['pincode'] = $user->pincode;
            }
            $payment->Order_Code = $response['ORDERID'];
            $payment->ResponseTransID = $response['TXNID'];
            $payment->Requested_Amount = $response['TXNAMOUNT'];
            $payment->PaymentMode = $response['PAYMENTMODE'];
            $payment->TransactionTime = $response['TXNDATE'];
            $payment->TransStatus = $response['STATUS'];
            $payment->Response_Code = $response['RESPCODE'];
            $payment->GatewayName = $response['GATEWAYNAME'];
            $payment->BankTransID = $response['BANKTXNID'];
            $payment->BankName = $response['BANKNAME'];
            $wallet = 0;
            if (\Auth::user()) {
                if (\Auth::user()->wallet > 100) {
                    $wallet = 100;
                } else {
                    $wallet = \Auth::user()->wallet;
                }
                $user->wallet = $user->wallet - $wallet;
                $user->save();
            }

            $address = \App\Address::where('user_id', '=', \Auth::user()->id)->where('set_as_a_current', '=', 'Yes')
                ->where('set_as_a_default', '=', 'Yes')
                ->first();
            if ($address) {
            } else {
                $address = \App\Address::where('user_id', '=', \Auth::user()->id)->where('set_as_a_current', '=', 'Yes')
                    ->where('set_as_a_default', '=', 'Yes')
                    ->first();
            }

            $order = \App\Order::create([
                'user_id' => \Auth::user()->id,
                'Party_Name' => $address->Contact_Person,
                'Address1' => $address->Address1,
                'Address2' => $address->Address2,
                'Address3' => $address->Address3,
                'Mobile_No' => $address->Mobile_No,
                'PIN' => $address->PIN,
                'City_Code' => $address->City_Code,
                'State_Code' => $address->State_Code,
            ]);
            $payment->Order_ID = $order->id;
            $payment->Testing_Payment = 1;
            $payment->save();
            $product_carts = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
            $card_subtotal = 0;
            $grand_total = 0;

            foreach ($product_carts as $product_cart) {
                $subtotal = 0;
                $amount = 0;
                $discount = 0;
                $subtotal = $product_cart->amount * $product_cart->Qty;
                $card_subtotal = $card_subtotal + $product_cart->amount * $product_cart->Qty;
                $product_detail = \App\Product::find($product_cart->product_id);

                if ($product_detail) {
                    if (\Auth::user()->role == 'Chemist') {
                        $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                            ->where('ProductPriceType_Code', '=', 7)
                            ->first();
                        $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                    } else {
                        $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)->where('ProductPriceType_Code', '=', '10')->first();
                        $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                            ->where('ProductPriceType_Code', '=', 9)
                            ->first();
                    }
                }
                $amount = $subtotal - $discount;
                $p_tax = $amount * $product_price->GST / 100;
                $p_total = $amount + $p_tax;
                $order_product = \App\OrderProduct::create([
                    'Order_Id' => $order->id,
                    'product_id' => $product_detail->id,
                    'Product_Code' => $product_detail->product_code,
                    'Order_Qty' => $product_cart->Qty,
                    'Rate' => $product_cart->amount,
                    'Amount' => $amount,
                    'Taxable' => $subtotal,
                    'TaxRate' => $product_price->GST,
                    'Tax' => $p_tax,
                    'Total' => $p_total,
                    'Discount' => $product_detail->offer,
                ]);
                $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $order_product->Product_Code)->first();
                if ($sales_scheme) {
                    $dividend = $product_cart->Qty;
                    $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                    $output = intdiv($dividend, $divisor);
                    $order_product->Free_Qty = $output * $sales_scheme->Free_Qty;
                }
                if ($mrp_product_price) {
                    $order_product->MRP = $mrp_product_price->Price;
                } else {
                    $order_product->MRP = 0;
                }
                $order_product->save();
            }
            foreach ($product_carts as $product_cart) {
                if ($product_cart->count()) {
                    $product_cart->delete();
                }
            }
            if (\Auth::user()->role == 'Chemist') {
                $chemist = \App\Chemist::where('user_id', '=', \Auth::user()->id)->first();
                $order->Party_ID = $chemist->id;
                $order->Party_Code = $chemist->Party_Code;
                $order->Party_Name = $chemist->Party_Name;
                $order->GSTIN = $chemist->GSTIN;
                $gst_amount = $card_subtotal * $product_price->GST / 100;
            } else {
                $order->GSTIN = 'null';
                $gst_amount = $card_subtotal * $product_price->GST / 100;
            }
            $grand_total1 = 0;
            $grand_total1 = $card_subtotal + $gst_amount;
            if($grand_total1>=500){
                $Delivery_Amount = 0;
            }else{
                $Delivery_Amount = 50;
            }
            
            $grand_total = $card_subtotal + $Delivery_Amount + $gst_amount;
            $grand_total_invoice = $card_subtotal - $wallet + $Delivery_Amount + $gst_amount;
            $pincode = \App\Pincode::where('pincode', '=', $order->PIN)->first();
            $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
            $order->Delivery_Amount = $Delivery_Amount;
            $order->Taxable_Amount = $card_subtotal;
            $order->Tax_Amount = $gst_amount;
            $order->WalletAmount = $wallet;
            $order->Discount_Amount = 0;
            $order->Grand_Total = $grand_total;

            $order->Order_No = 'NSRID-' . $order->id;
            $order->Order_Date = date('Y-m-d H:i:s');
            $order->Product_Amount = $card_subtotal;
            $order->Payment_Amount = $grand_total_invoice;
            $order->Payment_Status = $response['STATUS'];
            $order->OrderStatus_Code = 5;
            $order->OrderFrom_Code = 1;
            $order->is_update = 0;
            $order->Testing_Order = 1;
            if ($office_state) {
                $order->Office_Code = $office_state->Office_Code;
            } else {
                $order->Office_Code = 31;
            }
            $order->save();
            $reward_point = \App\RewardPoint::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'Order_No' => $order->Order_No,
                'Order_Code' => $order->Order_Code,
                'Order_Date' => $order->Order_Date,
                'Tax_Amount' => $order->Taxable_Amount,
                'Reward_Point' => round($order->Taxable_Amount * 2 / 100),
            ]);
            $balance = \App\RewardReferenceLedger::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->first();
            $reward_reference_ledger_debit1 = null;
            if ($payment->Wallet_Amount) {
                $reward_reference_ledger_debit1 = \App\RewardReferenceLedger::create([
                    'Reference' => $order->Order_No,
                    'Date_Time' => date('Y-m-d H:i:s'),
                    'Debit' => $payment->Wallet_Amount,
                    'Credit' => 0,
                    'user_id' => $user->id,
                ]);
                $reward_reference_ledger_debit1->Balance = $balance->Balance - $payment->Wallet_Amount;
                $reward_reference_ledger_debit1->save();
            }
    
            $reward_reference_ledger_debit2 = \App\RewardReferenceLedger::create([
                'Reference' => $order->Order_No,
                'Date_Time' => date('Y-m-d H:i:s'),
                'Debit' => 0,
                'Credit' => round($order->Taxable_Amount * 2 / 100),
                'user_id' => $user->id,
            ]);
            if ($reward_reference_ledger_debit1) {
                $reward_reference_ledger_debit2->Balance = $reward_reference_ledger_debit1->Balance + round($order->Taxable_Amount * 2 / 100);
            } else {
                $reward_reference_ledger_debit2->Balance = $balance->Balance + round($order->Taxable_Amount * 2 / 100);
            }
            $reward_reference_ledger_debit2->save();
    
            $reard_transaction = \App\RewardTransaction::create([
                'Transaction_Date' => date('Y-m-d H:i:s'),
                'RewardPointOf_Code' => 1,
                'Reference_Code' => $reward_reference_ledger_debit2->id,
                'RewardTransactionType_Code' => 2,
                'Points' => round($order->Taxable_Amount * 2 / 100),
                'user_id' => $user->id,
            ]);
            $order_product_arr = "";
            $order_products = \App\OrderProduct::where('Order_Id', '=', $order->id)->get();
            if ($address) {
                $pincode = \App\Pincode::where('pincode', '=', $order->PIN)->first();
                $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
            }
            foreach ($order_products as $order_product) {
                $sub = 0;
                $sub = $order_product->Rate * $order_product->Order_Qty;
                $product = \App\Product::find($order_product->product_id);
                $stock = \App\Stock::where('Office_Code', '=', $office_state->Office_Code)->where('Product_Code', '=', $order_product->Product_Code)->first();
                if ($stock) {
                    $stock_hold = \App\StockHold::where('User_Id', '=', \Auth::user()->id)->where('Office_Code', '=', $stock->Office_Code)->where('Product_Code', '=', $stock->Product_Code)->delete();
                    $stock->Ordered_Qty = $stock->Ordered_Qty + $order_product->Order_Qty + $order_product->Free_Qty;
                    $stock->QtyForNewOrder = $stock->QtyForNewOrder - $order_product->Order_Qty - $order_product->Free_Qty;
                    $stock->Hold_Qty = $stock->Hold_Qty - $order_product->Order_Qty - $order_product->Free_Qty;
                    $stock->save();
                }
            }
        }

        $mobile = $order->Mobile_No;
        $key = "fdAu5P2aUI1";
        $sender = "NESTOR";
        $service = "TEMPLATE_BASED";
        $message = "Thank you for trusting Nestor online. Your order No. ".$order->Order_No." has been placed. Estimated delivery date ".date("d-M-Y", strtotime($exp_date)).". Track order @https://play.google.com/store/apps/details?id=com.nestorpharma.b2b_app";
        $message = urlencode($message);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=" . $key . "&MobileNo=" . $mobile . "&SenderID=NESTOR&Message=" . $message . "&ServiceName=" . $service);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $return_val = curl_close($ch);
        if ($output == "") {
            echo "Process Failed, Please check domain, username and password.";
        } else {
            echo "$output";
        }
        $data = [];
        $data['order'] = $order;
        $data['user'] = $success;
        $data['response'] = $response;
        return response()->json(['status' => true, 'message' => 'You Order is Placed', 'data' => $data], 200);
    }

    public function customer_order_detail_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();

        if ($request->order_id) {
            $explode_order_id = explode("-", $request->order_id);

            if ($explode_order_id[1]) {

                $payment = \App\Payment::find($explode_order_id[1]);

                if ($payment) {
                    $order = \App\Order::find($payment->Order_ID);

                    if ($order) {
                        $order_prod = [];
                        $order_products = \App\OrderProduct::where('Order_Id', '=', $order->id)->get();
                        $state = \App\State::where('State_Code', '=', $order->State_Code)->first();
                        if ($state) {
                            $order->state = $state->name;
                        }
                        $city = \App\City::where('City_Code', '=', $order->City_Code)->first();
                        if ($city) {
                            $order->city = $city->name;
                        }

                        $order->Order_No = "NSRID-" . $order->id;
                        $order->Order_Date = $order->created_at->format('Y-m-d H:i');
                        $order->ProcessingOn = $order->created_at->format('Y-m-d H:m:s');
                        if (date('Y-m-d H:i:s', strtotime($order->created_at->format('Y-m-d H:m:s') . ' +1 day')) < date('Y-m-d H:i:s')) {
                            $order->PackedOn = date('Y-m-d H:i:s', strtotime($order->created_at->format('Y-m-d H:m:s') . ' +1 day'));
                        }

                        if (date('Y-m-d H:i:s', strtotime($order->created_at->format('Y-m-d H:m:s') . ' +1 day')) < date('Y-m-d H:i:s')) {
                            $order->DispatchedOn = date('Y-m-d H:i:s', strtotime($order->created_at->format('Y-m-d H:m:s') . ' +1 day'));
                        }
                        if (date('Y-m-d H:i:s', strtotime($order->created_at->format('Y-m-d H:m:s') . ' +3 day')) < date('Y-m-d H:i:s')) {
                            $order->DeliveredOn = date('Y-m-d H:i:s', strtotime($order->created_at->format('Y-m-d H:m:s') . ' +3 day'));
                        }
                        $order_status = \App\OrderStatus::find($order->OrderStatus_Code);
                        if ($order_status) {
                            $order->OrderStatus = $order_status->OrderStatus_Name;
                        }
                        $no_of_item = 0;
                        foreach ($order_products as $order_product) {
                            $product = \App\Product::find($order_product->product_id);
                            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                            if ($product_image) {
                                $order_product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                            } else {
                                $order_product->image = "";
                            }
                            $order_product->product_id = $product->id;
                            $order_product->brand_name = $product->brand_name;
                            $order_product->generic_name = $product->generic_name;
                            $no_of_item = $no_of_item + $order_product->Order_Qty;
                            $order->no_of_item = $no_of_item;

                            $order_prod[] = $order_product;
                        }
                        $order['order_product'] = $order_prod;
                        $data = $order;

                        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
                    }

                } else {
                    return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);

                }
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);

            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function customer_book_an_appointment_App(Request $request)
    {
        $user = \App\User::where('mobile', $request->mobile)->where('role', 'User')->first();

        if ($user) {
            $doctor_appointment = \App\Doctorappointment::create([
                'symptoms' => $request->symptoms,
                'mobile' => $request->mobile,
                'user_id' => $user->id,
                'doctor_type' => $request->doctor_type,
            ]);
            if ($request->file('file_attechment')) {
                $image = $request->file('file_attechment');
                $filename = $image->getClientOriginalName();
                $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
                $image->move("upload", $fullname);
                $doctor_appointment->file_attechment = 'upload/' . $fullname;
            }
            $doctor_appointment->save();

            return response()->json(['status' => true, 'message' => 'Your Appointment Submit Successfully. Our Representative Call you Asap'], $this->successStatus);

        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function customer_account_App(Request $request)
    {
        $user = \App\User::where('mobile', $request->mobile)->where('status', 'verify')->first();
        if ($user) {
            $chemist = \App\Chemist::where('user_id', $user->id)->with('addresses')->first();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chemist], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }


    public function customer_add_to_cart_guest_to_login_user_App(Request $request)
    {
        
        $All_Data = json_decode($request->All_Data);
     
        $user = \App\User::where('mobile', $All_Data->mobile)->where('role','User')->where('status', 'verify')->first();

        if ($user) {
            
            foreach($All_Data->products as $add_to_cart_product){
                $addtocard_product = \App\Addtocard::create([
                    'user_id' => $user->id,
                    'product_id' => $add_to_cart_product->product_id,
                    'Qty' => $add_to_cart_product->Qty,
                    'amount' => $add_to_cart_product->amount,
                ]);
            }
            return response()->json(['status' => true, 'message' => 'Product Add to Cart Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'],401);
        }
    }

    public function customer_delete_address_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $address = \App\Address::where('user_id', $user->id)->where('id', $request->address_id)->delete();

            return response()->json(['status' => true, 'message' => 'Address Delete Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

        public function customer_get_reward_ledger_App(Request $request)
    {
        $user = \App\User::where('role', 'User')->where('mobile', $request->mobile)->where('status', 'verify')->first();
        if ($user) {
            $reward_reference_ledgers = \App\RewardReferenceLedger::where('user_id', $user->id)->get();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $reward_reference_ledgers], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    
    public function customer_current_reward_balance_App(Request $request)
    {
        $user = \App\User::where('role', 'User')->where('mobile', $request->mobile)->where('status', 'verify')->first();
        if ($user) {
            $data['balance'] = \App\RewardReferenceLedger::where('user_id', $user->id)->orderBy('id', 'DESC')->select('balance')->first();
            if ($user->wallet >= 100) {
                $data['reward_check'] = 1;
            } else {
                $data['reward_check'] = 0;
            }
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    

}