<?php

namespace App\Http\Controllers\Admin\Web;

use App\Base\Controllers\Web\Controller;
use App\Models\Category as Model;
use App\Http\Requests\Admin\Web\CategoryRequest as FormRequest;

class CategoryController extends Controller
{
    public function __construct(FormRequest $request, Model $model)
    {
        parent::__construct(
            $request,
            $model,
            view_path: 'admin.categories.',
            hasDelete: true
        );
    }

    public function relations(): array
    {
        return ['products'];
    }
}
