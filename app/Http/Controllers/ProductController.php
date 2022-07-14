<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getImport()
    {
        return view('backend.products.getImport');
    }

    public function postImport(Request $request)
    {
        Excel::import(new ProductsImport, $request->file('file')->store('temp'));
        return back();
    }

    public function export(Request $request)
    {
        return Excel::download(new ProductsExport, 'product_export.xlsx');
        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = \App\Product::all();
        return view('backend.products.index', compact('products'));
    }

    public function list_with_price()
    {
        $products = \App\Product::all();
        return view('backend.products.list_with_price', compact('products'));
    }

    public function image()
    {
        $groups = \App\Group::orderBy('id', 'DESC')->get();
        $products = \App\Product::all();
        return view('backend.products.image', compact('products', 'groups'));
    }

    public function indexApp()
    {
        $products = \App\Product::all();
        if ($products) {
            echo json_encode($products);
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
        $categories = \App\Category::all();
        $packages = \App\Package::all();
        return view('backend.products.create', compact('groups', 'packages', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {

        $this->validate($request, [
            'generic_name' => 'required',
            'brand_name' => 'required',
            'group_id' => 'required',
            'groupcategory_id' => 'required',
            'category_id' => 'required',
            'manufacture' => 'required',
            'composition' => 'required',
            'storage' => 'required',
            'product_code' => 'required',
            'OrderQtyMultipleOf' => 'required',
            'package_id' => 'required',
            'mrp_amount' => 'required',
            'offer' => 'required',
            'actual_amount' => 'required',
        ]);
        $product = \App\Product::create([
            'generic_name' => $request->input('generic_name'),
            'brand_name' => $request->input('brand_name'),
            'group_id' => $request->input('group_id'),
            'groupcategory_id' => $request->input('groupcategory_id'),
            'category_id' => $request->input('category_id'),
            'composition' => $request->input('composition'),
            'storage' => $request->input('storage'),
            'manufacture' => $request->input('manufacture'),
            'product_code' => $request->input('product_code'),
            'OrderQtyMultipleOf' => $request->input('OrderQtyMultipleOf'),
            'package_id' => $request->input('package_id'),
            'mrp_amount' => $request->input('mrp_amount'),
            'offer' => $request->input('offer'),
            'actual_amount' => $request->input('actual_amount'),
        ]);
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $product->image = 'upload/' . $fullname;
        }
        $product->save();
        session()->flash('success', 'New Product is create Successfully');
        return redirect()->route('backend.products.index');
    }

    public function storeApp(Request $request)
    {
        $this->validate($request, [
            'generic_name' => 'required',
            'brand_name' => 'required',
            'group_id' => 'required',
            'category_id' => 'required',
            'manufacture' => 'required',
            'composition' => 'required',
            'storage' => 'required',
            'product_code' => 'required',
            'OrderQtyMultipleOf' => 'required',
            'package_id' => 'required',
            'mrp_amount' => 'required',
            'offer' => 'required',
            'actual_amount' => 'required',
        ]);
        $product = \App\Product::create([
            'generic_name' => $request->input('name'),
            'brand_name' => $request->input('manufacture'),
            'group_id' => $request->input('group_id'),
            'category_id' => $request->input('category_id'),
            'composition' => $request->input('composition'),
            'storage' => $request->input('storage'),
            'manufacture' => $request->input('manufacture'),
            'product_code' => $request->input('product_code'),
            'OrderQtyMultipleOf' => $request->input('OrderQtyMultipleOf'),
            'package_id' => $request->input('package_id'),
            'mrp_amount' => $request->input('package_id'),
            'offer' => $request->input('offer'),
            'actual_amount' => $request->input('actual_amount'),
        ]);
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $product->image = 'upload/' . $fullname;
        }
        $product->save();
        if ($product) {
            echo json_encode($product);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }
    }

    public function add_position(Request $request)
    {
        $this->validate($request, [
            'position_at' => 'required',
            'position' => 'required',
        ]);
        $product = $this->product->find($request->product_id);
        $product->position_at = $request->position_at;
        $product->position = $request->position;
        $product->save();
        return redirect()->route('backend.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $product = \App\Product::find($id);
        if ($product) {
            return view('backend.products.show', compact('category'));
        }
        return redirect()->route('backend.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $categories = \App\Category::all();
        $groups = \App\Group::all();
        $subcategories = \App\Subcategory::all();
        $product = \App\Product::find($id);
        if ($product) {
            return view('backend.products.edit', compact('categories', 'subcategories', 'groups', 'product'));
        }
        return redirect()->route('backend.products.index');
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
            'generic_name' => 'required',
            'brand_name' => 'required',
            'group_id' => 'required',
            'category_id' => 'required',
            'manufacture' => 'required',
            'composition' => 'required',
            'storage' => 'required',
            'product_code' => 'required',
            'OrderQtyMultipleOf' => 'required',
            'package_id' => 'required',
            'mrp_amount' => 'required',
            'offer' => 'required',
            'actual_amount' => 'required',
        ]);
        $product = $this->product->find($id);
        $product->generic_name = $request->input('generic_name');
        $product->brand_name = $request->input('brand_name');
        $product->group_id = $request->input('group_id');
        $product->category_id = $request->input('category_id');
        $product->manufacture = $request->input('manufacture');
        $product->composition = $request->input('composition');
        $product->storage = $request->input('storagestorage');
        $product->product_code = $request->input('product_code');
        $product->OrderQtyMultipleOf = $request->input('OrderQtyMultipleOf');
        $product->package_id = $request->input('package_id');
        $product->mrp_price = $request->input('mrp_price');
        $product->offer = $request->input('offer');
        $product->actual_price = $request->input('actual_price');
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $product->image = 'upload/' . $fullname;
        }
        $product->save();
        return redirect()->route('backend.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);
        if ($product->count()) {
            $product->delete();
            session()->flash('success', 'Selected Product deleted successfully.');
            return redirect()->route('backend.products.index');
        }
        session()->flash('error', 'Selected Product dose not found in database please try after some time.');
        return redirect()->route('backend.products.index');
    }

}