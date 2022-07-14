<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    protected $slider;

    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $sliders = \App\Slider::all();
        return view('backend.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('backend.sliders.create', compact('groups'));
    }
    public function App_Slider_List()
    {
        $sliders = \App\Slider::whereNotNull('mobile_image')->get();
        return view('backend.sliders.App_Slider_List', compact('sliders'));
    }

    public function Add_App_Slider()
    {
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('backend.sliders.Add_App_Slider', compact('groups'));
    }

    public function Add_App_Slider_store(Request $request)
    {
        $this->validate($request, [
            'mobile_image' => 'required',
            'slider_type' => 'required',
        ]);
        $slider = \App\Slider::create([
            'slider_type' => $request->input('slider_type'),
            'group_id' => $request->input('group_id'),
            'groupcategory_id' => $request->input('groupcategory_id'),
            'brand_id' => $request->input('brand_id'),
            'product_id' => $request->input('product_id'),
        ]);
        if ($request->file('mobile_image')) {
            $image = $request->file('mobile_image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $slider->mobile_image = 'upload/' . $fullname;
        }
        $slider->save();
        session()->flash('success', 'New Slider is create Successfully');
        return redirect()->route('backend.sliders.App_Slider_List');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'url_link' => 'required',
            'slider_type' => 'required',
            'image' => 'required',
            'group_id' => 'required',
            'groupcategory_id' => 'required',
        ]);

        $slider = \App\Slider::create([
            'title' => $request->input('title'),
            'url_link' => $request->input('url_link'),
            'slider_type' => $request->input('slider_type'),
            'group_id' => $request->input('group_id'),
            'groupcategory_id' => $request->input('groupcategory_id'),
        ]);
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $slider->image = 'upload/' . $fullname;
        }
        $slider->save();
        session()->flash('success', 'New Slider is create Successfully');
        return redirect()->route('backend.sliders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function view_fulldetail($id)
    {
        $slider = \App\Slider::find($id);
        if ($slider) {
            return view('backend.sliders.view_fulldetail', compact('category'));
        }
        return redirect()->route('backend.sliders.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();

        $slider = \App\Slider::find($id);

        if ($slider) {
            return view('backend.sliders.edit', compact('slider', 'groups'));
        }
        return redirect()->route('backend.sliders.index');
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
            'title' => 'required',
            'url_link' => 'required',
            'slider_type' => 'required',
            'group_id' => 'required',
            'groupcategory_id' => 'required',
        ]);
        $slider = $this->slider->find($id);
        $slider->title = $request->input('title');
        $slider->url_link = $request->input('url_link');
        $slider->slider_type = $request->input('slider_type');
        $slider->group_id = $request->input('group_id');
        $slider->groupcategory_id = $request->input('groupcategory_id');
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $slider->image = 'upload/' . $fullname;
        }
        $slider->save();
        return redirect()->route('backend.sliders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $slider = $this->slider->find($id);
        if ($slider->count()) {
            if ($slider->image) {
                \File::delete($slider->image);
            }
            if ($slider->mobile_image) {
                \File::delete($slider->mobile_image);
            }
            $slider->delete();
            session()->flash('success', 'Selected Slider deleted successfully.');
            return redirect()->back();
        }
        session()->flash('error', 'Selected Slider dose not found in database please try after some time.');
        return redirect()->back();
    }

}