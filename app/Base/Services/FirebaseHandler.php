<?php

namespace App\Base\Services;

use Illuminate\Support\Facades\Http;

class FirebaseHandler
{
    public function send($token, $title, $content, $message = '')
    {
        $server_key = env('FIREBASE_KEY');

        $fcmFields = [
            'registration_ids' => (array)$token,
            'priority' => 'high',
            'notification' => [
                'title' => $title,
                'content' => $content,
                // 'sound' => "default",
                // 'color' => "#203E78",
                // 'priority' => 'high',
                // 'notification' => $message
            ]
        ];

        $headers = [
            'Authorization' => 'key=' . $server_key,
            'Content-Type' => 'application/json'
        ];

        $request = Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $fcmFields);
        $request->body();
    }
}
