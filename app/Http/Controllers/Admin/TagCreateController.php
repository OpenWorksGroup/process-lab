<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;

class TagCreateController extends Controller
{
    public function create(Request $request)
    {
        //dd($request->session());
        return view('admin.createTag')->with('pageTitle','Add New Tag');        
    }
    
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
        
        return redirect('/admin/tag')->with('success', $request['tag'].' has been added.');
    }
}
