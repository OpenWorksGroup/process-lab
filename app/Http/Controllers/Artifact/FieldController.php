<?php

namespace App\Http\Controllers\Artifact;

use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ContentFieldContent;
use Log;
use Purifier;
use Storage;
use App\ContentStatus;

class FieldController extends Controller
{
	public function store(Request $request) {

		$content = Purifier::clean($request['content']);

		$this->validate($request, [
               'uri' => 'sometimes|url'
        ]);

        $uri = $request['uri'];
		
		$file = $request->file('file');

		if ($file && $file->isValid()) {
			// adding time for unique filename. Probably want to change this to keep name & store in derectory associated with ContentFieldContent id but don't want to save to db until file is uploaded...
    		$filename = time().preg_replace("/[^a-zA-Z0-9.]/", "", $request->file('file')->getClientOriginalName());
    		Storage::disk('userFiles')->put($filename,file_get_contents($file -> getRealPath()), 'public');

    		$uri = URL('/').'/files/'.$filename;

		}

		if ($request['id']) {

			$fieldContent = ContentFieldContent::find($request['id']);
			$fieldContent->content_id = $request['content_id'];
			$fieldContent->template_section_field_id = $request['template_section_field_id'];
			$fieldContent->type = $request['type'];
			$fieldContent->content = $content;
			$fieldContent->uri = $uri;

			$fieldContent->save();

			$contentStatus = ContentStatus::where('content_id', '=', $request['content_id'])->first();
            $contentStatus->touch();

			return $fieldContent;
		}
		else {

			$fieldContent = ContentFieldContent::create([
				'content_id' => $request['content_id'],
				'template_section_field_id' => $request['template_section_field_id'],
				'type' => $request['type'],
				'content' => $content,
				'uri' => $uri
			]);

            $contentStatus = ContentStatus::where('content_id', '=', $request['content_id'])->first();
            $contentStatus->touch();

			return $fieldContent;
		}
	}

	public function destroy(Request $request) {

		//Log::info($request);
		$fieldContent = ContentFieldContent::find($request['id']);
		//Log::info($fieldContent->type);
		$type = $fieldContent->type;
		if ($type == "image" || $type == "file") {
			//Log::info($fieldContent->uri);
			$filename = basename(parse_url($fieldContent->uri, PHP_URL_PATH));
			Storage::disk('userFiles')->delete($filename);
			//Log::info($filename);
		}

		$fieldContent -> delete();

		return $request['id'];

	}
}
