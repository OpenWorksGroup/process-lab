<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ContentSectionComment;
use Log;

class ContentSectionCommentController extends Controller
{
	public function store(Request $request) {

		$feedbackSwitch = 0;

		if ($request['feedback_on'] == "true") {
			$feedbackSwitch = 1;
		}
		else {
			$feedbackSwitch = 0;
		}

		if ($request['id']) {

			$contentSectionComments = ContentSectionComment::find($request['id']);
			$contentSectionComments->feedback_on = $feedbackSwitch;
			$contentSectionComments->save();

			return $contentSectionComments;		
		}
		else {

			$contentSectionComments = ContentSectionComment::create([
          		'content_id' => $request['content_id'],
          		'template_section_id' => $request['template_section_id'],
          		'feedback_on' => $feedbackSwitch
         	]);

         	return $contentSectionComments;

		}

	}
}
