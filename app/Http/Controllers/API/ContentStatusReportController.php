<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Setting;
use App\User;
use App\Content;
use App\ContentStatus;
use App\Review;
use App\ReviewResult;

class OAuthHelper {
    private $key;
    private $secret;

    public function __construct($consumerKey, $consumerSecret)
    {
        $this->key = $consumerKey;
        $this->secret = $consumerSecret;
    }

    public function isSignatureValid($request)
    {
        return $this->buildSignature($request) === $request->input('oauth_signature');
    }

    public function buildSignature($request)
    {
        $input = $request->all();
        unset($input['oauth_signature']);

        $hmac_method = new \OAuthSignatureMethod_HMAC_SHA1();
        $consumer = new \OAuthConsumer($this->key, $this->secret, NULL);
        $req = \OAuthRequest::from_consumer_and_token($consumer, NULL, 'POST', $request->fullUrl(), $input);
        return $req->build_signature($hmac_method, $consumer, null);
    }
}

class ContentStatusReportController extends Controller
{
 	public function index(Request $request)
    {
		$input = $request->all();
        $settings = Setting::all()->first();

        // if no settings, can't auth
        if (empty($settings)) 
        { 
            return response()->json(['error' => true, 'message' => 'This system has not been set up properly. Please refer to set up instructions.'], 422); 
        }
        else { //check consumer key & secret

            // get these from settings table
            $consumer_key = $settings->lti_consumer_key;
            $consumer_secret = $settings->lti_secret;
                
            if ($input['oauth_consumer_key'] !== $consumer_key) {
                return response()->json(['error' => true, 'message' => 'Oauth signature is invalid.'], 422); 
            }
                
            $oauthHelper = new OAuthHelper($consumer_key, $consumer_secret);
            if (!$oauthHelper->isSignatureValid($request)) {
                return response()->json(['error' => true, 'message' => 'Oauth signature is invalid.'], 422); 
            } 
             
             $report = [];
             $report['user'] =[];
             $users = User::all()->sortBy('name');

             foreach ($users as $user) {

                $userContent = Content::where('created_by_user_id', '=', $user->id)->get();
                if (count($userContent) > 0) {
                    $contentArr = [];

                    foreach ($userContent as $content) {

                        $contentStatus = ContentStatus::where('content_id', '=', $content->id)->first();

                        $reviews = Review::where('content_id', '=', $content->id)->get();
                        $reviewResults = [];
                        foreach ($reviews as $review) {
                            $reviewResult = ReviewResult::where('review_id','=',$review->id)->first();
                            array_push($reviewResults,Array(
                                'review' => $review->comment,
                                'score' => $reviewResult->results,
                                'created_at' => $reviewResult->created_at->format('Y-m-d'),
                            ));
                        }

                        array_push($contentArr, Array(
                            'id' => $content->id,
                            'title' => $content->title,
                            'link' => '/artifact/'.$content->id,
                            'created_at' => $content->created_at->format('Y-m-d'),
                            'updated_at' => $content->updated_at->format('Y-m-d'),
                            'status' => $contentStatus->status,
                            'reviews' => $reviewResults
                        ));
                    }

                    array_push($report['user'],Array(
                        'id' => $user->id,
                        'name' => $user->name,
                        'content' => $contentArr
                    ));
                }
            }
           // dd($report);
            return response()->json(['success' => $report], 200);
        }

    }
}
