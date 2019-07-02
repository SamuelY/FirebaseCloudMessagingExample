<?php

//This is laravel project and demo how to using google firebase cloud messaging
//To install the library, please reference https://github.com/googleapis/google-api-php-client 

namespace App\Http\Controllers;
use Google_Client;
use Google_Service_FirebaseCloudMessaging;

class TestController extends Controller
{
    function googleApi() {
        $file_path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix().'---name of your credentials json file---';
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.$file_path);

        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google_Service_FirebaseCloudMessaging::CLOUD_PLATFORM);

        $httpClient = $client->authorize();

        // Your Firebase project ID
        $project = "---project id here---";
        // Creates a notification for subscribers to the debug topic
        $message = [
            "message" => [
                "token" => "---token here---",
                "notification" => [
                    "title" => "FCM Message",
                    "body" => "This is an FCM notification message!",
                ]
            ]
        ];
        // Send the Push Notification - use $response to inspect success or errors
        $response = $httpClient->post("https://fcm.googleapis.com/v1/projects/{$project}/messages:send", ['json' => $message]);
        $return = json_decode($response->getBody()->getContents());
        return response()->json($return);

    }
}
