<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        @filamentStyles
        @vite('resources/css/app.css')

    </head>
    <body class="bg-[#e2e2e2] min-h-[100svh]">
        {{ $slot }}
        @livewire('notifications')
        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
