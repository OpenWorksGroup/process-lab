<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Tag;
use App\TagRelationship;
use Log;

class ContentTagsController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all()->sortBy('tag');
        return $tags;
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $template_id = $input['template_id'];
        $tag = trim($input['tag']);
        $user = Auth::user();

        /** TO DO
        * This assumes tags are being added for a template. May also be for artifact or elsewhere */

       // Log::info('Template Id: '.$templateId);
       // Log::info('TAG: '.$tag);

        /** Look up to see if content tag exists **/

        $tagSearch = Tag::where('tag', '=', $tag)
                        ->where('type', '=', "content")
                        ->first();
        if ($tagSearch) 
        {
           $tagId = $tagSearch->id;
            Log::info('TAG SEARCH: '.$tagId);
        }
        else {
            $tagNew = Tag::create([
                'type' => "content",
                'tag' => $tag,
                'created_by' => "user",
                'user_id' => $user->id
            ]);
            $tagId = $tagNew->id;
        }

        $tagRelSearch = TagRelationship::where('tag_id', '=', $tagId)
                        ->where('template_id', '=', $template_id)
                        ->first();

        if ($tagRelSearch) 
        {
            return response()->json(['tag' => $tag, 'message' => ' has already been added.'], 422); 
        }
        else {
           $tagRel = TagRelationship::create([
                'tag_id' => $tagId,
                'template_id' => $template_id,
                'user_id' => $user->id
            ]); 
        }
        return response()->json(['success' => $tag + ' added.'], 200); 
    }
}
