<?php

namespace App\Http\Middleware;

use Closure;
use App\Setting;
use Illuminate\Support\Facades\View;

class GlobalSettings
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
        if ($settings->isEmpty()) 
        {
           View::share('siteTitle', "Welcome"); 
        }
        else {
           View::share('siteTitle', $settings[0]->title);  
        } 
        
        return $next($request);
    }
}
