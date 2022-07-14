<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class APIController extends Controller
{
    public $successStatus = 200;

    public function upload_prescription_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $user = \App\User::where('mobile', '=', $request->mobile)->where('ApprovalSatus_Code', '=', 3)->first();

        if ($user && count($request->upload_prescription)) {
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
                'user_id' => $user->id,
            ]);

            if ($upload_prescription->add_medicine == 1) {
                $upload_prescription->add_medicine = "on";
            } else {
                $upload_prescription->add_medicine = "";
            }

            if ($upload_prescription->get_call == 1) {
                $upload_prescription->get_call = "on";
            } else {
                $upload_prescription->get_call = "";
            }
            return response()->json(['status' => true, 'message' => 'Prescription Uplaod Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match'], $this->successStatus);
        }
    }

    public function home_App()
    {
        $site_route = $request->getSchemeAndHttpHost();
        $main_sliders = \App\Slider::where('slider_type', '=', 'home_page_main')->select(['title', 'url_link', 'image'])->get();
        foreach ($main_sliders as $main_slider) {
            $main_slider->image = $site_route . "/" . $main_slider->image;
        }

        $shop_by_healthareas_groupcategories = \App\Groupcategory::whereIn('id', ['37', '39', '40', '44', '48', '11'])->get();

        foreach ($shop_by_healthareas_groupcategories as $shop_by_healthareas_groupcategory) {
            if ($shop_by_healthareas_groupcategory->id == '37') {
                $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/doctor.png";
            } elseif ($shop_by_healthareas_groupcategory->id == '39') {
                $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/healthcare.png";
            } elseif ($shop_by_healthareas_groupcategory->id == '40') {
                $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/heart.png";
            } elseif ($shop_by_healthareas_groupcategory->id == '44') {
                $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/healthcare.png";
            } elseif ($shop_by_healthareas_groupcategory->id == '48') {
                $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/baby-boy.png";
            } elseif ($shop_by_healthareas_groupcategory->id = '11') {
                $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/diet.png";
            } else {
            }

        }

        $deal_of_the_day_sliders = \App\Slider::where('slider_type', '=', 'home_page_second_top')->get();
        $hot_seller_products = \App\Product::select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code'])->get();
        $trending_today_products = \App\Product::select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code'])->get();
        $shop_by_category_groups = \App\Group::get();

        foreach ($deal_of_the_day_sliders as $deal_of_the_day_slider) {
            $deal_of_the_day_slider->image = $site_route . "/" . $deal_of_the_day_slider->image;
        }

        foreach ($shop_by_category_groups as $shop_by_category_group) {
            $shop_by_category_group->image = $site_route . "/" . $shop_by_category_group->image;
        }

        foreach ($hot_seller_products as $product) {

            $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
            if ($product_image) {
                $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }
            $product['offer'] = "10 % Off";

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

        }

        foreach ($trending_today_products as $product) {

            $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
            if ($product_image) {
                $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }
            $product['offer'] = "10 % Off";

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

        }

        $offers = \App\Offer::all();
        $data1['type'] = 'Slider';
        $data1['data'] = $main_sliders;
        $data[] = $data1;

        $data2['type'] = 'Shop_By_Healthareas';
        $data2['data'] = $shop_by_healthareas_groupcategories;
        $data[] = $data2;

        $data3['type'] = 'Deal_Of_The_Day';
        $data3['data'] = $deal_of_the_day_sliders;
        $data[] = $data3;

        $data4['type'] = 'Hot_Sellers';
        $data4['data'] = $hot_seller_products;
        $data[] = $data4;

        $data5['type'] = 'Slider2';
        $data5['data'] = $main_sliders;
        $data[] = $data5;

        $data6['type'] = 'Trending_Today';
        $data6['data'] = $trending_today_products;
        $data[] = $data6;

        $data7['type'] = 'Shop_By_Category';
        $data7['data'] = $shop_by_category_groups;
        $data[] = $data7;
        if ($data) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function product_App()
    {
        $site_route = $request->getSchemeAndHttpHost();
        $order_history[] = null;
        $trending_todays = \App\Product::all();
        $main_sliders = \App\Slider::where('slider_type', '=', 'home_page_main')->get();
        $deal_of_the_day_sliders = \App\Slider::where('slider_type', '=', 'home_page_second_top')->get();
        $a1['main_slider'] = $main_sliders;
        $a1['deal_of_the_day'] = $deal_of_the_day_sliders;
        $a1['order_history'] = $order_history;
        $a1['trending_today'] = $trending_todays;
        return response()->json(['status' => true, 'message' => 'Your Chemist Home Page API Work Successfully', 'data' => $a1], $this->successStatus);
    }

    public function book_a_doctor_appointment_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        if ($request->symptoms && $request->email && $request->mobile) {
            $doctorappointment = \App\Doctorappointment::create([
                'symptoms' => $request->input('symptoms'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
            ]);
            if ($request->file('file_attechment')) {
                $image = $request->file('file_attechment');
                $filename = $image->getClientOriginalName();
                $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
                $image->move("upload", $fullname);
                $doctorappointment->image = 'upload/' . $fullname;
            }
            $doctorappointment->save();
            return response()->json(['status' => true, 'message' => 'Your Request has been Accepted. Our Team Will be Contact with You Soon'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Please Fill Your Full Detail And Try Again'], $this->successStatus);
        }
    }

    public function aboutus_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $data['title1'] = 'Our Belief "Life Comes First"';
        $data['image1'] = $site_route . '/factory.jpg';
        $data['title11'] = 'Our Mission';
        $data['description11'] = 'To deliver best quality products at an affordable price. Worldwide for the masses';
        $data['description12'] = '';
        $data['title2'] = '';
        $data['image2'] = $site_route . '/nestor_about_us.jpeg';
        $data['description21'] = 'Products offered and developed through one of the most modern R&D facilities from our Goa facility';
        $data['description22'] = '';

        // $data['footer_title11'] = 'Nestor Pharmaceuticals Ltd.';
        // $data['footer_description11'] = 'Nestor Pharmaceuticals Ltd. is a rapidly growing global enterprise backed by more than four decades of expertise in manufacture and marketing of a wide array of ethical allopathic branded and generic formulations.';
        // $data['footer_title21'] = 'Contact Us';
        // $data['address21'] = 'S-22/6, DLF Phase III Gurgaon-122010, INDIA';
        // $data['mobile21'] = '0124-4045132';
        // $data['mobile22'] = '0124-4045162';
        // $data['email'] = 'info@nestorpharmaceuticals.com';
        // $data['footer_title22'] = 'Visitor Count';
        // $data['visitor_count'] = '23';
        // $data['footer_title31'] = 'Quick Contacts';
        // $data['footer_description31'] = 'If you have any questions or need help, feel free to contact with our team.';
        // $data['mobile31'] = '0124-4045132';
        // $data['mobile32'] = '0124-4045162';
        // $data['address31'] = 'S-22/6, DLF Phase III Gurgaon-122010, INDIA';

        return response()->json(['status' => true, 'message' => 'Your About Us API Work Successfully', 'data' => $data], $this->successStatus);

    }

    public function group_list(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $groups = \App\Group::with('groupcategories')->whereNotIn('id', [57])->get();
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $groups], $this->successStatus);
    }

    public function terms_and_conditions_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $success = 'Nestor Pharmaceutical welcomes your interest in our company and your visit to our Website. The following conditions set forth the basic rules that govern to use of our Site.';
        return response()->json(['status' => true, 'message' => 'Your Terms And Conditions API Work Successfully', 'data' => $success], $this->successStatus);

    }

    public function search_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        if ($request->name) {
            $product_list = [];
            $products = \App\Product::where('go_live', 1)->where('brand_name', 'LIKE', $request->name . '%')->orWhere('generic_name', 'LIKE', $request->name . '%')->limit(5)->get();
            if (strlen($request->search_names) >= 1) {
                $product1s = \App\Product::where('go_live', 1)->where('brand_name', 'LIKE', '%' . $request->name . '%')->where('ProductBrand_Code', 2)->limit(5)->get();
                if ($product1s) {
                    $products = $products->merge($product1s);
                }
                $product2s = \App\Product::where('go_live', 1)->where('brand_name', 'LIKE', '%' . $request->name . '%')->where('ProductBrand_Code', 3)->limit(5)->get();
                if ($product1s) {
                    $products = $products->merge($product2s);
                }

            }
            if (strlen($request->name) >= 1) {
                $ProductHashTags = \App\ProductHashTag::where('ProductHashtag_Name', 'LIKE', $request->name . '%')->get();
                if (count($ProductHashTags)) {
                    $ProductHashTagDetails = \App\ProductHashTagDetail::whereIn('ProductHashtag_Code', $ProductHashTags->map(function ($ProductHashTag) {
                        return $ProductHashTag->ProductHashtag_Code;
                    }))->get();
                    $product1s = \App\Product::where('go_live', 1)->whereIn('product_code', $ProductHashTagDetails->map(function ($ProductHashTagDetail) {
                        return $ProductHashTagDetail->Product_Code;
                    }))->limit(5)->get();
                    $products = $products->merge($product1s);
                }
            }

            if (strlen($request->name) >= 1) {
                $product_uses = \App\Productuse::where('ProductUse_Name', 'LIKE', $request->name . '%')->get();
                if (count($product_uses)) {
                    $productuse_details = \App\ProductuseDetail::whereIn('ProductUse_Code', $product_uses->map(function ($product_use) {
                        return $product_use->ProductUse_Code;
                    }))->distinct()->get(['Product_Code']);

                    $product1s = \App\Product::where('go_live', 1)->whereIn('product_code', $productuse_details->map(function ($productuse_detail) {
                        return $productuse_detail->Product_Code;
                    }))->limit(5)->get();

                    $products = $products->merge($product1s);

                }

            }
            if (strlen($request->name) >= 1) {
                $group = \App\Group::where('name', 'LIKE', $request->name . '%')->first();
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

            if (strlen($request->name) >= 1) {
                $single_groupcategory = \App\Groupcategory::where('name', 'LIKE', $request->name . '%')->first();

                if ($single_groupcategory) {
                    $product_group_categories = \App\ProductGroupCategories::where('groupcategory_id', $single_groupcategory->id)->get();

                    $product1s = \App\Product::where('go_live', 1)->whereIn('products.product_code', $product_group_categories->map(function ($product_group_category) {
                        return $product_group_category->Product_Code;
                    }))->limit(5)->get();

                    $products = $products->merge($product1s);
                }

            }

            // if (strlen($request->name) >= 1) {
            //     $product1s = \App\Product::where('brand_name', 'LIKE', '%' . $request->name . '%')->where('ProductBrand_Code', 2)->get();
            //     if ($product1s) {
            //         $products = $products->merge($product1s);
            //     }
            //     $product2s = \App\Product::where('brand_name', 'LIKE', '%' . $request->name . '%')->where('ProductBrand_Code', 3)->get();
            //     if ($product1s) {
            //         $products = $products->merge($product2s);
            //     }
            // }
            if (count($products)) {
                foreach ($products as $product) {
                    $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                    $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                    $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();
                    $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                    if ($product_image) {
                        $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    } else {
                        $product->image = "";
                    }
                    $product->offer = "10 % Off";

                    if ($product_price) {
                        $product->actual_amount = number_format($product_price->Price, 2, '.', '');

                    } else {
                        $product->actual_amount = "0.00";

                    }

                    if ($chemist_product_price) {
                        $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
                    } else {
                        $product->chemist_amount = "0.00";

                    }

                    if ($mrp_product_price) {
                        $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                        $product->gst = $mrp_product_price->GST . " %";
                    } else {
                        $product->mrp_amount = "0.00";

                        $product->gst = "0.00";

                    }
                    $group = \App\Group::find($product->group_id);
                    if ($group) {
                        $product->group = $group->name;
                    }
                    $group_category = \App\Groupcategory::find($product->groupcategory_id);
                    if ($group_category) {
                        $product->group_category = $group_category->name;
                    }
                    $login_user = $request->user();
                    $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
                        ->where('set_as_a_default', '=', 'Yes')
                        ->where('set_as_a_current', '=', 'Yes')
                        ->first();
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
                    if ($package) {
                        $product->package = $package->name;
                    }

                    $product_list[] = $product;
                }
                return response()->json(['status' => true, 'message' => 'Data fatch Successfully', 'data' => $product_list], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function product_detail_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $login_user = $request->user();
        $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
            ->where('set_as_a_default', '=', 'Yes')
            ->where('set_as_a_current', '=', 'Yes')
            ->first();
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

        $single_product = \App\Product::find($request->product_id);
        if ($single_product) {
            $group = \App\Group::find($single_product->group_id);
            $groupcategory = \App\Groupcategory::find($single_product->groupcategory_id);
            $product_price = \App\Productprice::where('Product_Code', '=', $single_product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $chemist_product_price = \App\Productprice::where('Product_Code', '=', $single_product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $mrp_product_price = \App\Productprice::where('Product_Code', '=', $single_product->product_code)->where('ProductPriceType_Code', '=', '8')->first();
            if ($group) {
                $single_product->group_name = $group->name;
            }
            if ($groupcategory) {
                $single_product->group_category_name = $groupcategory->name;
            }
            if ($single_product) {
                $package = \App\Package::find($single_product->package_id);
                if ($package) {
                    $single_product->package_name = $package->name;
                }
                $category = \App\Category::find($single_product->category_id);
                if ($category) {
                    $single_product->product_type = $category->name;
                }
                if ($product_price) {
                    $single_product->actual_amount = $product_price->Price;
                } else {
                    $single_product->actual_amount = "0.00";
                }
                if ($chemist_product_price) {
                    $single_product->chemist_amount = $chemist_product_price->Price;
                } else {
                    $single_product->chemist_amount = "0.00";
                }
                if ($mrp_product_price) {
                    $single_product->mrp_amount = $mrp_product_price->Price;
                    $single_product->gst = $mrp_product_price->GST . " %";
                } else {
                    $single_product->mrp_amount = "0.00";
                    $single_product->gst = "0.00";
                }

                if ($mrp_product_price && $chemist_product_price) {
                    $total = $chemist_product_price->Price + $chemist_product_price->Price * $chemist_product_price->GST / 100;
                    $margin = 0.00;
                    $margin = ($mrp_product_price->Price - $total) * 100 / $total;
                } else {
                    $margin = 0.00;
                }
                $single_product->margin = number_format($margin, 2, '.', '');

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
                $related_products = \App\Product::where('go_live', 1)->where('groupcategory_id', '=', $single_product->groupcategory_id)->whereNotIn('id', [$single_product->id])->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code'])->get();
                if (count($related_products)) {
                    foreach ($related_products as $product) {
                        $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                        $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                        $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();
                        $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                        if ($product_image) {
                            $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                        } else {
                            $product->image = "";
                        }
                        $product->offer = "10 % Off";

                        if ($product_price) {
                            $product->actual_amount = number_format($product_price->Price, 2, '.', '');
                        } else {
                            $product->actual_amount = "0.00";
                        }

                        if ($chemist_product_price) {
                            $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
                        } else {
                            $product->chemist_amount = "0.00";
                        }

                        if ($mrp_product_price) {
                            $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                            $product->gst = $mrp_product_price->GST . " %";
                        } else {
                            $product->mrp_amount = "0.00";
                            $product->gst = "0.00";
                        }
                        if ($mrp_product_price && $chemist_product_price) {
                            $total = $chemist_product_price->Price + $chemist_product_price->Price * $chemist_product_price->GST / 100;
                            $margin = 0.00;
                            $margin = ($mrp_product_price->Price - $total) * 100 / $total;
                        } else {
                            $margin = 0.00;
                        }
                        $product->margin = number_format($margin, 2, '.', '');
                        $login_user = $request->user();
                        $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
                            ->where('set_as_a_default', '=', 'Yes')
                            ->where('set_as_a_current', '=', 'Yes')
                            ->first();
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

                        if ($product->stock_by_office($Global_Office_Code)) {
                            if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                                $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                            } else {
                                $product->stock_in = "0.00";
                            }
                        } else {
                            $product->stock_in = "0.00";

                        }
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

    public function chemist_home_App(Request $request)
    {
        $login_user = $request->user();
        $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
            ->where('set_as_a_default', '=', 'Yes')
            ->where('set_as_a_current', '=', 'Yes')
            ->first();
        if ($pincode1) {
            $pincode = \App\Pincode::where('pincode', $pincode1->PIN)->first();
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
        $user = \App\User::where('role', '=', 'Chemist')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $order_history[] = null;
            $trending_todays = \App\Product::all();
            $main_sliders = \App\Slider::whereNotNull('mobile_image')->select(['id', 'title', 'image', 'mobile_image'])->get();

            foreach ($main_sliders as $main_slider) {
                $main_slider->image = $site_route . "/" . $main_slider->mobile_image;
            }
            $deal_of_the_day_sliders = \App\Slider::where('slider_type', '=', 'home_page_second_top')->select(['id', 'title', 'image'])->get();
            foreach ($deal_of_the_day_sliders as $deal_of_the_day_slider) {
                $deal_of_the_day_slider->image = $site_route . "/" . $deal_of_the_day_slider->image;
            }
            $data1['type'] = 'Slider';
            $data1['data'] = $main_sliders;
            $data[] = $data1;

            $button['button'] = 'Order_Now';
            $button['message'] = 'Place And Order';
            $data2['type'] = 'Button';
            $data2['data'] = $button;
            $data[] = $data2;

            $call['phoneNo'] = '01244522400';
            $call['message'] = 'Call to Order Your Medicine';

            $data3['type'] = 'Call';
            $data3['data'] = $call;
            $data[] = $data3;

            //   $shop_by_category_groups = \App\Group::whereNotIn('id', [57])->get();

            //  foreach($shop_by_category_groups as $shop_by_category_group){
            //     $shop_by_category_group->image =$site_route."/".$shop_by_category_group->image;
            //  }

            $data4['type'] = 'Brand';
            $data4['data'] = [['name' => 'OTC Products/Prescription Medicines', 'subname' => 'Nestor', 'image' => $site_route . '/img/nestor_logo.png', 'ProductBrand_Code' => 1], ['name' => 'Medical Consumable/Home care', 'subname' => 'Steriheal', 'image' => $site_route . '/img/Steriheal.jpg', 'ProductBrand_Code' => 2], ['name' => 'Ayurvedic Medicines/Body Care', 'subname' => 'Nectarine', 'image' => $site_route . '/img/NECTARINE.jpg', 'ProductBrand_Code' => 3]];
            $data[] = $data4;

            $button1['button'] = 'Shop_By_Category';
            $data21['type'] = 'Button';
            $data21['data'] = $button1;
            $data[] = $data21;

            $products = \App\Product::where('go_live', 1)->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'package_id'])->skip(1)->limit('20')->get();
            foreach ($products as $product) {

                $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                if ($product_image) {
                    $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                } else {
                    $product->image = "";
                }
                $product->offer = "10 % Off";

                if ($chemist_product_price) {
                    $product->actual_amount = number_format($chemist_product_price->Price, 2, '.', '');
                } else {
                    $product->actual_amount = "0.00";
                }

                if ($chemist_product_price) {
                    $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
                } else {
                    $product->chemist_amount = "0.00";

                }

                if ($mrp_product_price) {
                    $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                    $product->gst = $mrp_product_price->GST . " %";
                } else {
                    $product->mrp_amount = "0.00";
                    $product->gst = "0.00";
                }
                if ($mrp_product_price && $chemist_product_price) {
                    $total = $chemist_product_price->Price + $chemist_product_price->Price * $chemist_product_price->GST / 100;
                    $margin = 0.00;
                    $margin = ($mrp_product_price->Price - $total) * 100 / $total;
                } else {
                    $margin = 0.00;
                }
                $product->margin = number_format($margin, 2, '.', '');

                $package = \App\Package::find($product->package_id);
                if ($package) {
                    $product->package = $package->name;
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

            }

            $orders = \App\Order::where('user_id', '=', $user->id)->orderBy('id', 'DESC')->get();
            $order_prod = [];
            if (count($orders)) {
                $order_prod = [];
                foreach ($orders as $order) {

                    $order_products = \App\OrderProduct::where('Order_Id', '=', $order->id)->get();
                    foreach ($order_products as $order_product) {
                        $product = \App\Product::find($order_product->product_id);
                        if ($product) {
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
                            $order_product->productId = $product->id;
                            $package = \App\Package::find($product->package_id);
                            $login_user = $request->user();
                            $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
                                ->where('set_as_a_default', '=', 'Yes')
                                ->where('set_as_a_current', '=', 'Yes')
                                ->first();
                            if ($pincode1) {
                                $pincode = \App\Pincode::where('pincode', $pincode1->PIN)->first();
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

                            if ($product->stock_by_office($Global_Office_Code)) {
                                if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                                    $order_product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                                } else {
                                    $order_product->stock_in = 0.00;
                                }
                            } else {
                                $order_product->stock_in = 0.00;
                            }

                        }
                        if ($package) {
                            $order_product->package = $package->name;
                        }
                        $order_prod[] = $order_product;
                    }

                }
            }

            $data5['type'] = 'Recent_Order';
            $data5['data'] = $order_prod;
            $data[] = $data5;

            $data6['type'] = 'Trending_Today';
            $data6['data'] = $products;
            $data[] = $data6;

            $shop_by_healthareas_groupcategories = \App\Groupcategory::whereIn('id', ['37', '39', '40', '44', '48', '11'])->get();

            foreach ($shop_by_healthareas_groupcategories as $shop_by_healthareas_groupcategory) {
                if ($shop_by_healthareas_groupcategory->id == '37') {
                    $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/doctor.png";
                } elseif ($shop_by_healthareas_groupcategory->id == '39') {
                    $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/healthcare.png";
                } elseif ($shop_by_healthareas_groupcategory->id == '40') {
                    $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/heart.png";
                } elseif ($shop_by_healthareas_groupcategory->id == '44') {
                    $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/healthcare.png";
                } elseif ($shop_by_healthareas_groupcategory->id == '48') {
                    $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/baby-boy.png";
                } elseif ($shop_by_healthareas_groupcategory->id = '11') {
                    $shop_by_healthareas_groupcategory->image = $site_route . "/img/icons/diet.png";
                } else {
                }

            }

            $data7['type'] = 'Shop _By_Healthareas';
            $data7['data'] = $shop_by_healthareas_groupcategories;
            $data[] = $data7;

//         $a1['order_history'] = $order_history;
            //        $a1['trending_today'] = $trending_todays;
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function our_products_App(Request $request)
    {
        $login_user = $request->user();
        $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
            ->where('set_as_a_default', '=', 'Yes')
            ->where('set_as_a_current', '=', 'Yes')
            ->first();
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

        $site_route = $request->getSchemeAndHttpHost();
        $products = \App\Product::where('go_live', 1)->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'group_id', 'groupcategory_id', 'package_id'])->skip(1)->limit(500)->orderBy('id', 'ASC')->paginate(20);
        if (count($products)) {
            foreach ($products as $product) {

                $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
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

                if ($chemist_product_price) {
                    $product->actual_amount = number_format($chemist_product_price->Price, 2, '.', '');

                } else {
                    $product->actual_amount = "0.00";
                }

                if ($chemist_product_price) {
                    $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
                } else {
                    $product->chemist_amount = "0.00";

                }

                if ($mrp_product_price) {
                    $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                    $product->gst = $mrp_product_price->GST . " %";
                } else {
                    $product->mrp_amount = "0.00";
                    $product->gst = "0.00";
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
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'total_page' => $products->lastPage(), 'data' => $product_list], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function products_by_group_App(Request $request)
    {
        $login_user = $request->user();
        $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
            ->where('set_as_a_default', '=', 'Yes')
            ->where('set_as_a_current', '=', 'Yes')
            ->first();
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

        $site_route = $request->getSchemeAndHttpHost();
        $group = \App\Group::find($request->group_id);

        $groupcategories_list = \App\Groupcategory::where('group_id', $group->id)->get();

        $product_group_categories = \App\ProductGroupCategories::whereIn('groupcategory_id', $groupcategories_list->map(function ($groupcategory) {
            return $groupcategory->id;
        }))->get();

        if ($group) {
            $products = \App\Product::where('go_live', 1)->whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                return $product_group_category->Product_Code;
            }))->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'group_id', 'groupcategory_id', 'package_id'])->paginate(20);
            if (count($products)) {
                foreach ($products as $product) {

                    $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                    $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                    $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                    $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                    if ($product_image) {
                        $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    } else {
                        $product->image = "";
                    }
                    $product->offer = "10 % Off";

                    if ($chemist_product_price) {
                        $product->actual_amount = number_format($chemist_product_price->Price, 2, '.', '');

                    } else {
                        $product->actual_amount = "0.00";

                    }

                    if ($chemist_product_price) {
                        $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
                    } else {
                        $product->chemist_amount = "0.00";

                    }

                    if ($mrp_product_price) {
                        $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                        $product->gst = $mrp_product_price->GST . " %";
                    } else {
                        $product->mrp_amount = "0.00";

                        $product->gst = "0.00";

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
                    $package = \App\Package::find($product->package_id);
                    if ($package) {
                        $product->package = $package->name;
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

    public function products_by_groupcategory_App(Request $request)
    {
        $login_user = $request->user();
        $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
            ->where('set_as_a_default', '=', 'Yes')
            ->where('set_as_a_current', '=', 'Yes')
            ->first();
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

        $site_route = $request->getSchemeAndHttpHost();

        $groupcategory = \App\Groupcategory::find($request->groupcategory_id);
        $product_group_categories = \App\ProductGroupCategories::where('groupcategory_id', $groupcategory->id)->get();

        if ($groupcategory) {
            $products = \App\Product::where('go_live', 1)->whereIn('product_code', $product_group_categories->map(function ($product_group_category) {
                return $product_group_category->Product_Code;
            }))->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'group_id', 'groupcategory_id', 'package_id'])->paginate(20);

            if (count($products)) {
                foreach ($products as $product) {

                    $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                    $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                    $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                    $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                    if ($product_image) {
                        $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                    } else {
                        $product->image = "";
                    }
                    $product->offer = "10 % Off";

                    if ($chemist_product_price) {
                        $product->actual_amount = number_format($chemist_product_price->Price, 2, '.', '');

                    } else {
                        $product->actual_amount = "0.00";

                    }

                    if ($chemist_product_price) {
                        $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
                    } else {
                        $product->chemist_amount = "0.00";

                    }

                    if ($mrp_product_price) {
                        $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                        $product->gst = $mrp_product_price->GST . " %";
                    } else {
                        $product->mrp_amount = "0.00";

                        $product->gst = "0.00";

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
                    $package = \App\Package::find($product->package_id);
                    if ($package) {
                        $product->package = $package->name;
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

    public function products_by_brand_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $products = \App\Product::where('go_live', 1)->where('ProductBrand_Code', '=', $request->ProductBrand_Code)->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'group_id', 'groupcategory_id', 'package_id', 'ProductBrand_Code'])->paginate(20);
        if (count($products)) {
            foreach ($products as $product) {

                $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                if ($product_image) {
                    $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                } else {
                    $product->image = "";
                }
                $product->offer = "10 % Off";

                if ($chemist_product_price) {
                    $product->actual_amount = number_format($chemist_product_price->Price, 2, '.', '');

                } else {
                    $product->actual_amount = "0.00";

                }

                if ($chemist_product_price) {
                    $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
                } else {
                    $product->chemist_amount = "0.00";

                }

                if ($mrp_product_price) {
                    $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                    $product->gst = $mrp_product_price->GST . " %";
                } else {
                    $product->mrp_amount = "0.00";

                    $product->gst = "0.00";

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
                $package = \App\Package::find($product->package_id);
                if ($package) {
                    $product->package = $package->name;
                }
                $login_user = $request->user();
                $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
                    ->where('set_as_a_default', '=', 'Yes')
                    ->where('set_as_a_current', '=', 'Yes')
                    ->first();
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

                if ($product->stock_by_office($Global_Office_Code)) {
                    if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                        $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                    } else {
                        $product->stock_in = "0.00";
                    }
                } else {
                    $product->stock_in = "0.00";

                }

                $product_list[] = $product;
            }
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'total_page' => $products->lastPage(), 'data' => $product_list], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function wellness_products_App(Request $request)
    {
        $products = \App\Product::select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code'])->paginate(20);
        foreach ($products as $product) {

            $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
            if ($product_image) {
                $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }
            $product->offer = "10 % Off";

            if ($chemist_product_price) {
                $product->actual_amount = number_format($chemist_product_price->Price, 2, '.', '');

            } else {
                $product->actual_amount = "0.00";

            }

            if ($chemist_product_price) {
                $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
            } else {
                $product->chemist_amount = "0.00";

            }

            if ($mrp_product_price) {
                $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                $product->gst = $mrp_product_price->GST . " %";
            } else {
                $product->mrp_amount = "0.00";

                $product->gst = "0.00";

            }
            if ($mrp_product_price && $chemist_product_price) {
                $total = $chemist_product_price->Price + $chemist_product_price->Price * $chemist_product_price->GST / 100;
                $margin = 0.00;
                $margin = ($mrp_product_price->Price - $total) * 100 / $total;
            } else {
                $margin = 0.00;
            }
            $product->margin = number_format($margin, 2, '.', '');

            $login_user = $request->user();
            $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
                ->where('set_as_a_default', '=', 'Yes')
                ->where('set_as_a_current', '=', 'Yes')
                ->first();
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

            if ($product->stock_by_office($Global_Office_Code)) {
                if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                    $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                } else {
                    $product->stock_in = "0.00";
                }
            } else {
                $product->stock_in = "0.00";

            }

            $product_list[] = $product;
        }
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $product_list], $this->successStatus);
    }

    public function offer_products_App(Request $request)
    {
        $products = \App\Product::select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code'])->paginate(20);
        foreach ($products as $product) {

            $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
            $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();

            $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
            if ($product_image) {
                $product->image = $site_route . "/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
            } else {
                $product->image = "";
            }
            $product->offer = "10 % Off";

            if ($chemist_product_price) {
                $product->actual_amount = number_format($chemist_product_price->Price, 2, '.', '');
            } else {
                $product->actual_amount = "0.00";

            }

            if ($chemist_product_price) {
                $product->chemist_amount = number_format($chemist_product_price->Price, 2, '.', '');
            } else {
                $product->chemist_amount = "0.00";

            }

            if ($mrp_product_price) {
                $product->mrp_amount = number_format($mrp_product_price->Price, 2, '.', '');
                $product->gst = $mrp_product_price->GST . " %";
            } else {
                $product->mrp_amount = "0.00";

                $product->gst = "0.00";

            }
            if ($mrp_product_price && $chemist_product_price) {
                $total = $chemist_product_price->Price + $chemist_product_price->Price * $chemist_product_price->GST / 100;
                $margin = 0.00;
                $margin = ($mrp_product_price->Price - $total) * 100 / $total;
            } else {
                $margin = 0.00;
            }
            $product->margin = number_format($margin, 2, '.', '');

            $login_user = $request->user();
            $pincode1 = \App\Address::where('user_id', '=', $login_user->id)
                ->where('set_as_a_default', '=', 'Yes')
                ->where('set_as_a_current', '=', 'Yes')
                ->first();
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

            if ($product->stock_by_office($Global_Office_Code)) {
                if ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder > 0) {
                    $product->stock_in = $product->stock_by_office($Global_Office_Code)->QtyForNewOrder;
                } else {
                    $product->stock_in = "0.00";
                }
            } else {
                $product->stock_in = "0.00";

            }

            $product_list[] = $product;
        }
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'total_page' => $products->lastPage(), 'data' => $product_list], $this->successStatus);
    }

    public function add_address_App(Request $request)
    {
        $user = \App\User::where('role', '=', 'Chemist')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
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
                    $all_address->save();
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Delivery is Not Available at this Location. Please Change Your Location'], $this->successStatus);
            }
            return response()->json(['status' => true, 'message' => 'Your Address save Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function get_address_App(Request $request)
    {
        $user = \App\User::where('role', '=', 'Chemist')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $addresses = \App\Address::with('city')->with('state')->where('user_id', '=', $user->id)->get();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $addresses], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function set_as_a_default_address_App(Request $request)
    {
        $address = \App\Address::find($request->address_id);
        if ($address) {
            $address->set_as_a_default = 'Yes';
            $address->set_as_a_current = 'Yes';
            $address->save();
            $all_addresses = \App\Address::where('id', '!=', $address->id)->where('user_id', $address->user_id)->get();
            foreach ($all_addresses as $all_address) {
                $all_address->set_as_a_default = 'No';
                $all_address->set_as_a_current = 'No';
                $all_address->save();
            }

            return response()->json(['status' => true, 'message' => 'Selected Address Successfully Set As A Default Address.'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function edit_address_App(Request $request)
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

    public function change_address_App(Request $request)
    {
        $address = \App\Address::find($request->address_id);
        if ($address) {
            $address->set_as_a_default = 'Yes';
            $address->set_as_a_current = 'Yes';
            $address->save();
            $all_addresses = \App\Address::where('id', '!=', $address->id)->where('user_id', $address->user_id)->get();
            foreach ($all_addresses as $all_address) {
                $all_address->set_as_a_default = 'No';
                $all_address->set_as_a_current = 'No';
                $all_address->save();

            }
            return response()->json(['status' => true, 'message' => 'Selected Address Successfully Set As A Current Order Address.'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function search_my_order_App(Request $request)
    {
        $user = \App\User::where('role', '=', 'Chemist')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $orders = \App\Order::where('user_id', '=', $user->id)->get();
            $data = [];
            foreach ($orders as $order) {
                $order_products = \App\OrderProduct::where('Order_Id', '=', $order->id)->get();
                foreach ($order_products as $order_product) {
                    $product = \App\Product::find($order_product->product_id);
                    if ($product) {
                        $product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
                        if ($product_image) {
                            $order_product->image = "http://nestorpharma.in/product_image/images/" . $product_image->provided_by . "/" . $product_image->PhotoFile_Name;
                        } else {
                            $order_product->image = "";
                        }
                        $order_product->brand_name = $product->brand_name;
                        $order_product->generic_name = $product->generic_name;
                        $order_prod['order_id'] = 'NSRID-' . $order->id;
                        if (strstr($order_product->brand_name, $request->input('name'))) {
                            $data[] = $order_product;
                        }

                    }
                }
            }
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function list_of_order_history_App(Request $request)
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

    public function re_order_App(Request $request)
    {

        $site_route = $request->getSchemeAndHttpHost();
        $order = \App\Order::with('orderproducts')->where('id', $request->order_id)->first();
        $add_to_cards = \App\Addtocard::where('user_id', $order->user_id)->delete();
        if ($order) {
            foreach ($order->orderproducts as $orderproduct) {

                $product = \App\Product::find($orderproduct->product_id);
                if ($product) {
                    $add_to_card = \App\Addtocard::create([
                        'user_id' => $order->user_id,
                        'product_id' => $product->id,
                        'Qty' => $orderproduct->Order_Qty,
                        'amount' => $orderproduct->Rate,
                    ]);
                }
            }
            return response()->json(['status' => true, 'message' => 'All Product Add to Your Cart'], $this->successStatus);
        } else {
            return response()->json(['status' => true, 'message' => 'Product_id is not valid. Please Try Again', 'data' => $add_to_card], $this->successStatus);
        }
    }

    public function order_detail_App(Request $request)
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

    public function get_order_detail_from_order_list_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $order = \App\Order::find($request->order_id);
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

    }

    public function all_state_city_App(Request $request)
    {
        $states = \App\State::with('cities')->where('country_code', '=', 1)->orderBy('name', 'ASC')->get();
        if ($states) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $states], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Found. Please Try Again'], $this->successStatus);
        }

    }

    public function state_city_by_pinocode_App(Request $request)
    {
        $pincode = \App\Pincode::with('state')->with('city')->where('pincode', '=', $request->pincode)->first();
        if ($pincode) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $pincode], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Found. Please Try Again'], $this->successStatus);
        }

    }

    public function group_with_groupcategory_App(Request $request)
    {
        $groups = \App\Group::with('groupcategories')->whereNotIn('id', [57])->get();
        foreach ($groups as $group) {
            $group->image = $site_route . "/" . $group->image;
            foreach ($group->groupcategories as $groupcategory) {
                $groupcategory->image = $site_route . "/img/nestor_logo.png";
            }
        }
        if ($groups) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $groups], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Found. Please Try Again'], $this->successStatus);
        }
    }

    public function chemist_order_history_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $data = [];
            $orders = \App\Order::where('user_id', '=', $user->id)->orderBy('id', 'DESC')->get();
            if (count($orders)) {
                foreach ($orders as $order) {
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
                    $order->Order_Date = $order->created_at->format('Y-m-d H:m:s');
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
                        $order_product->Rate = number_format($order_product->Rate, 2, '.', '');
                        $order_product->Subtotal = number_format($order_product->Subtotal, 2, '.', '');
                        $order_product->brand_name = $product->brand_name;
                        $order_product->generic_name = $product->generic_name;
                        $no_of_item = $no_of_item + $order_product->Order_Qty;
                        $order->no_of_item = $no_of_item;
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

    public function chat_bot_App(Request $request)
    {
        $chat_question = \App\ChatQuestion::with('chat_question_options')->where('question_type', '=', 'single')->first();
        foreach ($chat_question->chat_question_options as $chat_question_option) {
            $chat_question_option->next_chat_questions;
        }
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chat_question], 200);
    }

    public function minimum_order_amount_App(Request $request)
    {
        $minimum_order = \App\OrderSetting::orderBy('id', 'DESC')->first();
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $minimum_order], 200);
    }

    public function user_detail(Request $request)
    {
        $input['user'] = $request->user();
        $chemist = \App\Chemist::where('user_id', $request->user()->id)->first();
        if ($chemist) {
            $input['email'] = $chemist->Email_ID;
        } else {
            $input['email'] = "";

        }
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $input], 200);

    }

    public function get_filter_data_App(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $nestor_groupcategory = \App\Groupcategory::where('brand_id', 1)->orderBy('name', 'ASC')->get();
        $steriheal_groupcategory = \App\Groupcategory::where('brand_id', 2)->orderBy('name', 'ASC')->get();
        $nectarine_groupcategory = \App\Groupcategory::where('brand_id', 3)->orderBy('name', 'ASC')->get();

        $brand_data = [
            ['name' => 'OTC Products/Prescription Medicines', 'subname' => 'Nestor', 'image' => $site_route . '/img/nestor_logo.png', 'ProductBrand_Code' => 1,
                'data' => $nestor_groupcategory],
            ['name' => 'Medical Consumable/Home care', 'subname' => 'Steriheal', 'image' => $site_route . '/img/Steriheal.jpg', 'ProductBrand_Code' => 2,
                'data' => $steriheal_groupcategory],
            ['name' => 'Ayurvedic Medicines/Body Care', 'subname' => 'Nectarine', 'image' => $site_route . '/img/NECTARINE.jpg', 'ProductBrand_Code' => 3,
                'data' => $nectarine_groupcategory],
        ];

// $brand_data = \App\Brand::with('group_categories')->get();
        $data1['type'] = 'Brand';
        $data1['data'] = $brand_data;
        $data[] = $data1;

        $Product_Form = \App\Category::all();
        $data2['type'] = 'Product_Form';
        $data2['data'] = $Product_Form;
        $data[] = $data2;

        $Prescription_Required = [['name' => 'Required', 'value' => 1], ['name' => 'Not Required', 'value' => 0]];
        $data3['type'] = 'Prescription_Required';
        $data3['data'] = $Prescription_Required;
        $data[] = $data3;

        $Uses = \App\Productuse::all();
        $data4['type'] = 'Uses';
        $data4['data'] = $Uses;
        $data[] = $data4;

        $price = ['minval' => 0, 'maxval' => 1000];
        $data4['type'] = 'Price';
        $data4['data'] = $price;
        $data[] = $data4;

        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], 200);

    }

    public function paytm_payment_config_App(Request $request)
    {
        $data = [
            'requestType' => 'Payment',
            'mid' => 'YtBoHw17737500171583',
            'websiteName' => 'WEBSTAGING',
            'orderId' => 'ORDERID_12345',
            'callbackUrl' => 'https://securegw-stage.paytm.in/order/process',
        ];
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], 200);

    }

    public function get_wallet_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('role', 'Chemist')->first();
        if ($user) {
            $data['note'] = 'For newly registered chemist, Rs. ' . number_format($user->wallet, 2, '.', ',') . ' is credited in the wallet. You can use this amount from wallet on the order amount above Rs. 2000. You can use maximum of Rs. 500 per order.';
            $data['wallet_amount'] = number_format($user->wallet, 2, '.', ',');
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function cancellation_return_and_refund_policy_App(Request $request)
    {
        $data['main_title'] = 'CANCELLATION, RETURN AND REFUND POLICY';
        $data['title1'] = 'Refund';
        $data['description1'] = 'At www.nestoronline.in, we do our best to ensure that you are completely satisfied with our products. We will be happy to issue a full refund based on the conditions listed in this policy below.';

        $data['title11'] = 'Full refund possible if:';
        $data['description11'] = 'you received a defective item;';
        $data['description12'] = 'the ordered item(s) is lost or damaged during transit;';
        $data['description13'] = 'the ordered item(s) is past its expiry date.';
        $data['description14'] = 'Please Note: Mode of refund may vary depending on circumstances. If the mode of refund is by Credit/Debit Card or Net Banking, please allow 4 to 7 working days for the credit to appear in your account. While we regret any inconvenience caused by this time frame, it is the banks policy that delays the refund timing and we have no control over that. If the mode of refund is by wallet, credit should be available within 72 hours.';
        $data['title21'] = 'How to request a refund:';
        $data['description21'] = 'To request a refund, simply email us your order details, including the reason why your are requesting a refund. We take customer feedback very seriously and use it to constantly improve our quality of service. If you have any queries, do call our help desk at +91-9871204440, email us at mkt@nestorpharmaceuticals.com.';
        $data['title31'] = 'Return';
        $data['description31'] = 'We do our best to ensure that the products you order are delivered according to your specifications. However, should you receive an incomplete order, damaged or incorrect product(s), please notify our customer support immediately or within 2 working days of receiving the products, to ensure prompt resolution. Please note that we will not accept liability for such delivery issues if you fail to notify us after 2 working days of receipt. We also understand that various circumstances may arise leading you to want to return a product or products that are not defective. In these cases, we may allow the return of unopened, unused products after deducting a 50% charge, only if you notify us within 3 working days of receipt. We reserve the right to refuse returns (or refunds) for certain products, as marked in the respective product pages as "Note: This item cannot be returned for a refund or exchange".';
        $data['title41'] = 'Cancellation';
        $data['description41'] = 'The customer can cancel the order for the product till it is shipped. Orders once shipped cannot be cancelled. Some situations that may result in your order being cancelled include, non-availability of the product or quantities ordered by you or inaccuracies or errors in pricing information specified by the company. The company also reserves the right to cancel any orders that classify as ‘Bulk Order’ as determined by the company as per certain criteria. An order can be classified as ‘Bulk Order’ if it meets with the below mentioned criteria, which may not be exhaustive, viz: Invalid address given in order details; and Any malpractice used to place the order.';

        return response()->json(['status' => true, 'message' => 'Your CANCELLATION, RETURN AND REFUND POLICY API Work Successfully', 'data' => $data], $this->successStatus);

    }

    public function data_get_by_pincode_App(Request $request)
    {
        $pincode = \App\Pincode::with('city')->with('state')->where('pincode', $request->pincode)->first();
        if ($pincode) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $pincode], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function chemist_account_App(Request $request)
    {
        $user = \App\User::where('role', 'Chemist')->where('mobile', $request->mobile)->where('status', 'verify')->first();
        if ($user) {
            $chemist = \App\Chemist::where('user_id', $user->id)->with('addresses')->first();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chemist], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function get_reward_ledger_App(Request $request)
    {
        $user = \App\User::where('role', 'Chemist')->where('mobile', $request->mobile)->where('status', 'verify')->first();
        if ($user) {
            $reward_reference_ledgers = \App\RewardReferenceLedger::where('user_id', $user->id)->get();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $reward_reference_ledgers], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function current_reward_balance_App(Request $request)
    {
        $user = \App\User::where('role', 'Chemist')->where('mobile', $request->mobile)->where('status', 'verify')->first();
        if ($user) {
            $data['balance'] = \App\RewardReferenceLedger::where('user_id', $user->id)->orderBy('id', 'DESC')->select('balance')->first();
            if ($user->wallet >= 500) {
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