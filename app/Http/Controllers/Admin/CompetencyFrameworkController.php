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

    /**
    * Display admin Manage Competency Frameworks page.
    *
    * @return \resources\views\admin\manageCompetencyFrameworks.blade.php
    */
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

    /**
    * Display Create Competency Framework page.
    *
    * @return \resources\views\admin\createCompetencyFramework.blade.php
    */
    public function create()
    {
        return view('admin.createCompetencyFramework')->with('pageTitle','Create Competency Framework');        
    }

    /**
    * Store a competency framework.
    *
    * @param  Request  $request
    * @return CompetencyFramework  $cf
    */
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

    /**
    * Display Edit Competency Framwork page for a specified competency framework.
    *
    * @param  int $cfId
    * @return \resources\views\admin\editCompetencyFramework.blade.php
    */
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

    /**
    * Read all competency frameworks.
    *
    * @param  Request  $request
    * @return array  $frameworks
    */
    public function retrieve(Request $request)
    {
        $frameworks = CompetencyFramework::all()->sortBy('framework');
        return $frameworks;
    }
}
