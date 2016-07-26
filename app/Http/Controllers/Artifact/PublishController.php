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
use App\Comment;
Use Mobile_Detect;

class PublishController extends Controller
{
	public function index($contentId) {

		$content = Content::find($contentId);

		$allComments = Comment::where('content_id', '=', $contentId)->get();
        $commentsCount = count($allComments);

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

		$displayedContent = [];

		$sections = TemplateSection::where('template_id', '=', $content->template_id)->get();

		foreach($sections as $section) {
			$fields = TemplateSectionField::where('template_section_id', '=', $section->id)
											->get();
			$fieldInfo = [];
			foreach($fields as $field) {
				$contentFields = ContentFieldContent::where('template_section_field_id', '=', $field->id)
													 ->where('content_id', '=', $contentId)
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
					array_push($fieldInfo,Array(
						'field_title' => $field->field_title,
						'text' => $text,
						'links' => $links,
						'files' => json_encode($files)
					));
				}
			}

			// Display sections with content
			if (count($fieldInfo) > 0) {
				array_push($displayedContent,Array(
					'section_title' => $section->section_title,
					'fields' => $fieldInfo
				));
			}
		}	

		$detect = new Mobile_Detect;

		return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.published')->with([
            		'pageTitle'=>$contentTitle,
            		'contentId' => $contentId,
            		'templateId' => $templateId,
            		'contentTitle' => $contentTitle,
            		'contents'=>$displayedContent,
            		'commentsCount' => $commentsCount,
			]); 

	}

    public function store($contentId) {

    	$detect = new Mobile_Detect;
    	$sectionsFieldsRequired = [];
	
		$user = Auth::user();

		$content = Content::find($contentId);

		//check that this user belongs to this content
		
		if ($content->created_by_user_id != $user->id) {
			return response('Unauthorized.', 401);
		}

		//First check to see if the last status on this content is published already
		$checkStatus = ContentStatus::where('content_id', '=', $contentId)->orderBy('updated_at', 'desc')->first();

		if ($checkStatus->status == "published") {
			return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.publishResult')->with([
            					'pageTitle'=>'Published',
            					'contentId' => $contentId,
            					'templateId' => $content->template_id,
            					'contentTitle' => $content->title,
            					'status'=>'published'
			]); 
		}

		$sections = TemplateSection::where('template_id', '=', $content->template_id)->get();


		foreach($sections as $section){
			$fields = TemplateSectionField::where('template_section_id', '=', $section->id)
											->where('required', '=', 1)
											->get();
		

			foreach($fields as $field) {
				$contentFields = ContentFieldContent::where('template_section_field_id', '=', $field->id)
													 ->where('content_id', '=', $contentId)
													 ->get();

				if (count($contentFields) == 0) {
					array_push($sectionsFieldsRequired,Array(
						'section_id'=>$section->id,
						'section_title'=>$section->section_title,
						'field_title' => $field->field_title)
					);
				}
			}
		}

				//	dd($sectionsFieldsRequired);		

		if (empty($sectionsFieldsRequired)) {
		
			$status = ContentStatus::create([
					'content_id' => $contentId,
                	'status' => 'published'
			]);
		
			return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.publishResult')->with([
            					'pageTitle'=>'Published',
            					'contentId' => $contentId,
            					'templateId' => $content->template_id,
            					'contentTitle' => $content->title,
            					'status'=>'published'
			]); 
		}
		else {
			return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.publishResult')->with([
            					'pageTitle'=>'Not Yet Published',
            					'contentId' => $contentId,
            					'templateId' => $content->template_id,
            					'contentTitle' => $content->title,
            					'fieldsMissing' => $sectionsFieldsRequired,
            					'status'=>'edit'
			]); 

		}
	}
}
