<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Roles;
use App\User;
use App\Tag;
use App\TagRelationship;
use Carbon\Carbon;
use Bouncer;

class UserRegistrationController extends Controller
{
    
 public function index(Request $request)
 {
     $roles = Roles::all()->sortBy('name');
     $formRoles = [];
     foreach ($roles as $role)
     {
         array_push($formRoles, $role->name);
     }
     
     return view('admin.registerUser')->with([
         'pageTitle'=>'Register New User',
         'roles' => $formRoles
         ]);    
 }   
 
 public function create(Request $request)
 {
     // should be global
    $adminUser = Auth::user();
    $adminUserId = $adminUser->id;
     
     $this->validate($request, [
         'name' => 'required|max:255',
         'email' => 'required|email|max:255|unique:users',
         'password' => 'required|confirmed|min:6',
         'profile_url' => 'url|max:255',
         'roles' => 'required'
     ]); 
         
     $user = User::create([
         'name' => $request->name,
         'email' => $request->email,
         'password' => bcrypt($request->password),
         'profile_url' => $request->profile_url,
         'last_login_at' => Carbon::now(),
     ]);
     
     foreach ($request->roles as $role)
     {
         Bouncer::assign($role)->to($user);
     } 
     
     $tags = preg_split("/[\s,]+/", $request->user_tags);
     
     foreach ($tags as $tag)
     {
         $tagName = strtolower($tag);
         
         $foundTag = Tag::where('tag', '=', $tagName)->first();
         
         if (! $foundTag) 
         { 
         
             $tagSave = Tag::create([
                 'tag' => $tagName, 
                 'type' => "User", 
                 'created_by' => 'Admin', 
                 'user_id' => $adminUserId
             ]);
             
             $tagId = $tagSave->id;
         }
         else {
             $tagId = $foundTag->id;
         }
         
         $tagRel = TagRelationship::create([
             'tag_id' => $tagId,
             'user_id' => $user->id
         ]); 
         
     }
     
     
    return redirect('/admin/register-user')->with('success', 'User Registered Successfully.');              
                
 }
    
    
}