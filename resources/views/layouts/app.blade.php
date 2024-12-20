<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lemonade">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <div class="fixed w-full z-10 px-10 bg-base-100">
            @include('layouts.navigation')
        </div>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto pt-20 px-10 mt-10">
            {{ $slot }}
            @stack('scripts')
        </main>
    </div>
</body>

</html>