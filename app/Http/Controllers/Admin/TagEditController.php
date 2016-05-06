<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;



class TagEditController extends Controller
{
    /**
     * Update the specified user.
     *
     * @param  string  $id
     * @return Response
   */
    
    public function edit($tagId)
    {
        $tag = Tag::find($tagId);
        if (empty($tag)) abort(404);
       

        return view('admin.editTag')->with([
            'pageTitle'=>'Edit '.$tag->tag,
            'tag' => $tag
            ]);    
    }
    
    /**
     * Update the the user roles.
     *
     * @param  Request  $request
     * @param  $tagId
     * @return Response
     */
    public function update(Request $request, $tagId)
    {      
        $this->validate($request, [
            'tag' => 'required'
        ]);
        
       // $tagId = $request->tagId;    
        $tag = Tag::find($tagId);
        $tag->tag = $request->tag;
        $tag->save();
               
        return redirect('/admin/tag/'.$tagId)->with('success', 'Tag has been updated.');
    }
}