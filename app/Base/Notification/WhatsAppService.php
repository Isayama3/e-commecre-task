<?php

namespace App\Base\Notification;

class WhatsAppService implements INotificationChannel
{
    /**
     * Send notification
     *
     * @param string $token
     * @param string $title
     * @param string $content
     * @return void
     */
    public function send(string $token, string $title, string $content): void
    {
        // Implementation for Firebase Cloud Messaging
    }
}
