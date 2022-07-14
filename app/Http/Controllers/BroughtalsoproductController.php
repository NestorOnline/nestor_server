<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BroughtalsoproductController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $brought_also_group_links = \App\Broughtalsoproduct::select('link_group')
        ->distinct()
        ->get();
        return view('backend.brought_also_products.index', compact('brought_also_group_links'));
    }
    
    public function indexApp() {
        $brought_also_products = \App\Broughtalsoproduct::all();
        if($brought_also_products){
               echo json_encode($brought_also_products);  
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
        return view('backend.brought_also_products.create');
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        
        $this->validate($request, [   
            'link_group' => 'required', 
            'Link_Prodoct_Code' => 'required',
        ]);
        $input = $request->all();
        for ($i = 0; $i < count($input['Link_Prodoct_Code']); $i++) {
            $brought_also_product = \App\Broughtalsoproduct::create([
                'link_group'=>$input['link_group'],
                'Prodoct_Code' => $input['Link_Prodoct_Code'][$i],
                'Link_Prodoct_Code' => $input['Link_Prodoct_Code'][$i]       
           ]);
        }
        session()->flash('success', 'Selected Product Link Successfully');
        return redirect()->back();
    }
    
        public function storeApp(Request $request) {
        $this->validate($request, [            
            'name' => 'required',
        ]);
        $brought_also_product = \App\Broughtalsoproduct::create([
             'name' => $request->input('name'),           
        ]);
        if($brought_also_product){
               echo json_encode($brought_also_product);  
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
        $brought_also_product = \App\Broughtalsoproduct::find($id);
        
        if ($brought_also_product) {
            return view('backend.brought_also_products.show', compact('category'));
        }
        return redirect()->route('backend.brought_also_products.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
        $brought_also_product = \App\Broughtalsoproduct::find($id);
        
        if ($brought_also_product) {
            return view('backend.brought_also_products.edit', compact('brought_also_product'));
        }
        return redirect()->route('backend.brought_also_products.index');
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
        
        $brought_also_product = $this->brought_also_product->find($id);
        $brought_also_product->name = $request->input('name');       
        if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $brought_also_product->image = 'upload/' . $fullname;
        }
        $brought_also_product->save();
        return redirect()->route('backend.brought_also_products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $brought_also_product = \App\Broughtalsoproduct::find($id);
        if ($brought_also_product->count()) {
            $brought_also_product->delete();
            session()->flash('success', 'Selected brought_also_product deleted successfully.');
            return redirect()->route('backend.brought_also_products.index');
        }
        session()->flash('error', 'Selected brought_also_product dose not found in database please try after some time.');
      return redirect()->route('backend.brought_also_products.index');
    }

}

