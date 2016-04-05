<?php

namespace App\Http\Middleware;

use Closure;
use App\Setting;

class Start
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
          return view('start');   
        }
        
        return $next($request);
    }
}
