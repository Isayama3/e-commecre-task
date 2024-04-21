@php
    $categories = App\Models\Category::select('id', 'title_'.app()->getLocale())->pluck('title_'.app()->getLocale(), 'id');
@endphp

@include('admin.layouts.partials.crud-components.filter', [
    'create_route' => $create_route,
    'filters' => [
        [
            'type' => 'text',
            'name' => 'filter[title_ar]',
            'label' => 'title_ar',
            'required' => 'false',
            'placeholder' => 'title_ar',
        ],
        [
            'type' => 'text',
            'name' => 'filter[title_en]',
            'label' => 'title_en',
            'required' => 'false',
            'placeholder' => 'title_en',
        ],
        [
            'type' => 'text',
            'name' => 'filter[description_ar]',
            'label' => 'description_ar',
            'required' => 'false',
            'placeholder' => 'description_ar',
        ],
        [
            'type' => 'text',
            'name' => 'filter[description_en]',
            'label' => 'description_en',
            'required' => 'false',
            'placeholder' => 'description_en',
        ],
    ],
])
