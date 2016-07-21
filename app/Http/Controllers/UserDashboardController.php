<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Bouncer;
use Log;
use App\Content;
use App\ContentStatus;
use App\TemplateSection;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();
        $workInProgress = [];
        $published = [];

        $contents = Content::where('created_by_user_id', '=', $user->id)->get();
        
        foreach($contents as $content) {
            $contentStatus = ContentStatus::where('content_id', '=', $content->id)
                                            ->orderBy('updated_at','desc')
                                            ->first();
            $content->status = $contentStatus->status;

            if ($contentStatus->status == "edit" || 
                $contentStatus->status == "peer review" ||
                $contentStatus->status == "expert review") {
                array_push($workInProgress,$content);
            }
            elseif ($contentStatus->status == "published") {
                array_push($published,$content);
            }
        }

        return view('dashboard')->with([
			'pageTitle'=>$user->name." Dashboard",
            'userName'=>$user->name,
			'workInProgress' => $workInProgress,
            'wipCount' =>count($workInProgress),
            'published' => $published,
            'pCount' =>count($published),
        ]);             
    }
}
