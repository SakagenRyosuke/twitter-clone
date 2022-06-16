<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vue Laravel SPA') }}</title>

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <style>
        /* 後でリセットCSSをセットする */
        * {
            margin: 0;
            padding: 0;
            box-sizing: 0;
        }
    </style>
</head>

<body>
    <div id="app" class="d-flex">
        <app-vue></app-vue>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}" defer></script>
</body>

</html>
