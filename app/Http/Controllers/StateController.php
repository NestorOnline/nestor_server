<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\State;
use Mail;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StatesImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class StateController extends Controller
{
   public function getImport()
    {
       return view('backend.states.getImport');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function postImport(Request $request) {
        Excel::import(new StatesImport, $request->file('file')->store('temp'));
        return back();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileExport() 
    {
        return Excel::download(new CitiesExport, 'cities-collection.xlsx');
    } 
}
