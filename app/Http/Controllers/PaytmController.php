<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User; 


class PaytmController extends Controller
{
    public $successStatus = 200;
    
          public function logoutApp(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    
        public function detailsApp() 
    { 

        $user = Auth::user(); 
         return response()->json(['Status' =>true,'Message'=>'Successfully Get User Detail','Data' =>$user], $this-> successStatus);  
    } 
   
}
