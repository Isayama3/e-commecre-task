@extends('admin.layouts.partials.crud-components.table', [
    'page_header' => __('admin.categories'),
])

@section('filter')
    @include('admin.categories.filter', [
        'create_route' => $create_route,
    ])
@stop

@section('table')
    <thead>
        <tr>
            <th>{{ __('#') }}</th>
            <th>{{ __('admin.title_ar') }}</th>
            <th>{{ __('admin.title_en') }}</th>
            <th>{{ __('admin.description_ar') }}</th>
            <th>{{ __('admin.description_en') }}</th>
            <th>{{ __('admin.image') }}</th>
            <th style="width: 1px">{{ __('admin.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $record)
            <tr id="removable{{ $record->id }}">
                <td>{{ $record->id }}</td>
                <td>{{ $record->title_ar }}</td>
                <td>{{ $record->title_en }}</td>
                <td>{{ $record->description_ar }}</td>
                <td>{{ $record->description_en }}</td>
                <td>
                    @include('admin.layouts.partials.components.custom.image-avatar-component', [
                        'record' => $record,
                    ])
                </td>
                <td style="">
                    <div style="display:flex; gap:2px; justify-content:center;">
                        <a href="{{ route($edit_route, $record->id) }}">
                            <button class="btn icon icon-left btn-success me-2 text-nowrap"><i
                                    class="bi bi-pencil-square"></i></button>
                        </a>
                        <button id="{{ $record->id }}" data-token="{{ csrf_token() }}"
                            data-route="{{ route($destroy_route, $record->id) }}" type="button"
                            class="btn icon icon-left btn-danger me-2 text-nowrap destroy">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>

@stop
