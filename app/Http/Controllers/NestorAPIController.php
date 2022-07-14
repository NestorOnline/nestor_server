<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NestorAPIController extends Controller
{
    public $successStatus = 200;

    public function chemist_list(Request $request)
    {
        if ($request->is_update == '0') {
            $chemists = \App\Chemist::with('addresses')->whereBetween('created_at', [$request->from_date . ' 00:00:01', $request->to_date . ' 23:59:59'])->where('Status', 1)->where('is_update', 0)->orderBy('id', 'DESC')->get();
        } elseif ($request->is_update == '1') {
            $chemists = \App\Chemist::with('addresses')->whereBetween('created_at', [$request->from_date . ' 00:00:01', $request->to_date . ' 23:59:59'])->where('Status', 1)->where('is_update', 1)->orderBy('id', 'DESC')->get();
        } elseif ($request->is_update == '2') {
            $chemists = \App\Chemist::with('addresses')->whereBetween('created_at', [$request->from_date . ' 00:00:01', $request->to_date . ' 23:59:59'])->where('Status', 1)->where('is_update', 2)->orderBy('id', 'DESC')->get();
        } else {
            $chemists = \App\Chemist::with('addresses')->where('Status', 1)->orderBy('id', 'DESC')->get();
        }
        if (count($chemists)) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chemists], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function chemist_detail(Request $request)
    {
        $chemist = \App\Chemist::with('addresses')->find($request->Chemist_ID);
        if ($chemist) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chemist], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function chemist_update(Request $request)
    {
        $chemist = \App\Chemist::find($request->Chemist_ID);
        if ($chemist) {
            if ($request->Party_Code) {
                $chemist->Party_Code = $request->Party_Code;
            }
            if ($request->admin_approval) {
                $chemist->admin_approval = $request->admin_approval;
            }
            if ($request->GSTIN) {
                $chemist->GSTIN = $request->GSTIN;
            }
            
            else {
                $chemist->is_update = 1;
            }
            $chemist->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chemist], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }
    public function chemist_area_update(Request $request)
    {
        $chemist = \App\Chemist::find($request->Chemist_ID);
        if ($chemist) {
            if ($request->Party_Code) {
                $chemist->Party_Code = $request->Party_Code;
            } else {
                $chemist->is_update = 1;
            }
            if ($request->Party_ID) {
                $chemist->Party_ID = $request->Party_ID;
            }
            if ($request->MarketingState_Code) {
                $chemist->MarketingState_Code = $request->MarketingState_Code;
            }
            if ($request->HQ_Code) {
                $chemist->HQ_Code = $request->HQ_Code;
            }
            if ($request->Territory_Code) {
                $chemist->Territory_Code = $request->Territory_Code;
            }
            if ($request->Location_Code) {
                $chemist->Location_Code = $request->Location_Code;
            }
            if ($request->Area_Code) {
                $chemist->Area_Code = $request->Area_Code;
            }
            $chemist->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chemist], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function order_list(Request $request)
    {
        $orders = \App\Order::all();
        if ($request->is_update == '0') {
            $orders = \App\Order::with('orderproducts')->where('is_update', '=', $request->is_update)->get();
        } elseif ($request->is_update == '1') {
            $orders = \App\Order::with('orderproducts')->where('is_update', '=', $request->is_update)->get();
        } elseif ($request->is_update == '2') {
            $orders = \App\Order::with('orderproducts')->get();
        } else {
            $orders = \App\Order::with('orderproducts')->get();
        }
        if (count($orders)) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $orders], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function order_detail(Request $request)
    {
        $order = \App\Order::with('orderproducts')->find($request->Order_ID);
        if ($order) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $order], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function productuses_list()
    {
        $product_uses = \App\Productuse::all();
        if (count($product_uses)) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $product_uses], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_productuses(Request $request)
    {

        $product_use = \App\Productuse::where('ProductUse_Code', '=', $request->ProductUse_Code)->first();
        if ($product_use) {
            if ($request->ProductUse_Code) {
                $product_use->ProductUse_Code = $request->ProductUse_Code;
            }
            if ($request->ProductUse_Name) {
                $product_use->ProductUse_Name = $request->ProductUse_Name;
            }
            if ($request->Status_code) {
                $product_use->Status_code = 1;
            }
            $product_use->save();
            return response()->json(['status' => true, 'message' => 'Data Update Successfully', 'data' => $product_use], $this->successStatus);
        } else {
            $product_use = \App\Productuse::create([
                'ProductUse_Code' => $request->ProductUse_Code,
                'ProductUse_Name' => $request->ProductUse_Name,
                'Status_code' => 1,
            ]);
            return response()->json(['status' => true, 'message' => 'Data Add Successfully', 'data' => $product_use], $this->successStatus);
        }
    }

    public function payment_detail(Request $request)
    {
        $payment = \App\Payment::find($request->Payment_iD);
        if ($payment) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $payment], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_order_detail(Request $request)
    {
        $order = \App\Order::find($request->Order_ID);
        if ($order) {
            if ($request->Invoice_Code) {
                $order->Invoice_Code = $request->Invoice_Code;
            }
            if ($request->Invoice_No) {
                $order->Invoice_No = $request->Invoice_No;
            }
            if ($request->Invoice_Date) {
                $order->Invoice_Date = $request->Invoice_Date;
            }
            if ($request->Invoice_Amount) {
                $order->Invoice_Amount = $request->Invoice_Amount;
            }

            if ($request->OrderStatus_Code) {
                $order->OrderStatus_Code = $request->OrderStatus_Code;
            }
            if ($request->Tracking_ID) {
                $order->Tracking_ID = $request->Tracking_ID;
            }
            if ($request->Transport_ID) {
                $order->Transport_ID = $request->Transport_ID;
            }
            if ($request->Account_ID) {
                $order->Account_ID = $request->Account_ID;
            }
            if ($request->Order_No) {
                $order->Order_No = $request->Order_No;
            }
            if ($request->Order_Code) {
                $order->Order_Code = $request->Order_Code;
            }
            if ($request->Shipment_ID) {
                $order->Shipment_ID = $request->Shipment_ID;
            }
            if ($request->AWB_Code) {
                $order->AWB_Code = $request->AWB_Code;
            }
            if ($request->Courier_Company_ID) {
                $order->Courier_Company_ID = $request->Courier_Company_ID;
            }

            if ($request->ProcessingOn) {
                $order->ProcessingOn = $request->ProcessingOn;
            }
            if ($request->PackedOn) {
                $order->PackedOn = $request->PackedOn;
            }
            if ($request->DispatchedOn) {
                $order->DispatchedOn = $request->DispatchedOn;
            }
            if ($request->DeliveredOn) {
                $order->DeliveredOn = $request->DeliveredOn;
            }
            if ($request->ExpectedOn) {
                $order->ExpectedOn = $request->ExpectedOn;
            }

            if ($request->Invoice_No) {
                $order->Invoice_No = $request->Invoice_No;
            }

            if ($request->Invoice_Amount) {
                $order->Invoice_Amount = $request->Invoice_Amount;
            }

            $order->is_update = 1;
            $order->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function product_list()
    {
        $products = \App\Product::all();
        foreach ($products as $product) {
            $product->Generic_Name = $product->generic_name;
            $product->Brand_Name = $product->brand_name;
            $product->ParentTherapeuticCategory_Code = $product->group_id;
            $product->TherapeuticCategory_Code = $product->groupcategory_id;
            $product->Category_Code = $product->category_id;
            $product->Packing_Code = $product->package_id;
            $product->Product_Code = $product->product_code;
        }
        if (count($products)) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $products], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }
    public function product_update(Request $request)
    {
        $product = \App\Product::where('product_code', '=', $request->Product_Code)->first();
        if ($product) {
            if ($request->input('Generic_Name')) {
                $product->generic_name = $request->input('Generic_Name');
            }
            if ($request->input('Product_Code')) {
                $product->product_code = $request->input('Product_Code');
            }
            if ($request->input('ProductBrand_Code')) {
                $product->ProductBrand_Code = $request->input('ProductBrand_Code');
            }

            if ($request->input('Brand_Name')) {
                $product->brand_name = $request->input('Brand_Name');
            }
            if ($request->input('url_name')) {
                $product->url_name = $request->input('url_name');
            }
            if ($request->input('Packing_Code')) {
                $product->package_id = $request->input('Packing_Code');
            }
            if ($request->input('Product_ID')) {
                $product->Product_ID = $request->input('Product_ID');
            }
            if ($request->input('HSN_Code')) {
                $product->HSN_code = $request->input('HSN_Code');
            }
            if ($request->input('OrderQtyMultipleOf_Chemist')) {
                $product->OrderQtyMultipleOf_Chemist = $request->input('OrderQtyMultipleOf_Chemist');
            }
            if ($request->input('OrderQtyMultipleOf_Customer')) {
                $product->OrderQtyMultipleOf_Customer = $request->input('OrderQtyMultipleOf_Customer');
            }
            if ($request->input('storage')) {
                $product->storage = $request->input('storage');
            }
            if ($request->input('ParentTherapeuticCategory_Code')) {
                $product->group_id = $request->input('ParentTherapeuticCategory_Code');
            }
            if ($request->input('TherapeuticCategory_Code')) {
                $product->groupcategory_id = $request->input('TherapeuticCategory_Code');
            }
            if ($request->input('Category_Code')) {
                $product->category_id = $request->input('Category_Code');
            }
            if ($request->input('best_before_date')) {
                $product->best_before_date = $request->input('best_before_date');
            }
            if ($request->input('IsDisplayExpiry')) {
                $product->is_display_expiry = $request->input('IsDisplayExpiry');
            }
            if ($request->input('GoLive')) {
                $product->go_live = $request->input('GoLive');
            }
            $product->Prescription_Required = $request->input('Prescription_Required');
            $product->save();
            return response()->json(['status' => true, 'message' => 'Product is Update Successfully', 'data' => $product], $this->successStatus);
        } else {
            $product = \App\Product::create([
                'generic_name' => $request->input('Generic_Name'),
                'brand_name' => $request->input('Brand_Name'),
                'url_name' => $request->input('url_name'),
                'package_id' => $request->input('Packing_Code'),
                'Product_ID' => $request->input('Product_ID'),
                'product_code' => $request->input('Product_Code'),
                'HSN_code' => $request->input('HSN_Code'),
                'OrderQtyMultipleOf_Chemist' => $request->input('OrderQtyMultipleOf_Chemist'),
                'OrderQtyMultipleOf_Customer' => $request->input('OrderQtyMultipleOf_Customer'),
                'group_id' => $request->input('ParentTherapeuticCategory_Code'),
                'groupcategory_id' => $request->input('TherapeuticCategory_Code'),
                'category_id' => $request->input('Category_Code'),
                'best_before_date' => $request->input('best_before_date'),
                'is_display_expiry' => $request->input('IsDisplayExpiry'),
                'go_live' => $request->input('GoLive'),
                'Prescription_Required' => $request->input('Prescription_Required'),
                'ProductBrand_Code' => $request->input('ProductBrand_Code'),
            ]);
            return response()->json(['status' => true, 'message' => 'Product is create Successfully'], $this->successStatus);
        }
    }

    public function package_list(Request $request)
    {
        $packages = \App\Package::all();
        if ($packages) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $packages], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_package_detail(Request $request)
    {
        $package = \App\Package::find($request->Packing_Code);
        if ($package) {
            if ($request->Packing_Name) {
                $package->name = $request->Packing_Name;
            }
            if ($request->Primary_Packing) {
                $package->Primary_Packing = $request->Primary_Packing;
            }
            if ($request->PrimaryPack_Qty) {
                $package->PrimaryPack_Qty = $request->PrimaryPack_Qty;
            }
            if ($request->Unit_Name) {
                $package->Unit_Name = $request->Unit_Name;
            }
            if ($request->TotalQtyInPacking) {
                $package->TotalQtyInPacking = $request->TotalQtyInPacking;
            }
            if ($request->Packing_Description) {
                $package->Packing_Description = $request->Packing_Description;
            }
            $package->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully'], $this->successStatus);
        } else {
            $package = \App\Package::create([
                "id" => $request->Packing_Code,
                "name" => $request->Packing_Name,
                "Primary_Packing" => $request->Primary_Packing,
                "PrimaryPack_Qty" => $request->PrimaryPack_Qty,
                "Unit_Name" => $request->Unit_Name,
                "TotalQtyInPacking"=>$request->TotalQtyInPacking,
                "Packing_Description" => $request->Packing_Description,
            ]);
            return response()->json(['status' => true, 'message' => 'Add New Package Entry Successfullly Added'], $this->successStatus);
        }
    }

    public function stock_list(Request $request)
    {
        $stocks = \App\Stock::all();
        if ($stocks) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $stocks], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_stock_detail(Request $request)
    {

        $stock = \App\Stock::where('Office_Code', '=', $request->Office_Code)->where('Product_Code', '=', $request->Product_Code)->first();
        if ($stock) {
            $orders = \App\Order::whereNull('Order_Code')->join('order_products as order_product', 'order_product.Order_Id', '=', 'orders.id')
                ->where('order_product.Product_Code', '=', $request->Product_Code)
                ->with('orderproducts')
                ->get();
            $xyz = 0;
            foreach ($orders as $order) {
                foreach ($order->orderproducts as $orderproduct) {
                    if ($orderproduct->Product_Code == $request->Product_Code) {
                        $xyz = $xyz + $orderproduct->Order_Qty + $orderproduct->Free_Qty;
                    }
                }
            }

            if ($request->EXP_Date) {
                $stock->EXP_Date = $request->EXP_Date;
            }
            if ($request->Stock) {
                $stock->Stock = $request->Stock - $xyz;
                $stock->QtyForNewOrder = $request->Stock - $xyz;
            }
            $stock->Ordered_Qty = 0;
            $stock->Hold_Qty = 0;
            $stock->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $stock], $this->successStatus);
        } else {
            $stock = \App\Stock::create([
                "Office_Code" => $request->Office_Code,
                "Product_Code" => $request->Product_Code,
                "Batch_No" => $request->Batch_No,
                "MRP" => $request->MRP,
                "EXP_Date" => $request->EXP_Date,
                "Stock" => $request->Stock,
                "Ordered_Qty" => $request->Ordered_Qty,
                "Hold_Qty" => 0,
                "QtyForNewOrder" => 0,
            ]);
            return response()->json(['status' => true, 'message' => 'Add New Stock Entry Successfullly Added'], $this->successStatus);
        }
    }

    public function office_list(Request $request)
    {
        $offices = \App\Office::all();
        if ($offices) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $offices], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_office_detail(Request $request)
    {
        $office = \App\Office::where('Office_Code', '=', $request->Office_Code)->first();
        if ($office) {
            if ($request->Location) {
                $office->Location = $request->Location;
            }
            if ($request->Office_Code) {
                $office->Office_Code = $request->Office_Code;
            }
            if ($request->Office_Name) {
                $office->Office_Name = $request->Office_Name;
            }
            if ($request->Address1) {
                $office->Address1 = $request->Address1;
            }
            if ($request->Address2) {
                $office->Address2 = $request->Address2;
            }
            if ($request->Address3) {
                $office->Address3 = $request->Address3;
            }
            if ($request->City_Name) {
                $office->City_Name = $request->City_Name;
            }
            if ($request->State_Name) {
                $office->State_Name = $request->State_Name;
            }
            if ($request->PIN) {
                $office->PIN = $request->PIN;
            }
            if ($request->GSTIN) {
                $office->GSTIN = $request->GSTIN;
            }
            $office->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully'], $this->successStatus);
        } else {
            $office = \App\Office::create([
                "Location" => $request->Location,
                "Office_Code" => $request->Office_Code,
                "Office_Name" => $request->Office_Name,
                "Address1" => $request->Address1,
                "Address2" => $request->Address2,
                "Address3" => $request->Address3,
                "Address2" => $request->Address2,
                "City_Name" => $request->City_Name,
                "State_Name" => $request->State_Name,
                "PIN" => $request->PIN,
                "GSTIN" => $request->GSTIN,
            ]);
            return response()->json(['status' => true, 'message' => 'Add New Stock Entry Successfullly Added'], $this->successStatus);
        }
    }

    public function office_state_list(Request $request)
    {
        $office_states = \App\OfficeState::all();
        if ($office_states) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $office_states], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_office_state_detail(Request $request)
    {
        $office_state = \App\OfficeState::where('State_Code', '=', $request->State_Code)->first();

        if ($office_state) {
            if ($request->Office_Code) {
                $office_state->Office_Code = $request->Office_Code;
            }
            if ($request->State_Code) {
                $office_state->State_Code = $request->State_Code;
            }
            $office_state->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully'], $this->successStatus);
        } else {
            $office_state = \App\OfficeState::create([
                "Office_Code" => $request->Office_Code,
                "State_Code" => $request->State_Code,
            ]);
            return response()->json(['status' => true, 'message' => 'Add New Office Entry Successfullly Added'], $this->successStatus);
        }
    }

    public function office_delivery_pin_list(Request $request)
    {
        $office_states = \App\OfficeState::with('pincodes')->get();
        foreach ($office_states as $office_state) {
            $office_state->State_Code = $office_state->state_id;
            $office_state->City_Code = $office_state->city_id;
        }
        if ($office_states) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $office_states], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_office_delivery_pin_detail(Request $request)
    {
        $pincode = \App\Pincode::where('pincode', '=', $request->pincode_id)->first();
        if ($pincode) {
            if ($request->Pincode) {
                $pincode->pincode = $request->Pincode;
            }
            if ($request->State_Code) {
                $pincode->state_id = $request->State_Code;
            }
            if ($request->City_Code) {
                $pincode->city_id = $request->City_Code;
            }
            if ($request->Serviceable) {
                $pincode->Serviceable = $request->Serviceable;
            }
            $pincode->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully'], $this->successStatus);
        } else {
            $pincode = \App\Pincode::create([
                "pincode" => $request->Pincode,
                "State_Code" => $request->State_Code,
                "City_Code" => $request->City_Code,
                "Serviceable" => $request->Serviceable,
            ]);
            return response()->json(['status' => true, 'message' => 'Add New Pincode Entry Successfullly Added'], $this->successStatus);
        }
    }

    public function office_sales_scheme_list(Request $request)
    {
        $office_states = \App\SalesScheme::all();
        if ($office_states) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $office_states], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_sales_scheme_detail(Request $request)
    {
        $sales_shame = \App\SalesScheme::find($request->sales_scheme_id);
        if ($sales_shame) {
            if ($request->SalesScheme_Code) {
                $pincode->SalesScheme_Code = $request->SalesScheme_Code;
            }
            if ($request->SalesScheme_Name) {
                $pincode->SalesScheme_Name = $request->SalesScheme_Name;
            }
            if ($request->Category_Code) {
                $pincode->Category_Code = $request->Category_Code;
            }
            if ($request->SchemeOn_Code) {
                $pincode->SchemeOn_Code = $request->SchemeOn_Code;
            }
            if ($request->Product_Code) {
                $pincode->Product_Code = $request->Product_Code;
            }
            if ($request->SchemeOn) {
                $pincode->SchemeOn = $request->SchemeOn;
            }
            if ($request->DiscountType_Code) {
                $pincode->DiscountType_Code = $request->DiscountType_Code;
            }
            if ($request->Discount) {
                $pincode->Discount = $request->Discount;
            }
            if ($request->NextMinSaleQty_ForScheme) {
                $pincode->NextMinSaleQty_ForScheme = $request->NextMinSaleQty_ForScheme;
            }
            if ($request->Free_Qty) {
                $pincode->Free_Qty = $request->Free_Qty;
            }
            if ($request->Effective_From) {
                $pincode->Effective_From = $request->Effective_From;
            }
            if ($request->Effective_To) {
                $pincode->Effective_To = $request->Effective_To;
            }
            if ($request->Office_Code) {
                $pincode->Office_Code = $request->Office_Code;
            }
            $pincode->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully'], $this->successStatus);
        } elseif ($request->sales_scheme_id) {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        } else {
            $sales_shame = \App\SalesScheme::create([
                "SalesScheme_Code" => $request->SalesScheme_Code,
                "SalesScheme_Name" => $request->SalesScheme_Name,
                "Category_Code" => $request->Category_Code,
                "SchemeOn_Code" => $request->SchemeOn_Code,
                "DiscountType_Code" => $request->DiscountType_Code,
                "Discount" => $request->Discount,
                "NextMinSaleQty_ForScheme" => $request->NextMinSaleQty_ForScheme,
                "Free_Qty" => $request->Free_Qty,
                "Effective_From" => $request->Effective_From,
                "Effective_To" => $request->Effective_To,
                "Office_Code" => $request->Office_Code,
                "City_Code" => $request->City_Code,
            ]);
            return response()->json(['status' => true, 'message' => 'Add New Sales Scheme Entry Successfullly Added'], $this->successStatus);
        }
    }

    public function product_price_list(Request $request)
    {
        $product_prices = \App\Productprice::all();
        if ($product_prices) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $product_prices], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_product_price(Request $request)
    {
        $product_price = \App\Productprice::where('Product_Code', '=', $request->Product_Code)->where('Effective_From', '=', $request->Effective_From)->where('ProductPriceType_Code', '=', $request->ProductPriceType_Code)->first();
        if ($product_price) {
            if ($request->Price) {
                $product_price->Price = $request->Price;
            }
            if ($request->GST) {
                $product_price->GST = $request->GST;
            }
            if ($request->Effective_From) {
                $product_price->Effective_From = $request->Effective_From;
            }
            if ($request->Effective_To) {
                $product_price->Effective_To = $request->Effective_To;
            }
            $product_price->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $product_price], $this->successStatus);
        } else {
            $find_product = \App\Product::where('Product_Code', '=', $request->Product_Code)->first();
            $last_product_price = \App\Productprice::where('Product_Code', '=', $request->Product_Code)->where('ProductPriceType_Code', '=', $request->ProductPriceType_Code)->orderBy('id', 'DESC')->first();
            if ($last_product_price) {
                $last_product_price->Effective_To = date('Y-m-d', (strtotime('-1 day', strtotime($request->Effective_From))));
                $last_product_price->save();
            }
            if ($find_product) {
                $product_price = \App\Productprice::create([
                    'Product_Code' => $request->Product_Code,
                    'product_id' => $find_product->id,
                    'ProductPriceType_Code' => $request->ProductPriceType_Code,
                    'Price' => $request->Price,
                    'GST' => $request->GST,
                    'Effective_From' => $request->Effective_From,
                    'Effective_To' => $request->Effective_To,
                ]);
                return response()->json(['status' => true, 'message' => 'Data Add Successfully'], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'That Product Are Not Avaible at database'], $this->successStatus);
            }

        }
    }

    public function add_update_product_use_detail(Request $request)
    {
        $productuse_detail = \App\ProductuseDetail::where('Product_Code', $request->Product_Code)->delete();
        $input = $request->all();
        if (count($input['ProductUse_Code'])) {
            for ($i = 0; $i < count($input['ProductUse_Code']); $i++) {
                $productuse_detail = \App\ProductuseDetail::create([
                    'Product_Code' => $input['Product_Code'],
                    'ProductUse_Code' => $input['ProductUse_Code'][$i],
                ]);
            }
        }
        return response()->json(['status' => true, 'message' => 'Data Add Successfully'], $this->successStatus);
    }

    public function add_manufacture(Request $request)
    {
        $manufacture = \App\Manufacture::create([
            'name' => $request->input('name'),
        ]);
        if ($manufacture) {
            return response()->json(['status' => true, 'message' => 'Data Add Successfully'], $this->successStatus);

        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }

    }

    public function TherapeuticCategory_list(Request $request)
    {
        $group_categories = \App\Groupcategory::all();
        if ($group_categories) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $group_categories], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function update_TherapeuticCategory(Request $request)
    {
        $input = $request->all();
        $group_category = \App\Groupcategory::find($input['TherapeuticCategory_Code']);
        if ($group_category) {
            if ($input['TherapeuticCategory_Name']) {
                $group_category->name = $input['TherapeuticCategory_Name'];
            }
            if ($input['TherapeuticCategory_Name']) {
                $explode = explode(' ', $input['TherapeuticCategory_Name']);
                $implode = implode('-', $explode);
                $group_category->url_name = $implode;
            }
            if ($input['ParentTherapeuticCategory_Code']) {
                $group_category->group_id = $input['ParentTherapeuticCategory_Code'];
            }
            $group_category->save();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully'], $this->successStatus);
        } else {
            $explode = explode(' ', $input['TherapeuticCategory_Name']);
            $implode = implode('-', $explode);
            $group_category->url_name = $implode;
            $group_category = \App\Groupcategory::create([
                'id' => $input['TherapeuticCategory_Code'],
                'name' => $input['TherapeuticCategory_Name'],
                'url_name' => $implode,
                'group_id' => $input['ParentTherapeuticCategory_Code'],
            ]);
            return response()->json(['status' => true, 'message' => 'Data Add Successfully'], $this->successStatus);
        }

    }

    public function Therapeutic_Category_By_Brand_Code(Request $request)
    {
        $groupcategories = \App\Groupcategory::where('brand_id', $request->ProductBrand_Code)->get();
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $groupcategories], 200);
    }

    public function Product_List_by_Therapeutic_Category_Code(Request $request)
    {

        $site_route = $request->getSchemeAndHttpHost();
        $product_group_categories = \App\ProductGroupCategories::where('groupcategory_id', $request->TherapeuticCategory_Code)->get();
        if (count($product_group_categories)) {
            $products = \App\Product::whereIn('product_code',$product_group_categories->map(function($product_group_category){
                return $product_group_category->Product_Code;
            }))->select(['id', 'generic_name', 'brand_name', 'image', 'offer', 'product_code', 'group_id', 'groupcategory_id', 'package_id'])->get();
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

                    $product->offer = "10 % Off";

                    if ($product->customer_price) {
                        $product->customer_price = number_format($product->customer_price->Price, 2, '.', '');
                        $product->gst = $product->customer_mrp_price->GST . " %";
                    } else {
                        $product->customer_price = [];
                        $product->gst = null;
                    }

                    if ($product->customer_mrp_price) {
                        $product->customer_mrp_price = number_format($product->customer_mrp_price->Price, 2, '.', '');
                    } else {
                        $product->customer_mrp_price = [];
                    }

                    if ($product->chemist_price) {
                        $product->chemist_price = number_format($product->chemist_price->Price, 2, '.', '');
                    } else {
                        $product->chemist_price = [];
                    }

                    if ($product->mrp_price) {
                        $product->mrp_price = number_format($product->mrp_price->Price, 2, '.', '');
                    } else {
                        $product->mrp_price = [];
                    }

                    $product_list[] = $product;
                }
                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $product_list], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function Product_Details_By_Product_Code(Request $request)
    {
        $site_route = $request->getSchemeAndHttpHost();
        $product = \App\Product::with('package')->with('comparative_products')->where('Product_Code', $request->Product_Code)->first();
        if ($product) {
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
                $product->customer_price = number_format($product->customer_price->Price, 2, '.', '');
                $product->gst = $product->customer_mrp_price->GST . " %";
            } else {
                $product->customer_price = [];
                $product->gst = null;
            }

            if ($product->customer_mrp_price) {
                $product->customer_mrp_price = number_format($product->customer_mrp_price->Price, 2, '.', '');
            } else {
                $product->customer_mrp_price = [];
            }

            if ($product->chemist_price) {
                $product->chemist_price = number_format($product->chemist_price->Price, 2, '.', '');
            } else {
                $product->chemist_price = [];
            }

            if ($product->mrp_price) {
                $product->mrp_price = number_format($product->mrp_price->Price, 2, '.', '');
            } else {
                $product->mrp_price = [];
            }

            $description_types = \App\Descriptiontype::all();

            $description_data = [];
            foreach ($description_types as $description_type) {
                $description = \App\Description::whereNotIn('description', ['0'])->where('product_code', '=', $product->product_code)->where('description_type_code', '=', $description_type->id)->limit(6)->select('description')->get();
                if (count($description)) {
                    $description_data[] = ['title' => $description_type->name, 'descriptions' => $description];
                }
            }
            $product->description_data = $description_data;
            if (count($product->comparative_products)) {
                foreach ($product->comparative_products as $comparative_product) {
                    if ($comparative_product->manufacturer_single) {
                        $comparative_product->manufacturer = $comparative_product->manufacturer_single->name;
                    }
                }
            }

            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $product], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function Add_Product_HashTag(Request $request)
    {
        $ProductHashTag = \App\ProductHashTag::create([
            'ProductHashtag_Code' => $request->input('ProductHashtag_Code'),
            'ProductHashtag_Name' => $request->input('ProductHashtag_Name'),
        ]);
        if ($ProductHashTag) {
            return response()->json(['status' => true, 'message' => 'Data Add Successfully'], $this->successStatus);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }

    }

    public function Add_ProductHashTag_Detail(Request $request)
    {
        $delete_ProductHashTagDetail = \App\ProductHashTagDetail::where('Product_Code', $request->Product_Code)->delete();
        $input = $request->all();
        if (count($input['ProductHashtag_Code'])) {
            for ($i = 0; $i < count($input['ProductHashtag_Code']); $i++) {
                $ProductHashTagDetail = \App\ProductHashTagDetail::create([
                    'Product_Code' => $input['Product_Code'],
                    'ProductHashtag_Code' => $input['ProductHashtag_Code'][$i],
                ]);
            }
            return response()->json(['status' => true, 'message' => 'Data Add Successfully'], $this->successStatus);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }

    }

    public function Add_Product_Therapeutic(Request $request)
    {

        $delete_Product_Therapeutic = \App\ProductGroupCategories::where('Product_Code', $request->Product_Code)->delete();
        $input = $request->all();
        if (count($input['TherapeuticCategory_Code'])) {
            for ($i = 0; $i < count($input['TherapeuticCategory_Code']); $i++) {
                $Add_Product_Therapeutic = \App\ProductGroupCategories::create([
                    'Product_Code' => $input['Product_Code'],
                    'groupcategory_id' => $input['TherapeuticCategory_Code'][$i],
                ]);
                $group_category = \App\Groupcategory::find($input['TherapeuticCategory_Code'][$i]);
                if ($group_category && $group_category->group_id == 38) {
                    $Add_Product_Therapeutic = \App\ProductGroupCategories::create([
                        'Product_Code' => $input['Product_Code'],
                        'groupcategory_id' => 15001,
                    ]);

                }

            }
            return response()->json(['status' => true, 'message' => 'Data Add Successfully'], $this->successStatus);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }

    }

    public function Add_Ayuveda_Product_On_App(Request $request)
    {

        $input = $request->all();

        if (count($input['Product_Code'])) {
            for ($i = 0; $i < count($input['Product_Code']); $i++) {
                $delete_Product_Therapeutic = \App\ProductGroupCategories::where('groupcategory_id', 15001)->where('Product_Code', $input['Product_Code'][$i])->delete();

                $Add_Product_Therapeutic = \App\ProductGroupCategories::create([
                    'Product_Code' => $input['Product_Code'][$i],
                    'groupcategory_id' => 15001,
                ]);
            }
            return response()->json(['status' => true, 'message' => 'Data Add Successfully'], $this->successStatus);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }

    }

    public function get_chemist_order_list(Request $request)
    {  
        $orders = \App\Order::where('Party_Code',$request->Party_Code)->get();
        if (count($orders)) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $orders], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }
}