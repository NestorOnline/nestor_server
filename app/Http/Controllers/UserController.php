<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function __construct()
    {
        session(['url.intended' => url()->previous()]);
        $this->redirectTo = session()->get('url.intended');
        $this->middleware('guest')->except('logout');
    }

/**
 * Send OTP For Registration From Web
 *
 * @return \Illuminate\Http\Response
 */
    public function register_generate_otp(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            return response('This Mobile No Already Registered');
        } else {
            $otp = rand(100000, 999999);
            $mobile = $request->mobile;
            $key = "fdAu5P2aUI1";
            $sender = "NESTOR";
            $service = "TEMPLATE_BASED";
            $message = "Dear Customer, Use " . $otp . " as your login OTP.";
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

            $user['otp'] = Hash::make($otp);
            $user['mobile'] = $request->mobile;
            $user['password'] = $request->password;
            $array_json = json_encode($user);
            $cookie = cookie('language', $array_json, 120);
            return response('One time OTP send Successfully')->cookie($cookie);
        }
    }

    public function register_generate_resend_otp(Request $request)
    {
        $value = request()->cookie('language');
        $data = json_decode($value);
        $otp = rand(100000, 999999);
        $mobile = $data->mobile;
        $key = "fdAu5P2aUI1";
        $sender = "NESTOR";
        $service = "TEMPLATE_BASED";
        $otp = rand(100000, 999999);
        $message = "Dear Customer, Use " . $otp . " as your login OTP.";
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

        $user['otp'] = Hash::make($otp);
        $user['mobile'] = $data->mobile;
        $user['password'] = $data->password;
        $array_json = json_encode($user);
        $cookie = cookie('language', $array_json, 120);
        return response('One Time OTP Resend to Your Phone Successfully')->cookie($cookie);
    }

    public function registerpagestore(Request $request)
    {
        $otp = $request->input('digit-1') . $request->input('digit-2') . $request->input('digit-3') . $request->input('digit-4') . $request->input('digit-5') . $request->input('digit-6');
        $value = request()->cookie('language');
        $data = json_decode($value);

        if (Hash::check($otp, $data->otp)) {

            $user = \App\User::create([
                'mobile' => $data->mobile,
                'role' => 'User',
                'password' => Hash::make($data->password),
                'status' => 'verify',
                'wallet' => 200,
                'otp' => null,
                'ApprovalSatus_Code' => 1,
            ]);
            $chemist = \App\Chemist::create([
                'user_id' => $user->id,
                'PartyType_Code' => 17,
                'Party_Name' => 'User' . $user->mobile,
                'ApprovalSatus_Code' => 1,
                'Mobile_No'=>$user->mobile,
                'is_update' => 0,
                'status' => 0,
            ]);
            Auth::login($user);
            $abc = \Auth::user();
            $reward_reference_ledger = \App\RewardReferenceLedger::create([
                'Reference' => 'Sign up Reward',
                'Date_Time' => date('Y-m-d H:i:s'),
                'Debit' => 0,
                'Credit' => 200,
                'Balance' => 200,
                'user_id' => $abc->id,
            ]);
            $reard_transaction = \App\RewardTransaction::create([
                'Transaction_Date' => date('Y-m-d H:i:s'),
                'RewardPointOf_Code' => 1,
                'Reference_Code' => $reward_reference_ledger->id,
                'RewardTransactionType_Code' => 2,
                'Points' => 200,
                'user_id' => $abc->id,
            ]);
            $mobile = $user->mobile;
            $key = "fdAu5P2aUI1";
            $sender = "NESTOR";
            $service = "TEMPLATE_BASED";
            $message = "Dear " . "Customer" . ", It is our great pleasure to have you on board! A hearty welcome to you at Nestor Online! Your login mobile no. is " . $user->mobile . " and password is " . $data->password . ".";
            // $message = "Dear user,\r\nWelcome to Nestor Online,\r\nPlace your order with us and avail 200 reward points on your first 2 purchases.";
            $message = urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=" . $key . "&MobileNo=" . $mobile . "&SenderID=NESTOR&Message=" . $message . "&ServiceName=" . $service);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            $return_val = curl_close($ch);
            if ($abc->role == 'User') {
                $add_cart = request()->cookie('add_cart');
                $add_cart_datas = json_decode($add_cart);
                if ($add_cart_datas) {
                    foreach ($add_cart_datas as $add_cart_data) {
                        $product = \App\Product::find($add_cart_data->product_id);
                        $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
                        $add_to_card = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->where('product_id', '=', $add_cart_data->product_id)->first();
                        if ($add_to_card) {
                            $add_to_card->Qty = $add_to_card->Qty + $add_cart_data->Qty;
                            $add_to_card->amount = $product_price->Price;
                            $add_to_card->save();
                        } else {
                            $add_to_card = \App\Addtocard::create([
                                'user_id' => $user->id,
                                'product_id' => $add_cart_data->product_id,
                                'Qty' => $add_cart_data->Qty,
                                'amount' => $product_price->Price,
                            ]);
                        }
                    }
                    $cookie = Cookie::forget('add_cart');
                    return redirect()->intended(Session::get('url.intended'))->cookie($cookie);
                } else {
                    return redirect()->intended(Session::get('url.intended'));
                }
            } elseif ($abc->role == 'Chemist') {
                return redirect(url('/'));
            } elseif ($abc->role == 'Admin') {
                return redirect(url('/'));
            } elseif ($abc->role == 'Doctor') {
                return redirect(url('/'));
            } else {
                return redirect(url('/'));
            }
        } else {
            session()->flash('error', 'OTP Does Not Match Please Try Again');
            return redirect()->back();
        }
    }
