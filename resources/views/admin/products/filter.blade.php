@php
    $categories = App\Models\Category::select('id', 'title_' . app()->getLocale())->pluck(
        'title_' . app()->getLocale(),
        'id',
    );

@endphp

@include('admin.layouts.partials.crud-components.filter', [
    'create_route' => $create_route,
    'filters' => [
        [
            'type' => 'text',
            'name' => 'filter[name_ar]',
            'label' => 'name_ar',
            'required' => 'false',
            'placeholder' => 'name_ar',
        ],
        [
            'type' => 'text',
            'name' => 'filter[name_en]',
            'label' => 'name_en',
            'required' => 'false',
            'placeholder' => 'name_en',
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
        [
            'type' => 'number',
            'name' => 'filter[price]',
            'label' => 'price',
            'required' => 'false',
            'placeholder' => 'price',
        ],
        [
            'type' => 'number',
            'name' => 'filter[quantity]',
            'label' => 'quantity',
            'required' => 'false',
            'placeholder' => 'quantity',
        ],
        [
            'type' => 'selectWithSearch',
            'name' => 'filter[category_id]',
            'label' => 'category',
            'required' => 'false',
            'placeholder' => 'category',
            'options' => $categories,
        ],
    ],
])
