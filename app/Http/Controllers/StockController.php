<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Stock;
use Mail;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StocksImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class StockController extends Controller
{
     protected $stock;

    public function __construct(Stock $stock) {
        $this->stock = $stock;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $offices = \App\Office::all();

        if($request->Office_Code){
            $Office_Code = $request->Office_Code;
$products = \App\Product::all();
        }else{
            $Office_Code = "";
            $products = \App\Product::all();
        }
         
            return view('backend.stocks.index', compact('products','Office_Code','offices'));
    }

    public function getImport() {
        return view('backend.stocks.getImport');
    }

    public function postImport(Request $request) {
        Excel::import(new StocksImport, $request->file('file')->store('temp'));
        return back();
    }

        public function report2() {
            $products = \App\Product::all();
            $offices = \App\Office::all();
            return view('backend.stocks.report2', compact('products','offices'));
    }

     
 

}
