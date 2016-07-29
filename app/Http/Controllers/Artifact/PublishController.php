<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Content;
use App\ContentStatus;
use App\TemplateSection;
use App\TemplateSectionField;
use App\ContentFieldContent;
Use Mobile_Detect;
use Log;
use App\Classes\CheckRequiredFieldsClass;
use App\Classes\RetrieveArtifactContentClass;

class PublishController extends Controller
{
	public function index($contentId) {

		$content = Content::find($contentId);

		//Check to see if content has been published at least once
		$publishedStatus = false;
		$checkStatus = ContentStatus::where('content_id', '=', $contentId)->get();
		foreach($checkStatus as $check) {
			if ($check->status == "published") {
				$publishedStatus = true;
			}
		}

		//if not - 404
	
		if ($publishedStatus == false) {
			return response()->view('errors.'.'404');
		}

		$templateId = $content->template_id;
		$contentTitle = $content->title;

		$displayedContent = RetrieveArtifactContentClass::retrieve($content);

		$detect = new Mobile_Detect;

		return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.published')->with([
            		'pageTitle'=>$contentTitle,
            		'contentId' => $contentId,
            		'templateId' => $templateId,
            		'contentTitle' => $contentTitle,
            		'contents'=>$displayedContent
			]); 

	}

    public function store($contentId) {

    	$detect = new Mobile_Detect;

    	$content = Content::find($contentId);
	
		$user = Auth::user();

		$content = Content::find($contentId);

		//check that this user belongs to this content
		
		if ($content->created_by_user_id != $user->id) {
			return response('Unauthorized.', 401);
		}

		//First check to see if the last status on this content is published already
		$checkStatus = ContentStatus::where('content_id', '=', $contentId)->first();

		if ($checkStatus->status == "published") {
			return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.publishResult')->with([
            					'pageTitle'=>'Published',
            					'contentId' => $contentId,
            					'templateId' => $content->template_id,
            					'contentTitle' => $content->title,
            					'status'=>'published'
			]); 
		}

		$sectionsFieldsRequired = CheckRequiredFieldsClass::check($content);

		$title = "Not Yet Published";	
		$status = "edit";

		if (empty($sectionsFieldsRequired)) {

			$title = "Published";
			$status = "published";

 			$checkStatus->status = $status;
 			$checkStatus->save();
		}
		
		return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.publishResult')->with([
            			'pageTitle'=> $title,
            			'contentId' => $contentId,
            			'templateId' => $content->template_id,
            			'contentTitle' => $content->title,
            			'fieldsMissing' => $sectionsFieldsRequired,
            			'status'=>$status
		]); 

	}
}
