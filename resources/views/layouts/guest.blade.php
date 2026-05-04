<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Frigorlato') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;600;700&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-ivory antialiased">
        <div class="flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_top,_rgba(178,34,34,0.16),_transparent_35%),linear-gradient(180deg,_#fff8e7_0%,_#f5f5dc_100%)] px-4 py-10">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
