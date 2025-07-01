@extends('layouts.app')

@section('title', 'Kontak DJM Outdoor')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Kontak DJM Outdoor') }}
    </h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-md space-y-8">
        <h3 class="text-2xl font-semibold mb-4 text-gray-900">Hubungi Kami</h3>
        <p class="text-base leading-relaxed text-gray-700 mb-6">
            Kami siap membantu kamu dalam kebutuhan sewa alat outdoor. Jangan ragu untuk menghubungi kami melalui kontak di bawah ini :
        </p>
        <div class="space-y-3 text-gray-700">
            <div class="flex flex-col md:flex-row items-start space-x-3">
                <img src="{{ asset('images/icons/googlemaps.svg') }}" alt="IkonMaps" class="h-6 w-6">
                <p>Jl. Ramajaksa No. 1, Kelurahan Winduherang, Kecamatan Cigugur, Kabupaten Kuningan, Jawa Barat</p>
            </div>
            <div class="flex flex-col md:flex-row items-start space-x-3">
                <img src="{{ asset('images/icons/whatsapp.svg') }}" alt="IkonWhatsApp" class="h-6 w-6">
                <p>
                    WhatsApp : 
                    <a href="https://wa.me/6285797162085" target="_blank" class="underline hover:text-emerald-700">+62 857-9716-2085</a>
                </p>
            </div>
            <div class="flex flex-col md:flex-row items-start space-x-3">
                <img src="{{ asset('images/icons/instagram.svg') }}" alt="IkonInstagram" class="h-6 w-6">
                <p>
                    Instagram : 
                    <a href="https://instagram.com/djm.outdoor" target="_blank" class="underline hover:text-emerald-700">@djm.outdoor</a>
                </p>
            </div>
            <div class="flex flex-col md:flex-row items-start space-x-3">
                <img src="{{ asset('images/icons/clock.svg') }}" alt="IkonJamOperasional" class="h-6 w-6">
                <p>Jam Operasional : Senin - Sabtu, 08.00 - 18.00</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('showFooter', '1')
