<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use PaytmWallet;

class DashboardController extends Controller
{

    public function changepassword(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();

        return view('dashboard.changepassword', compact('groups', 'site_route'));
    }

    public function changepassword_store(Request $request)
    {
        $this->validate($request, [
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'renewpassword' => 'required|same:newpassword',
        ]);
        $user = \Auth::user();
        $user->update([
            'password' => \Hash::make($request->input('newpassword')),
        ]);
        session()->flash('success', 'Your Password is Change Successfully');
        return redirect()->back();
    }

    public function pincode_check(Request $request)
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $value = \App\Pincode::where('pincode', '=', $request->pincode)->first();
        if ($value) {
            $state = \App\State::find($value->state_id);
            $city = \App\City::find($value->city_id);
            $data['state_id'] = $value->state_id;
            $data['city_id'] = $value->city_id;
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Found'], 200);
        }
    }

    public function my_profile(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if (\Auth::user()->role == 'Chemist') {
            $chemist = \App\Chemist::where('user_id', '=', \Auth::user()->id)->first();
        } else {
            $chemist = \App\Chemist::where('user_id', '=', \Auth::user()->id)->first();
        }
        return view('dashboard.my_profile', compact('site_route', 'chemist', 'groups'));
    }

    public function userdashboard(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $value = request()->cookie('add_cart');
        $add_cart_datas = json_decode($value);
        return view('dashboard.userdashboard', compact('site_route', 'add_cart_datas', 'groups'));
    }

    public function doctor_prescribed_product(Request $request, $id)
    {
        $data['site_route'] = $request->route()->getName();
        $data['groups'] = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $data['doctor_appointment'] = \App\Doctorappointment::where('id', $id)->where('user_id', \Auth::user()->id)->first();
        if ($data['doctor_appointment']) {
            return view('dashboard.doctor_prescribed_product', $data);
        } else {
            return redirect()->back();
        }
    }

    public function doctor_appointment_list(Request $request)
    {
        $data['site_route'] = $request->route()->getName();
        $data['groups'] = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
  
        $doctor_appointment1s = \App\Doctorappointment::where('user_id', \Auth::user()->id)->whereDate('created_at','<',date('Y-m-d', strtotime('-2 day')))->where('status','!=',6)->delete();
       
        $data['doctor_appointments'] = \App\Doctorappointment::where('user_id', \Auth::user()->id)->get();
        
        return view('dashboard.doctor_appointment_list', $data);
    }

    public function doctor_prescribed_product_add_to_mycart(Request $request, $id)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();

        $add_to_cards = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        foreach ($add_to_cards as $add_to_card) {
            $product = \App\Product::find($add_to_card->product_id);
            if ($product->Prescription_Required == 1) {
                $add_to_card->delete();
            }
        }

        $data['doctor_appointment'] = \App\Doctorappointment::with('doctor_prescription_products')->where('user_id', \Auth::user()->id)->where('id', $id)->first();

        if (count($data['doctor_appointment']->doctor_prescription_products)) {

            foreach ($data['doctor_appointment']->doctor_prescription_products as $doctor_prescription_product) {
                $addtocard_product = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->where('product_id', '=', $doctor_prescription_product->product_id)->first();
                if ($doctor_prescription_product->product) {
                    $cuctomer_price = $doctor_prescription_product->product->customer_price->Price;
                    $gst = $doctor_prescription_product->product->customer_price->Price * $doctor_prescription_product->product->customer_price->GST / 100;
                    $product_ab = \App\Product::find($doctor_prescription_product->product_id);
                    $sales_scheme = \App\SalesScheme::where('Product_Code',$product_ab->product_code)->where('Category_Code',1)->first();
                    $total = 0;
                    if($sales_scheme){
                            $total = $cuctomer_price + $gst ;
                            $total = $total -  $total*$sales_scheme->Discount/100;
                            
                        }else{
                            $total = $cuctomer_price + $gst;
                        }
                }
                if ($addtocard_product) {
                    $addtocard_product->Qty = $addtocard_product->Qty + $doctor_prescription_product->Qty;
                    $addtocard_product->doctor_description_id = $doctor_prescription_product->doctorappointment_id;
                    $addtocard_product->save();
                } else {
                    $addtocard_product = \App\Addtocard::create([
                        'user_id' => \Auth::user()->id,
                        'product_id' => $doctor_prescription_product->product->id,
                        'Qty' => $doctor_prescription_product->qty,
                        'amount' => $total,
                        'doctor_description_id' => $doctor_prescription_product->doctorappointment_id,
                    ]);
                }

            }
        }
        return redirect()->back();
    }

    public function offers(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $offers = \App\Doctorappointment::all();
        return view('dashboard.offers', compact('site_route', 'groups', 'offers'));
    }

    public function order_history(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $orders = \App\Order::with('orderproducts')->where('user_id', '=', \Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('dashboard.order_history', compact('site_route', 'orders', 'groups'));
    }

    public function delivery_address(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $addresses = \App\Address::where('user_id', '=', \Auth::user()->id)->get();
        $states = \App\State::with('cities')->get();
        return view('dashboard.delivery_address', compact('site_route', 'addresses', 'groups', 'states'));
    }

    public function diagnostics_faq(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.diagnostics_faq', compact('site_route', 'groups'));
    }

    public function my_prescription(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.my_prescription', compact('site_route', 'groups'));
    }

    public function subscription(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.subscription', compact('site_route', 'groups'));
    }

    public function customer_profile(Request $request)
    {
        $user = \App\User::find(\Auth::user()->id);
        $customer = \App\Chemist::where('user_id', \Auth::user()->id)->first();
        $address = \App\Address::where('user_id', '=', \Auth::user()->id)->first();
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.customer_profile', compact('site_route', 'groups', 'address', 'user', 'customer'));
    }

    public function profile_update($id)
    {
        $data['site_route'] = $request->route()->getName();
        $data['chemist'] = \App\Chemist::find($id);
        return view('dashboard.profile_update', $data);
    }

    public function profile_update_store(Request $request)
    {

        $chemist = \App\Chemist::find($request->chemist_id);
        $chemist->Party_Name = $request->Party_Name;
        $chemist->Mobile_No = $request->Mobile_No;
        $chemist->Email_ID = $request->Email_ID;
        
        $chemist->GSTIN = $request->GSTIN;
        $chemist->DL_No = $request->DL_No;
        $chemist->DL_No_21 = $request->DL_No_21;
        $chemist->DL_Valid_From = $request->DL_Valid_From;
        $chemist->DL_Valid_From_21 = $request->DL_Valid_From_21;
        $chemist->Contact_Person = $request->Contact_Person;
        if ($request->file('DL_File')) {
            $image = $request->file('DL_File');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $chemist->DL_File = 'upload/' . $fullname;
        }
        if ($request->file('DL_File_21')) {
            $image = $request->file('DL_File_21');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $chemist->DL_File_21 = 'upload/' . $fullname;
        }
        $chemist->save();
        return redirect()->back()->with('success', 'Profile Update successfully!');
    }

    public function my_wallet(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.my_wallet', compact('site_route', 'groups'));
    }

    public function sales_schemes(Request $request, $id)
    {
        if (\Auth::user()->role == 'Chemist') {
            $sales_schemes = \App\SalesScheme::where('schemefor', '=', 1)->get();
        } else {
            $sales_schemes = \App\SalesScheme::where('schemefor', '=', 2)->get();
        }

        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.sales_schemes', compact('site_route', 'groups', 'sales_schemes'));
    }

    public function wallet_recharge(Request $request)
    {
        $host = request()->getHost();
        $payment = PaytmWallet::with('receive');

        $payment_list = \App\Payment::create([
            'Order_Code' => 'NSRID-W-',
            'ResponseTransID' => '',
            'Requested_Amount' => '',
            'PaymentMode' => '',
            'TransactionTime' => date('Y-m-d H:m:s'),
            'TransStatus' => '',
            'Response_Code' => '',
            'RESPMSG' => '',
            'GatewayName' => \Auth::user()->id,
            'BankTransID' => '',
            'BankName' => '',
        ]);

        $payment->prepare([
            'order' => 'NSRID-W-' . $payment_list->id, // your order id taken from cart
            'user' => \Auth::user()->id, // your user id
            'mobile_number' => '485668552', // your customer mobile no
            'email' => 'email1@gmail.com', // your user email address
            'amount' => $request->recharge_amount, // amount will be paid in INR.
            'callback_url' => 'http://' . $host . '/dashboard/backurl_wallet_recharge', // callback URL
        ]);
        return $payment->receive();
    }

    public function backurl_wallet_recharge(Request $request)
    {
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        if ($transaction->isSuccessful()) {
            $payment_arr = explode("-", $response['ORDERID']);
            $payment = \App\Payment::find($payment_arr[2]);
            $user = \App\User::find($payment->GatewayName);
            Auth::login($user);
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
            $payment->save();
        }

        $user->wallet = $user->wallet + $response['TXNAMOUNT'];
        $user->save();
        session()->flash('success', 'Wallet Recharge Successfully');
        return redirect()->route('dashboard.my_wallet');
    }

    public function refer_earn(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.refer_earn', compact('site_route', 'groups'));
    }

    public function legal_information(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.legal_information', compact('site_route', 'groups'));
    }

    public function add_address1(Request $request)
    {
        $site_route = $request->route()->getName();
        $states = \App\State::with('cities')->get();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.add_address1', compact('site_route', 'groups', 'states'));
    }

    public function add_address(Request $request)
    {
        $site_route = $request->route()->getName();
        $states = \App\State::with('cities')->where('country_code', '=', '1')->orderBy('name', 'ASC')->get();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $addresses = \App\Address::where('user_id', '=', \Auth::user()->id)->get();
        return view('dashboard.add_address', compact('site_route', 'addresses', 'groups', 'states'));
    }

    public function store_add_address(Request $request)
    {
        $this->validate($request, [
            'Contact_Person' => 'required',
            'PIN' => 'required',
            'Address1' => 'required',
            'City_Code' => 'required',
            'State_Code' => 'required',
            'PIN' => 'required|min:6|max:6',
            'Mobile_No' => 'required|min:10|max:10',
            'address_type' => 'required',
        ]);
        $check_pin = \App\Pincode::where('pincode',$request->PIN)->first();
        if($check_pin){
            $address1 = \App\Address::create([
                'Contact_Person' => $request->Contact_Person,
                'Address1' => $request->Address1,
                'Address2' => $request->Address2,
                'Address3' => $request->Address3,
                'City_Code' => $request->City_Code,
                'State_Code' => $request->State_Code,
                'PIN' => $request->PIN,
                'Mobile_No' => $request->Mobile_No,
                'address_type' => $request->address_type,
                'user_id' => \Auth::user()->id,
            ]);
            $address1->set_as_a_current = 'Yes';
            $address1->set_as_a_default = 'Yes';
            $address1->save();
    
            $all_addresses = \App\Address::where('id', '!=', $address1->id)->where('user_id', $address1->user_id)->get();
            foreach ($all_addresses as $all_address) {
                $all_address->set_as_a_default = 'No';
                $all_address->set_as_a_current = 'No';
                $all_address->save();
            }
            return redirect()->route('dashboard.delivery_address', \Auth::user()->id)->with('success', 'Your Address Add successfully!');
        }else{
            return redirect()->back()->with('error', 'Delivery Are Not Available at this Pincode');
        }


       
    }

    public function contact_us(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.contact_us', compact('site_route', 'groups'));
    }

    public function contact_us_store(Request $request)
    {

        $this->validate($request, [
            'mobile' => 'required',
            'email' => 'required',
            'purpose_of_contact' => 'required',
            'message' => 'required',
        ]);
        $contact = \App\Contact::create([
            'mobile' => $request->mobile,
            'email' => $request->email,
            'purpose_of_contact' => $request->purpose_of_contact,
            'message' => $request->message,
        ]);
        return redirect()->back()->with('success', 'Your Request is Send successfully!');
    }

    public function upload_image(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.upload_image', compact('site_route', 'groups'));
    }

    public function upload_image_store(Request $request)
    {
        $this->validate($request, [
            'profile_image' => 'required',
        ]);

        if ($request->file('profile_image')) {
            $image = $request->file('profile_image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            \Auth::user()->profile_image = 'upload/' . $fullname;
            \Auth::user()->save();
        }
        return redirect()->back()->with('success', 'Image Upload successfully!');
    }

    public function set_as_a_current($address_id)
    {

        $address_arrs = \App\Address::where('user_id', '=', \Auth::user()->id)->get();
        foreach ($address_arrs as $address_arr) {
            $address_arr->set_as_a_current = 'No';
            $address_arr->set_as_a_default = 'No';
            $address_arr->save();
        }

        $address = \App\Address::find($address_id);
        $address->set_as_a_current = 'Yes';
        $address->set_as_a_default = 'Yes';
        $address->save();

        return redirect()->back();
    }

    public function user_dashboard(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.user_dashboard', compact('site_route', 'groups'));
    }

    public function account_summery(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();

        $reward_ledgers = \App\RewardReferenceLedger::where('user_id', \Auth::user()->id)->orderBy('id', 'ASC')->get();
        return view('dashboard.account_summery', compact('reward_ledgers', 'site_route', 'groups'));
    }

    public function edit_address(Request $request, $id)
    {
        $site_route = $request->route()->getName();
        $states = \App\State::with('cities')->where('country_code', '=', '1')->orderBy('name', 'ASC')->get();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $address = \App\Address::find($id);
        return view('dashboard.edit_address', compact('site_route', 'groups', 'address', 'states'));
    }

    public function edit_address_store(Request $request, $id)
    {
        $this->validate($request, [
            'Contact_Person' => 'required',
            'PIN' => 'required',
            'Address1' => 'required',
            'City_Code' => 'required',
            'State_Code' => 'required',
            'PIN' => 'required|min:6|max:6',
            'Mobile_No' => 'required|min:10|max:10',
            'address_type' => 'required',
        ]);
        $address = \App\Address::find($id);
        if ($address) {
            $pincode = \App\Pincode::where('pincode', '=', $request->input('PIN'))->first();
            if ($pincode) {
                if ($pincode->city_id == $request->input('City_Code') && $pincode->state_id == $request->input('State_Code')) {
                    $address->Contact_Person = $request->input('Contact_Person');
                    $address->Address1 = $request->input('Address1');
                    $address->Address2 = $request->input('Address2');
                    $address->Address3 = $request->input('Address3');
                    $address->City_Code = $request->input('City_Code');
                    $address->State_Code = $request->input('State_Code');
                    $address->PIN = $request->input('PIN');
                    $address->Mobile_No = $request->input('Mobile_No');
                    $address->user_id = \Auth::user()->id;
                    $address->address_type = $request->address_type;
                    $address->save();
                    return redirect()->route('dashboard.delivery_address', \Auth::user()->id)->with('success', 'Address Update successfully!');
                } else {
                    return redirect()->back()->with('error', 'Pincode And City Or State Does Not Match !');

                }
            } else {
                return redirect()->back()->with('error', 'Pincode Does Not Match!');
            }
            return redirect()->back()->with('error', 'Pincode Does Not Match !');
        } else {
            return redirect()->back()->with('error', 'Pincode Does Not Match !');
        }
    }

    public function delete_address($id)
    {
        $address = \App\Address::find($id);
        if ($address->count()) {
            $address->delete();
            session()->flash('success', 'Selected Address deleted successfully.');
            return redirect()->back();
        }
        session()->flash('error', 'Selected Address dose not found in database please try after some time.');
        return redirect()->back();
    }

}
