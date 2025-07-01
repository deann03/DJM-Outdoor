<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'DJM Outdoor')</title>

    <link rel="icon" href="{{ asset('images/logoDJM.png') }}" type="image/png">
    @vite('resources/css/app.css')

    <style>
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url('{{ asset('images/BGForest.jpg') }}') no-repeat center center / cover;
            opacity: 0.25;
            z-index: -1;
        }
    </style>

    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gradient-to-b from-green-950 to-green-800 min-h-screen flex flex-col text-white font-sans">

    {{-- Header --}}
    <header
        x-data="{ lastScroll: 0, hidden: false }"
        x-init="window.addEventListener('scroll', () => {
            let curr = window.scrollY;
            hidden = curr > lastScroll && curr > 100;
            lastScroll = curr;
        })"
        :class="{ '-translate-y-full': hidden }"
        class="sticky top-0 z-50 bg-green/70 backdrop-blur-sm shadow-md p-4 flex justify-between items-center text-white transition-transform duration-300"
    >
        <div class="font-bold tracking-wider">DJM Outdoor</div>
        <nav class="space-x-6">
            <div x-data="{ open: false }" class="relative inline-block text-left">
                <button
                    @click="open = !open"
                    @click.away="open = false"
                    class="hover:underline focus:outline-none"
                >
                    Informasi
                </button>

                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="absolute left-0 mt-2 w-44 bg-gray-900/10 backdrop-blur-sm text-white rounded shadow-lg z-50"
                >
                    <a href="{{ route('tentang') }}" class="block px-4 py-2 text-sm hover:bg-green-100/20">Tentang</a>
                    <a href="{{ route('kontak') }}" class="block px-4 py-2 text-sm hover:bg-green-100/20">Kontak</a>
                </div>
            </div>
            <a href="{{ route('login') }}" class="hover:underline">Masuk</a>
            <a href="{{ route('register') }}" class="hover:underline">Daftar</a>
        </nav>
    </header>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-green-950 text-gray-300 text-sm mt-20 pt-10 pb-6 px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-2">DJM Outdoor</h3>
                <p class="text-gray-400">
                    Sewa perlengkapan hiking, camping & trail run dengan mudah, hemat, dan siap digunakan. Berdiri sejak 2023.
                </p>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-2">Navigasi</h4>
                <ul class="space-y-1">
                    <li><a href="{{ route('tentang') }}" class="hover:underline">Tentang Kami</a></li>
                    <li><a href="{{ route('login') }}" class="hover:underline">Masuk</a></li>
                    <li><a href="{{ route('register') }}" class="hover:underline">Daftar</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-2">Kontak</h4>
                <p>Whatsapp : <a href="https://wa.me/6285797162085" class="hover:underline">+62 812-3456-7890</a></p>
                <p>Lokasi : Jl. Ramajaksa No. 1, Winduherang, Cigugur, Kuningan, Jawa Barat</p>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-2">Ikuti Kami</h4>
                <div class="flex space-x-4 items-center">
                    <a href="https://instagram.com/djm.outdoor" target="_blank" rel="noopener" class="flex items-center space-x-2 hover:opacity-80">
                        <img src="{{ asset('images/icons/instagram.svg') }}" alt="Instagram" class="w-6 h-6 filter invert brightness-0">
                        <span class="text-sm text-white">@djm.outdoor</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-4 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} DJM Outdoor • Dobrig Jaya Muda Outdoor Equipment. All rights reserved.
        </div>
    </footer>

    {{-- Scroll ke Atas --}}
    <div
        x-data="{ visible: false }"
        x-init="window.addEventListener('scroll', () => visible = window.scrollY > 300)"
        x-show="visible"
        x-transition
        class="fixed bottom-6 right-6 z-50"
    >
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="bg-green-700 hover:bg-green-600 text-white p-3 rounded-full shadow-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>
    </div>
</body>
</html>
