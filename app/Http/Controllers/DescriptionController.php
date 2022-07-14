<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Description;
use Mail;
use Illuminate\Support\Facades\Input;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\descriptionsImport;
use App\Exports\descriptionsExport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DescriptionController extends Controller
{
    protected $description;

    public function __construct(Description $description) {
        $this->description = $description;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    
    public function getImport() {
        return view('backend.descriptions.getImport');
    }

    public function postImport(Request $request) {
        Excel::import(new descriptionsImport, $request->file('file')->store('temp'));
        return back();
    }
    
    
    public function index() {
        $descriptions = \App\Description::all();
        return view('backend.descriptions.index', compact('descriptions'));
    }

        
    
    public function description_list($id) {
        $product =\App\Product::find($id);
        $descriptions = \App\Description::where('product_code',$product->product_code)->get();
        return view('backend.descriptions.description_list', compact('descriptions','product'));
    }
    
    public function indexApp() {
        $descriptions = \App\Description::all();
        if($descriptions){
               echo json_encode($descriptions);  
        }else{
       echo json_encode('Data Does Not Match. Please Try Again'); 
        }
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id) { 
           $medicines = \App\Medicine::all();
           $description_types  = \App\Descriptiontype::all();
        return view('backend.descriptions.create', compact('medicines','description_types'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request,$id) {

        $this->validate($request, [            
            'product_code' => 'required',
            'description_type_code' => 'required',
            'sr_no' => 'required',
            'heading' => 'required',
            'description' => 'required',
        ]);
        $description = \App\Description::create([
             'product_code' => $request->input('product_code'), 
             'description_type_code' => $request->input('description_type_code'), 
             'sr_no' => $request->input('sr_no'), 
             'heading' => $request->input('heading'), 
             'description' => $request->input('description'),
        ]);
        session()->flash('success', 'New Description is Add Successfully');
        return redirect()->back();
    }
    
        public function storeApp(Request $request) {
       $this->validate($request, [            
            'product_code' => 'required',
            'description_type_code' => 'required',
            'sr_no' => 'required',
            'heading' => 'required',
        ]);
        $description = \App\Description::create([
             'product_code' => $request->input('product_code'),           
            'description_type_code' => $request->input('description_type_code'),  
            'sr_no' => $request->input('sr_no'),  
            'heading' => $request->input('heading'),  
            'description' => $request->input('description'),
        ]);
        if($description){
               echo json_encode($description);  
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
        $description = \App\Description::find($id);      
        if ($description) {
            return view('backend.descriptions.show', compact('category'));
        }
        return redirect()->route('backend.descriptions.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
        $description = \App\Description::find($id);
        
        if ($description) {
            return view('backend.descriptions.edit', compact('group'));
        }
        return redirect()->route('backend.descriptions.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [            
            'product_code' => 'required',
            'description_type_code' => 'required',
            'sr_no' => 'required',
            'heading' => 'required',
        ]);
        
        $description = \App\Description::find($id);
        $description->product_code = $request->input('product_code');   
        $description->description_type_code = $request->input('description_type_code'); 
        $description->sr_no = $request->input('sr_no'); 
        $description->heading = $request->input('heading'); 
        $description->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $description = \App\Description::find($id);
        if ($description->count()) {
            $description->delete();
            session()->flash('success', 'Selected Description deleted successfully.');
            return redirect()->back();
        }
        session()->flash('error', 'Selected Description dose not found in database please try after some time.');
      return redirect()->back();
    }

}
