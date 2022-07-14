<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    protected $payment_gateway;

    public function __construct(PaymentGateway $payment_gateway)
    {
        $this->payment_gateway = $payment_gateway;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $payment_gateways = \App\PaymentGateway::all();
        return view('backend.payment_gateways.index', compact('payment_gateways'));
    }

    public function indexApp()
    {
        $payment_gateways = \App\PaymentGateway::all();
        if ($payment_gateways) {
            echo json_encode($payment_gateways);
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
        return view('backend.payment_gateways.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'PaymentGateway_Code' => 'required',
            'PaymentGateway_Name' => 'required',
            'PaymentGateway_MKey' => 'required',
            'PaymentGateway_MId' => 'required',
            'PaymentGateway_MWebsite' => 'required',
            'PaymentGateway_Channel' => 'required',
            'PaymentGateway_IndustryType' => 'required',
            'PaymentGateway_Callback_Url' => 'required',
            'PaymentGateway_Mode' => 'required',
        ]);
        $payment_gateway = \App\PaymentGateway::create([
            'PaymentGateway_Code' => $request->input('PaymentGateway_Code'),
            'PaymentGateway_Name' => $request->input('PaymentGateway_Name'),
            'PaymentGateway_MKey' => $request->input('PaymentGateway_MKey'),
            'PaymentGateway_MId' => $request->input('PaymentGateway_MId'),
            'PaymentGateway_MWebsite' => $request->input('PaymentGateway_MWebsite'),
            'PaymentGateway_Channel' => $request->input('PaymentGateway_Channel'),
            'PaymentGateway_IndustryType' => $request->input('PaymentGateway_IndustryType'),
            'PaymentGateway_Callback_Url' => $request->input('PaymentGateway_Callback_Url'),
            'PaymentGateway_Mode' => $request->input('PaymentGateway_Mode'),
            'is_active' => 0,
        ]);
        session()->flash('success', 'New Group is create Successfully');
        return redirect()->route('backend.payment_gateways.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */

    public function get_payment_gateway_App()
    {
        $data['payment_gateway'] = \App\PaymentGateway::where('is_active', 1)->first();
        if ($data['payment_gateway']) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $data], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 200);
        }
    }

    public function show($id)
    {
        $payment_gateway = \App\PaymentGateway::find($id);

        if ($payment_gateway) {
            return view('backend.payment_gateways.show', compact('category'));
        }
        return redirect()->route('backend.payment_gateways.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $payment_gateway = \App\PaymentGateway::find($id);

        if ($payment_gateway) {
            return view('backend.payment_gateways.edit', compact('payment_gateway'));
        }
        return redirect()->route('backend.payment_gateways.index');
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
            'PaymentGateway_Code' => 'required',
            'PaymentGateway_Name' => 'required',
            'PaymentGateway_MKey' => 'required',
            'PaymentGateway_MId' => 'required',
            'PaymentGateway_MWebsite' => 'required',
            'PaymentGateway_Channel' => 'required',
            'PaymentGateway_IndustryType' => 'required',
            'PaymentGateway_Callback_Url' => 'required',
            'PaymentGateway_Mode' => 'required',
        ]);
        $payment_gateway = $this->payment_gateway->find($id);
        $payment_gateway->PaymentGateway_Code = $request->input('PaymentGateway_Code');
        $payment_gateway->PaymentGateway_Name = $request->input('PaymentGateway_Name');
        $payment_gateway->PaymentGateway_MKey = $request->input('PaymentGateway_MKey');
        $payment_gateway->PaymentGateway_MId = $request->input('PaymentGateway_MId');
        $payment_gateway->PaymentGateway_MWebsite = $request->input('PaymentGateway_MWebsite');
        $payment_gateway->PaymentGateway_Channel = $request->input('PaymentGateway_Channel');
        $payment_gateway->PaymentGateway_IndustryType = $request->input('PaymentGateway_IndustryType');
        $payment_gateway->PaymentGateway_Callback_Url = $request->input('PaymentGateway_Callback_Url');
        $payment_gateway->PaymentGateway_Mode = $request->input('PaymentGateway_Mode');
        $payment_gateway->save();
        return redirect()->route('backend.payment_gateways.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $payment_gateway = $this->payment_gateway->find($id);
        if ($payment_gateway->count()) {
            $payment_gateway->delete();
            session()->flash('success', 'Selected Group deleted successfully.');
            return redirect()->route('backend.payment_gateways.index');
        }
        session()->flash('error', 'Selected Group dose not found in database please try after some time.');
        return redirect()->route('backend.payment_gateways.index');
    }

}