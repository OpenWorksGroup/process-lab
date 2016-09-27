<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Tag;
use App\User;


class TagController extends Controller
{
    /**
    * Display admin Manage Tags page.
    *
    * @param  Request  $request
    * @return \resources\views\admin\manageTags.blade.php
    */
    public function index(Request $request)
    {
        $tags = Tag::all()->sortBy('tag');
        
        foreach ($tags as $tag)
        {
            $userName = User::getUserName($tag->user_id);
            if ($userName) {
              //  $tag->creator = "$userName";
            }
        }

        return view('admin.manageTags')->with([
            'pageTitle'=>'Manage Tags',
            'tags' => $tags
        ]);    
    }

    /**
    * Display Create New Tag page.
    *
    * @param  Request  $request
    * @return \resources\views\admin\createTag.blade.php
    */
    public function create(Request $request)
    {
        return view('admin.createTag')->with('pageTitle','Add New Tag');        
    }
    
    /**
    * Store a tag and reload page.
    *
    * @param  Request  $request
    * @return \resources\views\admin\createTag.blade.php
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'tag' => 'required'
        ]);  
            
        $user = auth()->user(); 
            
        $tag = Tag::create([
            'type' => $request['type'],
            'label' => $request['label'],
            'tag' => $request['tag'],
            'created_by' => "admin",
            'user_id' => $user->id
        ]);   
        
        return redirect('/admin/tags/create')->with('success', $request['tag'].' has been added.');
    }

    /**
    * Display Edit Tag page for a specified tag.
    *
    * @param  int $tagId
    * @return \resources\views\admin\editTag.blade.php
    */
    public function edit($tagId)
    {
        $tag = Tag::find($tagId);
        if (empty($tag)) abort(404);
       

        return view('admin.editTag')->with([
            'pageTitle'=>'Edit Tag',
            'tag' => $tag
            ]);    
    }
    
    /**
    * Update a tag and reload page.
    *
    * @param  Request  $request
    * @param  int $tagId
    * @return Response
    */
    public function update(Request $request, $tagId)
    {      
        $this->validate($request, [
            'tag' => 'required'
        ]);
        
        $user = auth()->user(); 
       // $tagId = $request->tagId;    
        $tag = Tag::find($tagId);
        $tag->tag = $request->tag;
        $tag->created_by = "admin";
       /* $tag->user_id' = $user->id;*/
        $tag->save();
               
        return redirect('/admin/tags/'.$tagId)->with('success', 'Tag has been updated.');
    }
}
