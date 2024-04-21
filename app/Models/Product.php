<?php

namespace App\Models;

use App\Base\Models\Base;

class Product extends Base
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
