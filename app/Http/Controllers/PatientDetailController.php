<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\PatientDetail;
use Illuminate\Http\Request;

class PatientDetailController extends Controller
{
    protected $patient_detail;

    public function __construct(PatientDetail $patient_detail)
    {
        $this->patient_detail = $patient_detail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $patient_details = \App\PatientDetail::all();
        return view('backend.patient_details.index', compact('patient_details'));
    }

    public function indexApp()
    {
        $patient_details = \App\PatientDetail::all();
        if ($patient_details) {
            echo json_encode($patient_details);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $groups = \App\Group::all();
        return view('backend.patient_details.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'Patient_Name' => 'required',
            'Patient_Age' => 'required',
            'Sex' => 'required',
            'Mobile_No' => 'required',
            'Food_Allergies' => 'required',
            'Tendency_Bleed' => 'required',
            'Heart_Disease' => 'required',
            'High_Blood_Pressure' => 'required',
            'Diabetic' => 'required',
            'Surgery' => 'required',
            'Accident' => 'required',
            'Others' => 'required',
            'Family_Medical_History' => 'required',
            'Current_Medication' => 'required',
            'Female_Pregnancy' => 'required',
            'Breast_Feeding' => 'required',
        ]);
        $patient_detail = \App\PatientDetail::create([
            'user_id' => $request->input('user_id'),
            'Patient_Name' => $request->input('Patient_Name'),
            'Patient_Age' => $request->input('Patient_Age'),
            'Sex' => $request->input('Sex'),
            'Mobile_No' => $request->input('Mobile_No'),
            'Food_Allergies' => $request->input('Food_Allergies'),
            'Tendency_Bleed' => $request->input('Tendency_Bleed'),
            'Heart_Disease' => $request->input('Heart_Disease'),
            'High_Blood_Pressure' => $request->input('High_Blood_Pressure'),
            'Diabetic' => $request->input('Diabetic'),
            'Surgery' => $request->input('Surgery'),
            'Accident' => $request->input('Accident'),
            'Others' => $request->input('Others'),
            'Family_Medical_History' => $request->input('Family_Medical_History'),
            'Current_Medication' => $request->input('Current_Medication'),
            'Female_Pregnancy' => $request->input('Female_Pregnancy'),
            'Breast_Feeding' => $request->input('Breast_Feeding'),
        ]);
        session()->flash('success', 'New patient_detail is create Successfully');
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
    public function get_detail_on_patient_select(Request $request)
    {
        $patient_detail = \App\PatientDetail::find($request->petient_id);
        if ($patient_detail) {
            return view('backend.patient_details.get_detail_on_patient_select', compact('patient_detail'));
        }
        return redirect()->route('backend.patient_details.index');
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
        $patient_detail = \App\PatientDetail::find($id);

        if ($patient_detail) {
            return view('backend.patient_details.edit', compact('patient_detail', 'groups'));
        }
        return redirect()->route('backend.patient_details.index');
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
            'name' => 'required',
            'group_id' => 'required',
        ]);
        $patient_detail = $this->patient_detail->find($id);
        $patient_detail->name = $request->input('name');
        $patient_detail->save();
        return redirect()->route('backend.patient_details.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $patient_detail = $this->patient_detail->find($id);
        if ($patient_detail->count()) {
            $patient_detail->delete();
            session()->flash('success', 'Selected patient_detail deleted successfully.');
            return redirect()->route('backend.patient_details.index');
        }
        session()->flash('error', 'Selected patient_detail dose not found in database please try after some time.');
        return redirect()->route('backend.patient_details.index');
    }

}