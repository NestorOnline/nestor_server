<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Group;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GroupController extends Controller
{
   protected $group;

    public function __construct(Group $group) {
        $this->group = $group;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $groups = \App\Group::all();
        return view('backend.groups.index', compact('groups'));
    }
    
    public function indexApp() {
        $groups = \App\Group::all();
        if($groups){
               echo json_encode($groups);  
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
        return view('backend.groups.create');
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
        $group = \App\Group::create([
             'name' => $request->input('name'),           
        ]);
        if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $group->image = 'upload/' . $fullname;
        }
        $group->save();
        session()->flash('success', 'New Group is create Successfully');
        return redirect()->route('backend.groups.index');
    }
    
        public function storeApp(Request $request) {
        $this->validate($request, [            
            'name' => 'required',
        ]);
        $group = \App\Group::create([
             'name' => $request->input('name'),           
        ]);
        if($group){
               echo json_encode($group);  
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
        $group = \App\Group::find($id);
        
        if ($group) {
            return view('backend.groups.show', compact('category'));
        }
        return redirect()->route('backend.groups.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
        $group = \App\Group::find($id);
        
        if ($group) {
            return view('backend.groups.edit', compact('group'));
        }
        return redirect()->route('backend.groups.index');
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
        
        $group = $this->group->find($id);
        $group->name = $request->input('name');       
        if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $group->image = 'upload/' . $fullname;
        }
        $group->save();
        return redirect()->route('backend.groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $group = $this->group->find($id);
        if ($group->count()) {
            $group->delete();
            session()->flash('success', 'Selected Group deleted successfully.');
            return redirect()->route('backend.groups.index');
        }
        session()->flash('error', 'Selected Group dose not found in database please try after some time.');
      return redirect()->route('backend.groups.index');
    }

}
