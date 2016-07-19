<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Template;

class BuildListController extends Controller
{
	public function index(Request $request) {

		 //Add order by
        $templates = Template::all();
        
   		return view('dashboard.buildList')->with([
            'templates' => $templates,
			'pageTitle'=>"Build"
        ]);       
   	}
}
