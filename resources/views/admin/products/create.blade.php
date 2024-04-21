@extends('admin.layouts.partials.crud-components.create-page')
@php
    $categories = App\Models\Category::select('id', 'title_' . app()->getLocale())->pluck(
        'title_' . app()->getLocale(),
        'id',
    );
@endphp
@section('form')
    {{ \App\Base\Helper\Field::text(name: 'name_ar', label: 'name_ar', required: true) }}
    {{ \App\Base\Helper\Field::text(name: 'name_en', label: 'name_en', required: true) }}
    {{ \App\Base\Helper\Field::text(name: 'description_ar', label: 'description_ar', required: true) }}
    {{ \App\Base\Helper\Field::text(name: 'description_en', label: 'description_en', required: true) }}
    {{ \App\Base\Helper\Field::number(name: 'price', label: 'price', required: true) }}
    {{ \App\Base\Helper\Field::number(name: 'quantity', label: 'quantity', required: true) }}
    {{ \App\Base\Helper\Field::selectWithSearch(name: 'category_id', label: 'category', required: 'true', placeholder: 'category', options: $categories) }}
    {{ \App\Base\Helper\Field::fileWithPreview(name: 'image', label: 'image', required: 'true') }}

@stop
