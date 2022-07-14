<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Groupcategory;
use Mail;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GroupcategorysImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GroupcategoryController extends Controller
{
    protected $groupcategory;

    public function __construct(Groupcategory $groupcategory) {
        $this->groupcategory = $groupcategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
           public function getImport() {
            $groupcategories = \App\Groupcategory::all();

        return view('backend.groupcategories.getImport');
    }

    public function postImport(Request $request) {
        Excel::import(new GroupcategorysImport, $request->file('file')->store('temp'));
        return back();
    }
    
    
    public function index() {       
        $groupcategories = \App\Groupcategory::orderBy('name','ASC')->get();
        return view('backend.groupcategories.index', compact('groupcategories'));
    }
    
        public function indexApp() {
        $groupcategories = \App\Groupcategory::all();
        if($groupcategories){
               echo json_encode($groupcategories);  
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
        return view('backend.groupcategories.create', compact('groups'));
    }
    
    
        public function store(Request $request) {
        $this->validate($request, [            
            'name' => 'required',
            'group_id' => 'required',
            'url_name' => 'required',
        ]);
        $groupcategory = \App\Groupcategory::create([
             'name' => $request->input('name'),    
            'group_id' => $request->input('group_id'),   
            'url_name' => $request->input('url_name'), 
        ]);
        if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $groupcategory->image = 'upload/' . $fullname;
        }
        $groupcategory->save();

        session()->flash('success', 'New Groupcategory is create Successfully');
        return redirect()->route('backend.groupcategories.index');
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
        $groupcategory = \App\Groupcategory::find($id);       
        if ($groupcategory) {
            return view('backend.groupcategories.show', compact('groupcategory'));
        }
        return redirect()->route('backend.groupcategories.index');
    } 

    public function is_home($id) {
        $groupcategory = \App\Groupcategory::find($id);       
        if ($groupcategory->image) {
            $groupcategory->is_home = 1;
            $groupcategory->save();
            session()->flash('success', 'Selected Groupcategory Set At Home Successfully.');
            return redirect()->back();
        }else{
            session()->flash('error', 'Image Not Availabe For Home Page');
            return redirect()->back();
        }
        return redirect()->back();
    } 

    public function unset_from_home($id) {
        $groupcategory = \App\Groupcategory::find($id);       
        if ($groupcategory) {
            $groupcategory->is_home = NULL;
            $groupcategory->save();
            session()->flash('success', 'Selected Groupcategory Unset From Home Successfully.');
            return redirect()->back();
        }
        return redirect()->back();
    } 

    
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
      
        $groups = \App\Group::all();
        $groupcategory = \App\Groupcategory::find($id);

        if ($groupcategory) {
            return view('backend.groupcategories.edit', compact('groupcategory','groups'));
        }
        return redirect()->route('backend.groupcategories.index');
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
            'url_name' => 'required',
        ]);        
        $groupcategory = $this->groupcategory->find($id);
        $groupcategory->name = $request->input('name'); 
        $groupcategory->group_id = $request->input('group_id');
        $groupcategory->url_name = $request->input('url_name');
        if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $groupcategory->image = 'upload/' . $fullname;
        }
        $groupcategory->save();
        return redirect()->route('backend.groupcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $groupcategory = $this->groupcategory->find($id);
        if ($groupcategory->count()) {
            $groupcategory->delete();
            session()->flash('success', 'Selected Groupcategory deleted successfully.');
            return redirect()->route('backend.groupcategories.index');
        }
        session()->flash('error', 'Selected Groupcategory dose not found in database please try after some time.');
      return redirect()->route('backend.groupcategories.index');
    }

}
