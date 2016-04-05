<?php

namespace App\Http\Middleware;

use Closure;
use App\Setting;
use Illuminate\Support\Facades\Auth;

class UserRouter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
        $settings = Setting::all();
        $rootAdmins = unserialize($settings[0]['attributes']['admins']);
        
        $user_id = Auth::id();
       // dd($user_id);
        if (in_array($user_id,$rootAdmins))
        {
         $request->session()->put('roles', array("Admin"));  
         return redirect('settings'); 
        }
        
        return $next($request);
    }
}
