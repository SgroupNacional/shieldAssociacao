<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Metronic Global Stylesheets Bundle -->
    <link rel="stylesheet" href="{{ asset('metronic/assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('metronic/assets/css/style.bundle.css') }}">
</head>
<body id="kt_body" class="app-blank">
    {{ $slot }}

    <!-- Metronic Global Javascript Bundle -->
    <script src="{{ asset('metronic/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/scripts.bundle.js') }}"></script>

    @stack('scripts')
</body>
</html>
