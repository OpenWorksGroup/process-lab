<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\CompetencyFramework;
use App\CompetencyFrameworkCategory;
use App\User;
use Log;

class CompetencyFrameworkController extends Controller
{

	public function index()
    {
        $frameworks = CompetencyFramework::all()->sortByDesc('updated_at');

        foreach ($frameworks as $framework)
        {
            $creator = User::getUserName($framework->created_by_user_id);
            $framework->creator = "$creator";
           // $updator = User::getUserName($framework->updated_by_user_id);
           // $template->updator = "$updator";
        }

        return view('admin.manageCompetencyFrameworks')->with([
            'pageTitle'=>'Manage Competency Frameworks',
            'frameworks' => $frameworks
        ]);         
    }

    public function create()
    {
        return view('admin.createCompetencyFramework')->with('pageTitle','Create Competency Framework');        
    }

    public function store(Request $request)
    {
    	if ($request['framework_id'])
    	{
            $cf = CompetencyFramework::find($request['framework_id']);

            if ($request['framework'] != $cf->framework) {
    		  $this->validate($request, [
                'framework' => 'required|filled|unique:competency_frameworks,framework'
                ]);
            }
            
            $cf->framework = $request['framework'];

            $cf->save();

    	}
    	else
    	{
	    	$this->validate($request, [
            	'framework' => 'required|filled|unique:competency_frameworks,framework'
        	]);  
            
        	$user = auth()->user(); 
            
        	$cf = CompetencyFramework::create([
            	'framework' => $request['framework'],
            	'created_by_user_id' => $user->id,
            	'updated_by_user_id' => $user->id
        	]);   
        }        

        return $cf;
    }

    public function edit($cfId)
    {

        $framework = CompetencyFramework::find($cfId);
        $frameworkName = $framework->framework;

        $categories = CompetencyFrameworkCategory::where('framework_id', '=', $cfId)->get();

        return view('admin.editCompetencyFramework')->with([
            'pageTitle' => 'Edit Competency Framework',
            'frameworkName' => $frameworkName,
            'categories' => $categories,
            'cfId' => $cfId
        ]);       
    }

    public function retrieve(Request $request)
    {
        $frameworks = CompetencyFramework::all()->sortBy('framework');
        return $frameworks;
    }
}
