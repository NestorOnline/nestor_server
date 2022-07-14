<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Manufacture;
use Illuminate\Http\Request;

class ManufactureController extends Controller
{
    protected $manufacture;

    public function __construct(Manufacture $manufacture)
    {
        $this->manufacture = $manufacture;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $manufactures = \App\Manufacture::all();
        return view('backend.manufactures.index', compact('manufactures'));
    }

    public function indexApp()
    {
        $manufactures = \App\Manufacture::all();
        if ($manufactures) {
            echo json_encode($manufactures);
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
        return view('backend.manufactures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $manufacture = \App\Manufacture::create([
            'name' => $request->input('name'),
        ]);
        session()->flash('success', 'New Group is create Successfully');
        return redirect()->route('backend.manufactures.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $manufacture = \App\Manufacture::find($id);

        if ($manufacture) {
            return view('backend.manufactures.show', compact('category'));
        }
        return redirect()->route('backend.manufactures.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $manufacture = \App\Manufacture::find($id);

        if ($manufacture) {
            return view('backend.manufactures.edit', compact('manufacture'));
        }
        return redirect()->route('backend.manufactures.index');
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
        ]);

        $manufacture = $this->manufacture->find($id);
        $manufacture->name = $request->input('name');

        $manufacture->save();
        return redirect()->route('backend.manufactures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $manufacture = $this->manufacture->find($id);
        if ($manufacture->count()) {
            $manufacture->delete();
            session()->flash('success', 'Selected Group deleted successfully.');
            return redirect()->route('backend.manufactures.index');
        }
        session()->flash('error', 'Selected Group dose not found in database please try after some time.');
        return redirect()->route('backend.manufactures.index');
    }

}