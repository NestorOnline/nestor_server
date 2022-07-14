<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScemeonController extends Controller
{
    public function sidebar_filter_data(Request $request)
    {
        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                $price_code = 7;
            } else {
                $price_code = 9;
            }
        } else {
            $price_code = 9;
        }

        if ($request->category && $request->prescription_required && $request->uses) {
            $productuse_details = \App\ProductuseDetail::where('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

            $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                ->whereIn('Prescription_Required', $request->prescription_required)
                ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                ->where('productprice.ProductPriceType_Code', '=', $price_code)
                ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                    return $productuse_detail->Product_Code;
                }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                ->select('products.*')->paginate(100);
        } else if ($request->category && $request->prescription_required) {
            $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                ->whereIn('Prescription_Required', $request->prescription_required)
                ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                ->where('productprice.ProductPriceType_Code', '=', $price_code)
                ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                ->select('products.*')->paginate(100);
        } else if ($request->prescription_required && $request->uses) {
            $products = \App\Product::where('group_id', $request->group_id)->whereIn('ProductUse_Code', $request->uses)
                ->whereIn('Prescription_Required', $request->prescription_required)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                ->where('productprice.ProductPriceType_Code', '=', $price_code)
                ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                    return $productuse_detail->Product_Code;
                }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                ->select('products.*')->paginate(100);
        } else if ($request->uses && $request->category) {
            $productuse_details = \App\ProductuseDetail::where('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);

            $products = \App\Product::where('group_id', $request->group_id)->whereIn('category_id', $request->category)
                ->whereIn('ProductUse_Code', $request->uses)
                ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                ->where('productprice.ProductPriceType_Code', '=', $price_code)
                ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                ->select('products.*')->paginate(100);
        } else if ($request->category) {
            $products = \App\Product::where('group_id', '=', $request->group_id)->whereIn('category_id', $request->category)
                ->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                ->where('productprice.ProductPriceType_Code', '=', $price_code)
                ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                ->select('products.*')->orderBy('id', 'DESC')->paginate(100);

        } else if ($request->prescription_required) {
            $products = \App\Product::where('group_id', $request->group_id)->whereIn('Prescription_Required', $request->prescription_required)
                ->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                ->where('productprice.ProductPriceType_Code', '=', $price_code)
                ->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                ->select('products.*')->paginate(100);
        } else if ($request->uses) {

            $productuse_details = \App\ProductuseDetail::where('ProductUse_Code', $request->uses)->distinct()->get(['Product_Code']);
            $products = \App\Product::where('group_id', $request->group_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                ->where('productprice.ProductPriceType_Code', '=', $price_code)
                ->whereIn('productprice.Product_Code', $productuse_details->map(function ($productuse_detail) {
                    return $productuse_detail->Product_Code;
                }))->whereBetween('productprice.Price', array($request->minval, $request->maxval))
                ->select('products.*')->paginate(100);

        } else {
            if ($request->group_id && $request->groupcategory_id) {
                $products = \App\Product::where('group_id', $request->group_id)->where('groupcategory_id', $request->groupcategory_id)->orderBy('id', 'DESC')->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->where('productprice.Price', '<=', number_format($request->maxval, 2, '.', ''))
                    ->where('productprice.Price', '>=', number_format($request->minval, 2, '.', ''))
                    ->select('products.*')->paginate(100);

            } elseif ($request->group_id) {
                $products = \App\Product::where('group_id', $request->group_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->whereNotNull('productprice.Price')
                    ->where('productprice.Price', '<=', number_format($request->maxval, 2, '.', ''))
                    ->where('productprice.Price', '>=', number_format($request->minval, 2, '.', ''))
                    ->select('products.*')->paginate(100);
            } else {
                $products = \App\Product::where('group_id', $request->group_id)->join('productprices as productprice', 'productprice.Product_Code', '=', 'products.product_code')
                    ->where('productprice.ProductPriceType_Code', '=', $price_code)
                    ->where('productprice.Price', '<=', number_format($request->maxval, 2, '.', ''))
                    ->where('productprice.Price', '>=', number_format($request->minval, 2, '.', ''))
                    ->select('products.*')->paginate(100);
            }

        }

        if (\Auth::user()) {
            if (\Auth::user()->role == 'Chemist') {
                return view('frontend.chemists.sidebar_filter_data', compact('products'));
            } elseif (\Auth::user()->role == 'User') {
                return view('frontend.users.sidebar_filter_data', compact('products'));
            } else {
                return view('frontend.sidebar_filter_data', compact('products'));
            }
        } else {
            return view('frontend.sidebar_filter_data', compact('products'));
        }
    }
}