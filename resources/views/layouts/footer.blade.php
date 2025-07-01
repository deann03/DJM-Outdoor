<footer class="bg-white/70 backdrop-blur-md shadow mt-8">
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-700">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logoDJM.png') }}" class="w-6 h-6" alt="logo">
            <span class="font-semibold">DJM Outdoor Equipment</span>
        </div>
        <div class="mt-2 md:mt-0">
            &copy; {{ date('Y') }} Dibangun dengan semangat petualang
        </div>
        <div class="space-x-4 mt-2 md:mt-0">
            <a href="{{ route('user.informasi.tentang') }}" class="hover:underline">Tentang</a>
            <a href="{{ route('user.informasi.kontak') }}" class="hover:underline">Kontak</a>
        </div>
    </div>
</footer>
