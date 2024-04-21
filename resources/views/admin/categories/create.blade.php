@extends('admin.layouts.partials.crud-components.create-page')
@section('form')
    {{ \App\Base\Helper\Field::text(name: 'title_ar', label: 'title_ar', required: 'true', placeholder: 'title_ar') }}
    {{ \App\Base\Helper\Field::text(name: 'title_en', label: 'title_en', required: 'true', placeholder: 'title_en') }}
    {{ \App\Base\Helper\Field::text(name: 'description_ar', label: 'description_ar', required: 'true', placeholder: 'description_ar') }}
    {{ \App\Base\Helper\Field::text(name: 'description_en', label: 'description_en', required: 'true', placeholder: 'description_en') }}
    {{ \App\Base\Helper\Field::fileWithPreview(name: 'image', label: 'image', required: 'true') }}
@stop
