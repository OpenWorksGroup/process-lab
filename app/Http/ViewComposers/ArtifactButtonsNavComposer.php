<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\TemplateRubric;


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
        $templateRubric = TemplateRubric::where('template_id', '=', $templateId)->get();

        $view->with([
            'templateId' => $templateId,
            'rubric' => $templateRubric
            ]);
    }
            
}