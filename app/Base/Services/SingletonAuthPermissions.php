<?php

namespace App\Base\Services;

use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;

class SingletonAuthPermissions
{
    private static $instance;

    private function __construct()
    {
        // Private constructor to prevent direct instantiation
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
