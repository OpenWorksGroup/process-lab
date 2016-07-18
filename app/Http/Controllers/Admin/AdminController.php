<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    /**
    * Display Admin dashboard.
    *
    * @param  Request  $request
    * @return \resources\views\admin\dashboard.blade.php
    */
    public function index(Request $request)
    {
        return view('admin.dashboard')->with('pageTitle','Admin Dashboard');        
    }
}