/**
 * Open Login Page On Web
 *
 * @return \Illuminate\Http\Response
 */

    public function loginpage()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }
        return view('frontend.login', compact('groups'));
    }

    /**
     * Send OTP For Login With Password
     *
     * @return \Illuminate\Http\Response
     */
    public function loginpage_password(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                Auth::login($user);
                $abc = \Auth::user();

                $ip = \Request::ip();
                if (!$ip == "127.0.0.1") {
                    $data = \Location::get($ip);
                    $latitude_longitude = $data->latitude . ',' . $data->longitude;
                    $user_login_log = \App\Userloginlog::create([
                        'user_id' => \Auth::user()->id,
                        'user_role' => \Auth::user()->role,
                        'login_date_time' => date('Y-m-d H:i:s'),
                        'ip_address' => $request->ip(),
                        'plateform' => 'Web',
                        'referral' => 'Nothing',
                        'location' => $latitude_longitude,
                    ]);
                }

                if ($abc->role == 'User') {
                    $add_cart = request()->cookie('add_cart');
                    $add_cart_datas = json_decode($add_cart);
                    if ($add_cart_datas) {
                        foreach ($add_cart_datas as $add_cart_data) {
                            $product = \App\Product::find($add_cart_data->product_id);
                            $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
                            $add_to_card = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->where('product_id', '=', $add_cart_data->product_id)->first();
                            $current_price = $product->customer_price->Price + ($product->customer_price->Price * $product->customer_price->GST) / 100;
                            if ($product->sales_schame_customer) {
                                $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
                                $purchase_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
                            } else {
                                $purchase_price = $current_price;
                            }
                            if ($add_to_card) {
                                $add_to_card->Qty = $add_to_card->Qty + $add_cart_data->Qty;
                                $add_to_card->amount = $purchase_price;
                                $add_to_card->save();
                            } else {
                                $add_to_card = \App\Addtocard::create([
                                    'user_id' => $user->id,
                                    'product_id' => $add_cart_data->product_id,
                                    'Qty' => $add_cart_data->Qty,
                                    'amount' => $purchase_price,
                                ]);
                            }
                        }
                        $cookie = Cookie::forget('add_cart');
                        return redirect()->intended(url('/'))->cookie($cookie);
                    } else {
                        return redirect()->intended(url('/'));
                    }

                } elseif ($abc->role == 'Chemist') {
                    $add_cart = request()->cookie('add_cart');
                    $add_cart_datas = json_decode($add_cart);
                    if ($add_cart_datas) {
                        foreach ($add_cart_datas as $add_cart_data) {
                            $product = \App\Product::find($add_cart_data->product_id);
                            $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                            $add_to_card = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->where('product_id', '=', $add_cart_data->product_id)->first();
                            if ($add_to_card) {
                                $add_to_card->Qty = $add_to_card->Qty + $add_cart_data->Qty;
                                $add_to_card->amount = $chemist_product_price->Price;
                                $add_to_card->save();
                            } else {
                                $add_to_card = \App\Addtocard::create([
                                    'user_id' => $user->id,
                                    'product_id' => $add_cart_data->product_id,
                                    'Qty' => $add_cart_data->Qty,
                                    'amount' => $chemist_product_price->Price,
                                ]);
                            }
                        }
                        $cookie = Cookie::forget('add_cart');
                        return redirect()->intended(Session::get('url.intended'))->cookie($cookie);
                    } else {
                        return redirect()->intended(Session::get('url.intended'));
                    }
                } elseif ($abc->role == 'Admin') {
                    return redirect()->route('admindashboard');
                } elseif ($abc->role == 'Doctor') {
                    return redirect()->route('doctordashboard');
                } else {
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'Unauthorized Authentication');
                return redirect()->back();
            }
        } else {
            session()->flash('error', 'Unauthorized Authentication');
            return redirect()->back();
        }
    }

    /**
     * Send OTP For Login From Web
     *
     * @return \Illuminate\Http\Response
     */

    public function send_otp(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $otp = rand(100000, 999999);
            $mobile = $request->mobile;
            $key = "fdAu5P2aUI1";
            $sender = "NESTOR";
            $service = "TEMPLATE_BASED";
            $otp = rand(100000, 999999);
            $message = "Dear Customer, Use " . $otp . " as your login OTP.";
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

            $user['otp'] = Hash::make($otp);
            $user['mobile'] = $request->mobile;
            $array_json = json_encode($user);
            $cookie = cookie('language', $array_json, 120);
            return response('One Time OTP Send to Your Phone Successfully')->cookie($cookie);
        } else {
            return response('Unauthorized User');
        }
    }

    public function resend_otp(Request $request)
    {
        $value = request()->cookie('language');
        $data = json_decode($value);

        $otp = rand(100000, 999999);
        $mobile = $data->mobile;
        $key = "fdAu5P2aUI1";
        $sender = "NESTOR";
        $service = "TEMPLATE_BASED";
        $otp = rand(100000, 999999);
        $message = "Dear Customer, Use " . $otp . " as your login OTP.";
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

        $user['otp'] = Hash::make($otp);
        $user['mobile'] = $data->mobile;
        $array_json = json_encode($user);
        $cookie = cookie('language', $array_json, 120);
        return response('One Time OTP Resend to Your Phone Successfully')->cookie($cookie);

    }

    /**
     * Verify Login OTP From  Web
     *
     * @return \Illuminate\Http\Response
     */
    public function loginpagestore(Request $request)
    {
        $otp = $request->input('digit-1') . $request->input('digit-2') . $request->input('digit-3') . $request->input('digit-4') . $request->input('digit-5') . $request->input('digit-6');
        $value = request()->cookie('language');
        $data = json_decode($value);
        $user = \App\User::where('mobile', '=', $data->mobile)->first();
        if (Hash::check($otp, $data->otp)) {
            Auth::login($user);

            $ip = \Request::ip();
            if (!$ip == "127.0.0.1") {
                $data = \Location::get($ip);
                $latitude_longitude = $data->latitude . ',' . $data->longitude;
                $user_login_log = \App\Userloginlog::create([
                    'user_id' => \Auth::user()->id,
                    'user_role' => \Auth::user()->role,
                    'login_date_time' => date('Y-m-d H:i:s'),
                    'ip_address' => $request->ip(),
                    'plateform' => 'Web',
                    'referral' => 'Nothing',
                    'location' => $latitude_longitude,
                ]);
            }

            $abc = \Auth::user();
            if ($abc->role == 'User') {
                $add_cart = request()->cookie('add_cart');
                $add_cart_datas = json_decode($add_cart);
                if ($add_cart_datas) {
                    foreach ($add_cart_datas as $add_cart_data) {
                        $purchase_price = 0;
                        $product = \App\Product::find($add_cart_data->product_id);
                        $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
                        $current_price = $product->customer_price->Price + ($product->customer_price->Price * $product->customer_price->GST) / 100;
if ($product->sales_schame_customer) {
    $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
    $purchase_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
} else {
    $purchase_price = $current_price;
}
                        $add_to_card = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->where('product_id', '=', $add_cart_data->product_id)->first();
                        if ($add_to_card) {
                            $add_to_card->Qty = $add_to_card->Qty + $add_cart_data->Qty;
                            $add_to_card->amount = $purchase_price;
                            $add_to_card->save();
                        } else {
                            $add_to_card = \App\Addtocard::create([
                                'user_id' => $user->id,
                                'product_id' => $add_cart_data->product_id,
                                'Qty' => $add_cart_data->Qty,
                                'amount' => $purchase_price,
                            ]);
                        }
                    }
                    $cookie = Cookie::forget('add_cart');
                    return redirect()->intended(Session::get('url.intended'))->cookie($cookie);
                } else {
                    return redirect()->intended(Session::get('url.intended'));
                }

            } elseif ($abc->role == 'Chemist') {
                $add_cart = request()->cookie('add_cart');
                $add_cart_datas = json_decode($add_cart);
                if ($add_cart_datas) {
                    foreach ($add_cart_datas as $add_cart_data) {
                        $product = \App\Product::find($add_cart_data->product_id);
                        $chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
                        $add_to_card = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->where('product_id', '=', $add_cart_data->product_id)->first();
                        if ($add_to_card) {
                            
                            $add_to_card->Qty = $add_to_card->Qty + $add_cart_data->Qty;
                            $add_to_card->amount = $chemist_product_price->Price;
                            $add_to_card->save();
                        } else {
                            $add_to_card = \App\Addtocard::create([
                                'user_id' => $user->id,
                                'product_id' => $add_cart_data->product_id,
                                'Qty' => $add_cart_data->Qty,
                                'amount' => $chemist_product_price->Price,
                            ]);
                        }
                    }
                    $cookie = Cookie::forget('add_cart');
                    return redirect()->intended(Session::get('url.intended'))->cookie($cookie);
                } else {
                    return redirect()->intended(Session::get('url.intended'));
                }
            } elseif ($abc->role == 'Admin') {
                return redirect()->route('admindashboard');
            } elseif ($abc->role == 'Doctor') {
                return redirect()->route('doctordashboard');
            } else {
                return redirect()->back();
            }
            if (!session()->has('url.intended')) {
                return redirect()->route('admindashboard');
            } else {
                return redirect()->intended(Session::get('url.intended'));
            }

        } else {
            session()->flash('error', 'OTP does not match. Please try again');
            return redirect()->back();
        }
    }
    /**
     *User Login From APP By mobile,Password
     *
     * @return \Illuminate\Http\Response
     */
    public function login_App(Request $request)
    {
        $user = \App\User::where('role', 'Chemist')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            if (Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])) {
                $user = Auth::user();

                //      $ip= \Request::ip();
                // $data = \Location::get($ip);
                // $latitude_longitude = $data->latitude.','.$data->longitude;
                //  $user_login_log = \App\Userloginlog::create([
                //       'user_id'=>$user->id,
                // 'user_role'=>$user->role,
                // 'login_date_time'=>date('Y-m-d H:i:s'),
                // 'ip_address'=>$request->ip(),
                // 'plateform'=>'App',
                // 'referral'=>'Nothing',
                // 'location'=>$latitude_longitude,
                //  ]);
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
                $address = \App\Address::where('user_id', $user->id)->get();
                if (count($address)) {
                    $success['address'] = $address;
                } else {
                    $success['address'] = null;
                }

                return response()->json(['status' => true, 'message' => 'You Are Login Successfully', 'data' => $success], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Unauthorized User'], 401);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized User'], 401);

        }
    }

    public function customer_login_App(Request $request)
    {
        $user = \App\User::where('role', 'User')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();

        if ($user) {
            if (Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])) {
                $user = Auth::user();

                $ip = \Request::ip();
                if (!$ip == "127.0.0.1") {
                    $data = \Location::get($ip);
                    $latitude_longitude = $data->latitude . ',' . $data->longitude;
                    $user_login_log = \App\Userloginlog::create([
                        'user_id' => $user->id,
                        'user_role' => $user->role,
                        'login_date_time' => date('Y-m-d H:i:s'),
                        'ip_address' => $request->ip(),
                        'plateform' => 'App',
                        'referral' => 'Nothing',
                        'location' => $latitude_longitude,
                    ]);
                }
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
                $address = \App\Address::where('user_id', $user->id)->get();
                if (count($address)) {
                    $success['address'] = $address;
                } else {
                    $success['address'] = null;
                }

                return response()->json(['status' => true, 'message' => 'You Are Login Successfully', 'data' => $success], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Unauthorized User'], 401);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized User'], 401);

        }
    }

    public function customer_registration_App(Request $request)
    {
        $otp = rand(100000, 999999);
        $user = \App\User::where('mobile', '=', $request->input('mobile'))->where('status', '=', 'verify')->first();
        if ($user) {
            return response()->json(['status' => false, 'message' => 'This Mobile No is Already Registered'], $this->successStatus);
        } else {
            $user = \App\User::where('mobile', '=', $request->input('mobile'))->where('status', '=', 'not_verify')->first();
            if ($user) {
                $user->otp = bcrypt($otp);
                $user->mobile = $request->input('mobile');
                $user->password = bcrypt($request->input('password'));
                $user->save();
            } else {
                $user = \App\User::create([
                    'mobile' => $request->input('mobile'),
                    'role' => 'User',
                    'password' => bcrypt($request->input('password')),
                    'status' => 'not_verify',
                    'otp' => bcrypt($otp),
                    'wallet'=>200
                ]);
            }
            $mobile = $request->mobile;
            $key = "fdAu5P2aUI1";
            $sender = "NESTOR";
            $service = "TEMPLATE_BASED";
            $message = "Dear Customer, Use " . $otp . " as your login OTP.";
            $message = urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=" . $key . "&MobileNo=" . $mobile . "&SenderID=NESTOR&Message=" . $message . "&ServiceName=" . $service);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            $return_val = curl_close($ch);
            return response()->json(['status' => true, 'message' => 'OTP is Send Successfully'], $this->successStatus);
        }
    }

    /**
     *Verify OTP IN User Registration Process By APP
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_registration_otp_verify_App(Request $request)
    {
      
        $user = \App\User::where('mobile', '=', $request->mobile)->first();
        if ($user) {
            if (Hash::check($request->otp, $user->otp)) {
                $ip = \Request::ip();
                if (!$ip == "127.0.0.1") {
                $data = \Location::get($ip);
                $latitude_longitude = $data->latitude . ',' . $data->longitude;
                $user_login_log = \App\Userloginlog::create([
                    'user_id' => $user->id,
                    'user_role' => $user->role,
                    'login_date_time' => date('Y-m-d H:i:s'),
                    'ip_address' => $request->ip(),
                    'plateform' => 'App',
                    'referral' => 'Nothing',
                    'location' => $latitude_longitude,
                ]);
            }
                $chemist = \App\Chemist::create([
                    'user_id' => $user->id,
                    'PartyType_Code' => 17,
                    'Party_Name' => 'User' . $user->mobile,
                    'Mobile_No'=>$user->mobile,
                    'ApprovalSatus_Code' => 1,
                    'is_update' => 0,
                    'status' => 1,
                ]);

                $address = \App\Address::create([
                    'Contact_Person' => 'User' . $user->mobile,
                    'Address1' => 'Address1',
                    'Address2' => 'Address2',
                    'Address3' => 'Address3',
                    'City_Code' => 44,
                    'State_Code' => 10,
                    'PIN' => 122010,
                    'Mobile_No' => $user->mobile,
                    'user_id' => $user->id,
                    'set_as_a_default' => 'Yes',
                    'set_as_a_current' => 'Yes',
                ]);
                $reward_reference_ledger = \App\RewardReferenceLedger::create([
                    'Reference' => 'Sign up Reward',
                    'Date_Time' => date('Y-m-d H:i:s'),
                    'Debit' => 0,
                    'Credit' => 200,
                    'Balance' => 200,
                    'user_id' => $user->id,
                ]);
                $reard_transaction = \App\RewardTransaction::create([
                    'Transaction_Date' => date('Y-m-d H:i:s'),
                    'RewardPointOf_Code' => 1,
                    'Reference_Code' => $reward_reference_ledger->id,
                    'RewardTransactionType_Code' => 2,
                    'Points' => 200,
                    'user_id' => $user->id,
                ]);

                
                $mobile = $user->mobile;
                $key = "fdAu5P2aUI1";
                $sender = "NESTOR";
                $service = "TEMPLATE_BASED";
                $message = "Dear user,\r\nWelcome to Nestor Online,\r\nPlace your order with us and avail reward points on your first 2 purchases.";
                $message = urlencode($message);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=" . $key . "&MobileNo=" . $mobile . "&SenderID=NESTOR&Message=" . $message . "&ServiceName=" . $service);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                $return_val = curl_close($ch);
                $user->status = 'verify';
                $user->otp = null;
                $user->save();
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['token_type'] = 'Bearer';
                $success['mobile'] = $user->mobile;
                $success['status'] = 'verify';
                $success['password'] = $user->password;
                return response()->json(['status' => true, 'message' => 'You Are Successfully Registered', 'data' => $success], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }
    /**
     *Send OTP IN User Registration Process By APP
     *
     * @return \Illuminate\Http\Response
     */
    public function registration_App(Request $request)
    {
        $mobile_new = substr($request->input('mobile'), -min(strlen($request->input('mobile')), 10));
        $otp = rand(100000, 999999);
        $user = \App\User::where('mobile', '=', $mobile_new)->where('status', '=', 'verify')->first();
        if ($user) {
            return response()->json(['status' => false, 'message' => 'This Mobile No is Already Registered'], $this->successStatus);
        } else {
            $user = \App\User::where('mobile', '=', $mobile_new)->where('status', '=', 'not_verify')->first();
            if ($user) {
                $user->otp = bcrypt($otp);
                $user->mobile = $mobile_new;
                $user->password = bcrypt(123456);
                $user->save();
            } else {
                $user = \App\User::create([
                    'mobile' => $mobile_new,
                    'role' => 'Chemist',
                    'password' => bcrypt(123456),
                    'status' => 'not_verify',
                    'otp' => bcrypt($otp),
                    'wallet' => 1000,
                    'is_verify' => 0,
                ]);

                $chemist = \App\Chemist::create([
                    'user_id' => $user->id,
                    'PartyType_Code' => 13,
                    'Party_Name' => $request->input('Party_Name'),
                    'Contact_Person' => $request->input('Contact_Person'),
                    'Mobile_No' => $mobile_new,
                    'Email_ID' => $request->input('Email_ID'),
                    'DL_No' => $request->input('DL_No'),
                    'DL_No_21' => $request->input('DL_No_21'),
                   
                    'GSTIN' => $request->input('GSTIN'),
                    'ApprovalSatus_Code' => 1,
                    'is_update' => 0,
                    'Status' => 0,
                ]);

                $address = \App\Address::create([
                    'Contact_Person' => null,
                    'Address1' => null,
                    'Address2' => null,
                    'Address3' => null,
                    'PIN' => $request->input('PIN'),
                    'Mobile_No' => $mobile_new,
                    'user_id' => $user->id,
                    'set_as_a_default' => 'Yes',
                    'set_as_a_current' => 'Yes',
                ]);

                $pincode = \App\Pincode::where('pincode', $request->input('PIN'))->first();
                if ($pincode) {
                    $address->City_Code = $pincode->city_id;
                    $address->State_Code = $pincode->state_id;
                    $chemist->City_Code = $pincode->city_id;
                    $chemist->State_Code = $pincode->state_id;
                    $chemist->PIN = $request->input('PIN');
                } else {
                    $address->City_Code = null;
                    $address->State_Code = null;
                }
                $address->save();

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
                $reward_reference_ledger = \App\RewardReferenceLedger::create([
                    'Reference' => 'Sign up Reward',
                    'Date_Time' => date('Y-m-d H:i:s'),
                    'Debit' => 0,
                    'Credit' => 1000,
                    'Balance' => 1000,
                    'user_id' => $user->id,
                ]);
                $reard_transaction = \App\RewardTransaction::create([
                    'Transaction_Date' => date('Y-m-d H:i:s'),
                    'RewardPointOf_Code' => 1,
                    'Reference_Code' => $reward_reference_ledger->id,
                    'RewardTransactionType_Code' => 2,
                    'Points' => 1000,
                    'user_id' => $user->id,
                ]);

            }
            $mobile = $mobile_new;
            $key = "fdAu5P2aUI1";
            $sender = "NESTOR";
            $service = "TEMPLATE_BASED";
            $message = "Dear Customer, Use " . $otp . " as your login OTP.";
            $message = urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=" . $key . "&MobileNo=" . $mobile . "&SenderID=NESTOR&Message=" . $message . "&ServiceName=" . $service);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            $return_val = curl_close($ch);
            return response()->json(['status' => true, 'message' => 'OTP is Send Successfully'], $this->successStatus);
        }
    }

    /**
     *Verify OTP IN User Registration Process By APP
     *
     * @return \Illuminate\Http\Response
     */
    public function registration_otp_verify_App(Request $request)
    {
        $mobile_new = substr($request->mobile, -min(strlen($request->mobile), 10));
        $user = \App\User::where('role', '=', 'Chemist')->where('mobile', '=', $mobile_new)->first();
        if ($user) {
            if (Hash::check($request->otp, $user->otp)) {
                $ip = \Request::ip();
                if (!$ip == "127.0.0.1") {
                    $data = \Location::get($ip);
                    $latitude_longitude = $data->latitude . ',' . $data->longitude;
                    $user_login_log = \App\Userloginlog::create([
                        'user_id' => $user->id,
                        'user_role' => $user->role,
                        'login_date_time' => date('Y-m-d H:i:s'),
                        'ip_address' => $request->ip(),
                        'plateform' => 'App',
                        'referral' => 'Nothing',
                        'location' => $latitude_longitude,
                    ]);
                }
                $user->status = 'verify';
                $user->is_verify = 1;
                $user->otp = null;
                $password = rand(100000, 999999);
                $user->password = bcrypt($password);
                $user->save();

                $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();

                $chemist->Status = 1;
                $chemist->save();
                $PartyDetails = ['Party_Code' => 0, 'PartyType_Code' => $chemist->PartyType_Code, 'Party_ID' => $chemist->Party_ID, 'OnlineParty_id' => $chemist->id, 'Registration_Date' => $chemist->created_at->format('d-M-Y H:i:s'), 'Party_Name' => $chemist->Party_Name, 'Address1' => $chemist->Address1, 'Address2' => $chemist->Address2, 'Address3' => $chemist->Address3, 'City_Code' => $chemist->City_Code, 'State_Code' => $chemist->State_Code, 'PIN' => $chemist->PIN, 'Phone' => $chemist->Phone, 'Email_ID' => $chemist->Email_ID, 'Contact_Person' => $chemist->Contact_Person, 'Mobile_No' => $chemist->Mobile_No, 'Email' => $chemist->Email, 'GSTIN' => $chemist->GSTIN, 'DLForm20' => $chemist->DL_No, 'DLForm21' => $chemist->DL_No_21, 'DLForm20_File' => $chemist->DL_File, 'DLForm21_File' => $chemist->DL_File_21, 'DLForm21ValidFrom' => $chemist->DL_Valid_From_21, 'DLForm20ValidFrom' => $chemist->DL_Valid_From];
                $data = [];
                $data['PartyDetails'] = json_encode($PartyDetails);
                $data['API_KEY'] = 'fdAu52PaUI1';
//   $data['PartyDetails']="{'Party_Code':1,'PartyType_Code':13,'Party_ID':101,'GPS':null,'Party_Name':'Test','Address1':'AddressLine1','Address2':'AddressLine2','Address3':'AddressLine3','City_Code':1,'City_Name':null,'State_Code':0,'State_Name':null,'PIN':null,'Phone':null,'DL_No':null,'PAN_No':null,'GSTIN':null,'Contact_Person':null,'Mobile_No':null,'Email':null,'Transporter_Code':0,'Transporter_Name':null,'Territory_Code':0,'Territory_Name':null,'TPArea_Code':0,'Area_Code':0,'Area_Name':null,'DistanceFromCity':0,'Photos':null,'LastVisit_Date':null,'LastInvoice_Date':null,'LastGoodsReceipt_Date':null,'LastInvoice_Value':0,'OutStanding_Value':null,'ApprovalStatus_Code':0,'Upload_Status':0,'CreatedBy':0,'Created_Date':null}";
                $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);

                $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/PartyAdd";

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                $server_output = curl_exec($ch);
                if ($server_output) {
                    $chemist->Party_Code = json_decode(substr_replace($server_output, "", -10), true)['Reference_Code'];
                }
                $chemist->save();
                curl_close($ch);

                $mobile = $user->mobile;
                $key = "fdAu5P2aUI1";
                $sender = "NESTOR";
                $service = "TEMPLATE_BASED";
                $message = "Dear " . $chemist->Party_Name . ", It is our great pleasure to have you on board! A hearty welcome to you at Nestor Online! Your login mobile no. is " . $user->mobile . " and password is " . $password . ".";
                $message = urlencode($message);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=" . $key . "&MobileNo=" . $mobile . "&SenderID=NESTOR&Message=" . $message . "&ServiceName=" . $service);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                $return_val = curl_close($ch);

                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['token_type'] = 'Bearer';
                $success['mobile'] = $user->mobile;
                $success['role'] = $user->role;
                $success['status'] = 'verify';
                $address = \App\Address::where('user_id', $user->id)->get();
                if (count($address)) {
                    $success['address'] = $address;
                } else {
                    $success['address'] = null;
                }
                return response()->json(['status' => true, 'message' => 'You Are Successfully Registered', 'data' => $success], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    /**
     *Send OTP IN User LOGIN Process By APP
     *
     * @return \Illuminate\Http\Response
     */

    public function send_otp_for_login_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('role', 'Chemist')->first();
        if ($user) {
            $otp = rand(100000, 999999);
            $user->otp = bcrypt($otp);
            $user->save();

            $mobile = $request->mobile;
            $key = "fdAu5P2aUI1";
            $sender = "NESTOR";
            $service = "TEMPLATE_BASED";
            $message = "Dear Customer, Use " . $otp . " as your login OTP.";
            $message = urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=" . $key . "&MobileNo=" . $mobile . "&SenderID=NESTOR&Message=" . $message . "&ServiceName=" . $service);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            $return_val = curl_close($ch);

            return response()->json(['status' => true, 'message' => 'OTP is Send Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }

    public function customer_send_otp_for_login_App(Request $request)
    {

        $user = \App\User::where('mobile', '=', $request->mobile)->where('role', 'User')->first();
        if ($user) {
            $otp = rand(100000, 999999);
            $user->otp = bcrypt($otp);
            $user->save();

            $mobile = $request->mobile;
            $key = "fdAu5P2aUI1";
            $sender = "NESTOR";
            $service = "TEMPLATE_BASED";
            $message = "Dear Customer, Use " . $otp . " as your login OTP.";
            $message = urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=" . $key . "&MobileNo=" . $mobile . "&SenderID=NESTOR&Message=" . $message . "&ServiceName=" . $service);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            $return_val = curl_close($ch);

            return response()->json(['status' => true, 'message' => 'OTP is Send Successfully'], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }

    }
    /**
     *Verify OTP IN User Process By APP
     *
     * @return \Illuminate\Http\Response
     */
    public function otp_verify_login_App(Request $request)
    {

        $user = \App\User::where('mobile', '=', $request->mobile)->where('role', 'Chemist')->first();

        if (Hash::check($request->otp, $user->otp)) {

            $ip = \Request::ip();
            if (!$ip == "127.0.0.1") {
                $data = \Location::get($ip);
                $latitude_longitude = $data->latitude . ',' . $data->longitude;
                $user_login_log = \App\Userloginlog::create([
                    'user_id' => $user->id,
                    'user_role' => $user->role,
                    'login_date_time' => date('Y-m-d H:i:s'),
                    'ip_address' => $request->ip(),
                    'plateform' => 'App',
                    'referral' => 'Nothing',
                    'location' => $latitude_longitude,
                ]);
            }

            $user->status = 'verify';
            $user->otp = null;
            $user->save();
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
            $success['role'] = $user->role;
            $success['wallet'] = $user->wallet;
            $address = \App\Address::where('user_id', $user->id)->get();
            if (count($address)) {
                $success['address'] = $address;
            } else {
                $success['address'] = null;
            }
            return response()->json(['status' => true, 'message' => 'You Are Successfully Registered', 'data' => $success], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function customer_otp_verify_login_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('role', 'User')->where('status', 'verify')->first();
        if (Hash::check($request->otp, $user->otp)) {
            $ip = \Request::ip();
            if (!$ip == "127.0.0.1") {
                $data = \Location::get($ip);
                $latitude_longitude = $data->latitude . ',' . $data->longitude;
                $user_login_log = \App\Userloginlog::create([
                    'user_id' => $user->id,
                    'user_role' => $user->role,
                    'login_date_time' => date('Y-m-d H:i:s'),
                    'ip_address' => $request->ip(),
                    'plateform' => 'App',
                    'referral' => 'Nothing',
                    'location' => $latitude_longitude,
                ]);
            }

            $user->status = 'verify';
            $user->otp = null;
            $user->save();
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
            $success['role'] = $user->role;
            $success['wallet'] = $user->wallet;
            $address = \App\Address::where('user_id', $user->id)->get();
            if (count($address)) {
                $success['address'] = $address;
            } else {
                $success['address'] = null;
            }

            return response()->json(['status' => true, 'message' => 'You Are Successfully Registered', 'data' => $success], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], $this->successStatus);
        }
    }

    public function registerform()
    {
        return view('registerform');
    }

/**
 * Register api
 *
 * @return \Illuminate\Http\Response
 */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function changepassword()
    {
        $title = 'Setting';
        $pageTitle = $title;
        $breadcrumb = [['icon' => 'dashboard', 'title' => 'Dashboard'], ['icon' => 'user-md', 'title' => 'Guards']];
        return view('auth.changepassword', compact(['title', 'pageTitle', 'breadcrumb']));
    }

    public function registration_varification(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $username = "Demtech";
        $password = "muzztech";
        $sender = "Demtec";
//---------------------------------

        $otp = rand(100000, 999999);
        $mobile = 8109771419;
        $message = "This is Your One Time OTP '" . $otp . "' For Nestor";
        $username = urlencode($username);
        $password = urlencode($password);
        $sender = urlencode($sender);
        $message = urlencode($message);
        $parameters = "username=" . $username . "&password=" . $password . "&mobile=" . $mobile . "&sendername=" . $sender . "&message=" . $message;
        $url = "http://priority.muzztech.in/sms_api/sendsms.php";
        $ch = curl_init($url);
        if (isset($_POST)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        } else {
            $get_url = $url . "?" . $parameters;
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_URL, $get_url);
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0); // DO NOT RETURN HTTP HEADERS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // RETURN THE CONTENTS OF THE CALL
        $return_val = curl_exec($ch);
        if ($return_val == "") {
            echo "Process Failed, Please check domain, username and password.";
        } else {
            echo "$return_val";
        }

    }

    public function registration_store(Request $request)
    {
        $value = $request->cookie('test_cookie');
        $data = json_decode($value);
        if ($request->otp == $data->otp) {
            $user = \App\User::create([
                'mobile' => $data->mobile,
                'role' => 'User',
                'password' => bcrypt($request->password),
            ]);
            if (Hash::check($request->password, $user->password)) {
                return redirect(url('/home'));
            } else {
                echo json_encode('Data Does Not Match. Please Try Again');
            }
        } else {

        }
    }

    public function changepasswordpost(Request $request)
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
        return redirect(url('/'));
    }

    public function registerpage()
    {
        $groups = \App\Group::with('groupcategories')->get();
        return view('frontend.register', compact('groups'));
    }

/*
public function registerpagestore(Request $request) {
$this->validate($request, [
'mobile' => 'required|string|max:255|unique:users',
'password' => 'required|string|min:6|confirmed',
]);
$user = \App\User::create([
'mobile' => $request->input('mobile'),
'role' => 'User',
'password' => bcrypt($request->input('password')),
]);
if (Hash::check($request->password, $user->password)) {
echo json_encode($user);
} else {
echo json_encode('Data Does Not Match. Please Try Again');
}
}
 */

}
