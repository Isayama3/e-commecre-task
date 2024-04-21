<?php

namespace App\Base\Models;

use App\Base\Models\Base;

class Notification extends Base
{
    protected $fillable = [
        'channel_name',
        'title',
        'content',
        'read_at',
        'image',
        'notifiable_id',
        'notifiable_type',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
