<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Package;
use Mail;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PackagesImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected $package;

    public function __construct(Package $package) {
        $this->package = $package;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
        public function getImport() {
        return view('backend.packages.getImport');
    }

    public function postImport(Request $request) {
        Excel::import(new PackagesImport, $request->file('file')->store('temp'));
        return back();
    }
    public function index() {
        $packages = \App\Package::all();
        return view('backend.packages.index', compact('packages'));
    }
    
    public function indexApp() {
        $packages = \App\Package::all();
        if($packages){
               echo json_encode($packages);  
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
        return view('backend.packages.create');
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
        $package = \App\Package::create([
             'name' => $request->input('name'),           
        ]);
        session()->flash('success', 'New Package is create Successfully');
        return redirect()->route('backend.packages.index');
    }
    
        public function storeApp(Request $request) {
        $this->validate($request, [            
            'name' => 'required',
        ]);
        $package = \App\Package::create([
             'name' => $request->input('name'),           
        ]);
        if($package){
               echo json_encode($package);  
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
        $package = \App\Package::find($id);
        
        if ($package) {
            return view('backend.packages.show', compact('category'));
        }
        return redirect()->route('backend.packages.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
        $package = \App\Package::find($id);
        
        if ($package) {
            return view('backend.packages.edit', compact('package'));
        }
        return redirect()->route('backend.packages.index');
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
        
        $package = $this->package->find($id);
        $package->name = $request->input('name');       
        $package->save();
        return redirect()->route('backend.packages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $package = $this->package->find($id);
        if ($package->count()) {
            $package->delete();
            session()->flash('success', 'Selected Package deleted successfully.');
            return redirect()->route('backend.packages.index');
        }
        session()->flash('error', 'Selected Package dose not found in database please try after some time.');
      return redirect()->route('backend.packages.index');
    }

}
