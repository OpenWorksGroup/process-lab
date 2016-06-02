<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Template;
use App\User;

/**
To dos:
- documentation 
- Add validate after (new template) to warn user about duplicate title
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
        $template = Template::find($request['id']);

        if ($request['id']) {
            if ($request['required_num_reviews']) {
                $this->validate($request, [
                    'required_num_reviews' => 'integer'
                ]);
                $template->required_num_reviews = $request['required_num_reviews'];
            }

            if ($request['title']) {
                $template->title = $request['title'];
            }

            if ($request['description']) {
                $template->description = $request['description'];
            }

            $template->save();
            
            return $template;
        }
        else {
            $this->validate($request, [
                'title' => 'required'
            ]); 

            // Add validate after to warn user about duplicate title

            $user = Auth::user();
        
            $template = Template::create([
                'title' => $request['title'],
                'status' => "edit",
                'created_by_user_id' => $user->id,
            ]);

            return $template;
        }
    }
}
