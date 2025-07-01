<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'DJM Outdoor'))</title>

    <link rel="icon" href="{{ asset('images/logoDJM.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
     <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased overflow-x-hidden">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-lime-300 to-emerald-800">
        @include('layouts.navigation')

        {{-- Header Section --}}
        @hasSection('header')
            <header class="bg-white/70 shadow backdrop-blur-md">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        {{-- Main Content --}}
        <main class="flex-1">
            @yield('content')
        </main>

        {{-- Footer Section --}}
        @if(trim($__env->yieldContent('showFooter')))
            @include('layouts.footer')
        @endif
    </div>
</body>
@stack('scripts')
</html>
