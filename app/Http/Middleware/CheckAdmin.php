<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Bouncer;

class CheckAdmin
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
        if (Auth::check()) 
        {
            $user = Auth::user();
         
            if (Bouncer::is($user)->an('admin'))
            {
                return $next($request);
            }
            else       
            {
            return response('Unauthorized.', 401);
            }   
        }
        else
        {
            return response('Unauthorized.', 401);
        } 
    }
}
