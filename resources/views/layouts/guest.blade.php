<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Frigorlato') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-ivory antialiased">
        <div class="flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_top,_rgba(144,12,15,0.14),_transparent_30%),radial-gradient(circle_at_bottom_left,_rgba(185,111,31,0.12),_transparent_28%),linear-gradient(180deg,_#fffdf8_0%,_#fdf8f0_100%)] px-4 py-10">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
