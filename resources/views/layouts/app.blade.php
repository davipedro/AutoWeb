<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>@yield('title')</title>

        <link rel="icon" href="{{ asset('assets/images/logo.svg') }}" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    </head>

    <body>
        <!-- Aqui importa a navbar -->
        @if (request()->routeIs('catalogo') && !(auth()->check()))
            @include('partials.catalog-navbar')
        @else
            @include('partials.navbar')
        @endif

        <main style="padding: 2rem;">
            @yield('content')
        </main>

        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    </body>

</html>
