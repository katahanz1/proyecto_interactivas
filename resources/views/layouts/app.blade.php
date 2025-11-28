<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Library System') }}</title>


        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-primary-50">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')


            @isset($header)
                <header class="bg-white border-b border-primary-200">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset


            <main class="flex-1">
                {{ $slot }}
            </main>


            <footer class="bg-white border-t border-primary-200 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <p class="text-center text-sm text-primary-600">
                        &copy; {{ date('Y') }} Sistema de Biblioteca. Todos los derechos reservados.
                    </p>
                </div>
            </footer>
        </div>
    </body>
</html>
