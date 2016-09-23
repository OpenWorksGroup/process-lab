<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Bouncer;
use Log;
use App\Content;
use App\TagRelationship;
use App\Tag;
use App\ContentStatus;
use App\TemplateSection;
use App\ContentSectionComment;
use App\Comment;
use App\User;
use App\ReviewRequest;
use App\Review;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();
        $workInProgress = [];
        $published = [];
        $feedbackNeeded = [];
        $reviewsNeeded = [];
        $publishedResources = [];

        $resources = Content::all()->sortByDesc('updated_at');
        foreach($resources as $resource) {
            $resourceStatus = ContentStatus::where('content_id', '=', $resource->id)->first();

            if ($resourceStatus && $resourceStatus->status == "published") {

                $userTagRels = TagRelationship::where('user_id', '=', $resource->created_by_user_id)->get();
                $userTagsList = [];
                foreach($userTagRels as $rel) {
                    $tag = Tag::where('id', '=', $rel->tag_id)
                                ->where('type', '=', 'user')
                                ->first();
                    if ($tag) {
                        array_push($userTagsList,$tag->tag);
                    }
                    
                }

                $tagRels = TagRelationship::where('content_id', '=', $resource->id)->get();
                $tagsList = [];
                foreach($tagRels as $rel) {
                    $tag = Tag::where('id', '=', $rel->tag_id)->first();
                    if ($tag) {
                        array_push($tagsList,$tag->tag);
                    }
                    
                }

                $author = User::find($resource->created_by_user_id);

                array_push($publishedResources,Array(
                    'id' => $resource->id,
                    'title' => $resource->title,
                    'author' => $author->name,
                    'publishDate' => date('F, j, Y', $resourceStatus->updated_at->getTimestamp()),
                    'userTags' => implode(",", $userTagsList),
                    'tags' => implode(", ", $tagsList)
                ));
            }

        }

       // dd($publishedResources);

        $contents = Content::where('created_by_user_id', '=', $user->id)->get();
        
        foreach($contents as $content) {
            $contentStatus = ContentStatus::where('content_id', '=', $content->id)
                                            ->orderBy('updated_at','desc')
                                            ->first();
            if ($contentStatus) $content->status = $contentStatus->status;

            $reviewCheck = Review::where('content_id','=', $content->id)->get();

            if (count($reviewCheck) > 0) {
                $content['reviewsLink'] = "/artifact-reviews/".$content->id;
            }

            if ($contentStatus &&
                ($contentStatus->status == "edit" || 
                $contentStatus->status == "peer review" ||
                $contentStatus->status == "expert review")) {
                array_push($workInProgress,$content);

            }
            elseif ($contentStatus && $contentStatus->status == "published") {
                array_push($published,$content);
            }

            $commentsCheck = Comment::where('content_id','=', $content->id)->get();

            if (count($commentsCheck) > 0) {
                $content['commentsCount'] = count($commentsCheck);
            }

        }

        // Get Collaborative feedback
        $feedback = ContentSectionComment::where('feedback_on', '=', 1)->get();

        if ($feedback) {
            foreach ($feedback as $item){
                $content = Content::where('id', '=', $item->content_id)->orderBy('updated_at','desc')->first();
                $content['section_id'] = $item->template_section_id;
                $section = TemplateSection::find($item->template_section_id);
                $content['section_title'] = $section->section_title;
                $author = User::find($content->created_by_user_id);
                $content['author'] = $author->name;

                //Don't include content for this user
                if ($content->created_by_user_id != $user->id) {
                    array_push($feedbackNeeded,$content);
                }
            }
        }

        // Get Reviews Needed
        $reviews = ReviewRequest::where('reviewed_count', '<', 3)
                                ->where('user_id', '!=', $user->id)
                                ->get();

        if ($reviews) {
            foreach ($reviews as $review){

                // Don't show if this user already submitted a review
                $reviewSubmittedCheck = Review::where('content_id','=', $review->content_id)
                                        ->where('user_id','=', $user->id)
                                        ->first();
                if (! $reviewSubmittedCheck) {
                    $content = Content::where('id', '=', $review->content_id)->orderBy('updated_at','desc')->first();
                    $author = User::find($content->created_by_user_id);
                    $content['author'] = $author->name;

                    array_push($reviewsNeeded,$content);
                }
            }
        }

        return view('dashboard')->with([
			'pageTitle'=>$user->name." Dashboard",
            'userName'=>$user->name,
            'resources'=>$publishedResources,
            'resourcesSearch'=>json_encode($publishedResources),
            'rCount'=> count($publishedResources),
			'workInProgress' => $workInProgress,
            'wipCount' =>count($workInProgress),
            'published' => $published,
            'pCount' =>count($published),
            'feedback' =>$feedbackNeeded,
            'fCount' => count($feedbackNeeded),
            'reviews' => $reviewsNeeded,
            'rCount' => count($reviewsNeeded)
        ]);             
    }
}
