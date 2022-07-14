<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Productimage;
use Mail;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductimagesImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductimageController extends Controller
{
     protected $productimage;

    public function __construct(Productimage $productimage) {
        $this->productimage = $productimage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
        public function add_image($id) {
        $product = \App\Product::find($id);    
         $product_images = \App\Productimage::where('Product_Code','=',$product->product_code)->get();   
         
        return view('backend.product_images.add_image', compact('product_images','product'));
    }

     public function store(Request $request) {

        $this->validate($request, [            
            'Product_Code' => 'required',            
            'provided_by' => 'required',
            'Display_Sequence' => 'required', 
            'PhotoFile_Name' => 'required',     
        ]);
        $product_image = \App\Productimage::create([
            'Product_Code' => $request->input('Product_Code'), 
            'provided_by' => $request->input('provided_by'), 
            'Display_Sequence' => $request->input('Display_Sequence'),       
        ]);
            if($request->file('PhotoFile_Name')) {
            $image = $request->file('PhotoFile_Name');
            $filename = $image->getClientOriginalName();
            $fullname = $filename;
            // $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("product_image/images/CHANGE", $fullname);   
            $product_image->PhotoFile_Name = $fullname;
        }
        $product_image->save();
        session()->flash('success', 'New Product is create Successfully');
        return redirect()->back();
    }


    public function add_image_mobile(Request $request) {

        $this->validate($request, [            
            'Product_Code' => 'required',            
            'provided_by' => 'required',
            'Display_Sequence' => 'required', 
            'PhotoFile_Name' => 'required',     
        ]);
        $product_image = \App\Productimage::create([
            'Product_Code' => $request->input('Product_Code'), 
            'provided_by' => $request->input('provided_by'), 
            'Display_Sequence' => $request->input('Display_Sequence'),   
            'image_type' => 1,      
        ]);
            if($request->file('PhotoFile_Name')) {
            $image = $request->file('PhotoFile_Name');
            $filename = $image->getClientOriginalName();
            $fullname = $filename;
            // $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("product_image/images/MOBILE", $fullname);   
            $product_image->PhotoFile_Name = $fullname;
        }
        $product_image->save();
        session()->flash('success', 'New Product is create Successfully');
        return redirect()->back();
    }

      public function getImport() {
        return view('backend.product_images.getImport');
    }
    

    public function postImport(Request $request) {
        Excel::import(new ProductimagesImport, $request->file('file')->store('temp'));
        return back();
    }

         public function destroy($id) {
        $product_image = \App\Productimage::find($id);
        if ($product_image->count()) {
            \File::delete("product_image/images/CHANGE/".$product_image->PhotoFile_Name);
            $product_image->delete();
            session()->flash('success', 'Selected Product Image deleted successfully.');
            return redirect()->back();
        }
        session()->flash('error', 'Selected Product Image dose not found in database please try after some time.');
      return redirect()->back();
    }

}