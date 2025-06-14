<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        @vite('resources/css/app.css')
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title')</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    </head>

    <body>
        {{--@include('partials.navbar') <!-- Aqui importa a navbar -->--}}

        <main style="padding: 2rem;">
            @yield('content')
        </main>
    </body>

</html>
