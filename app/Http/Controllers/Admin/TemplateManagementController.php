<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Template;
use App\User;

class TemplateManagementController extends Controller
{
    public function index(Request $request)
    {
        $templates = Template::all()->sortBy('title');
        
        foreach ($templates as $template)
        {
            $creator = User::getUserName($template->created_by_user_id);
            $template->creator = "$creator";
            $updator = User::getUserName($template->updated_by_user_id);
            $template->updator = "$updator";
        }

        return view('admin.manageTemplates')->with([
            'pageTitle'=>'Manage Templates',
            'templates' => $templates
            ]);    
    }
}
