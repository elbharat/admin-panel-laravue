<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @if(isset($page['props']['settings']['favicon']))
            <link rel="icon" href="{{ asset($page['props']['settings']['favicon']) }}">
        @endif

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        
        @if(isset($page['props']['settings']['subtitle']))
            <meta name="description" content="{{ $page['props']['settings']['subtitle'] }}">
        @endif

        @if(isset($page['props']['settings']['thumbnail']))
            <meta property="og:image" content="{{ asset($page['props']['settings']['thumbnail']) }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
