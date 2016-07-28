<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Content;
use App\ContentStatus;
Use Mobile_Detect;
use App\Classes\CheckRequiredFieldsClass;
use App\ReviewRequest;

class ReviewController extends Controller
{
    public function store($contentId) {

    	$detect = new Mobile_Detect;

    	$content = Content::find($contentId);
	
		$user = Auth::user();

		//check that this user belongs to this content
		
		if ($content->created_by_user_id != $user->id) {
			return response('Unauthorized.', 401);
		}

		$sectionsFieldsRequired = CheckRequiredFieldsClass::check($content);	
		$title = "Not Ready for Review Yet";	

		//Check to see if the the review request has already been submitted
		$checkReviewQueue = ReviewRequest::where('content_id', '=', $contentId)->first();

		if ($checkReviewQueue) {
			$title = "Review Submitted";
			return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.reviewResult')->with([
            		'pageTitle'=> $title,
            		'contentId' => $contentId,
            		'templateId' => $content->template_id,
            		'contentTitle' => $content->title,
            		'fieldsMissing' => $sectionsFieldsRequired,
            		'status'=>'edit'
			]);
		}

		if (empty($sectionsFieldsRequired)) {
			$title = "Review Submitted";
			$submitReview = ReviewRequest::create([
					'content_id' => $contentId,
                	'user_id' => $user->id
			]);

		}
		
		return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.reviewResult')->with([
            		'pageTitle'=> $title,
            		'contentId' => $contentId,
            		'templateId' => $content->template_id,
            		'contentTitle' => $content->title,
            		'fieldsMissing' => $sectionsFieldsRequired,
            		'status'=>'edit'
		]);

    }
}
