<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Setting;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Bouncer;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'site_title' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'profile_url' => 'url|max:255'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * If new user coming from start form, create new site settings
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        /**
        * Seed DB with roles and abilities. See Providers/BouncerServiceProvider.php
        **/
        Bouncer::seed();
      
        $user = User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'password' => bcrypt($data['password']),
          'profile_url' => $data['profile_url'],
          'last_login_at' => Carbon::now(),
          ]);
      
          if ($data['site'] == "new")
          {    
              $settings = Setting::create([
                  'title' => $data['site_title'],
                  'admins' => serialize(array($user['id'])),
              ]);
              Bouncer::assign('admin')->to($user);
          }
          
          return $user;
    }
    
}
