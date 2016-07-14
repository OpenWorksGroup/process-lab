<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Bouncer;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (Bouncer::is($user)->an('admin')){
            return view('admin.userDashboard')->with([
				'pageTitle'=>$user->name." Dashboard",
				'userName' => $user->name
            ]);  
		}
		else {
           return view('dashboard')->with([
				'pageTitle'=>$user->name." Dashboard",
				'userName' => $user->name
            ]);    
		}
          
    }
}
