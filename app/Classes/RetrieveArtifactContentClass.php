<?php

namespace App\Classes;
use App\TemplateSection;
use App\TemplateSectionField;
use App\ContentFieldContent;
use Log;

class RetrieveArtifactContentClass {  

	public static function retrieve($content) {
		$templateId = $content->template_id;
		$displayedContent = [];

		$sections = TemplateSection::where('template_id', '=', $content->template_id)->get();

		foreach($sections as $section) {
			$fields = TemplateSectionField::where('template_section_id', '=', $section->id)
											->get();
			$fieldInfo = [];
			foreach($fields as $field) {
				$contentFields = ContentFieldContent::where('template_section_field_id', '=', $field->id)
													 ->where('content_id', '=', $content->id)
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
					else if ($contentField->type == "image" || $contentField->type == "file"){
						if (!empty($contentField)) {	
							array_push($files,$contentField);
						}
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

			//dd($fieldInfo);

			// Display sections with content
			if (count($fieldInfo) > 0) {
				array_push($displayedContent,Array(
					'section_title' => $section->section_title,
					'fields' => $fieldInfo
				));
			}
		}

		return $displayedContent;
	}
}