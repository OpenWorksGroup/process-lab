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
use App\Comment;
use Log;

class BuilderController extends Controller
{
	/**
	 * Display Start page for artifact builder.
     *
	 * @param  numeric  $templateId
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

    	if ($templateCourse) {
    		$loadInfo['course_id'] = $templateCourse['course_id'];
    		$loadInfo['course_title'] = $templateCourse['course_title'];
    		$loadInfo['course_url'] = $templateCourse['course_url'];
    	}

    	//Check if Rubric. If so, add link to retrieve rubric. Rubric not required.
    	
    	$templateRubric = TemplateRubric::where('template_id', '=', $templateId)->get();

    	if (! $templateRubric->isEmpty()) {
    		$loadInfo['rubric_link'] = "/artifact-rubric/".$templateId;
    	}

    	return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.build')->with([
            'pageTitle'=>'Start Building',
            'templateId' => $template->id,
            'contentId' => null,
            'loadInfo' => $loadInfo
            ]);  
  
	}

    /**
	 * Store content.
     *  - if new content, store new content and content status information.
     *  - if already exists, update content and content status information.
     *
	 * @param  Request  $request
	 * @return view: artifact/phone||tabletDesktop/edit.blade.php
	 */
	public function store(Request $request) {

        $user = Auth::user();

        $this->validate($request, [
            'title' => 'required|unique:contents,title,NULL,id,created_by_user_id,'.$user->id.''
        ]);

        if ($request['contentId']) {

            $content = Content::find($request['contentId']);
            $content->title = $request['title'];

            $content->save();

            $status = ContentStatus::create([
                'content_id' => $content->id,
                'status' => 'edit'
            ]);


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

    public function edit($contentId){
        $detect = new Mobile_Detect;

        $user = Auth::user();

        /** retrieve information set in template:
        *
        * Course info - one course per template. Add multiple courses logic and display here.
        * Sections & fields
        * Rubric
        */

        $content = Content::find($contentId);
        $template = Template::find($content->template_id);

        //Get course info. Course info is not required.   
        $templateCourse = TemplateCourse::where('template_id', '=', $content->template_id)->first();

        $courseId = "";
        $courseTitle = "";
        $courseUrl = "";
        if ($templateCourse) {
            $courseId = $templateCourse['course_id'];
            $courseTitle = $templateCourse['course_title'];
            $courseUrl = $templateCourse['course_url'];
        }

        //Check if Rubric. If so, add link to retrieve rubric. Rubric not required.    
        $templateRubric = TemplateRubric::where('template_id', '=', $content->template_id)->get();

        $rubricLink = "";
        if (! $templateRubric->isEmpty()) {
            $rubricLink = "/artifact-rubric/".$content->template_id;
        }

        // Get Template Sections for phone
        $templateSections = TemplateSection::where('template_id', '=', $content->template_id)
                                                ->get();

        // Count comments if any yet - only used for phone view - check other artifact controllers when cleaning up
        
        $comments = Comment::where('content_id', '=', $contentId)->get();

        $commentsCount = count($comments);

        return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.buildEdit')->with([
            'pageTitle'=>'Edit '.$content->title,
            'templateId' => $template->id,
            'contentId' => $contentId,
            'contentTitle' => $content->title,
            'content' => $content,
            'courseId' => $courseId,
            'courseTitle' => $courseTitle,
            'courseUrl' => $courseUrl,
            'rubricLink' => $rubricLink,
            'sections' => $templateSections,
            'buildLink' => "/artifact-edit/".$contentId,
            'tagsLink' => "/artifact-tags/".$contentId,
            'collaborateLink' => "/artifact-collaboration/".$contentId,
            'commentsCount' => $commentsCount,
            'notesLink' => "/artifact-notes/".$contentId,
            ]);  
  
    }

    public function update(Request $request) {
        
        $user = Auth::user();

        $this->validate($request, [
            'title' => 'required|unique:contents,title,'.$user->id.',created_by_user_id'
        ]);

        $content = Content::find($request['contentId']);
        $content->title = $request['title'];

        $content->save();

        $contentStatus = ContentStatus::where('content_id', '=', $content->id)->first();
        $contentStatus->touch();

        $templateSection = TemplateSection::where('template_id', '=', $request['templateId'])
                                                ->where('order', '=', 1)
                                                ->first();

        return redirect('/artifact-edit/'.$content->id)->with('success', 'Title has been updated.');
    }

}
