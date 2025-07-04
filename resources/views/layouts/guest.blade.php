<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#F2F7FE]">

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white overflow-hidden sm:rounded-2xl border border-gray-300">
                <div class="flex flex-col items-center mb-4">
                    <x-application-logo class="fill-current text-gray-500" />
                    <h1 class="text-2xl font-extrabold text-gray-800 mt-4 mb-1">
                        AutoWeb
                    </h1>
                    <p class="text-sm text-gray-600">
                        Faça login para acessar o sistema
                    </p>
                </div>
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
