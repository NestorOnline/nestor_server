<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Depot;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DepotController extends Controller
{
   protected $depot;

    public function __construct(Depot $depot) {
        $this->depot = $depot;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $depots = \App\Depot::all();
        return view('backend.depots.index', compact('depots'));
    }
    
        public function indexApp() {
        $depots = \App\Depot::all();
        if($depots){
               echo json_encode($depots);  
        }else{
       echo json_encode('Data Does Not Match. Please Try Again'); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() { 
        $groups = \App\Group::all();
        return view('backend.depots.create', compact('groups'));
    }
    
    
        public function store(Request $request) {
        $this->validate($request, [            
            'location' => 'required',
            'office_code' => 'required',
            'office_name' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'gst' => 'required',
        ]);
        $depot = \App\Depot::create([
             'location' => $request->input('location'),  
            'office_code' => $request->input('office_code'),
            'office_name' => $request->input('office_name'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'pincode' => $request->input('pincode'),
            'gst' => $request->input('gst'),
        ]);

        session()->flash('success', 'New Depot is create Successfully');
        return redirect()->route('backend.depots.index');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function storeApp(Request $request) {
        $this->validate($request, [            
            'name' => 'required',
        ]);
        $depot = \App\Depot::create([
             'name' => $request->input('name'),      
        ]);
        
         if($depot){
               echo json_encode($depot);  
        }else{
       echo json_encode('Data Does Not Match. Please Try Again'); 
        }

    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $depot = \App\Depot::find($id);       
        if ($depot) {
            return view('backend.depots.show', compact('depot'));
        }
        return redirect()->route('backend.depots.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
      
        $groups = \App\Group::all();
        $depot = \App\Depot::find($id);

        if ($depot) {
            return view('backend.depots.edit', compact('depot','groups'));
        }
        return redirect()->route('backend.depots.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [            
            'name' => 'required',
            'group_id' => 'required',
        ]);        
        $depot = $this->depot->find($id);
        $depot->name = $request->input('name'); 
        $depot->save();
        return redirect()->route('backend.depots.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $depot = $this->depot->find($id);
        if ($depot->count()) {
            $depot->delete();
            session()->flash('success', 'Selected Depot deleted successfully.');
            return redirect()->route('backend.depots.index');
        }
        session()->flash('error', 'Selected Depot dose not found in database please try after some time.');
      return redirect()->route('backend.depots.index');
    }

}

