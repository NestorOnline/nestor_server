<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\RewardPoint;
use Illuminate\Http\Request;

class RewardPointController extends Controller
{
    public function reward_point_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $balance = \App\RewardReferenceLedger::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->first();

          
            if ($balance) {
                $data['note'] = 'for purchase of every Rs. 100 you earn 2 reward points';
                $data['wallet_amount'] = $balance->Balance;
                return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 200);
        }
    }
}