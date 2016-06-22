<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TemplateSectionField;

use Log;

/** To do 
* 1) Add errors & success
* 2) Field not consistently maintaining it's section_id
**/

class TemplateSectionFieldController extends Controller
{
	public function store(Request $request)
    {

    	Log::info($request);

    	$user = Auth::user();

    	if ($request['field_id']) {

    		$templateSectionField = TemplateSectionField::find($request['field_id']);

			if ($request['field_title']) {
				if ($request['field_title'] != $templateSectionField->field_title) {
					$this->validate($request, [
                	'field_title' => 'filled' //add unique per template validation
            		]); 
					$templateSectionField->field_title = $request['field_title'];
				}
			}
			//if ($request['field_description']) $templateSectionField->description = $request['field_description'];

			if ($request['field_required']) {
				if ($request['field_required'] == "true") {
					$request['field_required'] = 1;
				}
				else {
					$request['field_required'] = 0;
				}

				$templateSectionField->required = $request['field_required'];
			}

			//if ($request['field_required']) {

			$templateSectionField->save();
    	}
    	else {

    		Log::info($request['field_title']);

    		$this->validate($request, [
                'field_title' => 'required' //add unique per template validation
            ]); 

            $templateSectionField = TemplateSectionField::create([
                'field_title' => $request['field_title'],
                'template_id' => $request['template_id'],
                'template_section_id' => $request['field_section_id'],
                'order' => $request['order'],
                'created_by_user_id' => $user->id,
                'updated_by_user_id' => $user->id,
            ]);
    	}

    	return $templateSectionField;

    }
}
