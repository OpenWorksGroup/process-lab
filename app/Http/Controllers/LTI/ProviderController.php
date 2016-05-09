<?php

namespace App\Http\Controllers\LTI;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\UtilitiesClass;
use App\Setting;
use App\User;
use Validator;
use Carbon\Carbon;
use Bouncer;

class ProviderController extends Controller
{

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
            
            $validator->after(function($validator) use ($input,$settings) {
                
                $providedSignature = $input['oauth_signature'];
                unset($input['oauth_signature']);
                
                // get these from settings table
                $consumer_key = $settings->lti_consumer_key;
                $consumer_secret = $settings->lti_secret;
                
                if ($input['oauth_consumer_key'] !== $consumer_key) {
                    $validator->errors()->add('key', 'Oauth signature is invalid.');
                    return;
                }
                
              //  $string1 = 'POST&http%3A%2F%2Fprocesslab.dev%3A8000%2Flti%2Fauth&';
              $string1 = 'POST&https%3A%2F%2Fdml.viflearn.com%2Flti%2Fauth&';

                $keys = UtilitiesClass::urlencode_rfc3986(array_keys($input));
                $values = UtilitiesClass::urlencode_rfc3986(array_values($input));
                $params = array_combine($keys, $values);
               // dd($params);
                uksort($params, 'strcmp');
     
                $pairs = array();
     
                foreach ($params as $parameter => $value) {
                  if (is_array($value)) {
                    sort($value, SORT_STRING);
                    foreach ($value as $duplicate_value) {
                      $pairs[] = $parameter . '=' . $duplicate_value;
                    }
                  } else {
                    $pairs[] = $parameter . '=' . $value;
                  }
                }
     
                $string2 = implode('&', $pairs);
     
                $string3 = $string1.UtilitiesClass::urlencode_rfc3986($string2);
                
                $key = $consumer_secret.'&';

                $signed = base64_encode(hash_hmac('sha1', $string3, $key, true));
                
               // var_dump($providedSignature);
               // var_dump($signed);
                
                if ($signed !== $providedSignature) {
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
              
                Bouncer::assign('author')->to($user);
              
            }
            $request->session()->put('user', $user); 
            
            /** redirect user based on role. Add LTI roles **/
            
            if (Bouncer::is($user)->an('admin'))
            {
                return redirect('/admin');
            }
            else
            {
                return redirect('/dashboard/'.$user->id);  
            }
    }
    
           

        
    //dd($request);
            
          // var_dump($request);
      
         // dd($request);
      
       
          // var_dump(hash_algos());
         //  var_dump($request->oauth_consumer_key);
         //  var_dump($request->oauth_signature_method);
         //  var_dump($request->oauth_timestamp);
         //  var_dump($request->oauth_version);
         //  var_dump($request->oauth_nonce);
     
       /*  $string1 = 'POST&http%3A%2F%2Fprocesslab.dev%3A8000%2Flti%2Fauth&';
     
         $input = $request->all();
         unset($input['oauth_signature']);
         $keys = UtilitiesClass::urlencode_rfc3986(array_keys($input));
         $values = UtilitiesClass::urlencode_rfc3986(array_values($input));
         $params = array_combine($keys, $values);

         uksort($params, 'strcmp');
     
         $pairs = array();
     
         foreach ($params as $parameter => $value) {
           if (is_array($value)) {
             sort($value, SORT_STRING);
             foreach ($value as $duplicate_value) {
               $pairs[] = $parameter . '=' . $duplicate_value;
             }
           } else {
             $pairs[] = $parameter . '=' . $value;
           }
         }
     
         $string2 = implode('&', $pairs);
     
         $string3 = $string1.UtilitiesClass::urlencode_rfc3986($string2);
         var_export($string3);

         echo "<br/><br/>";
 

           $key = $consumer_secret.'&';

           $signed = base64_encode(hash_hmac('sha1', $string3, $key, true));
       
           var_dump('signature processed '.$signed);
           var_dump('oauth_signature sent '.$request->oauth_signature);
       
           var_dump(strlen($signed));
           var_dump(strlen($request->oauth_signature));
       
           if ($signed === $request->oauth_signature) {
                   echo "hashes match!";
               } 
           
              // $test1 = base64_encode(hash_hmac('sha1', 'hello', $key, true));
             //  $test2 = base64_encode(hash_hmac('sha1', 'hello', $key, true));
           
              // var_dump($test1);
             //  var_dump($test2);
       
           dd('');*/
}
