<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UserDashboardController extends Controller
{
    public function index($userId)
    {
        $user = User::find($userId);
        if (empty($user)) abort(404);
       

        return view('userDashboard')->with([
            'pageTitle'=>$user->name." Dashboard",
            'userName' => $user->name
            ]);    
    }
}
