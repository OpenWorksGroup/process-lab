<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\TagRelationship;
use App\Review;
use App\ReviewRequest;
use App\ReviewResult;
use App\Comment;
use App\ContentSectionComment;
use App\ContentNote;
use App\ContentStatus;
use App\ContentFieldContent;
use App\Content;

class DeleteArtifactController extends Controller
{
	public function update($contentId) {

		/**
	 	* TagRelationship - content_id
	 	* ReviewRequest - content_id
	 	* Review - content_id
	 	* ReviewResult - review_id
	 	* Comment - content_id
	 	* ContentSectionComment - content_id
	 	* ContentNote - content_id
	 	* ContentStatus - content_id
	 	* ContentFieldContent - content_id
	 	* Content - request id
	 	*/
	 
	 	//softdelete all artifact content
	 	TagRelationship::where('content_id', '=', $contentId)->delete();
	 	ContentNote::where('content_id', '=', $contentId)->delete();
	 	Comment::where('content_id', '=', $contentId)->delete();
	 	ContentSectionComment::where('content_id', '=', $contentId)->delete();
	 	ContentNote::where('content_id', '=', $contentId)->delete();
	 	ContentStatus::where('content_id', '=', $contentId)->delete();
	 	ContentFieldContent::where('content_id', '=', $contentId)->delete();
	 	Content::where('id', '=', $contentId)->delete();
		ReviewRequest::where('content_id', '=', $contentId)->delete();

	 	$reviews = Review::where('content_id', '=', $contentId)->get();

	 	foreach ($reviews as $review) {
			ReviewResult::where('review_id', '=', $review->id)->delete();
	 	}

		Review::where('content_id', '=', $contentId)->delete();
		ReviewRequest::where('content_id', '=', $contentId)->delete();
	
		return redirect('/dashboard')->with('success', 'Content has been deleted');
	}
    
}
