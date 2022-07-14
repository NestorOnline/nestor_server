<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\City;
use Mail;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CitiesImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CityController extends Controller
{
   public function getImport()
    {
       return view('backend.cities.getImport');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function postImport(Request $request) 
    {
        Excel::import(new CitiesImport, $request->file('file')->store('temp'));
        return back();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileExport() 
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx');
    } 
}
