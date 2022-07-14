<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Contact;
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ContactController extends Controller
{ 
    protected $contact;

    public function __construct(Contact $contact) {
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $contacts = \App\Contact::all();
        return view('backend.contacts.index', compact('contacts'));
    }
    
        public function indexApp() {
        $contacts = \App\Contact::all();
        if($contacts){
               echo json_encode($contacts);  
        }else{
       echo json_encode('Data Does Not Match. Please Try Again'); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    
        public function store(Request $request) {
        $this->validate($request, [            
            'purpose_contact' => 'required',
            'message' => 'required',
            'mobile' => 'required',
            'email' => 'required',          
        ]);
        $contact = \App\Contact::create([
            'purpose_contact' => $request->input('purpose_contact'),  
            'message' => $request->input('message'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),          
        ]);
        session()->flash('success', 'New Contact is create Successfully');
        return redirect()->route('backend.contacts.index');
    }


    public function contact_store_App(Request $request) {
         $rules = [                 
            'purpose_contact' => 'required',
            'message' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            ];
    $response = array('error' => '', 'status'=>false);
    $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
             $response['error'] = $validator->messages();
        return $response;
        }else{
        //process the request
        }
        $contact = \App\Contact::create([
            'purpose_contact' => $request->input('purpose_contact'),  
            'message' => $request->input('message'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),          
        ]);
       return response()->json([
            'status'=>'success',
            'message' => 'Data is Save Successfully',
        ], 200);
    }


    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $contact = \App\Contact::find($id);       
        if ($contact) {
            return view('backend.contacts.show', compact('contact'));
        }
        return redirect()->route('backend.contacts.index');
    } 
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
      
        $contact = \App\Contact::find($id);

        if ($contact) {
            return view('backend.contacts.edit', compact('contact','groups'));
        }
        return redirect()->route('backend.contacts.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
         $this->validate($request, [            
            'purpose_contact' => 'required',
            'message' => 'required',
            'mobile' => 'required',
            'email' => 'required',          
        ]);       
        $contact = $this->contact->find($id);
        $contact->purpose_contact = $request->input('purpose_contact'); 
        $contact->message = $request->input('message'); 
        $contact->mobile = $request->input('mobile'); 
        $contact->email = $request->input('email'); 
        $contact->save();
        return redirect()->route('backend.contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($id) {
        $contact = $this->contact->find($id);
        if ($contact->count()) {
            $contact->delete();
            session()->flash('success', 'Selected Contact deleted successfully.');
            return redirect()->route('backend.contacts.index');
        }
        session()->flash('error', 'Selected Contact dose not found in database please try after some time.');
      return redirect()->route('backend.contacts.index');
    }

}