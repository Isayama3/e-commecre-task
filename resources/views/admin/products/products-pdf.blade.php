<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>قائمة المنتجات</title>
    <style>
        /* Define your styles for the PDF here */
        /* Example: */
        body {
            font-family: 'Arial', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">قائمة المنتجات</h1>
    <table>
        <thead>
            <tr>
                <th>{{ __('#') }}</th>
                <th>{{ __('admin.name_ar') }}</th>
                <th>{{ __('admin.name_en') }}</th>
                <th>{{ __('admin.description_ar') }}</th>
                <th>{{ __('admin.description_en') }}</th>
                <th>{{ __('admin.quantity') }}</th>
                <th>{{ __('admin.price') }}</th>
                <th>{{ __('admin.category') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $record)
                <tr id="removable{{ $record->id }}">
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name_ar }}</td>
                    <td>{{ $record->name_en }}</td>
                    <td>{{ $record->description_ar }}</td>
                    <td>{{ $record->description_en }}</td>
                    <td>{{ $record->quantity }}</td>
                    <td>{{ $record->price }}</td>
                    <td>{{ $record->category->getLocaleAttribute('title_ar') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
