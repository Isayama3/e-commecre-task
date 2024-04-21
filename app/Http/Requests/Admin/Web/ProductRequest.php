<?php

namespace App\Http\Requests\Admin\Web;

use App\Base\Request\Web\AdminBaseRequest;

class ProductRequest extends AdminBaseRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'name_ar' => 'required|string|max:255',
                        'name_en' => 'required|string|max:255',
                        'description_ar' => 'required|string|max:255',
                        'description_en' => 'required|string|max:255',
                        'price' => 'required|numeric',
                        'quantity' => 'required|numeric',
                        'category_id' => ['required', 'numeric', 'exists:categories,id'],
                    ];
                }
            case 'PUT': {
                    return [
                        'name_ar' => 'nullable|string|max:255',
                        'name_en' => 'nullable|string|max:255',
                        'description_ar' => 'nullable|string|max:255',
                        'description_en' => 'nullable|string|max:255',
                        'price' => 'nullable|numeric',
                        'quantity' => 'nullable|numeric',
                        'category_id' => ['nullable', 'numeric', 'exists:categories,id'],
                    ];
                }
        }
    }
}
