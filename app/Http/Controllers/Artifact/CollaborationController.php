<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ContentSectionComment;
use App\Content;
use App\TemplateSection;
use App\TemplateSectionField;
use App\ContentFieldContent;
use App\Comment;
use App\User;
Use Mobile_Detect;

class CollaborationController extends Controller
{
	public function index($contentId) {
		$content = Content::find($contentId);
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

		$detect = new Mobile_Detect;

		return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.viewFeedback')->with([
            'pageTitle'=>$content->title.' Feedback',
            'templateId' => $content->template_id,
            'contentId' => $contentId,
            'contentTitle' => $content->title,
			'sectionsFeedback' => $sectionsFeedback,
            'sections' => $sections,
            'buildLink' => "/artifact-edit/".$contentId,
            'tagsLink' => "/artifact-tags/".$contentId,
            'collaborateLink' => "/artifact-collaboration/".$contentId,
            'commentsCount' => $commentsCount,
            'notesLink' => "/artifact-notes/".$contentId,
            ]);  
	}

    public function edit($contentId,$sectionId) {
        
        if (!$contentId && !$sectionId) {
            return response()->view('errors.'.'404');
        }

        $feedback = ContentSectionComment::where('content_id', '=', $contentId)
        									->where('feedback_on', '=', 1)
       									 	->get();

       	$content = Content::find($contentId);
       	$templateSection = TemplateSection::where('id', '=', $sectionId)->first();
       	$loadInfo['section_title'] = $templateSection->section_title;
       	$fields = TemplateSectionField::where('template_section_id', '=', $sectionId)->get();

		$loadInfo['fields'] = [];
       	foreach ($fields as $field){
            $contentFields = ContentFieldContent::where('content_id', '=', $contentId)
                                                ->where('template_section_field_id', '=', $field->id)
                                                ->get();
            $text = [];
			$links = [];
			$files = [];
			foreach($contentFields as $contentField) {
				if ($contentField->type == "text") {
					array_push($text,$contentField);
				}
				else if ($contentField->type == "link") {
					array_push($links,$contentField);
				}
				else {
					array_push($files,$contentField);
				}	
			}
			if (count($contentFields) > 0 ) {
				array_push($loadInfo['fields'],Array(
					'field_title' => $field->field_title,
					'text' => $text,
					'links' => $links,
					'files' => json_encode($files)
				));
			}

        }

        $comments = [];
        $retrieveComments = Comment::where('content_id', '=', $contentId)
        					->where('template_section_id', '=', $sectionId)
        					->orderBy('updated_at','desc')
        					->get();

        foreach ($retrieveComments as $comment) {
        	// add tags/profile url here
        	$user = User::find($comment->user_id);

        	array_push($comments,Array(
        		'userName' => $user->name,
        		'comment'=>$comment->comment,
        		'comment_date' => date('F, j, Y', $comment->created_at->getTimestamp())
        	));
        }

        // change this to react so that it's in real time. Same for dashboard.

        return view('artifact.collaborationEdit')->with([
			'pageTitle'=>'Add Feedback to '.$content->title.' - '.$loadInfo['section_title'],
			'feedback'=>$feedback,
            'loadInfo'=>$loadInfo,
			'comments' => $comments,
			'contentId' => $contentId,
			'sectionId' => $sectionId
        ]);
    }

    public function store(Request $request) {

    	$user = Auth::user();

    	$this->validate($request, [
               'comment' => 'required'
        ]);

        $contentId = $request['contentId'];
        $sectionId = $request['sectionId'];

        //add purifier here - maybe react wysiwig
        $comment = Comment::create([
			'content_id' => $contentId,
			'user_id' => $user->id,
			'template_section_id' => $request['sectionId'],
			'comment' => $request['comment']
		]);

		return redirect('/artifact-collaboration/'.$contentId.'/'.$sectionId)->with('success', 'Your feedback has been added.');

    }
}
