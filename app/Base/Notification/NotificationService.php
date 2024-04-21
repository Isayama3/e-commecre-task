<?php

namespace App\Base\Notification;

use App\Base\Traits\Custom\ResizableImageTrait;

class NotificationService
{
    use ResizableImageTrait;
    /**
     * @var array
     */
    protected $notificationChannels = [];

    /**
     * Add notification channel
     *
     * @param string $name
     * @param INotificationChannel $channel
     * @return void
     */
    public function addChannel(string $name, INotificationChannel $channel): void
    {
        $this->notificationChannels[$name] = $channel;
    }

    /**
     * Send notification
     *
     * @param string $channelName
     * @param string $token
     * @param mixed $user
     * @param string $title
     * @param string $content
     * @return void
     */
    public function send(string $channelName, string $token, $user, string $title, string $content): void
    {
        $this->validateChannel($channelName);

        $this->sendNotification($channelName, $token, $title, $content);
        $this->saveNotificationToDatabase($channelName, $user, $title, $content);
    }

    /**
     * Validate channel
     *
     * @param string $channelName
     * @return void
     */
    protected function validateChannel(string $channelName): void
    {
        if (!isset($this->notificationChannels[$channelName])) {
            throw new \InvalidArgumentException("Invalid notification channel: $channelName");
        }
    }

    /**
     * Send notification
     *
     * @param string $channelName
     * @param string $token
     * @param string $title
     * @param string $content
     * @return void
     */
    protected function sendNotification(string $channelName, string $token, string $title, string $content): void
    {
        $this->notificationChannels[$channelName]->send($token, $title, $content);
    }

    /**
     * Save notification to database
     *
     * @param string $channelName
     * @param mixed $user
     * @param string $title
     * @param string $content
     * @return void
     */
    protected function saveNotificationToDatabase(string $channelName, $user, string $title, string $content): void
    {
        if (request()->has('image') && !is_null(request()->image)) {
            $image = $this->uploadImage(request()->image);
            $user->notifications()->create([
                'chanel_name' => $channelName,
                'title' => $title,
                'content' => $content,
                'image' => $image
            ]);
        } else {
            $user->notifications()->create([
                'chanel_name' => $channelName,
                'title' => $title,
                'content' => $content,
            ]);
        }
    }
}
