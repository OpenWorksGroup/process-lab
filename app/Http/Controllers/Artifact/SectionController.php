<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TemplateSection;
use App\TemplateSectionField;
use App\ContentFieldContent;
use App\Content;
use App\ContentStatus;
use App\ContentSectionComment;
use App\Comment;
Use Mobile_Detect;
Use Log;


class SectionController extends Controller
{
    public function edit($contentId,$sectionId) {
        
        if (!$contentId && !$sectionId) {
            return response()->view('errors.'.'404');
        }

        $allComments = Comment::where('content_id', '=', $contentId)->get();
        $commentsCount = count($allComments);

        $user = Auth::user();

        $content = Content::where('id', '=', $contentId)
                            ->where('created_by_user_id', '=', $user->id)
                            ->first();

        if (empty($content)) {
            return response()->view('errors.'.'404');
        }

        $templateId = $content->template_id;
        $contentStatus = ContentStatus::where('content_id', '=', $contentId)->orderBy('updated_at', 'desc')->first();
        $contentTitle = $content['title'];
        $loadInfo['content_status'] = $contentStatus->status;
        $templateSection = TemplateSection::where('id', '=', $sectionId)->first();
        $loadInfo['section_title'] = $templateSection->section_title;
        $fields = TemplateSectionField::where('template_section_id', '=', $sectionId)->get();

        $loadInfo['fields'] = [];
        foreach ($fields as $field){
            $fieldContent = ContentFieldContent::where('content_id', '=', $contentId)
                                                ->where('template_section_field_id', '=', $field->id)
                                                ->get();
             // dd($fieldContent);                                  
            $field['savedContent'] = $fieldContent;
            $loadField = array('field'=>$field);
            array_push($loadInfo['fields'],$loadField);
        }

        $feedbackSetting = [];
        $feedbackSetting['feedbackOn'] = false;
        $contentSectionComment = ContentSectionComment::where('content_id', '=', $contentId)
                                                        ->where('template_section_id', '=', $templateSection->id)
                                                        ->first();
        if (!empty($contentSectionComment)) {
            if ($contentSectionComment->feedback_on == 1) {
                $feedbackSetting['feedbackOn'] = true;
                $feedbackSetting['id'] = $contentSectionComment->id;
            }
        }


       // dd($loadInfo);
       // 
       // 
       $templateSections = TemplateSection::where('template_id', '=', $templateId)
                                                ->where('id', '!=', $sectionId)
                                                ->get();  
      // dd($templateSections); 

       $nextSection = null;
       foreach ($templateSections as $section) {
        if ($section->id > $sectionId) {
            $nextSection = $section;
            break;
        }
       }
      // dd($nextSection->section_title);

       
       $detect = new Mobile_Detect;

       if ($detect->isMobile() && !$detect->isTablet())
       {                                   

        return view('artifact.phone.edit')->with([
            'pageTitle'=>$templateSection->section_title,
            'sectionDescription' => $templateSection->description,
            'loadInfo' => json_encode($loadInfo),
            'contentId' => $contentId,
            'contentTitle' => $contentTitle,
            'sectionId' => $sectionId,
            'sectionsComment' => json_encode($feedbackSetting),
            'otherSections' => $templateSections,
            'buildLink' => "/artifact-edit/".$contentId,
            'tagsLink' => "/artifact-tags/".$contentId,
            'collaborateLink' => "/artifact-collaboration/".$contentId,
            'commentsCount' => $commentsCount,
            'notesLink' => "/artifact-notes/".$contentId,
            'templateId' => $templateId
            ]); 
       }
       else {

        return view('artifact.tabletDesktop.edit')->with([
            'pageTitle'=>$templateSection->section_title,
            'sectionDescription' => $templateSection->description,
            'loadInfo' => json_encode($loadInfo),
            'contentId' => $contentId,
            'contentTitle' => $contentTitle,
            'sectionId' => $sectionId,
            'templateId' => $templateId,
            'sectionsComments' => json_encode($feedbackSetting),
            'commentsCount' => $commentsCount,
            'nextSection' => $nextSection
            ]); 
        }

    }
}
