<?php

namespace App\Http\Controllers;

use App\DoctorSpecialization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorSpecializationController extends Controller
{
    protected $doctor_specialization;

    public function __construct(DoctorSpecialization $doctor_specialization)
    {
        $this->doctor_specialization = $doctor_specialization;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $doctor_specializations = \App\DoctorSpecialization::all();
        return view('backend.doctor_specializations.index', compact('doctor_specializations'));
    }

    public function indexApp()
    {
        $doctor_specializations = \App\DoctorSpecialization::all();
        if ($doctor_specializations) {
            echo json_encode($doctor_specializations);
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
        return view('backend.doctor_specializations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Doctor_Type' => 'required',
            'Specialization_Type' => 'required',
            'Specialization_Name' => 'required',
            'icon_image' => 'required',
        ]);
        $doctor_specialization = \App\DoctorSpecialization::create([
            'Doctor_Type' => $request->input('Doctor_Type'),
            'Specialization_Type' => $request->input('Specialization_Type'),
            'Specialization_Name' => $request->input('Specialization_Name'),
        ]);
        if ($request->file('icon_image')) {
            $image = $request->file('icon_image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $doctor_specialization->icon_image = 'upload/' . $fullname;
        }
        $doctor_specialization->save();
        session()->flash('success', 'New DoctorSpecialization is create Successfully');
        return redirect()->route('backend.doctor_specializations.index');
    }

    public function storeApp(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $doctor_specialization = \App\DoctorSpecialization::create([
            'name' => $request->input('name'),
        ]);
        if ($doctor_specialization) {
            echo json_encode($doctor_specialization);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $doctor_specialization = \App\DoctorSpecialization::find($id);

        if ($doctor_specialization) {
            return view('backend.doctor_specializations.show', compact('category'));
        }
        return redirect()->route('backend.doctor_specializations.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $doctor_specialization = \App\DoctorSpecialization::find($id);

        if ($doctor_specialization) {
            return view('backend.doctor_specializations.edit', compact('doctor_specialization'));
        }
        return redirect()->route('backend.doctor_specializations.index');
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
            'Doctor_Type' => 'required',
            'Specialization_Type' => 'required',
            'Specialization_Name' => 'required',
            'icon_image' => 'required',
        ]);
        $doctor_specialization = $this->doctor_specialization->find($id);
        $doctor_specialization->Doctor_Type = $request->input('Doctor_Type');
        $doctor_specialization->Specialization_Type = $request->input('Specialization_Type');
        $doctor_specialization->Specialization_Name = $request->input('Specialization_Name');

        if ($request->file('icon_image')) {
            $image = $request->file('icon_image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $doctor_specialization->icon_image = 'upload/' . $fullname;
        }
        $doctor_specialization->save();
        return redirect()->route('backend.doctor_specializations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $doctor_specialization = $this->doctor_specialization->find($id);
        if ($doctor_specialization->count()) {
            $doctor_specialization->delete();
            session()->flash('success', 'Selected DoctorSpecialization deleted successfully.');
            return redirect()->route('backend.doctor_specializations.index');
        }
        session()->flash('error', 'Selected DoctorSpecialization dose not found in database please try after some time.');
        return redirect()->route('backend.doctor_specializations.index');
    }

}