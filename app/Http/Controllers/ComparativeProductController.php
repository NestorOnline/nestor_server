<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComparativeProductController extends Controller
{
    function list($product_id) {
        $product = \App\Product::find($product_id);
        $comparative_products = \App\ComparativeProduct::where('product_id', '=', $product_id)->get();
        $manufactures = \App\Manufacture::all();
        return view('backend.comparative_products.list', compact('comparative_products', 'product_id', 'product', 'manufactures'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'manufacturer' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'product_id' => 'required',
            'b2c_price' => 'required',
        ]);

        $comparative_product = \App\ComparativeProduct::create([
            'manufacturer' => $request->input('manufacturer'),
            'product_name' => $request->input('product_name'),
            'price' => $request->input('price'),
            'b2c_price' => $request->input('b2c_price'),
            'product_id' => $request->input('product_id'),
        ]);

        $product = \App\Product::find($request->product_id);
        if ($product) {
            $comparative_product->product_code = $product->product_code;
            $comparative_product->save();
        }
        session()->flash('success', 'New Comparative Product is create Successfully');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'manufacturer' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'b2c_price' => 'required',
        ]);

        $comparative_product = \App\ComparativeProduct::find($id);
        $comparative_product->manufacturer = $request->input('manufacturer');
        $comparative_product->product_name = $request->input('product_name');
        $comparative_product->price = $request->input('price');
        $comparative_product->b2c_price = $request->input('b2c_price');

        $comparative_product->save();

        session()->flash('success', 'Selected Comparative Product is Update Successfully');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $comparative_product = \App\ComparativeProduct::find($id);
        if ($comparative_product->count()) {
            $comparative_product->delete();
            session()->flash('success', 'Selected Comparative Product deleted successfully.');
            return redirect()->back();
        }
        session()->flash('error', 'Selected  Comparative Product dose not found in database please try after some time.');
        return redirect()->back();
    }
}