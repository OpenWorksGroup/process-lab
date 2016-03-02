<?php

namespace App\Http\Middleware;

use Closure;
use App\Settings;

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
        $settings = Settings::all();
        if ($settings->isEmpty()) 
        { 
          return view('start');   
        }
        
        return $next($request);
    }
}
