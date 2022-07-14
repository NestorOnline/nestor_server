<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\User;
use Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SocialiteController extends Controller {

    
    
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        try {
            $google_user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $google_user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/');
            } else {
                 return redirect(url('socialite/socialite_mobile', $google_user->id));
            }
           
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect('socialite/google');
        }
    }

    public function socialite_mobile($id) {
        $google_user_id = $id;
        $groups = \App\Group::with('groupcategories')->get();

        return view('frontend.social_mobile', compact('groups', 'google_user_id'));
    }

    public function send_otp(Request $request) {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if($user){
            return response('This Mobile No Already Registered');
        }else{
            $username = "Demtech";
            $password = "muzztech";
            $sender = "Demtec";
//---------------------------------
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
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $output = curl_exec($ch);
            $return_val = curl_close($ch);
            if ($output == "")
                echo "Process Failed, Please check domain, username and password.";
            else
                echo "$output";

            $user['otp'] = Hash::make($otp);
            $user['mobile'] = $request->mobile;
            $user['password'] = $request->password;
            $user['google_user_id'] = $request->google_user_id;
            $array_json = json_encode($user);
            $cookie = cookie('language', $array_json, 120);
            return response('One time OTP send Successfully')->cookie($cookie);
        }
    }

    public function resend_otp(Request $request) {
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($ch);
        $return_val = curl_close($ch);
        if ($output == "")
            echo "Process Failed, Please check domain, username and password.";
        else
            echo "$output";
        $user['otp'] = Hash::make($otp);
        $user['mobile'] = $data->mobile;
        $user['password'] = $data->password;
        $user['google_user_id'] = $request->google_user_id;
        $array_json = json_encode($user);
        $cookie = cookie('language', $array_json, 120);
        return response('One Time OTP Resend to Your Phone Successfully')->cookie($cookie);
    }

    public function socialite_mobile_store(Request $request) {
        $otp = $request->input('digit-1') . $request->input('digit-2') . $request->input('digit-3') . $request->input('digit-4') . $request->input('digit-5') . $request->input('digit-6');
        $value = request()->cookie('language');
        $data = json_decode($value);
       
        if(Hash::check($otp, $data->otp)){
            $finduser = User::where('google_id', $data->google_user_id)->first();
            if($finduser){
                Auth::login($finduser);
                return redirect('/home');
            }else{
                $newUser = User::create(['mobile' => $data->mobile, 'google_id' => $data->google_user_id, 'role' => 'User', 'password' => Hash::make(123456)]);
                Auth::login($newUser);
                return redirect()->back();
            }
        }
    }
    
    
    
    
    
    
    
     public function redirectToFacebook() {
        return Socialite::driver('facebook')->redirect();
    }
    
        public function handleFacebookCallback() {
        try {
            $facebook_user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $facebook_user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/');
            } else {
                 return redirect(url('socialite/socialite_mobile_facebook', $facebook_user->id));
            }
           
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect('socialite/google');
        }
    }
    
     public function socialite_mobile_facebook($id) {
        $facebook_user_id = $id;
        $groups = \App\Group::with('groupcategories')->get();

        return view('frontend.social_mobile_facebook', compact('groups', 'facebook_user_id'));
    }
    
    public function send_otp_facebook(Request $request) {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if($user){
            return response('This Mobile No Already Registered');
        }else{
            $username = "Demtech";
            $password = "muzztech";
            $sender = "Demtec";
//---------------------------------
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
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $output = curl_exec($ch);
            $return_val = curl_close($ch);
            if ($output == "")
                echo "Process Failed, Please check domain, username and password.";
            else
                echo "$output";

            $user['otp'] = Hash::make($otp);
            $user['mobile'] = $request->mobile;
            $user['password'] = $request->password;
            $user['facebook_user_id'] = $request->facebook_user_id;
            $array_json = json_encode($user);
            $cookie = cookie('language', $array_json, 120);
            return response('One time OTP send Successfully')->cookie($cookie);
        }
    }

    public function resend_otp_facebook(Request $request) {
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($ch);
        $return_val = curl_close($ch);
        if ($output == "")
            echo "Process Failed, Please check domain, username and password.";
        else
            echo "$output";
        $user['otp'] = Hash::make($otp);
        $user['mobile'] = $data->mobile;
        $user['password'] = $data->password;
        $user['facebook_user_id'] = $request->facebook_user_id;
        $array_json = json_encode($user);
        $cookie = cookie('language', $array_json, 120);
        return response('One Time OTP Resend to Your Phone Successfully')->cookie($cookie);
    }

    public function socialite_mobile_facebook_store(Request $request) {
        $otp = $request->input('digit-1') . $request->input('digit-2') . $request->input('digit-3') . $request->input('digit-4') . $request->input('digit-5') . $request->input('digit-6');
        $value = request()->cookie('language');
        $data = json_decode($value);
       
        if(Hash::check($otp, $data->otp)){
            $finduser = User::where('google_id', $data->facebook_user_id)->first();
            if($finduser){
                Auth::login($finduser);
                return redirect('/home');
            }else{
                $newUser = User::create(['mobile' => $data->mobile, 'google_id' => $data->facebook_user_id, 'role' => 'User', 'password' => Hash::make(123456)]);
                Auth::login($newUser);
                return redirect()->back();
            }
        }
    }

}
