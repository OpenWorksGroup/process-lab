<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingsController extends Controller
{
    /**
     * Update the specified user.
     *
     * @param  string  $id
     * @return Response
   */
    
    public function edit()
    {
        $settings = Setting::all()->first();
        if (empty($settings)) 
        { 
            return view('lti.error')->with([
                'siteTitle'=>'',
                'pageTitle'=>'Authorization Error',
                'message'=>"This system has not been set up properly. Please refer to set up instructions."
            ]);                
        }
       

        return view('admin.editSettings')->with([
            'pageTitle'=>'Edit Settings',
            'settings' => $settings
            ]);    
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'lti_consumer_name' => 'required|max:255',
            'lti_consumer_key' => 'required|max:255',
            'lti_secret' => 'required|max:255'
        ]);

        /**
         * Gather Competency Framework Values labels and write to json object
         */

        $settings = Setting::all()->first();
        $settings->title = $request['title'];
        $settings->lti_consumer_name = $request['lti_consumer_name'];
        $settings->lti_consumer_key = $request['lti_consumer_key'];
        $settings->lti_secret = $request['lti_secret'];  
        $settings->competency_framework_description_1 = $request['competency_framework_description_1']; 
        $settings->competency_framework_description_2 = $request['competency_framework_description_2']; 
        $settings->competency_framework_description_3 = $request['competency_framework_description_3']; 
        $settings->competency_framework_description_4 = $request['competency_framework_description_4']; 

        $settings->save();

        $request->session()->put('siteTitle', $settings->title); 
        
        return redirect('/admin/settings')->with('success', 'Settings have been updated.');
    }
}