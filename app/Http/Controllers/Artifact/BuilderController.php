<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Mobile_Detect;

class BuilderController extends Controller
{
	public function index() {
    	$detect = new Mobile_Detect;

    	return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.builder1')->with('pageTitle','Artifact Builder');   

    	//return View::make( ($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.builder1' );
	}
}
