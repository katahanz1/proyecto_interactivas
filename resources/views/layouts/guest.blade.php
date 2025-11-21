<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Library System') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-primary-50 to-primary-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <!-- Logo Section -->
            <div class="mb-8">
                <a href="/" class="inline-flex items-center gap-3">
                    <div class="p-2 bg-white rounded-lg border border-primary-200 shadow-sm">
                        <x-application-logo class="w-8 h-8 fill-current text-primary-800" />
                    </div>
                    <span class="font-bold text-2xl text-primary-900 hidden sm:inline">Biblioteca</span>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md animate-slideInUp">
                <div class="card shadow-md">
                    {{ $slot }}
                </div>

                <!-- Footer Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-primary-600">
                        © {{ date('Y') }} Sistema de Biblioteca. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
