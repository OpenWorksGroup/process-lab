<?php

namespace App\Classes;
use App\TemplateSection;
use App\TemplateSectionField;
use App\ContentFieldContent;
use Log;

class CheckRequiredFieldsClass {   
    public static function check($content) {
        $sectionsFieldsRequired = [];
        $contentId = $content->id;

        $sections = TemplateSection::where('template_id', '=', $content->template_id)->get();

        foreach($sections as $section){
            $fields = TemplateSectionField::where('template_section_id', '=', $section->id)
                                            ->where('required', '=', 1)
                                            ->get();

            foreach($fields as $field) {
                $contentFields = ContentFieldContent::where('template_section_field_id', '=', $field->id)
                                                    ->where('content_id', '=', $contentId)
                                                    ->get();

                
                // If there are no fields, requirement hasn't been met
                if (count($contentFields) == 0) {
                    array_push($sectionsFieldsRequired,Array(
                        'section_id'=>$section->id,
                        'section_title'=>$section->section_title,
                        'field_title' => $field->field_title)
                    );
                }

                foreach($contentFields as $content) {
                    // if the content field is null, also requirement hasn't been met
                    if (($content->type == "text" && $content->content == '') || 
                        ($content->type != "text" && $content->uri == '' )) {
                        if (! array_search($field->field_title, array_column($sectionsFieldsRequired, 'field_title'))) {
                            array_push($sectionsFieldsRequired,Array(
                                'section_id'=>$section->id,
                                'section_title'=>$section->section_title,
                                'field_title' => $field->field_title)
                            );
                        }
                    }    
                }
            }
        }

        return $sectionsFieldsRequired;
    }
}