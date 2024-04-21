<?php

namespace App\Base\Notification;

use App\Base\Services\FirebaseHandler;

class FCMService implements INotificationChannel
{
    /**
     * Send notification
     *
     * @param string $token
     * @param string $title
     * @param string $title_en
     * @param string $content_ar
     * @param string $content_en
     * @return void
     */
    public function send(string $token, string $title, string $content): void
    {
        (new FirebaseHandler())->send(
            token: $token,
            title: $title,
            content: $content
        );
    }
}
