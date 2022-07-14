<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pincode;
use Mail;
use DB;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PincodesImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    protected $pincode;

    public function __construct(Pincode $pincode) {
        $this->pincode = $pincode;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function getImport() {
        return view('backend.pincodes.getImport');
    }

    public function postImport(Request $request) {
        Excel::import(new PincodesImport, $request->file('file')->store('temp'));
        return back();
    }
    
    public function office($id) {
          $pincodes = DB::table('pincodes')
                ->join('office_states', function ($join) use($id) {
                    $join->on('pincodes.state_id', '=', 'office_states.State_Code')
                    ->where('office_states.Office_Code', '=', $id);
                })->get();
        return view('backend.pincodes.office', compact('pincodes'));
    }

        public function state($id) {
         $pincodes = \App\Pincode::where('state_id','=',$id)->get();
        return view('backend.pincodes.state', compact('pincodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() { 
        $groups = \App\Group::all();
        return view('backend.pincodes.create', compact('groups'));
    }
    
    
        public function store(Request $request) {
        $this->validate($request, [            
            'pincode' => 'required',
            'dipot_id' => 'required',
            'location' => 'required',
        ]);
        $pincode = \App\Pincode::create([
            'pincode' => $request->input('pincode'),  
            'dipot_id' => $request->input('dipot_id'),  
            'location' => $request->input('location'),  
        ]);

        session()->flash('success', 'New Pincode is create Successfully');
        return redirect()->route('backend.pincodes.index');
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
    public function show($id) {
        $pincode = \App\Pincode::find($id);       
        if ($pincode) {
            return view('backend.pincodes.show', compact('pincode'));
        }
        return redirect()->route('backend.pincodes.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
      
        $groups = \App\Group::all();
        $pincode = \App\Pincode::find($id);

        if ($pincode) {
            return view('backend.pincodes.edit', compact('pincode','groups'));
        }
        return redirect()->route('backend.pincodes.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [            
            'pincode' => 'required',
            'dipot_id' => 'required',
            'location' => 'required',
        ]);       
        $pincode = $this->pincode->find($id);
        $pincode->pincode = $request->input('pincode'); 
        $pincode->dipot_id = $request->input('dipot_id');
        $pincode->location = $request->input('location');
        $pincode->save();
        return redirect()->route('backend.pincodes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $pincode = $this->pincode->find($id);
        if ($pincode->count()) {
            $pincode->delete();
            session()->flash('success', 'Selected Pincode deleted successfully.');
            return redirect()->route('backend.pincodes.index');
        }
        session()->flash('error', 'Selected Pincode dose not found in database please try after some time.');
      return redirect()->route('backend.pincodes.index');
    }

}
