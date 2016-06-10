<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Template;
use App\User;
use Log;


/**
To dos:
- documentation 
- Add validate after (new template) to warn user about duplicate title
- Updator not working right
**/

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = Template::all()->sortByDesc('updated_at');
        
        foreach ($templates as $template)
        {
            $creator = User::getUserName($template->created_by_user_id);
            $template->creator = "$creator";
            $updator = User::getUserName($template->updated_by_user_id);
            /*if ($updator) {
                $template->updator = "$updator";
            }*/
        }

        return view('admin.manageTemplates')->with([
            'pageTitle'=>'Manage Templates',
            'templates' => $templates
            ]);    
    }

    public function create(Request $request)
    {
        return view('admin.createTemplate')->with('pageTitle','Create New Template');        
    }
    
    public function store(Request $request)
    {

		if ($request['id']) {

			$this->validate($request, [
				'title' => 'bail|sometimes|filled|unique:templates,title',
				'description' => 'bail|sometimes|filled',
                'required_num_reviews' => 'bail|sometimes|filled|integer|min:0',
                'required_period_time' => 'bail|sometimes|filled|integer|min:0'
            ]);

        	$template = Template::find($request['id']);
        	if ($request['title']) $template->title = $request['title'];
			if ($request['description'])  $template->description = $request['description'];

			if ($request['include_collaborative_feedback']) {
				if ($request['include_collaborative_feedback'] == "true") {
					$request['include_collaborative_feedback'] = 0;
				}
				else {
					$request['include_collaborative_feedback'] = 1;
				}

				$template->include_collaborative_feedback = $request['include_collaborative_feedback'];
			}

			if (isset($request['required_num_reviews'])) {
				//Log::info('Number of reviews: '.$request['required_num_reviews']);
				$template->required_num_reviews = $request['required_num_reviews'];
			}

			if (isset($request['required_period_time'])) {
    			if ($request['required_period_time'] == 0 && $request['required_num_reviews'] > 0) {
        			$request['required_period_time'] = 1; //Return to default of 1 day
    			}

				$reqTimeSeconds = $request['required_period_time'] * 86400;
				$template->required_period_time = $reqTimeSeconds;
			}

            $template->save();
            
            return $template;
        }
        else {

            $this->validate($request, [
                'title' => 'required|unique:templates,title'
            ]); 

            // Add validate after to warn user about duplicate title

            $user = Auth::user();
        
            $template = Template::create([
                'title' => $request['title'],
                'status' => "edit",
                'include_collaborative_feedback' => 1,
                'created_by_user_id' => $user->id,
            ]);

            return $template;
        }
    }
}
