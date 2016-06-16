<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\TemplateCourse;
use Log;

class TemplateCourseController extends Controller
{
public function store(Request $request)
    {

        $user = Auth::user();

        if ($request['template_course_id']) {

           // Log::info($request);

            $this->validate($request, [
                'course_id' => 'required',
                'course_title' => 'required',
                'course_url' => 'required'
            ]);

            $templateCourse = TemplateCourse::find($request['template_course_id']);
            if ($request['course_id']) $templateCourse->course_id = $request['course_id'];
            if ($request['course_title']) $templateCourse->course_title = $request['course_title'];
            if ($request['course_url']) $templateCourse->course_url = $request['course_url'];

            $templateCourse->save();
        }
        else {

            $this->validate($request, [
                'course_id' => 'required',
                'course_title' => 'unique:template_courses,course_title|required',
                'course_url' => 'required'
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
