<?php

namespace App\Http\Controllers\Admin\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingsController extends Controller
{
	/**
    * Read all settings.
    *
    * @param  Request  $request
    * @return array  $settings
    */
	public function index(Request $request)
    {
   		$settings = Setting::all()->first();
   		return $settings;
   	}
}
