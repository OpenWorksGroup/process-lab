<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\UserRole;
use Bouncer;



class UserEditController extends Controller
{
    /**
     * Update the specified user.
     *
     * @param  string  $id
     * @return Response
   */
    
    public function index($userId)
    {
        $user = User::find($userId);
        if (empty($user)) abort(404);
        $roles = Role::all()->sortBy('name');
        $userRoles = UserRole::getRoles($userId)->get();

        foreach ($roles as $role) {
            foreach ($userRoles as $userRole) {
                if ($userRole->role_id == $role->id){
                    $role->user = true;
                }
            }           
        }

        return view('admin.editUser')->with([
            'pageTitle'=>'Edit '.$user->name.' Roles',
            'name' => $user->name,
            'userId' => $userId,
            'roles' => $roles,
            ]);    
    }
    
    /**
     * Update the the user roles.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $userId = $request->userId;
        
        $this->validate($request, [
            'roles' => 'required'
        ]);
        
        $user = User::find($userId);
        $deletedRows = UserRole::getRoles($userId)->delete();
        
        foreach ($request->roles as $role)
        {
            Bouncer::assign($role)->to($user);
        } 
        
        return redirect('/admin/edit-user/'.$userId)->with('success', 'Roles have been updated.');
    }
}
