<?php

namespace App\Http\Controllers\LTI;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\UtilitiesClass;
use App\Setting;
use App\User;
use App\Tag;
use App\TagRelationship;
use Validator;
use Carbon\Carbon;
use Bouncer;

class OAuthHelper {
    private $key;
    private $secret;

    public function __construct($consumerKey, $consumerSecret)
    {
        $this->key = $consumerKey;
        $this->secret = $consumerSecret;
    }

    public function isSignatureValid($request)
    {
        return $this->buildSignature($request) === $request->input('oauth_signature');
    }

    public function buildSignature($request)
    {
        $input = $request->all();
        unset($input['oauth_signature']);

        $hmac_method = new \OAuthSignatureMethod_HMAC_SHA1();
        $consumer = new \OAuthConsumer($this->key, $this->secret, NULL);
        $req = \OAuthRequest::from_consumer_and_token($consumer, NULL, 'POST', $request->fullUrl(), $input);
        return $req->build_signature($hmac_method, $consumer, null);
    }
}

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware('lti');
    }

    public function store(Request $request)
    {
        /* first check to make sure the process lab has been set up */
        $input = $request->all();
        $settings = Setting::all()->first();
        
       // dd($input);
        
        if (empty($settings)) 
        { 
            return view('lti.error')->with([
                'siteTitle'=>'',
                'pageTitle'=>'Authorization Error',
                'message'=>"This system has not been set up properly. Please refer to set up instructions."
            ]);                
        }
           
           $validator = Validator::make($request->all(), [
               "lti_message_type" => "bail|required|regex:/basic-lti-launch-request/",
               "lti_version" => "bail|required|regex:/LTI-1p0/",
               "launch_presentation_return_url" => "bail|required",
               "resource_link_id" => "bail|required",
               "oauth_consumer_key" => "bail|required",
               "oauth_signature_method" => "bail|required|regex:/HMAC-SHA1/",
               "oauth_timestamp" => "bail|required", //LTI requires but we're not using it
               "oauth_nonce" => "bail|required", //LTI requires but we're not using it
               "oauth_version" => "bail|required|regex:/1.0/",
               "oauth_signature" => "bail|required",
               "oauth_callback" => "bail|required",
               "user_id" => "bail|required",
               "user_image" => "bail|required|url",
               "lis_person_name_full" => "bail|required",
               "lis_person_contact_email_primary" => "bail|required|email",
               "custom_tc_profile_url" => "bail|required|url"
            ]);
            
              // dd($input);
            
            $validator->after(function($validator) use ($input, $settings, $request) {
                
                $providedSignature = $input['oauth_signature'];
                unset($input['oauth_signature']);
                
                // get these from settings table
                $consumer_key = $settings->lti_consumer_key;
                $consumer_secret = $settings->lti_secret;
                
                if ($input['oauth_consumer_key'] !== $consumer_key) {
                    $validator->errors()->add('key', 'Oauth signature is invalid.');
                    return;
                }
                
                $oauthHelper = new OAuthHelper($consumer_key, $consumer_secret);
                if (!$oauthHelper->isSignatureValid($request)) {
                  $validator->errors()->add('signature', 'Oauth signature is invalid.');
                  return;
                } 
                
 
               });

            if ($validator->fails()) {
                $error = $validator->errors()->first();

                return view('lti.error')->with([
                    'siteTitle'=>$settings->title, //replace this with settings
                    'pageTitle'=>'Authorization Error',
                    'consumerName'=>$settings->lti_consumer_name,
                    'message'=>"There was a problem connecting to ".$settings->title.".",
                    'error'=>$validator->errors()->first(),
                    'returnUrl'=>$input['launch_presentation_return_url']
                    ]);   
            }
            
            /** check to see if user exists already **/
            
            $ltiUserId = $input['user_id'];
            $email = $input['lis_person_contact_email_primary'];

            $user = User::where('lti_user_id', '=', $ltiUserId)
                        ->orWhere('email', '=', $email)->first();
           
            if (empty($user))
            {
                $user = User::create([
                    'name' => $input['lis_person_name_full'],
                    'email' => $email,
                    'lti_user_id' => $ltiUserId,
                    'profile_url' => $input['custom_tc_profile_url'],
                    'profile_image' => $input['user_image'],
                    'last_login_at' => Carbon::now(),
                ]);
              
                /* every user is an author */
                Bouncer::assign('author')->to($user);              
            }
            
            /* set user as authenticated */
            Auth::login($user, true);
            $request->session()->put('user', $user); 
          
            foreach($input as $key => $value) {
                if (preg_match('/^custom_user_tags/',$key)){
                    $tags = explode(",",$value);
                    foreach($tags as $tag) {
                        $newTag = Tag::firstOrCreate(array('type' => "user", 'tag' => trim($tag), 'created_by' => 'system'));
                        $newTagRel = TagRelationship::firstOrCreate(array('tag_id' => $newTag->id, 'user_id' => $user->id));
                    }
                }
                else if (preg_match('/^custom_user_tag/',$key)){
                   $tags = explode(",",$value);
                   $labelArr = explode("_",$key);
                   $label = array_pop($labelArr);
                   foreach($tags as $tag) {
                      // var_dump($tag." ".$label);
                       $newTag = Tag::firstOrCreate(array('type' => "user", 'label' => $label, 'tag' => trim($tag), 'created_by' => 'system'));
                       $newTagRel = TagRelationship::firstOrCreate(array('tag_id' => $newTag->id, 'user_id' => $user->id));
                  }    
                }
            };
            
            /* if any roles are sent via LTI add them here */
            
            if (! empty($input['roles'])){
                
                $rolesTranslateArr = [
                    'learner' => 'author',
                    'administrator' => 'admin',
                    'mentor' => 'online facilitator',
                    'instructor' => 'peer reviewer',
                    'mentor/reviewer' => 'expert reviewer'
                ];
                
                $roles = explode(",",$input['roles']);
                
                foreach($roles as $role) {
                    $role = trim(strtolower($role));
                    Bouncer::assign($rolesTranslateArr[$role])->to($user);

                    if ($role == 'peer reviewer' || $role == 'expert reviewer') {
                        $user['reviewer'] = true;
                    }

                    if ($role == 'admin') {
                        $user['admin'] = true;
                    }
                }
            }
            
            $request->session()->put('user', $user); 
            
            /** redirect user based on role. Add LTI roles **/
            
            if (Bouncer::is($user)->an('admin'))
            {
                return redirect('/admin');
            }
            else
            {
                return redirect('/dashboard);  
            }
    }
}
