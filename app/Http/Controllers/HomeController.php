<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Bouncer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Main user landing routing
     * Display start page if there are no settings
     * Once user is registered using AuthContoller, save settings
     * If settings:
     * - if user is admin - redirect to admin/dashboard
     * - all other users: user tailored dashboard page
     * if guest - go to 404 (response for now, view TBD)
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settings = Setting::all();

        if ($settings->isEmpty()) 
        { 
            $request->session()->put('newSite', true); 
            return redirect('/start');                
        }
        else
        {
            /*** 
            * First user & rest of users get redirected here. 
            * Clear newSite from session once settings are in place 
            */
            
            $request->session()->forget('newSite');
            
            /***
            * Route user to correct dashboard view
            * starting with admin
            */
            
            if (Auth::check()) 
            {
                $user = Auth::user();
                
                //adding user to the session - need access to $user for bouncer.
                $request->session()->put('user', $user); 
                
                if (Bouncer::is($user)->an('admin'))
                {
                   // Add admin role to user session array
                    $user['admin'] = true;

                    if (Bouncer::is($user)->an('peer reviewer') || Bouncer::is($user)->an('expert reviewer'))
                    {
                        $user['reviewer'] = true;
                        $request->session()->put('user', $user);
                    }
                    
                    $request->session()->put('user', $user);

                    return redirect('/admin');
                }
                else
                {
                    if (Bouncer::is($user)->an('peer reviewer') || Bouncer::is($user)->an('expert reviewer'))
                    {
                        $user['reviewer'] = true;
                        $request->session()->put('user', $user);
                    }

                    // Temp placeholder. Will change this to author dashboard once we get there.
                    return redirect('/dashboard');
                }
            }
            else
            {
                return response('Unauthorized.', 401);
                return redirect('/login');
            }
        }
    }
}
