<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;
use App\User;

class TagManagementController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all()->sortBy('tag');
        
        foreach ($tags as $tag)
        {
            $userName = User::getUserName($tag->user_id);
            $tag->creator = "$userName";
        }

        return view('admin.manageTags')->with([
            'pageTitle'=>'Manage Tags',
            'tags' => $tags
            ]);    
    }
}
