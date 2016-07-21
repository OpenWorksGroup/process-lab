<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Content;
use App\Tag;
use App\TagRelationship;
use App\TemplateSection;
Use Mobile_Detect;

class TagsController extends Controller
{
	public function edit($contentId) {
        
        if (!$contentId) {
            return response()->view('errors.'.'404');
        }

        $content = Content::find($contentId);
        $tagRelSearch = TagRelationship::where('content_id', '=', $contentId)->get();

        $tags = [];
        if ($tagRelSearch) {
            foreach ($tagRelSearch as $tagRel){
                $tagSearch = Tag::find($tagRel['tag_id']);
                array_push($tags,$tagSearch['tag']);
            }
        }

        $detect = new Mobile_Detect;

        if ($detect->isMobile() && !$detect->isTablet())
       {
            
            $templateSections = TemplateSection::where('template_id', '=', $content->template_id)->get();

       // dd($templateSections);

            return view('artifact.phone.tags')->with([
                'pageTitle'=>"Tags",
                'contentId' => $contentId,
                'templateId' => $content->template_id,
                'contentTitle' => $content->title,
                'tags' => json_encode($tags),
                'otherSections' => $templateSections,
                'buildLink' => "/artifact-builder/".$content->template_id,
                'tagsLink' => "/artifact-tags/".$content->template_id,
                'collaborateLink' => "",
                'notesLink' => "/artifact-notes/".$contentId,
            ]); 
        }
        else {

            return view('artifact.tabletDesktop.tags')->with([
                'pageTitle'=>"Tags",
                'contentId' => $contentId,
                'templateId' => $content->template_id,
                'contentTitle' => $content->title,
                'tags' => json_encode($tags)
            ]); 
        }
    }
}