@extends('layouts.public')

@section('title', 'Kontak DJM Outdoor')

@section('content')
<div class="flex-grow px-4 sm:px-6 lg:px-8 py-12 max-w-4xl mx-auto space-y-12">
    <a href="{{ url('/') }}" class="inline-flex items-center text-sm text-white hover:underline mb-4">
        ← Kembali ke Halaman Awal
    </a>

    <section>
        <h1 class="text-3xl font-bold mb-4">Hubungi Kami</h1>
        <p class="text-base leading-relaxed text-gray-100 mb-6">
            Kami siap membantu kamu dalam kebutuhan sewa alat outdoor. Jangan ragu untuk menghubungi kami melalui kontak di bawah ini:
        </p>
        <div class="space-y-4 text-gray-100 text-sm">
            <div class="flex items-start space-x-3">
                <img src="{{ asset('images/icons/googlemaps.svg') }}" alt="IkonMaps" class="h-6 w-6 filter invert brightness-0">
                <p>Jl. Ramajaksa No. 1, Kelurahan Winduherang, Kecamatan Cigugur, Kabupaten Kuningan, Jawa Barat</p>
            </div>
            <div class="flex items-start space-x-3">
                <img src="{{ asset('images/icons/whatsapp.svg') }}" alt="IkonWhatsApp" class="h-6 w-6 filter invert brightness-0">
                <p>
                    WhatsApp: 
                    <a href="https://wa.me/6285797162085" target="_blank" class="underline hover:text-green-300">+62 857-9716-2085</a>
                </p>
            </div>
            <div class="flex items-start space-x-3">
                <img src="{{ asset('images/icons/instagram.svg') }}" alt="IkonInstagram" class="h-6 w-6 filter invert brightness-0">
                <p>
                    Instagram: 
                    <a href="https://instagram.com/djm.outdoor" target="_blank" class="underline hover:text-green-300">@djm.outdoor</a>
                </p>
            </div>
            <div class="flex items-start space-x-3">
                <img src="{{ asset('images/icons/clock.svg') }}" alt="IkonJamOperasional" class="h-6 w-6 filter invert brightness-0">
                <p>Jam Operasional: Senin - Sabtu, 08.00 - 18.00</p>
            </div>
        </div>
    </section>
</div>
@endsection
