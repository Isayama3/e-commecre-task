<?php

namespace App\Http\Controllers\Admin\Web;

use App\Models\Product as Model;
use App\Base\Controllers\Web\Controller;
use App\Http\Requests\Admin\Web\ProductRequest as FormRequest;
use PDF;

class ProductController extends Controller
{
    public function __construct(FormRequest $request, Model $model)
    {
        parent::__construct(
            $request,
            $model,
            view_path: 'admin.products.',
            hasDelete: true,
            hasPdf: true,
        );
    }

    public function relations(): array
    {
        return ['category'];
    }
}
