<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\StockNotification;
use Illuminate\Http\Request;

class StockNotificationController extends Controller
{
    protected $stock_notification;

    public function __construct(StockNotification $stock_notification)
    {
        $this->stock_notification = $stock_notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $stock_notifications = \App\StockNotification::all();
        return view('backend.stock_notifications.index', compact('stock_notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.stock_notifications.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'Product_Code' => 'required',
            'email' => 'required',
        ]);
        $stock_notification = \App\StockNotification::create([
            'Product_Code' => $request->input('Product_Code'),
            'email' => $request->input('email'),
        ]);
        session()->flash('success', 'You Will Get a Nification When Product Are Available in Stock.');
        return redirect()->back();
    }

    public function stock_notification_App(Request $request)
    {
        if ($request->Product_Code && $request->email) {
            $stock_notification = \App\StockNotification::create([
                'Product_Code' => $request->input('Product_Code'),
                'email' => $request->input('email'),
            ]);
            return response()->json(['status' => true, 'message' => 'Notification alert has been activated.', 'data' => $stock_notification], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Please Enter Valid data'], 401);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $stock_notification = \App\StockNotification::find($id);
        if ($stock_notification) {
            return view('backend.stock_notifications.show', compact('category'));
        }
        return redirect()->route('backend.stock_notifications.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $groups = \App\Group::all();
        $stock_notification = \App\StockNotification::find($id);

        if ($stock_notification) {
            return view('backend.stock_notifications.edit', compact('category', 'groups'));
        }
        return redirect()->route('backend.stock_notifications.index');
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
            'group_id' => 'required',
        ]);
        $stock_notification = $this->category->find($id);
        $stock_notification->name = $request->input('name');
        $stock_notification->save();
        return redirect()->route('backend.stock_notifications.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $stock_notification = $this->category->find($id);
        if ($stock_notification->count()) {
            $stock_notification->delete();
            session()->flash('success', 'Selected Category deleted successfully.');
            return redirect()->route('backend.stock_notifications.index');
        }
        session()->flash('error', 'Selected Category dose not found in database please try after some time.');
        return redirect()->route('backend.stock_notifications.index');
    }

}