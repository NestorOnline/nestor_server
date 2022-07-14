<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Package;
use Mail;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SalesSchemesImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SalesSchemeController extends Controller
{
           public function getImport() {
        return view('backend.sales_schemes.getImport');
    }

    public function postImport(Request $request) {
        Excel::import(new SalesSchemesImport, $request->file('file')->store('temp'));
        return back();
    }
    
    public function index() {  
        // $sales_scheme1 = \App\SalesScheme::find(29);
        // $products =\App\Product::all();
        // foreach($products as $product){
        //     $sales_scheme1 = \App\SalesScheme::create([
        //         'SalesScheme_Code' => $sales_scheme1->SalesScheme_Code, 
        //         'SalesScheme_Name' => $sales_scheme1->SalesScheme_Name,  
        //         'Category_Code' => $sales_scheme1->Category_Code, 
        //         'SchemeOn_Code' => $sales_scheme1->Category_Code, 
        //         'SchemeOn' => $sales_scheme1->SchemeOn, 
        //         'DiscountType_Code' => $sales_scheme1->DiscountType_Code,  
        //         'Discount' => $sales_scheme1->Discount,  
        //         'NextMinSaleQty_ForScheme' => $sales_scheme1->NextMinSaleQty_ForScheme,  
        //         'Free_Qty' => $sales_scheme1->Free_Qty, 
        //         'Effective_From' => $sales_scheme1->Effective_From,  
        //         'Effective_To' => $sales_scheme1->Effective_To,  
        //         'Office_Code' => $sales_scheme1->Office_Code,    
        //         'Product_Code' => $product->product_code,        
        //     ]);
        // }      
        $sales_schemes = \App\SalesScheme::all(); 
        return view('backend.sales_schemes.index',compact('sales_schemes'));
    }

    public function create() {         
        return view('backend.sales_schemes.create');
    }

    public function image_upload(Request $request,$id) {   
        $this->validate($request, [       
            'Image' => 'required',          
        ]);
        $sales_scheme = \App\SalesScheme::find($id);      
        if($request->file('Image')) {
            $image = $request->file('Image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $sales_scheme->Image = 'upload/' . $fullname;
        }
        $sales_scheme->save();
        return redirect()->back();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [            
            'SalesScheme_Code' => 'required',            
            'SalesScheme_Name' => 'required',
            'Category_Code' => 'required',
            'SchemeOn_Code' => 'required',
            'SchemeOn' => 'required',
            'DiscountType_Code' => 'required',
            'Discount' => 'required',
            'NextMinSaleQty_ForScheme' => 'required',
            'Free_Qty' => 'required',
            'Effective_From' => 'required',
            'Effective_To' => 'required',
            'Office_Code' => 'required',
            'Image' => 'required',          
        ]);
        $sales_scheme = \App\SalesScheme::create([
            'SalesScheme_Code' => $request->input('SalesScheme_Code'), 
            'SalesScheme_Name' => $request->input('SalesScheme_Name'), 
            'Category_Code' => $request->input('Category_Code'),
            'SchemeOn_Code' => $request->input('SchemeOn_Code'),
            'SchemeOn' => $request->input('SchemeOn'),
            'DiscountType_Code' => $request->input('DiscountType_Code'), 
            'Discount' => $request->input('Discount'), 
            'NextMinSaleQty_ForScheme' => $request->input('NextMinSaleQty_ForScheme'), 
            'Free_Qty' => $request->input('Free_Qty'), 
            'Effective_From' => $request->input('Effective_From'), 
            'Effective_To' => $request->input('Effective_To'), 
            'Office_Code' => $request->input('Office_Code'),         
        ]);
            if($request->file('Image')) {
            $image = $request->file('Image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $sales_scheme->Image = 'upload/' . $fullname;
        }
        $sales_scheme->save();
        session()->flash('success', 'New Product is create Successfully');
        return redirect()->route('backend.sales_schemes.index');
    }
}
