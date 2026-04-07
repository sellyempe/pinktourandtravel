<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style></style>
        @endif
    </head>
    <body class="bg-white dark:bg-gray-900">
        <!-- Navbar Component -->
        <x-navbar></x-navbar>

        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-4">
                    Welcome to <span class="bg-gradient-to-r from-pink-500 to-blue-500 bg-clip-text text-transparent">PinkTravel</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                    Discover amazing destinations and plan your perfect trip
                </p>

                <div class="flex gap-4 justify-center">
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-pink-500 to-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition">
                        Explore Now
                    </a>
                    <a href="{{ route('register') }}" class="border-2 border-gray-300 text-gray-900 dark:text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
