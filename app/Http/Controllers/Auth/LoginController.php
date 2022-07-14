<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    
    public function logout(Request $request) {
        Auth::logout();
         $add_cart = request()->cookie('add_cart');
         $add_cart_datas = json_decode($add_cart);
        if($add_cart_datas){
        foreach($add_cart_datas as $add_cart_data){
         $product= \App\Product::find($add_cart_data->product_id);
         $add_cart_data->amount = $product->actual_amount;
         $product1[] = $add_cart_data;
        }
        $array_json=json_encode($product1);
        $cookie = cookie('add_cart',$array_json, 4500);
        return redirect('/')->cookie($cookie); 
        }else{
         return redirect('/');   
        }

}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
           $this->middleware('guest')->except('logout');
    $this->redirectTo = url()->previous();
    }
}
