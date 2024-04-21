@extends('admin.layouts.partials.crud-components.edit-page')

@section('form')
    {{ \App\Base\Helper\Field::text(name: 'title_ar', label: 'title_ar', value: $record->title_ar) }}
    {{ \App\Base\Helper\Field::text(name: 'title_en', label: 'title_en', value: $record->title_en) }}
    {{ \App\Base\Helper\Field::text(name: 'description_ar', label: 'description_ar', value: $record->description_ar) }}
    {{ \App\Base\Helper\Field::text(name: 'description_en', label: 'description_en', value: $record->description_en) }}
    {{ \App\Base\Helper\Field::fileWithPreview(name: 'image', label: 'image', required: 'false') }}
@stop
