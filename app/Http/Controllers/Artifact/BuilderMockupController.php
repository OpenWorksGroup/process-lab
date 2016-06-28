<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
Use Mobile_Detect;

class BuilderMockupController extends Controller
{
	public function index() {
    	$detect = new Mobile_Detect;

    	return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone.mockups' : 'artifact.tabletDesktop.mockups') . '.build')->with('pageTitle','Start Building');   
	}

	public function buildAsk() {
		$detect = new Mobile_Detect;

    	return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone.mockups' : 'artifact.tabletDesktop.mockups') . '.buildAsk')->with('pageTitle','Build -> Ask');   
	}

	public function buildTag() {
		$detect = new Mobile_Detect;

    	return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone.mockups' : 'artifact.tabletDesktop.mockups') . '.tag')->with('pageTitle','Tag'); 
	}
}

