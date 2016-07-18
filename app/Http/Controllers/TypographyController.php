<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TypographyController extends Controller
{
    /**
    * Display Typography page.
    *
    * @param  Request  $request
    * @return \resources\views\typography.blade.php
    */
    public function index(Request $request)
    {
        return view('typography');        
    }
}
