<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
        <link href="{{ asset(mix('css/app.css')) }}" type="text/css" rel="stylesheet" />
        <meta name="csrf-token" value="{{ csrf_token() }}" />
        <script defer src="{{ asset(mix('js/app.js')) }}"></script>
    </head>
    <body>
        <div id="app">
            <app-component></app-component>
        </div>
        <script>
            window.countries = @json($countries);
            window.states = @json($states);
        </script>
    </body>
</html>

