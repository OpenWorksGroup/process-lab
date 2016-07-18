<?php

namespace App\Http\Controllers\Admin\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\TemplateRubric;
use Log;
use SoftDeletes;

class TemplateRubricController extends Controller
{
	/**
    * Store a template rubric.
    *
    * @param  Request  $request
    * @return TemplateRubric  $rubric
    */
	public function store(Request $request) {

    	$user = Auth::user();

    	if ($request['rubric_id']) {

    		$rubric = TemplateRubric::find($request['rubric_id']);

			if ($request['description_1']) $rubric->description_1 = $request['description_1'];
			if ($request['description_2']) $rubric->description_2 = $request['description_2'];
			if ($request['description_3']) $rubric->description_3 = $request['description_3'];
			if ($request['description_4']) $rubric->description_4 = $request['description_4'];

			$rubric->save();
    	}
    	else {

    		//Log::info($request['framework_id']);

            $rubric = TemplateRubric::create([
                'template_id' => $request['template_id'],
                'competency_framework_id' => $request['framework_id'],
                'competency_framework_category_id' => $request['category_id'],
                'description_1' => $request['description_1'],
                'description_2' => $request['description_2'],
                'description_3' => $request['description_3'],
                'description_4' => $request['description_4'],
                'created_by_user_id' => $user->id,
                'updated_by_user_id' => $user->id
            ]);
    	}

    	return $rubric;

    }

	/**
    * Delete all template rubrics for a given competency framework (CF) and CF category if CF category id is specified.
	* If category id not specified, delete all template rubrics for a given CF and template.
    *
    * @param  Request  $request
    * @return Response
    */
    public function destroy(Request $request) {

    	$input = $request->all();

		//Log::info($input);
		//
		//
		/** Remove one competency category */

		if ($input['category_id'] > 0){

			$rubric = TemplateRubric::where('competency_framework_id', '=', $input['framework_id'])
								->where('competency_framework_category_id', '=', $input['category_id'])
								->first();
			if (empty($rubric)){
				abort(404);
			}

			$rubric -> delete(); //should be soft delete 

			return response()->json(['success' => 'competency deleted.'], 200); 

        }
        else {
        	/** Remove all rubrics for template */

        	$rubrics = TemplateRubric::where('template_id', '=', $input['template_id'])
								->where('competency_framework_id', '=', $input['framework_id'])
								->get();

			if (empty($rubrics)){
				abort(404);
			}				

        	foreach ($rubrics as $rubric) {
            	$rubric -> delete(); //should be soft delete 
        	}
        }

        return response()->json(['success' => 'framework deleted.'], 200); 

    }
}
