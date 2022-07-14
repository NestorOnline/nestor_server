<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Productprice;
use Mail;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductpricesImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductpriceController extends Controller
{
   protected $productprice;

    public function __construct(Productprice $productprice) {
        $this->productprice = $productprice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function getImport() {
        return view('backend.productprices.getImport');
    }

    public function postImport(Request $request) {
        Excel::import(new ProductpricesImport, $request->file('file')->store('temp'));
        return back();
    }
    
    public function index() {
        $productprices = \App\Productprice::all();
        foreach($productprices as $productprice){
            $product = \App\Product::where('product_code','=',$productprice->Product_Code)->first();
            if($product){
              $productprice->product_id = $product->id;
              $productprice->save();
            }
            
        }
        return view('backend.productprices.index', compact('productprices'));
    }
    
        public function indexApp() {
        $productprices = \App\Productprice::all();
        if($productprices){
               echo json_encode($productprices);  
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
        return view('backend.productprices.create', compact('groups'));
    }
    
    
        public function store(Request $request) {
        $this->validate($request, [            
            'productprice' => 'required',
            'dipot_id' => 'required',
            'location' => 'required',
        ]);
        $productprice = \App\Productprice::create([
            'productprice' => $request->input('productprice'),  
            'dipot_id' => $request->input('dipot_id'),  
            'location' => $request->input('location'),  
        ]);

        session()->flash('success', 'New Productprice is create Successfully');
        return redirect()->route('backend.productprices.index');
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
        $productprice = \App\Productprice::find($id);       
        if ($productprice) {
            return view('backend.productprices.show', compact('productprice'));
        }
        return redirect()->route('backend.productprices.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
      
        $groups = \App\Group::all();
        $productprice = \App\Productprice::find($id);

        if ($productprice) {
            return view('backend.productprices.edit', compact('productprice','groups'));
        }
        return redirect()->route('backend.productprices.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [            
            'productprice' => 'required',
            'dipot_id' => 'required',
            'location' => 'required',
        ]);       
        $productprice = $this->productprice->find($id);
        $productprice->productprice = $request->input('productprice'); 
        $productprice->dipot_id = $request->input('dipot_id');
        $productprice->location = $request->input('location');
        $productprice->save();
        return redirect()->route('backend.productprices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $productprice = $this->productprice->find($id);
        if ($productprice->count()) {
            $productprice->delete();
            session()->flash('success', 'Selected Productprice deleted successfully.');
            return redirect()->route('backend.productprices.index');
        }
        session()->flash('error', 'Selected Productprice dose not found in database please try after some time.');
      return redirect()->route('backend.productprices.index');
    }

}

