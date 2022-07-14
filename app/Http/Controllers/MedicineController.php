<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Medicine;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    protected $medicine;

    public function __construct(Medicine $medicine) {
        $this->medicine = $medicine;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $medicines = \App\Medicine::all();
        return view('backend.medicines.index', compact('medicines'));
    }
    
    
        public function indexApp() {
        $medicines = \App\Medicine::all();
         if($medicines){
               echo json_encode($medicines);  
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
         $subcategories = \App\Subcategory::all();
          $packages = \App\Package::all();
        return view('backend.medicines.create', compact('categories','subcategories','groups','packages'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [            
            'generic_name' => 'required',            
            'brand_name' => 'required',
            'group_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'manufacture' => 'required',
            'composition' => 'required',
            'storage' => 'required',
            'product_code' => 'required',
            'OrderQtyMultipleOf' => 'required',
            'package_id' => 'required',
            'mrp_amount' => 'required',
            'offer' => 'required',
            'actual_amount' => 'required',          
        ]);
        $medicine = \App\Medicine::create([
            'generic_name' => $request->input('generic_name'), 
            'brand_name' => $request->input('brand_name'), 
            'group_id' => $request->input('group_id'),
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'composition' => $request->input('composition'), 
            'storage' => $request->input('storage'), 
            'manufacture' => $request->input('manufacture'), 
            'product_code' => $request->input('product_code'), 
            'OrderQtyMultipleOf' => $request->input('OrderQtyMultipleOf'), 
            'package_id' => $request->input('package_id'), 
            'mrp_amount' => $request->input('mrp_amount'), 
            'offer' => $request->input('offer'), 
            'actual_amount' => $request->input('actual_amount'),          
        ]);
            if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $medicine->image = 'upload/' . $fullname;
        }
        $medicine->save();
        session()->flash('success', 'New Medicine is create Successfully');
        return redirect()->route('backend.medicines.index');
    }
    
    
        public function storeApp(Request $request) {
        $this->validate($request, [            
            'generic_name' => 'required',            
            'brand_name' => 'required',
            'group_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'manufacture' => 'required',
            'composition' => 'required',
            'storage' => 'required',
            'product_code' => 'required',
            'OrderQtyMultipleOf' => 'required',
            'package_id' => 'required',
            'mrp_amount' => 'required',
            'offer' => 'required',
            'actual_amount' => 'required',          
        ]);
        $medicine = \App\Medicine::create([
            'generic_name' => $request->input('name'), 
            'brand_name' => $request->input('manufacture'), 
            'group_id' => $request->input('group_id'),
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'composition' => $request->input('composition'), 
            'storage' => $request->input('storage'), 
            'manufacture' => $request->input('manufacture'), 
            'product_code' => $request->input('product_code'), 
            'OrderQtyMultipleOf' => $request->input('OrderQtyMultipleOf'), 
            'package_id' => $request->input('package_id'), 
            'mrp_amount' => $request->input('package_id'), 
            'offer' => $request->input('offer'), 
            'actual_amount' => $request->input('actual_amount'),          
        ]);
            if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $medicine->image = 'upload/' . $fullname;
        }
        $medicine->save();       
        if($medicine){
        echo json_encode($medicine);  
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
        $medicine = \App\Medicine::find($id);       
        if ($medicine) {
            return view('backend.medicines.show', compact('category'));
        }
        return redirect()->route('backend.medicines.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
         $categories = \App\Category::all();
         $groups = \App\Group::all();
         $subcategories = \App\Subcategory::all();
        $medicine = \App\Medicine::find($id);
        if ($medicine) {
            return view('backend.medicines.edit', compact('categories','subcategories','groups','medicine'));
        }
        return redirect()->route('backend.medicines.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
          $this->validate($request, [            
            'generic_name' => 'required',            
            'brand_name' => 'required',
            'group_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'manufacture' => 'required',
            'composition' => 'required',
            'storage' => 'required',
            'product_code' => 'required',
            'OrderQtyMultipleOf' => 'required',
            'package_id' => 'required',
            'mrp_amount' => 'required',
            'offer' => 'required',
            'actual_amount' => 'required',          
        ]);
        $medicine = $this->medicine->find($id);
        $medicine->generic_name = $request->input('generic_name'); 
         $medicine->brand_name = $request->input('brand_name');
        $medicine->group_id = $request->input('group_id'); 
        $medicine->category_id = $request->input('category_id'); 
        $medicine->subcategory_id = $request->input('subcategory_id'); 
        $medicine->manufacture = $request->input('manufacture');  
        $medicine->composition = $request->input('composition');  
        $medicine->storage = $request->input('storagestorage');  
        $medicine->product_code = $request->input('product_code');  
        $medicine->OrderQtyMultipleOf = $request->input('OrderQtyMultipleOf');  
        $medicine->package_id = $request->input('package_id'); 
        $medicine->mrp_price = $request->input('mrp_price');  
        $medicine->offer = $request->input('offer');  
        $medicine->actual_price = $request->input('actual_price');  
        if($request->file('image')){
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $medicine->image = 'upload/' . $fullname;
        }
        $medicine->save();
        return redirect()->route('backend.medicines.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $medicine = $this->medicine->find($id);
        if ($medicine->count()) {
            $medicine->delete();
            session()->flash('success', 'Selected Medicine deleted successfully.');
            return redirect()->route('backend.medicines.index');
        }
        session()->flash('error', 'Selected Medicine dose not found in database please try after some time.');
      return redirect()->route('backend.medicines.index');
    }

}

