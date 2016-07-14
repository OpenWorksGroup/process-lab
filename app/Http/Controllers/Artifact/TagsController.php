<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Content;
use App\Tag;
use App\TagRelationship;
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

        return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.tags')->with([
            'pageTitle'=>"Tags",
            'contentId' => $contentId,
            'templateId' => $content->template_id,
            'contentTitle' => $content->title,
            'tags' => json_encode($tags)
        ]); 
    }
}
