<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingsEditController extends Controller
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
            
        $settings = Setting::all()->first();
        $settings->title = $request['title'];
        $settings->lti_consumer_name = $request['lti_consumer_name'];
        $settings->lti_consumer_key = $request['lti_consumer_key'];
        $settings->lti_secret = $request['lti_secret'];           
        $settings->save();
        
        return redirect('/admin/settings')->with('success', 'Settings have been updated.');
    }
}
