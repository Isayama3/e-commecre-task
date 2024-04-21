<?php

namespace App\Http\Requests\Admin\Web;

use App\Base\Request\Web\AdminBaseRequest;

class CategoryRequest extends AdminBaseRequest
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
                        'title_ar' => 'required|string|max:255',
                        'title_en' => 'required|string|max:255',
                        'description_ar' => 'required|string|max:255',
                        'description_en' => 'required|string|max:255',
                        'image' => 'required|mimes:jpg,png,jpeg,gif,svg,pdf|max:' . config('settings.max_file_upload'),

                    ];
                }
            case 'PUT': {
                    return [
                        'title_ar' => 'nullable|string|max:255',
                        'title_en' => 'nullable|string|max:255',
                        'description_ar' => 'nullable|string|max:255',
                        'description_en' => 'nullable|string|max:255',
                        'image' => 'nullable|mimes:jpg,png,jpeg,gif,svg,pdf|max:' . config('settings.max_file_upload'),
                    ];
                }
        }
    }
}
