<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeController extends Controller
{
     public function index(Request $request) {
        $offices = \App\Office::all();
        return view('backend.offices.index', compact('offices'));
    }
}
