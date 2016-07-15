<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Bouncer;
use Log;
use App\Template;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();

        return view('dashboard')->with([
			'pageTitle'=>$user->name." Dashboard",
			'userName' => $user->name
        ]);             
    }
}
