<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subcategory;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    protected $subcategory;

    public function __construct(Subcategory $subcategory) {
        $this->subcategory = $subcategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $subcategories = \App\Subcategory::all();
        return view('backend.subcategories.index', compact('subcategories'));
    }
    
    
        public function indexApp() {
        $subcategories = \App\Subcategory::all();
      if($subcategories){
        echo json_encode($subcategories);  
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
         $categories = \App\Category::all();
         $groups = \App\Group::all();
        return view('backend.subcategories.create', compact('categories','groups'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [            
             'name' => 'required',
             'category_id' => 'required',
             'group_id' => 'required',
            
            
        ]);
        $subcategory = \App\Subcategory::create([
             'name' => $request->input('name'), 
             'category_id' => $request->input('category_id'),  
             'group_id' => $request->input('group_id'),
        ]);
        session()->flash('success', 'New Subcategory is create Successfully');
        return redirect()->route('backend.subcategories.index');
    }
    
    
        public function storeApp(Request $request) {
       $this->validate($request, [            
             'name' => 'required',
             'category_id' => 'required',
             'group_id' => 'required',
        ]);
        $subcategory = \App\Subcategory::create([
             'name' => $request->input('name'), 
             'category_id' => $request->input('category_id'),  
             'group_id' => $request->input('group_id'),  
        ]);
        if($subcategory){
        echo json_encode($subcategory);  
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
    public function view_fulldetail($id) {
        $subcategory = \App\Subcategory::find($id);
        
        if ($subcategory) {
            return view('backend.subcategories.view_fulldetail', compact('category'));
        }
        return redirect()->route('backend.subcategories.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
        $subcategory = \App\Subcategory::find($id);
        
        if ($subcategory) {
            return view('backend.subcategories.edit', compact('category'));
        }
        return redirect()->route('backend.subcategories.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
         $subcategory = \App\Subcategory::create([
             'name' => $request->input('name'), 
             'category_id' => $request->input('category_id'),  
             'group_id' => $request->input('group_id'),
        ]);
        
        $subcategory = $this->subcategory->find($id);
        $subcategory->name = $request->input('name');  
         $subcategory->category_id = $request->input('category_id'); 
          $subcategory->group_id = $request->input('group_id');
        $subcategory->save();
        return redirect()->route('backend.subcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $subcategory = $this->subcategory->find($id);
        if ($subcategory->count()) {
            $subcategory->delete();
            session()->flash('success', 'Selected Subcategory deleted successfully.');
            return redirect()->route('backend.subcategories.index');
        }
        session()->flash('error', 'Selected Subcategory dose not found in database please try after some time.');
      return redirect()->route('backend.subcategories.index');
    }

}
