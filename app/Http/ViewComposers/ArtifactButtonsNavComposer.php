<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\TemplateRubric;
use App\ContentStatus;

class ArtifactButtonsNavComposer
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
        $templateRubric = TemplateRubric::where('template_id', '=', $templateId)->get();
        $checkStatus = ContentStatus::where('content_id', '=', $contentId)->first();

        $view->with([
            'templateId' => $templateId,
            'rubric' => $templateRubric,
            'status' => $checkStatus->status
            ]);
    }
            
}