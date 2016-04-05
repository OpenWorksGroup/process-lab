<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all()->sortBy('name');
        
        foreach ($users as $user)
        {
            unset($user->password);
        }
     //dd($users);
        return view('admin.manageUsers')->with([
            'pageTitle'=>'Manage Users',
            'users' => $users
            ]);    
    }
}
