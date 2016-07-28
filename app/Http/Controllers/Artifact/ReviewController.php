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
use App\ReviewResult;
use App\TemplateRubric;
use App\Review;

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

    public function index($contentId) {

		$content = Content::find($contentId);

		$reviewsDisplay = [];
		$reviews = Review::where('content_id','=',$contentId)->get();

		if (count($reviews) > 0) {
			foreach ($reviews as $review) {
				$resultsData = [];
				$reviewResults = ReviewResult::where('review_id','=',$review->id)->get();

				foreach ($reviewResults as $result) {
					foreach(json_decode($result->results) as $item) {
						$rubric = TemplateRubric::where('competency_framework_category_id','=',$item->category_id)->first();
						$descriptionField = 'description_'.$item->score;
						array_push($resultsData,Array(
							'competency' => $item->competency,
							'description' => $rubric[$descriptionField]
							));
					}

					array_push($reviewsDisplay,Array(
							'comment' => $review->comment,
							'data' => $resultsData
						));
				}
			}

			//dd($reviewsDisplay);
		}

		/*
		
		for each review display:
		competency result description
		 */


		$detect = new Mobile_Detect;

		return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.viewReviews')->with([
            'pageTitle'=>$content->title.' Reviews',
            'templateId' => $content->template_id,
            'contentId' => $contentId,
            'contentTitle' => $content->title,
            'reviewContent' => $reviewsDisplay,
            'buildLink' => "/artifact-edit/".$contentId,
            'tagsLink' => "/artifact-tags/".$contentId,
            'collaborateLink' => "/artifact-collaboration/".$contentId,
            'notesLink' => "/artifact-notes/".$contentId,
            ]);  
    }
}
