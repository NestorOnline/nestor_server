<?php

namespace App\Http\Controllers;

use App\Chemist;
use App\Exports\ChemistsExport;
use App\Http\Controllers\Controller;
use Excel;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Validator;

class ChemistController extends Controller
{

    protected $chemist;

    public function __construct(Chemist $chemist)
    {
        $this->chemist = $chemist;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function chemist_form()
    {
        $groups = \App\Group::with('groupcategories')->get();
        if ($groups) {
            return view('frontend.chemist_form', compact('groups'));
        }
    }

    public function chemist_register_generate_otp(Request $request)
    {
        $find_user = \App\User::where('mobile', '=', $request->mobile)->where('is_verify', 0)->orderBy('id', 'DESC')->first();
        if ($find_user) {
            $chemist1 = \App\Chemist::where('user_id', $find_user->id)->first();
            $address = \App\Address::where('user_id', $find_user->id)->delete();
            if ($chemist1->count()) {
                \File::delete($chemist1->DL_File);
                $chemist1->delete();
            }
            $find_user = \App\User::where('mobile', '=', $request->mobile)->where('is_verify', 0)->orderBy('id', 'DESC')->delete();
        }

        $validator = Validator::make($request->all(), [
            'Party_Name' => 'required',
            'mobile' => ['required', 'string', 'max:15', 'unique:users'],
            'Contact_Person' => 'required',
            'DL_No' => 'required',
            'DL_File' => 'required',
            'PIN' => 'required',
            'State_Code' => 'required',
        ]);
        if ($validator->passes()) {
            $user = \App\User::create([
                'mobile' => $request->input('mobile'),
                'role' => 'Chemist',
                'password' => bcrypt(123456),
                'status' => 'not_verify',
                'ApprovalSatus_Code' => 1,
                'wallet' => 1000,
                'is_verify' => 0,
            ]);
            $chemist = \App\Chemist::create([
                'Party_Name' => $request->input('Party_Name'),
                'Mobile_No' => $request->input('mobile'),
                'user_id' => $user->id,
                'Contact_Person' => $request->input('Contact_Person'),
                'DL_No' => $request->input('DL_No'),
                'GSTIN' => $request->input('GSTIN'),
                'Email_ID' => $request->input('Email_ID'),
                'Address1' => "",
                'Address2' => "",
                'Address3' => "",
                'PartyType_Code' => 17,
                'City_Code' => $request->input('City_Code'),
                'State_Code' => $request->input('State_Code'),
                'PIN' => $request->input('PIN'),
                'Geolocation' => $request->input('Geolocation'),
                'Status' => 0,
                'ApprovalSatus_Code' => 1,
            ]);

            // if ($request->file('DL_File')) {
            //     $file = $request->file('DL_File');
            //     $filename = $file->getClientOriginalName();
            //     $fullname = Str::slug(Str::random(16) . $filename) . '.' . $file->getClientOriginalExtension();
            //     $path = public_path('Chemist_DL_File/' . date('d-m-Y'));
            //     if (!File::exists($path)) {
            //         $result = File::makeDirectory($path, $mode = 0777, true, true);
            //     } else {

            //     }
            //     $file->move($path, $fullname);
            //     $chemist->DL_File = 'Chemist_DL_File/' . date('d-m-Y') . '/' . $fullname;
            // }

            if ($request->file('DL_File')) {
                $image = $request->file('DL_File');
                $filename = $image->getClientOriginalName();
                $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
                $image->move("upload", $fullname);
                $chemist->DL_File = 'upload/' . $fullname;
            }
            $chemist->save();
            $address = \App\Address::create([
                'Contact_Person' => $request->input('Contact_Person'),
                'Address1' => "",
                'Address2' => "",
                'Address3' => "",
                'City_Code' => $request->input('City_Code'),
                'State_Code' => $request->input('State_Code'),
                'PIN' => $request->input('PIN'),
                'Mobile_No' => $request->input('mobile'),
                'user_id' => $user->id,
                'set_as_a_default' => 'Yes',
                'set_as_a_current' => 'Yes',
            ]);

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

            $user['otp'] = Hash::make($otp);
            $user['mobile'] = $request->mobile;
            $array_json = json_encode($user);
            $cookie = cookie('language', $array_json, 120);
            return response()->json(['success' => 'One Time OTP Send to Your Phone Successfully'])->cookie($cookie);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function chemist_register_generate_resend_otp(Request $request)
    {
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
        return response()->json(['success' => 'One Time OTP Send to Your Phone Successfully'])->cookie($cookie);
    }

    public function chemist_store(Request $request)
    {
        $otp = $request->input('digit-1') . $request->input('digit-2') . $request->input('digit-3') . $request->input('digit-4') . $request->input('digit-5') . $request->input('digit-6');
        $value = request()->cookie('language');
        $data1 = json_decode($value);
        if (Hash::check($otp, $data1->otp)) {
            $user = \App\User::where('mobile', '=', $data1->mobile)->first();
            $user->status = 'verify';
            $password = rand(100000, 999999);
            $user->password = bcrypt($password);
            $user->is_verify = 1;
            $user->save();
            Auth::login($user);

            $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
            $chemist->status = 1;
            $chemist->save();
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
            if ($output == "") {
                echo "Process Failed, Please check domain, username and password.";
            } else {
                echo "$output";
            }
            $PartyDetails = ['Party_Code' => $chemist->Party_Code, 'PartyType_Code' => $chemist->PartyType_Code, 'Party_ID' => $chemist->Party_ID, 'GPS' => $chemist->Geolocation, 'Party_Name' => $chemist->Party_Name, 'Address1' => $chemist->Address1, 'Address2' => $chemist->Address2, 'Address3' => $chemist->Address3, 'City_Code' => $chemist->City_Code, 'City_Name' => $chemist->City_Code, 'State_Code' => $chemist->State_Code, 'State_Name' => $chemist->State_Code, 'PIN' => $chemist->PIN, 'Phone' => $chemist->Phone, 'DL_No' => $chemist->DL_No, 'PAN_No' => null, 'GSTIN' => $chemist->GSTIN, 'Contact_Person' => $chemist->Contact_Person, 'Mobile_No' => $chemist->Mobile_No, 'Email' => $chemist->Email_ID, 'Transporter_Code' => 0, 'Transporter_Name' => null, 'Territory_Code' => 0, 'Territory_Name' => null, 'TPArea_Code' => 0, 'Area_Code' => 0, 'Area_Name' => null, 'DistanceFromCity' => 0, 'Photos' => null, 'LastVisit_Date' => null, 'LastInvoice_Date' => null, 'LastGoodsReceipt_Date' => null, 'LastInvoice_Value' => 0, 'OutStanding_Value' => null, 'ApprovalStatus_Code' => 0, 'Upload_Status' => 0, 'CreatedBy' => 0, 'Created_Date' => null];
            $data = [];
            $data['PartyDetails'] = json_encode($PartyDetails);
            $data['API_KEY'] = 'fdAu52PaUI1';
            $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);
            $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/PartyAdd";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            $server_output = curl_exec($ch);
            curl_close($ch);
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

            return redirect()->route('home');
        } else {
            session()->flash('error', 'OTP Does Not Match Please try Again');
            return redirect()->back();

        }
    }

    public function storeApp(Request $request)
    {

        $data['API_KEY'] = 'fdAu52PaUI1';
        $data['PartyDetails'] = [
            'id' => '18',
            'user_id' => '158',
            'Party_Code' => '67152',
            'PartyType_Code' => '13',
            'Party_ID' => 'EC18',
            'Party_Name' => 'qa',
            'Address1' => 'asdxfcgvhbjn',
            'Address2' => null,
            'Address3' => null,
            'PIN' => '12345678',
            'City_Code' => '431',
            'State_Code' => '98',
            'Phone' => null,
            'Email_ID' => 'asdfghjn',
            'Contact_Person' => 'wasedfgh',
            'Designation' => null,
            'Mobile_No' => '7905316446',
            'GSTIN' => '1234567890-hxc',
            'DL_No' => 'upload/waejjajvg35hmfjm7png.PNG',
            'DL_File' => 'upload/waejjajvg35hmfjm7png.PNG',
            'ShopPhoto' => 'product_image/images/CHANGE/170010.webp',
            'Location_Code' => null,
            'MarketingState_Code' => null,
            'HQ_Code' => null,
            'Territory_Code' => null,
            'Area_Code' => null,
            'Geolocation' => '26.2331,78.1692',
            'Status' => 'Deactivate',
            'ApprovalSatus_Code' => '1',
            'is_update' => '0',
        ];

        $post_data = json_encode($data);

        $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/PartyAdd";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);

    }

    public function index(Request $request)
    {
        $search_state_code = $request->state_code;
        $search_from_date = $request->from_date;
        $search_to_date = $request->to_date;
        $states = \App\State::where('country_code', 1)->orderBy('name', 'ASC')->get();
        if ($search_state_code && $search_from_date && $search_to_date) {
            $chemists = \App\Chemist::where('Status', 1)->whereBetween('created_at', [$search_from_date . ' 00:00:00', $search_to_date . ' 23:59:59'])->where('State_Code', $search_state_code)->orderBy('id', 'DESC')->get();
        } else {
            $chemists = \App\Chemist::where('Status', 1)->orderBy('id', 'DESC')->get();

        }

        return view('backend.chemists.index', compact('chemists', 'states', 'search_state_code', 'search_from_date', 'search_to_date'));
    }

    public function indexApp()
    {
        $chemists = \App\Chemist::all();
        if ($chemists) {
            echo json_encode($chemists);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.chemists.create');
    }

    public function view_profile($user_id)
    {
        $chemist = \App\Chemist::where('user_id', $user_id)->first();
        return view('backend.chemists.view_profile', compact('chemist'));
    }

    public function chemist_list_without_Party_Code(Request $request)
    {
        $data['search_state_code'] = $request->state_code;
        $data['search_from_date'] = $request->from_date;
        $data['search_to_date'] = $request->to_date;
        if ($request->from_date && $request->to_date) {
            $data['search_from_date'] = date('Y-m-d');
            $data['search_to_date'] = date('Y-m-d');
        }

        $data['states'] = \App\State::where('country_code', 1)->orderBy('name', 'ASC')->get();
        $data['is_verify'] = $request->is_verify;

        if ($data['search_from_date'] && $data['search_to_date'] && $data['is_verify']) {
            $data['users'] = \App\User::where('role', 'chemist')->where('status', $data['is_verify'])->get();
        } else {
            $data['users'] = \App\User::where('role', 'chemist')->get();
        }
        return view('backend.chemists.chemist_list_without_Party_Code', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'chemist_name' => 'required',
            'contact_person' => 'required',
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'password-confirm' => 'required|same:password',
            'code' => 'required',
            'drug_license_no' => 'required',
            'geolocation' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);
        $user = \App\User::create([
            'mobile' => $request->input('mobile'),
            'role' => 'Chemist',
            'password' => bcrypt($request->input('password')),
        ]);
        $chemist = \App\Chemist::create([
            'chemist_name' => $request->input('chemist_name'),
            'user_id' => $user->id,
            'contact_person' => $request->input('contact_person'),
            'mobile' => $request->input('mobile'),
            'code' => $request->input('code'),
            'drug_license_no' => $request->input('drug_license_no'),
            'geolocation' => $request->input('geolocation'),
            'address' => $request->input('address'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'status' => "Deactivate",

        ]);
        session()->flash('success', 'New Chemist is create Successfully');
        return redirect()->route('backend.chemists.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $chemist = \App\Chemist::find($id);
        if ($chemist) {
            return view('backend.chemists.show', compact('category'));
        }
        return redirect()->route('backend.chemists.index');
    }

    public function activate($id)
    {
        $chemist = \App\Chemist::find($id);
        $chemist->status = "Activate";
        $chemist->save();
        $user = \App\User::where('mobile', '=', $chemist->mobile)->first();
        $user->status = 'verify';
        $user->save();
        session()->flash('success', 'Selected User is Activate successfully.');
        return redirect()->back();
    }

    public function deactivate($id)
    {
        $chemist = \App\Chemist::find($id);
        $chemist->status = "Deactivate";
        $chemist->save();
        $user = \App\User::where('mobile', '=', $chemist->mobile)->first();
        $user->status = 'not_verify';
        $user->save();
        session()->flash('success', 'Selected User is Deactivate successfully.');
        return redirect()->back();
    }

    public function create_App(Request $request)
    {

        $this->validate($request, [
            'Party_Name' => 'required',
            'Mobile_No' => 'required',
            'GSTIN' => 'required',
            'GSTIN' => 'required',
            'DL_No' => 'required',
            'PIN' => 'required',
            'DL_File' => 'required',
            'ShopPhoto' => 'required',
            'Geolocation' => 'required',
        ]);
        $chemist = \App\Chemist::create([
            'Party_Name' => $request->input('Party_Name'),
            'Mobile_No' => $request->input('Mobile_No'),
            'Contact_Person' => $request->input('Contact_Person'),
            'DL_No' => $request->input('DL_No'),
            'GSTIN' => $request->input('GSTIN'),
            'Email_ID' => $request->input('Email_ID'),
            'Address1' => $request->input('Address1'),
            'Address2' => $request->input('Address2'),
            'Address3' => $request->input('Address3'),
            'City_Code' => $request->input('City_Code'),
            'State_Code' => $request->input('State_Code'),
            'Territory_Code' => $request->input('Territory_Code'),
            'Area_Code' => $request->input('Area_Code'),
            'PIN' => $request->input('PIN'),
            'Geolocation' => $request->input('Geolocation'),
            'Status' => "Activate",
            'ApprovalSatus_Code' => 1,
        ]);
        if ($request->file('DL_File')) {
            $image = $request->file('DL_File');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $chemist->DL_File = 'upload/' . $fullname;
        }
        if ($request->file('ShopPhoto')) {
            $image = $request->file('ShopPhoto');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $chemist->ShopPhoto = 'upload/' . $fullname;
        }

        return response()->json(['status' => true, 'message' => 'You Are Login Successfully', 'data' => $chemist], $this->successStatus);

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $chemist = \App\Chemist::find($id);

        $PartyDetails = ['Party_Code' => $chemist->Party_Code, 'PartyType_Code' => $chemist->PartyType_Code, 'Party_ID' => $chemist->Party_ID, 'GPS' => $chemist->Geolocation, 'Party_Name' => $chemist->Party_Name, 'Address1' => $chemist->Address1, 'Address2' => $chemist->Address2, 'Address3' => $chemist->Address3, 'City_Code' => $chemist->City_Code, 'City_Name' => $chemist->City_Code, 'State_Code' => $chemist->State_Code, 'State_Name' => $chemist->State_Code, 'PIN' => $chemist->PIN, 'Phone' => $chemist->Phone, 'DL_No' => $chemist->DL_No, 'PAN_No' => null, 'GSTIN' => $chemist->GSTIN, 'Contact_Person' => $chemist->Contact_Person, 'Mobile_No' => $chemist->Mobile_No, 'Email' => $chemist->Email_ID, 'Transporter_Code' => 0, 'Transporter_Name' => null, 'Territory_Code' => 0, 'Territory_Name' => null, 'TPArea_Code' => 0, 'Area_Code' => 0, 'Area_Name' => null, 'DistanceFromCity' => 0, 'Photos' => null, 'LastVisit_Date' => null, 'LastInvoice_Date' => null, 'LastGoodsReceipt_Date' => null, 'LastInvoice_Value' => 0, 'OutStanding_Value' => null, 'ApprovalStatus_Code' => 0, 'Upload_Status' => 0, 'CreatedBy' => 0, 'Created_Date' => null];
        $data = [];
        $data['PartyDetails'] = json_encode($PartyDetails);
        $data['API_KEY'] = 'fdAu52PaUI1';
        $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);
        $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/PartyAdd";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $server_output = curl_exec($ch);
        curl_close($ch);

        if ($chemist) {
            return view('backend.chemists.edit', compact('chemist'));
        }
        return redirect()->route('backend.chemists.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'code' => 'required',
            'drug_license_no' => 'required',
            'user_id' => 'required',
            'geolocation' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);

        $chemist = $this->chemist->find($id);
        $chemist->name = $request->input('name');
        $chemist->mobile = $request->input('mobile');
        $chemist->code = $request->input('code');
        $chemist->drug_license_no = $request->input('drug_license_no');
        $chemist->user_id = $request->input('user_id');
        $chemist->geolocation = $request->input('geolocation');
        $chemist->address = $request->input('address');
        $chemist->state = $request->input('state');
        $chemist->city = $request->input('city');
        $chemist->pincode = $request->input('pincode');
        $chemist->save();
        return redirect()->route('backend.chemists.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $chemist = $this->chemist->find($id);
        if ($chemist->count()) {
            $chemist->delete();
            session()->flash('success', 'Selected Chemist deleted successfully.');
            return redirect()->route('backend.chemists.index');
        }
        session()->flash('error', 'Selected Chemist dose not found in database please try after some time.');
        return redirect()->route('backend.chemists.index');
    }

    public function dl_file_delete_in_bulk(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        if ($date_from && $date_to) {
            // $chemists = \App\Chemist::whereBetween('created_at', [$date_from . ' 00:00:00', $date_to . ' 23:59:59'])->count();
            // foreach ($chemists as $chemist) {
            //     if ($chemist->count()) {
            //         \File::delete($chemist->DL_File);
            //         $chemist->delete();
            //     }
            // }
            return redirect()->back();
        } else {
            session()->flash('error', 'Selected Chemist Image Detele dose not found in database please try after some time.');
            return redirect()->back();
        }

    }

    public function export()
    {
        return Excel::download(new ChemistsExport, 'InvoiceSummeryExport.xlsx');
        return redirect()->back();
    }

}