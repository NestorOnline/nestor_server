<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Offer;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OfferController extends Controller
{
   protected $offer;

    public function __construct(Offer $offer) {
        $this->offer = $offer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $offers = \App\Offer::all();
        return view('backend.offers.index', compact('offers'));
    }
    
        public function indexApp() {
        $offers = \App\Offer::all();
         if($offers){
        echo json_encode($offers);  
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
        return view('backend.offers.create');
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [              
            'name' => 'required',
            'description' => 'required',
            'valid_till' => 'required',
            'eligibility' => 'required',
            'how_you_get' => 'required',
            'image' => 'required',
            'cancellation_condition' => 'required',
        ]);
        
        $offer = \App\Offer::create([
             'name' => $request->input('name'),    
             'description' => $request->input('description'), 
             'valid_till' => $request->input('valid_till'), 
             'eligibility' => $request->input('eligibility'), 
             'how_you_get' => $request->input('how_you_get'), 
             'cancellation_condition' => $request->input('cancellation_condition'), 
              'code' => $request->input('code'), 
        ]);
            if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $offer->image = 'upload/' . $fullname;
        }
        $offer->save();
        session()->flash('success', 'New Offer is create Successfully');
        return redirect()->route('backend.offers.index');
    }
    
    
        public function storeApp(Request $request) {
        $this->validate($request, [              
            'name' => 'required',
            'description' => 'required',
            'valid_till' => 'required',
            'eligibility' => 'required',
            'how_you_get' => 'required',
            'image' => 'required',
            'cancellation_condition' => 'required',
        ]);
        
        $offer = \App\Offer::create([
             'name' => $request->input('name'),    
             'description' => $request->input('description'), 
             'valid_till' => $request->input('valid_till'), 
             'eligibility' => $request->input('eligibility'), 
             'how_you_get' => $request->input('how_you_get'), 
             'cancellation_condition' => $request->input('cancellation_condition'), 
        ]);
            if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $offer->image = 'upload/' . $fullname;
        }
        $offer->save();
        
          if($offer){
        echo json_encode($offer);  
        }else{
       echo json_encode('Data Does Not Match. Please Try Again'); 
        }
        session()->flash('success', 'New Offer is create Successfully');
        return redirect()->route('backend.offers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function view_fulldetail($id) {
        $offer = \App\Offer::find($id);
        
        if ($offer) {
            return view('backend.offers.view_fulldetail', compact('category'));
        }
        return redirect()->route('backend.offers.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
        $offer = \App\Offer::find($id);
        
        if ($offer) {
            return view('backend.offers.edit', compact('category'));
        }
        return redirect()->route('backend.offers.index');
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
            'description' => 'required',
            'valid_till' => 'required',
            'eligibility' => 'required',
            'how_you_get' => 'required',
            'image' => 'required',
            'cancellation_condition' => 'required',
        ]);
        
        $offer = $this->offer->find($id);
        $offer->name = $request->input('name');
        $offer->description = $request->input('description'); 
        $offer->valid_till = $request->input('valid_till'); 
        $offer->eligibility = $request->input('eligibility'); 
        $offer->how_you_get = $request->input('how_you_get'); 
        $offer->cancellation_condition = $request->input('cancellation_condition');
         $offer->code = $request->input('code');
        if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);   
            $offer->image = 'upload/' . $fullname;
        }
        $offer->save();
        return redirect()->route('backend.offers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $offer = $this->offer->find($id);
        if ($offer->count()) {
            $offer->delete();
            session()->flash('success', 'Selected Offer deleted successfully.');
            return redirect()->route('backend.offers.index');
        }
        session()->flash('error', 'Selected Offer dose not found in database please try after some time.');
      return redirect()->route('backend.offers.index');
    }

}
