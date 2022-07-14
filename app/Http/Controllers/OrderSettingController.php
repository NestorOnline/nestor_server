<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OrderSetting;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrderSettingController extends Controller
{
    protected $order_setting;

    public function __construct(OrderSetting $order_setting) {
        $this->OrderSetting = $order_setting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $order_settings = \App\OrderSetting::all();
        return view('backend.order_settings.index', compact('order_settings'));
    }
    

    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() { 
        return view('backend.order_settings.create');
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [          
            'MinimumOrderValueForChemist' => 'required',
            'MinimumOrderValueForCustomer' => 'required',
        ]);
        $order_setting = \App\OrderSetting::create([
             'MinimumOrderValueForChemist' => $request->input('MinimumOrderValueForChemist'), 
             'MinimumOrderValueForCustomer' => $request->input('MinimumOrderValueForCustomer'), 
             'update_by'=>\Auth::user()->id       
        ]);
        $order_setting->save();
        session()->flash('success', 'New OrderSetting is create Successfully');
        return redirect()->route('backend.order_settings.index');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $order_setting = \App\OrderSetting::find($id);
        
        if ($order_setting) {
            return view('backend.order_settings.show', compact('category'));
        }
        return redirect()->route('backend.order_settings.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
        $order_setting = \App\OrderSetting::find($id);
        
        if ($order_setting) {
            return view('backend.order_settings.edit', compact('order_setting'));
        }
        return redirect()->route('backend.order_settings.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [          
            'MinimumOrderValueForChemist' => 'required',
            'MinimumOrderValueForCustomer' => 'required',
        ]);
        
        $order_setting = $this->OrderSetting->find($id);
        $order_setting->MinimumOrderValueForChemist = $request->input('MinimumOrderValueForChemist'); 
        $order_setting->MinimumOrderValueForCustomer = $request->input('MinimumOrderValueForCustomer');
        $order_setting->update_by=\Auth::user()->id;
        $order_setting->save();
        return redirect()->route('backend.order_settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $order_setting = $this->OrderSetting->find($id);
        if ($order_setting->count()) {
            $order_setting->delete();
            session()->flash('success', 'Selected OrderSetting deleted successfully.');
            return redirect()->route('backend.order_settings.index');
        }
        session()->flash('error', 'Selected OrderSetting dose not found in database please try after some time.');
      return redirect()->route('backend.order_settings.index');
    }

}
