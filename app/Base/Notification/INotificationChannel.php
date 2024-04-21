<?php

namespace App\Base\Notification;

interface INotificationChannel
{
    /**
     * Send notification
     *
     * @param string $token
     * @param string $title
     * @param string $content
     * @return void
     */
    public function send(string $token, string $title, string $content): void;
}
