<?php

namespace App\Http\Controllers\Admin\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\TemplateCourse;
use Log;

class TemplateCourseController extends Controller
{
    /**
    * Store a template course.
    *
    * @param  Request  $request
    * @return TemplateCourse $templateCourse
    */
    public function store(Request $request)
    {

        $user = Auth::user();

        if ($request['template_course_id']) {

           // Log::info($request);

            $this->validate($request, [
                'course_id' => 'sometimes|
                required_with:course_title,course_url|
                unique:template_courses,course_id',
                'course_title' => 'sometimes|required_with:course_id,course_url',
                'course_url' => 'sometimes|required_with:course_id,course_title'
            ]);

            $templateCourse = TemplateCourse::find($request['template_course_id']);
            if ($request['course_id']) $templateCourse->course_id = $request['course_id'];
            if ($request['course_title']) $templateCourse->course_title = $request['course_title'];
            if ($request['course_url']) $templateCourse->course_url = $request['course_url'];

            $templateCourse->save();
        }
        else {

            $this->validate($request, [
                'template_id' => 'required',
                'course_id' => 'required',
                'course_title' => 'required',
                'course_url' => 'required|url'
            ]);

            $templateCourse = TemplateCourse::create([
                'course_id' => $request['course_id'],
                'course_title' => $request['course_title'],
                'course_url' => $request['course_url'],
                'template_id' => $request['template_id'],
                'created_by_user_id' => $user->id,
                'updated_by_user_id' => $user->id,
            ]);
        }

        return $templateCourse;
    }

}
