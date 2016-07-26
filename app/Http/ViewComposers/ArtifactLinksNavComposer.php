<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Template;
use App\TemplateSection;
use App\Comment;

class ArtifactLinksNavComposer
{

    /**
     * Retrieve Sections info for Tablet/Desktop Artifact Navigation
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $templateId = $view->getData()['templateId'];
        $contentId = $view->getData()['contentId'];
        $templateSections = TemplateSection::where('template_id', '=', $templateId)->get();
        $comments = Comment::where('content_id', '=', $contentId)->get();
        $commentsCount = count($comments);

        $view->with([
            'sections' => $templateSections,
            'contentId' => $contentId,
            'templateId' => $templateId,
            'commentsCount' => $commentsCount
            ]);
    }
            
}