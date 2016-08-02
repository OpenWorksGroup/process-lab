<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Content;
use App\Classes\RetrieveArtifactContentClass;
use App\TemplateRubric;
use App\TemplateSection;
use App\Comment;
use App\User;
use App\CompetencyFrameworkCategory;
use App\Setting;
use App\Review;
use App\ReviewResult;
use App\ReviewRequest;
use Validator;
use Purifier;
Use Mobile_Detect;

class ReviewerController extends Controller
{
   public function edit($contentId) {
        $user = Auth::user();
        $detect = new Mobile_Detect; 

        $content = Content::find($contentId);
        $contentTitle = $content->title;
        $templateRubric = TemplateRubric::where('template_id', '=', $content->template_id)->get();
        $rubricLink = "/artifact-rubric/".$content->template_id;
        $displayedContent = RetrieveArtifactContentClass::retrieve($content);

        $settings = Setting::all()->first();
        $competencyHeaders = array(
            $settings->competency_framework_description_1,
            $settings->competency_framework_description_2,
            $settings->competency_framework_description_3,
            $settings->competency_framework_description_4,
        );
        
        $rubricResult=[];
        foreach ($templateRubric as $rubric){
            $category = CompetencyFrameworkCategory::where('id',$rubric->competency_framework_category_id)->first();
            array_push($rubricResult,array(
                'category'=>$category['category'], 
                'category_id'=>$category['id']));
        }

        // Check that user hasn't already submitted a review
        $alreadySubmitted = "";
        $reviewSubmittedCheck = Review::where('content_id','=', $contentId)
                                        ->where('user_id','=', $user->id)
                                        ->first();
        if ($reviewSubmittedCheck) {
            $alreadySubmitted = "You've already submitted this review.";
        }

        //Get Feedback - To Do: consolidate this into a view composer with collaborationController

        $sections = TemplateSection::where('template_id', '=', $content->template_id)->get();

        $allComments = Comment::where('content_id', '=', $contentId)->get();
        $commentsCount = count($allComments);

        $sectionsFeedback = [];
        foreach($sections as $section) {

            $comments = [];
            $retrieveComments = Comment::where('content_id', '=', $contentId)
                                        ->where('template_section_id', '=', $section->id)
                                        ->orderBy('updated_at','desc')
                                        ->get();
            

            if (count($retrieveComments) > 0) {
                foreach ($retrieveComments as $comment) {
                    // add tags/profile url here
                    $user = User::find($comment->user_id);

                    array_push($comments,Array(
                        'userName' => $user->name,
                        'comment'=>$comment->comment,
                        'comment_date' => date('F, j, Y', $comment->created_at->getTimestamp())
                    ));
                }

                array_push($sectionsFeedback,Array(
                    'sectionTitle' => $section->section_title,
                    'comments' => $comments
                ));
            }
        }


        return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.reviewForm')->with([
            'pageTitle'=> "Review ".$contentTitle,
            'contentId' => $contentId,
            'contentTitle' => $contentTitle,
            'contents'=> $displayedContent,
            'sectionsFeedback' => $sectionsFeedback,
            'rubricLink'=>$rubricLink,
            'competencyHeaders' => $competencyHeaders,
            'rubrics' => $rubricResult,
            'alreadySubmitted' => $alreadySubmitted
        ]);
    }

    public function store(Request $request) {
        $user = Auth::user();
        $contentId = $request['contentId'];
        $content = Content::find($contentId);
        $templateRubric = TemplateRubric::where('template_id', '=', $content->template_id)->get();

        // Check that user hasn't already submitted a review
        $reviewSubmittedCheck = Review::where('content_id','=', $contentId)
                                        ->where('user_id','=', $user->id)
                                        ->first();
        if ($reviewSubmittedCheck) {
            return redirect('/submit-review/'.$contentId)->with('alreadySubmitted', "You've already submitted this review.");
        }                               

        $results = [];
        $totalScore = '';
        foreach ($templateRubric as $rubric){
            $result = [];
            $category = CompetencyFrameworkCategory::where('id',$rubric->competency_framework_category_id)->first();
            $attributeNames = array(
                'category_'.$category->id => $category->category
            ); 

            $validator = Validator::make($request->all(), ['category_'.$category->id => 'required']);
            $validator->setAttributeNames($attributeNames); 

            if ($validator->fails()) {
                return redirect('/submit-review/'.$contentId)
                    ->withErrors($validator)
                    ->withInput();
            }

            //gather results
            
            $result['category_id'] = $category->id;
            $result['competency'] = $category->category;
            $result['score'] = $request['category_'.$category->id];
            $totalScore += $result['score'];

            array_push($results,$result);
            
        }
        //Comment required

        $this->validate($request, [
               'comment' => 'required'
        ]);

        $comment = Purifier::clean($request['comment']);

        $review = Review::create([
            'content_id' => $contentId,
            'user_id' => $user->id,
            'comment' => $comment
        ]);

        $reviewResult = ReviewResult::create([
            'review_id' => $review->id,
            'results' => json_encode($results)
        ]);

        $reviewRequest = ReviewRequest::where('content_id','=', $contentId)->first();
        $reviewRequest->reviewed_count = $reviewRequest->reviewed_count + 1;
        $reviewRequest->save();


        return redirect('/submit-review/'.$contentId)->with('success', 'Review Submitted!');
   }
}
