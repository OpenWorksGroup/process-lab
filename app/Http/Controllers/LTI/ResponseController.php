<?php

namespace App\Http\Controllers\LTI;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    public function index(Request $request)
    {
        return view('lti.error')->with('pageTitle','Authorization Error');        
    }
}
