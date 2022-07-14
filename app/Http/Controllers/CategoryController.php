<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category) {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $categories = \App\Category::all();
        return view('backend.categories.index', compact('categories'));
    }
    
    public function indexApp() {
        $categories = \App\Category::all();
        if($categories){
               echo json_encode($categories);  
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
        return view('backend.categories.create', compact('groups'));
    }
    
    
    public function store(Request $request) {
        $this->validate($request, [            
            'name' => 'required',
        ]);
        $category = \App\Category::create([
             'name' => $request->input('name'),  
        ]);
        session()->flash('success', 'New Category is create Successfully');
        return redirect()->route('backend.categories.index');
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
        $category = \App\Category::create([
             'name' => $request->input('name'),      
        ]);
        
         if($category){
               echo json_encode($category);  
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
        $category = \App\Category::find($id);       
        if ($category) {
            return view('backend.categories.show', compact('category'));
        }
        return redirect()->route('backend.categories.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
      
        $groups = \App\Group::all();
        $category = \App\Category::find($id);

        if ($category) {
            return view('backend.categories.edit', compact('category','groups'));
        }
        return redirect()->route('backend.categories.index');
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
        $category = $this->category->find($id);
        $category->name = $request->input('name'); 
        $category->save();
        return redirect()->route('backend.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $category = $this->category->find($id);
        if ($category->count()) {
            $category->delete();
            session()->flash('success', 'Selected Category deleted successfully.');
            return redirect()->route('backend.categories.index');
        }
        session()->flash('error', 'Selected Category dose not found in database please try after some time.');
      return redirect()->route('backend.categories.index');
    }

}