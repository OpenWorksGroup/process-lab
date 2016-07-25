<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ContentNote;
use App\Content;
use App\ContentStatus;
use App\TemplateSection;
use Purifier;
Use Mobile_Detect;

class NotesController extends Controller
{
    /**
	 * Display content note page.
     *
	 * @param  int  $contentId
	 * @return view:  artifact/phone||tabletDesktop/notes.blade.php
	 */
	public function edit($contentId) {
        
        if (!$contentId) {
            return response()->view('errors.'.'404');
        }

        $user = Auth::user();
        $note="";
        $contentNote = ContentNote::where('content_id', '=', $contentId)->first();
        if ($contentNote) {
        	$note = $contentNote->note;
        }
        $content = Content::find($contentId);

        $detect = new Mobile_Detect;

        $content = Content::where('id', '=', $contentId)
                            ->where('created_by_user_id', '=', $user->id)
                            ->first();

        if ($detect->isMobile() && !$detect->isTablet())
       {

            $templateSections = TemplateSection::where('template_id', '=', $content->template_id)->get();

            return view('artifact.phone.notes')->with([
                'pageTitle'=>"Notes from the field",
                'contentId' => $contentId,
                'templateId' => $content->template_id,
                'contentTitle' => $content->title,
                'note' => $note,
                'otherSections' => $templateSections,
                'buildLink' => "/artifact-builder/".$content->template_id,
                'tagsLink' => "/artifact-tags/".$contentId,
                'collaborateLink' => "",
                'notesLink' => "/artifact-notes/".$contentId,
            ]);

       }
       else {

        return view(($detect->isMobile() && !$detect->isTablet() ? 'artifact.phone' : 'artifact.tabletDesktop') . '.notes')->with([
            'pageTitle'=>"Notes from the field",
            'contentId' => $contentId,
            'templateId' => $content->template_id,
            'contentTitle' => $content->title,
            'note' => $note
        ]);

       } 
    }

    /**
	 * Store a ContentNote.
     *  - if new note, store new note and content status information.
     *  - if already exists, update note and content status information.
     *
	 * @param  Request  $request
	 * @return ContentNote  $contentNote
	 */
    public function store(Request $request) {

    	$notes = Purifier::clean($request['note']);

    	if ($request['id']) {

			$contentNote = ContentNote::find($request['id']);
			$contentNote->note = $notes;

			$contentNote->save();

			//$contentStatus = ContentStatus::where('content_id', '=', $request['content_id'])->first();
            //$contentStatus->touch();

			$status = ContentStatus::create([
                'content_id' => $contentNote->content_id,
                'status' => 'edit'
            ]);

            return $contentNote;
		}
		else {

			$contentNote = ContentNote::create([
				'content_id' => $request['content_id'],
				'note' => $notes
			]);

           // $contentStatus = ContentStatus::where('content_id', '=', $request['content_id'])->first();
           // $contentStatus->touch();

            $status = ContentStatus::create([
                'content_id' => $contentNote->content_id,
                'status' => 'edit'
            ]);

			return $contentNote;
		}

    }
}
