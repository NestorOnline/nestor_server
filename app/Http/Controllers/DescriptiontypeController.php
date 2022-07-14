<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Descriptiontype;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DescriptiontypeController extends Controller
{
      protected $description_type;

    public function __construct(Descriptiontype $description_type) {
        $this->description_type = $description_type;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $description_types = \App\Descriptiontype::all();
        return view('backend.description_types.index', compact('description_types'));
    }
    
    public function indexApp() {
        $description_types = \App\Descriptiontype::all();
        if($description_types){
               echo json_encode($description_types);  
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
        return view('backend.description_types.create');
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [            
            'name' => 'required',
        ]);
        $description_type = \App\Descriptiontype::create([
             'name' => $request->input('name'),           
        ]);
        session()->flash('success', 'New Descriptiontype is create Successfully');
        return redirect()->route('backend.description_types.index');
    }
    
        public function storeApp(Request $request) {
        $this->validate($request, [            
            'name' => 'required',
        ]);
        $description_type = \App\Descriptiontype::create([
             'name' => $request->input('name'),           
        ]);
        if($description_type){
               echo json_encode($description_type);  
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
        $description_type = \App\Descriptiontype::find($id);
        
        if ($description_type) {
            return view('backend.description_types.show', compact('category'));
        }
        return redirect()->route('backend.description_types.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
        $description_type = \App\Descriptiontype::find($id);
        
        if ($description_type) {
            return view('backend.description_types.edit', compact('description_type'));
        }
        return redirect()->route('backend.description_types.index');
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
        ]);
        
        $description_type = $this->description_type->find($id);
        $description_type->name = $request->input('name');       
        $description_type->save();
        return redirect()->route('backend.description_types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $description_type = $this->description_type->find($id);
        if ($description_type->count()) {
            $description_type->delete();
            session()->flash('success', 'Selected Descriptiontype deleted successfully.');
            return redirect()->route('backend.description_types.index');
        }
        session()->flash('error', 'Selected Descriptiontype dose not found in database please try after some time.');
      return redirect()->route('backend.description_types.index');
    }

}
