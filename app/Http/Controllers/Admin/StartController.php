<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StartController extends Controller
{

    /**
    * Display Start page.
    *
    * @param  Request  $request
    * @return \resources\views\start.blade.php
    */
    public function index(Request $request)
    {
        if ($request->session()->get('newSite') == true)
        {
           return view('start');  
        }        
    }
}
