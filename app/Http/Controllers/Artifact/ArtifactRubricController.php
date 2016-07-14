<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TemplateRubric;
use App\CompetencyFrameworkCategory;
use App\CompetencyFramework;
use App\Setting;
use Log;

class ArtifactRubricController extends Controller
{
	public function index($templateId) {

		$templateRubric = TemplateRubric::where('template_id', '=', $templateId)->get();
		$framework = CompetencyFramework::find($templateRubric[0]->competency_framework_id);
		$settings = Setting::all()->first();
		$competencyHeaders = array(
			$settings->competency_framework_description_1,
			$settings->competency_framework_description_2,
			$settings->competency_framework_description_3,
			$settings->competency_framework_description_4,
			);
		
		$rubricResult=[];
		foreach ($templateRubric as $rubric){
			//Log::info("competency_framework_category_id ".$rubric->competency_framework_category_id);
			$category = CompetencyFrameworkCategory::where('id',$rubric->competency_framework_category_id)->first();
			//Log::info("category ".$category['category']);
			$categoryName = $category['category'];

			array_push($rubricResult,array('rubric'=>$rubric,'category'=>$categoryName));
		}

		//dd($rubricResult);

		//$isPhone = ($detect->isMobile() && !$detect->isTablet()) ? true:false;

		return view('artifact.Rubric')->with([
            'pageTitle'=>'Competency Rubric',
            'framework' => $framework->framework,
            'competencyHeaders' => $competencyHeaders,
            'rubrics' => $rubricResult
           // 'is_phone => $isPhone
        ]);  
	}
}
