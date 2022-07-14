<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Upoadprescription;
use Illuminate\Http\Request;

class UploadprescriptionController extends Controller
{
    protected $upload_prescription;

    public function __construct(Upoadprescription $upload_prescription)
    {
        $this->upload_prescription = $upload_prescription;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $upload_prescriptions = \App\Upoadprescription::all();
        return view('backend.upload_prescriptions.index', compact('upload_prescriptions'));
    }

    public function select_doctor_type()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('frontend.upload_prescriptions.select_doctor_type', compact('groups'));
    }

    public function select_illness()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('frontend.upload_prescriptions.select_illness', compact('groups'));
    }

    public function explain_issue(Request $request)
    {
        $doctor_specialization_id = $request->doctor_specialization_id;
        return view('frontend.upload_prescriptions.explain_issue', compact('doctor_specialization_id'));
    }

    public function get_illness(Request $request)
    {
        $doctor_specialization_types = \App\DoctorSpecializationType::with('doctor_specializations')->where('Doctor_Type', $request->doctor_type)->get();
        return view('frontend.upload_prescriptions.get_illness', compact('doctor_specialization_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    public function add_product($id)
    {
        $upload_prescription = \App\Upoadprescription::find($id);
        $products = \App\Product::all();
        return view('backend.upload_prescriptions.add_product', compact('upload_prescription', 'products'));
    }

    public function add_product_store(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'product_id' => 'required',
            'Qty' => 'required',
        ]);

        $product = \App\Product::find($request->input('product_id'));
        if ($product) {
            $product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
        }
        $add_to_card = \App\Addtocard::create([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'Qty' => $request->input('Qty'),
            'amount' => $product_price->Price,
        ]);
        return redirect()->back();
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
    public function show($id)
    {
        $upload_prescription = \App\Upoadprescription::find($id);
        if ($upload_prescription) {
            return view('backend.upload_prescriptions.show', compact('upload_prescription'));
        }
        return redirect()->route('backend.upload_prescriptions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $groups = \App\Group::all();
        $upload_prescription = \App\Upoadprescription::find($id);

        if ($upload_prescription) {
            return view('backend.upload_prescriptions.edit', compact('upload_prescription', 'groups'));
        }
        return redirect()->route('backend.upload_prescriptions.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'upload_prescription' => 'required',
            'dipot_id' => 'required',
            'location' => 'required',
        ]);
        $upload_prescription = $this->upload_prescription->find($id);
        $upload_prescription->upload_prescription = $request->input('upload_prescription');
        $upload_prescription->dipot_id = $request->input('dipot_id');
        $upload_prescription->location = $request->input('location');
        $upload_prescription->save();
        return redirect()->route('backend.upload_prescriptions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $upload_prescription = $this->upload_prescription->find($id);
        if ($upload_prescription->count()) {
            $upload_prescription->delete();
            session()->flash('success', 'Selected Upoadprescription deleted successfully.');
            return redirect()->route('backend.upload_prescriptions.index');
        }
        session()->flash('error', 'Selected Upoadprescription dose not found in database please try after some time.');
        return redirect()->route('backend.upload_prescriptions.index');
    }

}