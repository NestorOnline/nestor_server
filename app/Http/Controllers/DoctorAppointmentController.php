<?php

namespace App\Http\Controllers;

use App\Doctorappointment;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorAppointmentController extends Controller
{
    protected $doctor_appointment;
    public function __construct(Doctorappointment $doctor_appointment)
    {
        $this->doctor_appointment = $doctor_appointment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $doctor_appointments = \App\Doctorappointment::orderBy('id','DESC')->get();
        return view('backend.doctor_appointments.index', compact('doctor_appointments'));
    }

    public function prescribed_order(Request $request)
    {
        $date = $request->date;
        $OrderFrom_Code = $request->OrderFrom_Code;
        if ($date && $OrderFrom_Code) {
            $orders = \App\Order::whereNotNull('DoctorConsult_id')->whereDate('created_at', $date)->where('OrderFrom_Code', $OrderFrom_Code)->orderBy('id', 'DESC')->get();
        } elseif ($date) {
            $orders = \App\Order::whereNotNull('DoctorConsult_id')->whereDate('created_at', $date)->orderBy('id', 'DESC')->get();
        } else {
            $date = date('Y-m-d');
            $orders = \App\Order::whereNotNull('DoctorConsult_id')->whereDate('created_at', $date)->orderBy('id', 'DESC')->get();
        }
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('backend.doctors.prescribed_order', compact('date', 'orders', 'groups', 'OrderFrom_Code'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    public function prescribed_order_detail($id)
    {
        $order = \App\Order::with('orderproducts')->find($id);
        $patients = \App\PatientDetail::where('user_id', $order->user_id)->get();
        return view('backend.doctors.prescribed_order_detail', compact('order', 'patients'));
    }

    public function prescribed_order_detail_store(Request $request, $id)
    {
        $this->validate($request, [
            'orderproduct_id' => 'required',
            'order_id' => 'required',
            'petient_id' => 'required',
        ]);
        $order = \App\Order::find($id);
        $order->petient_id = $request->input('petient_id');
        $order->save();
        $input = $request->all();
        for ($i = 0; $i < count($input['orderproduct_id']); $i++) {
            $order_product = \App\OrderProduct::find($input['orderproduct_id'][$i]);
            $order_product->DoctorConsult_id = \Auth::user()->id;
            $order_product->save();
        }
        return redirect()->route('backend.doctors.prescribed_order');
    }

    public function create()
    {
        return view('backend.doctor_appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'symptoms' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'file_attechment' => 'required',
            'doctor_type' => 'required',
        ]);

        $doctor_appointment = \App\Doctorappointment::create([
            'symptoms' => $request->input('symptoms'),
            'email' => $request->input('email'),
            'doctor_appointment_type' => $request->input('doctor_appointment_type'),
            'doctor_type' => $request->input('doctor_type'),
        ]);
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $doctor_appointment->image = 'upload/' . $fullname;
        }
        $doctor_appointment->save();
        session()->flash('success', 'New Doctorappointment is create Successfully');
        return redirect()->route('backend.doctor_appointments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function view_fulldetail($id)
    {
        $doctor_appointment = \App\Doctorappointment::find($id);
        if ($doctor_appointment) {
            return view('backend.doctor_appointments.view_fulldetail', compact('category'));
        }
        return redirect()->route('backend.doctor_appointments.index');
    }


    
    public function doctor_call_missed(Request $request, $id)
    {
        $doctor_appointment = \App\Doctorappointment::find($id);
        $mobile = $doctor_appointment->mobile;
        $key = "fdAu5P2aUI1";
        $sender = "NESTOR";
        $service = "TEMPLATE_BASED";
        $otp = rand(100000, 999999);
        $message = 'Doctor tried reaching you for your prescription. Will call again soon. Nestor Online "Life Comes First"';
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
        return redirect()->back()->with('success','message sent successfully');
    }
    
    public function accepted(Request $request, $id)
    {

        $doctor_appointment = \App\Doctorappointment::find($id);
        if ($doctor_appointment) {
            $doctor_appointment->doctor_id = \Auth::user()->id;
            $doctor_appointment->status = 1;
            $doctor_appointment->schedule_date = $request->schedule_date;
            $doctor_appointment->schedule_time = date("H:i A", strtotime($request->schedule_time));
            $doctor_appointment->save();
            $mobile = $doctor_appointment->mobile;
            $key = "fdAu5P2aUI1";
            $sender = "NESTOR";
            $service = "TEMPLATE_BASED";
            $message = "You have a Doctor's appointment on " . $doctor_appointment->schedule_date->format('d-M-Y') . ", at " . $doctor_appointment->schedule_time . ". Your assessment will be conducted on This Number. Please let us know in advance if you cannot make it or wish to reschedule. \r\nNestor Pharmaceuticals Limited\r\n 01244522400";
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

            return redirect()->route('backend.doctor_appointments.index')->with('success', 'You Succesfully Accepted This Appointment !');
        }
        return redirect()->route('backend.doctor_appointments.index')->with('error', 'Data Does Not Match !');
    }

    public function add_product_in_patient_cart($id)
    {
        $data['patient_detail'] = \App\PatientDetail::find($id);
        $data['doctor_prescription_products'] = \App\DoctorPrescriptionProduct::where('doctorappointment_id', $data['patient_detail']->doctorappointment_id)->where('patient_detail_id', $id)->get();
        if ($data['patient_detail']) {
            return view('backend.doctor_appointments.add_product_in_patient_cart', $data);
        }
    }

    public function doctor_prescribed_product_add_to_mycart_App(Request $request)
    {
        $user = \App\User::where('mobile', $request->mobile)->where('role', 'User')->where('status', 'verify')->first();
        if ($user) {
            $add_to_cards = \App\Addtocard::where('user_id', '=', $user->id)->get();
            foreach ($add_to_cards as $add_to_card) {
                $product = \App\Product::find($add_to_card->product_id);
                if ($product->Prescription_Required == 1) {
                    $add_to_card->delete();
                }
            }
            $data['doctor_appointment'] = \App\Doctorappointment::with('doctor_prescription_products')->where('user_id', $user->id)->where('id', $request->doctorappointment_id)->first();
            if (count($data['doctor_appointment']->doctor_prescription_products)) {
                foreach ($data['doctor_appointment']->doctor_prescription_products as $doctor_prescription_product) {
                    $addtocard_product = \App\Addtocard::where('user_id', '=', $user->id)->where('product_id', '=', $doctor_prescription_product->product_id)->first();
                    if ($doctor_prescription_product->product) {
                        $cuctomer_price = $doctor_prescription_product->product->customer_price->Price;
                        $gst = $doctor_prescription_product->product->customer_price->Price * $doctor_prescription_product->product->customer_price->GST / 100;
                        $product_ab = \App\Product::find($doctor_prescription_product->product_id);
                        $sales_scheme = \App\SalesScheme::where('Product_Code',$product_ab->product_code)->where('Category_Code',1)->first();
                        if($sales_scheme){
                            $total = $cuctomer_price + $gst ;
                            $total = $total - $total * $sales_scheme->Discount/100;
                            
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
                            'user_id' => $user->id,
                            'product_id' => $doctor_prescription_product->product->id,
                            'Qty' => $doctor_prescription_product->qty,
                            'amount' => $total,
                            'doctor_description_id' => $doctor_prescription_product->doctorappointment_id,
                        ]);
                    }
                }
            }
            return response()->json(['status' => true, 'message' => 'Product Add Successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Does Not Match. Please Try Again'], 401);
        }
    }

    public function add_product_in_patient_cart_store(Request $request, $id)
    {
        $patient_detail = \App\PatientDetail::find($id);
        $input = $request->all();
        if ($patient_detail) {
            for ($i = 0; $i < count($input['product_id']); $i++) {
                $product = \App\Product::find($input['product_id'][$i]);
                $doctor_prescription_abbreviation = \App\DoctorPrescriptionAbbreviations::find($request->input('doses_id'));
                $doctor_prescription_product = \App\DoctorPrescriptionProduct::create([
                    'doctorappointment_id' => $request->input('doctorappointment_id'),
                    'patient_detail_id' => $request->input('patient_detail_id'),
                    'order_id' => $request->input('order_id'),
                    'doctor_id' => \Auth::user()->id,
                    'chemist_user_id' => $request->input('chemist_user_id'),
                    'product_code' => $product->product_code,
                    'product_id' => $input['product_id'][$i],
                    'doses_id' => $request->input('doses_id'),
                    'taken_id' => $request->input('taken_id'),
                    'user_id' => $patient_detail->user_id,
                    'price_per_qty' => $request->input('price_per_qty'),
                    'no_of_day' => $request->input('no_of_day'),
                ]);
                if ($product->package) {
                    $doctor_prescription_product->qty = ceil($request->input('no_of_day') * $doctor_prescription_abbreviation->quantity_in_a_day / $product->package->PrimaryPack_Qty);
                }
                $doctor_prescription_product->save();
            }
        }
        return redirect()->back()->with('success', 'Product add in Prescription Successfully');
    }

    public function rejected($id)
    {
        $doctor_appointment = \App\Doctorappointment::find($id);
        if ($doctor_appointment) {
            $doctor_appointment->doctor_id = null;
            $doctor_appointment->save();
            return redirect()->route('backend.doctor_appointments.index')->with('success', 'You Succesfully Accepted This Appointment !');
        }
        return redirect()->route('backend.doctor_appointments.index')->with('error', 'Data Does Not Match !');
    }

    public function prescribed_now(Request $request, $id)
    {
        $data['doctor_appointment'] = \App\Doctorappointment::find($id);
        $data['doctor_appointment']->patient_detail_id = $request->petient_id;
        $data['doctor_appointment']->save();
        $data['patients'] = \App\PatientDetail::where('user_id', $data['doctor_appointment']->user_id)->get();
        if ($data['doctor_appointment'] && $request->petient_id) {
            $data['patient_detail'] = \App\PatientDetail::find($request->petient_id);
            $data['patient_detail']->doctorappointment_id = $data['doctor_appointment']->id;
            $data['patient_detail']->save();
            return redirect()->route('backend.doctor_appointments.add_product_in_patient_cart', $data['patient_detail']->id);
        } else {
            $data['patient_detail'] = null;
            return view('backend.doctor_appointments.prescribed_now', $data);
        }
        return redirect()->route('backend.doctor_appointments.index');
    }

    public function prescription_submit_now($id)
    {
        $data['doctor_appointment'] = \App\Doctorappointment::find($id);
        $data['doctor_appointment']->status = 6;
        $data['doctor_appointment']->save();
        return redirect()->route('backend.doctor_appointments.index');
    }

    public function customer_get_doctor_appointment_list_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->first();
        if ($user) {
            $data['doctor_appointments'] = \App\Doctorappointment::where('user_id', $user->id)->where('status', 6)->get();
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 401);
        }
    }
    
    public function customer_doctor_appointment_detail_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->first();
        if ($user) {
            $data['doctor_appointment'] = \App\Doctorappointment::with('doctor_prescription_products')->where('user_id', $user->id)->where('id', $request->doctor_appointment_id)->first();
            foreach ($data['doctor_appointment']->doctor_prescription_products as $doctor_prescription_product) {
                $doctor_prescription_product->product;
                $doctor_prescription_product->doctor_prescription_abbreviation_doses;
                $doctor_prescription_product->doctor_prescription_abbreviation_takes;
            }
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 401);
        }
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
            'title' => 'required',
            'url_link' => 'required',
            'doctor_appointment_type' => 'required',
            'image' => 'required',
        ]);
        $doctor_appointment = $this->doctor_appointment->find($id);
        $doctor_appointment->title = $request->input('title');
        $doctor_appointment->url_link = $request->input('url_link');
        $doctor_appointment->doctor_appointment_type = $request->input('doctor_appointment_type');
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $doctor_appointment->image = 'upload/' . $fullname;
        }
        $doctor_appointment->save();
        return redirect()->route('backend.doctor_appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $doctor_appointment = $this->doctor_appointment->find($id);
        if ($doctor_appointment->count()) {
            \File::delete($product->image);
            $doctor_appointment->delete();
            session()->flash('success', 'Selected Doctorappointment deleted successfully.');
            return redirect()->route('backend.doctor_appointments.index');
        }
        session()->flash('error', 'Selected Doctorappointment dose not found in database please try after some time.');
        return redirect()->route('backend.doctor_appointments.index');
    }

}