<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Tag;
use App\TagRelationship;
use Log;

class ContentTagsController extends Controller
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
    * Read all content tags.
    *
    * @param  Request  $request
    * @return array  $tags
    */
    public function index(Request $request)
    {
        $tags = Tag::all()->sortBy('tag');
        return $tags;
    }

    /**
    * Store a content tag.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $input = $request->all();
        if (!empty($input['template_id'])) {
            $template_id = $input['template_id'];
        }
        if (!empty($input['content_id'])) {
            $content_id = $input['content_id'];
        }
        $tag = trim($input['tag']);
        $user = Auth::user();

       // Log::info('Template Id: '.$templateId);
       // Log::info('TAG: '.$tag);

        /** Look up to see if content tag exists **/

        $tagSearch = Tag::where('tag', '=', $tag)
                        ->where('type', '=', "content")
                        ->first();
        if ($tagSearch) 
        {
           $tagId = $tagSearch->id;
           // Log::info('TAG SEARCH: '.$tagId);
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

        if (!empty($template_id)) {

            $tagRelSearch = TagRelationship::where('tag_id', '=', $tagId)
                                            ->where('template_id', '=', $template_id)
                                            ->first();
        }
        else {
            $tagRelSearch = TagRelationship::where('tag_id', '=', $tagId)
                                            ->where('content_id', '=', $content_id)
                                            ->first();
        }

        if ($tagRelSearch) 
        {
            return response()->json(['tag' => $tag, 'message' => ' has already been added.'], 422); 
        }
        else {
            if (!empty($template_id)) {
                $tagRel = TagRelationship::create([
                    'tag_id' => $tagId,
                    'template_id' => $template_id,
                    'user_id' => $user->id
                ]); 
            }
            else {
                $tagRel = TagRelationship::create([
                    'tag_id' => $tagId,
                    'content_id' => $content_id,
                    'user_id' => $user->id
                ]); 
            }
        }
        return response()->json(['success' => $tag + ' added.'], 200); 
    }

    /**
    * Delete a content tag.
    *
    * @param  Request  $request
    * @return Response
    */
    public function destroy(Request $request)
    {
        $input = $request->all();
        if (!empty($input['template_id'])) {
            $template_id = $input['template_id'];
        }
        if (!empty($input['content_id'])) {
            $content_id = $input['content_id'];
        }

        //Note: not sure why we're checking this
        if ($template_id || $content_id)
        {
            $tag = trim($input['tag']);

            $tagSearch = Tag::where('tag', '=', $tag)
                        ->where('type', '=', "content")
                        ->first();

            //Log::info($tagSearch->id);

            $tagRelSearch = TagRelationship::where('tag_id', '=', $tagSearch->id)->first();
            $tagRelSearch -> delete();

            /** delete working but not soft delete (updating deleted_at col)  **/

            return response()->json(['success' => $tag + ' relationship deleted.'], 200); 
        }
                

    }
}
