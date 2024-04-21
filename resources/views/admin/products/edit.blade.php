@extends('admin.layouts.partials.crud-components.edit-page')
@php
    $categories = App\Models\Category::select('id', 'title_' . app()->getLocale())->pluck(
        'title_' . app()->getLocale(),
        'id',
);
@endphp
@section('form')
    {{ \App\Base\Helper\Field::text(name: 'name_ar', label: 'name_ar', value: $record->name_ar) }}
    {{ \App\Base\Helper\Field::text(name: 'name_en', label: 'name_en', value: $record->name_en) }}
    {{ \App\Base\Helper\Field::text(name: 'description_ar', label: 'description_ar', value: $record->description_ar) }}
    {{ \App\Base\Helper\Field::text(name: 'description_en', label: 'description_en', value: $record->description_en) }}
    {{ \App\Base\Helper\Field::number(name: 'price', label: 'price', value: $record->price) }}
    {{ \App\Base\Helper\Field::number(name: 'quantity', label: 'quantity', value: $record->quantity) }}
    {{ \App\Base\Helper\Field::selectWithSearch(name: 'category_id', label: 'category', required: 'false', placeholder: 'category', options: $categories, selected: $record->category_id) }}
@stop
