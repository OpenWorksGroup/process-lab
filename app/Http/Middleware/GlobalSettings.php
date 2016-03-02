<?php

namespace App\Http\Middleware;

use Closure;
use App\Settings;
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
        $settings = Settings::all();
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
