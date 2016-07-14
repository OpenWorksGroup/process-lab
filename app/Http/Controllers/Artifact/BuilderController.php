<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Mobile_Detect;
use App\Template;
use App\TemplateSection;
use App\TemplateCourse;
use App\TemplateRubric;
use App\Content;
use App\ContentStatus;
use Log;

class BuilderController extends Controller
{
	/**
	 * Start page for artifact builder
	 * @param numeric $templateId
	 *
	 * @return view: artifact/phone||tabletDesktop/build.blade.php
	 */

	public function index($templateId) {
    	$detect = new Mobile_Detect;

    	$user = Auth::user();

    	/** retrieve information set in template:
    	*
    	* Course info - one course per template. Add multiple courses logic and display here.
    	* Sections & fields
    	* Rubric
    	*/
    
    	$loadInfo = [];

    	//Get template info - required. 404 if not found.
    	$template = Template::find($templateId);
    	if (!$template) {
    		return response()->view('errors.'.'404');
    	}

    	//Get course info. Course info is not required.
    
    	$templateCourse = TemplateCourse::where('template_id', '=', $templateId)->first();

    	//Checking to see if the user already has content where this template is used
    	$content = Content::where('template_id', '=', $templateId)
    						->where('created_by_user_id', '=', $user->id)
                            ->get();
        $contentId = '';
        $contentTitle = '';
    	if (! empty($content)) {
    		if (count($content) > 1) {
                // To Do: how to handle if user has created more than one artifact per template
                // For now defaulting to first
    			$contentId = $content[0]['id'];
                $contentTitle = $content[0]['title'];
    		}
    		else {
               $contentId = $content[0]['id'];
               $contentTitle = $content[0]['title'];
    		}
    	}

    	if ($templateCourse) {
    		$loadInfo['course_id'] = $templateCourse['course_id'];
    		$loadInfo['course_title'] = $templateCourse['course_title'];
    		$loadInfo['course_url'] = $templateCourse['course_url'];
    	}

    	//Check if Rubric. If so, add link to retrieve rubric. Rubric not required.
    	
    	$templateRubric = TemplateRubric::where('template_id', '=', $templateId)->get();

    	if ($templateRubric) {
    		$loadInfo['rubric_link'] = "/artifact-rubric/".$templateId;
    	}
       // dd($contentId);

    	return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone.mockups' : 'artifact.tabletDesktop') . '.build')->with([
            'pageTitle'=>'Start Building',
            'templateId' => $template->id,
            'content' => $content[0],
            'contentId' => $contentId,
            'contentTitle' => $contentTitle,
            'loadInfo' => $loadInfo
            ]);  
  
	}

	public function store(Request $request) {

        $user = Auth::user();

        $this->validate($request, [
            'title' => 'required|unique:contents,title,NULL,null,created_by_user_id,'.$user->id.''
        ]);

        if ($request['contentId']) {

            $content = Content::find($request['contentId']);
            $content->title = $request['title'];

            $content->save();

            $contentStatus = ContentStatus::where('content_id', '=', $content->id)->first();
            $contentStatus->touch();


            $templateSection = TemplateSection::where('template_id', '=', $request['templateId'])
                                                ->where('order', '=', 1)
                                                ->first();

            return redirect('/artifact/'.$content->id.'/'.$templateSection->id);
        }
        else {

        $content = Content::create([
          'title' => $request['title'],
          'template_id' => $request['templateId'],
          'created_by_user_id' => $user->id
         ]);

        $status = ContentStatus::create([
            'content_id' => $content->id,
            'status' => 'edit'
        ]);

        $templateSection = TemplateSection::where('template_id', '=', $request['templateId'])
                            ->where('order', '=', 1)
                            ->first();

        return redirect('/artifact/'.$content->id.'/'.$templateSection->id);

        }
	}
}
