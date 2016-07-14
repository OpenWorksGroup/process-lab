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
Use Mobile_Detect;


class SectionController extends Controller
{
    public function edit($contentId,$sectionId) {
        
        if (!$contentId && !$sectionId) {
            return response()->view('errors.'.'404');
        }

        $user = Auth::user();

        $content = Content::where('id', '=', $contentId)
                            ->where('created_by_user_id', '=', $user->id)
                            ->first();

        if (empty($content)) {
            return response()->view('errors.'.'404');
        }

        $templateId = $content->template_id;
        $contentStatus = ContentStatus::where('content_id', '=', $contentId)->first();
        $contentTitle = $content['title'];
        $loadInfo['content_status'] = $contentStatus->status;
        $templateSections = TemplateSection::where('id', '=', $sectionId)->first();
        $loadInfo['section_title'] = $templateSections->section_title;
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


       // dd($loadInfo);
       
       $detect = new Mobile_Detect;

        return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.edit')->with([
            'pageTitle'=>$templateSections->section_title,
            'sectionDescription' => $templateSections->description,
            'loadInfo' => json_encode($loadInfo),
            'contentId' => $contentId,
            'contentTitle' => $contentTitle,
            'sectionId' => $sectionId,
            'templateId' => $templateId
            ]); 

    }
}
