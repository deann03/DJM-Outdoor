@extends('layouts.app')

@section('title', 'Tentang DJM Outdoor')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tentang DJM Outdoor
    </h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-8 rounded-xl shadow-md backdrop-blur-md text-gray-900 space-y-8">

        {{-- Tentang DJM Outdoor --}}
        <section>
            <h3 class="text-2xl font-semibold mb-4">Tentang DJM Outdoor</h3>
            <p class="leading-relaxed text-base">
                <strong>DJM Outdoor</strong> adalah penyedia layanan penyewaan perlengkapan kegiatan alam terbuka seperti hiking, camping, dan trail run. 
                Berdiri sejak <strong>tahun 2023</strong>, kami berkomitmen memberikan solusi penyewaan yang mudah, praktis, dan terpercaya.
            </p>
        </section>

        {{-- Visi & Misi --}}
        <section class="grid md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-lg font-semibold mb-2">Visi</h4>
                <p class="leading-relaxed">
                    Menjadi platform penyewaan outdoor terbaik di Indonesia dengan layanan unggulan dan fokus pada kepuasan pelanggan.
                </p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-2">Misi</h4>
                <ul class="list-disc list-inside space-y-1">
                    <li>Menyediakan perlengkapan outdoor berkualitas tinggi dan terawat.</li>
                    <li>Memudahkan pelanggan melalui sistem pemesanan online.</li>
                    <li>Menjamin harga transparan dan pelayanan nyaman.</li>
                    <li>Memberikan pengalaman profesional dan responsif.</li>
                </ul>
            </div>
        </section>

        {{-- Keunggulan --}}
        <section>
            <h4 class="text-lg font-semibold mb-2">Keunggulan Kami</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <ul class="list-disc list-inside space-y-1">
                    <li>Stok perlengkapan real-time dan selalu diperbarui.</li>
                    <li>Pilihan pengantaran ke rumah atau pengambilan langsung.</li>
                    <li>Interface sistem pemesanan yang simpel dan nyaman.</li>
                </ul>
                <ul class="list-disc list-inside space-y-1">
                    <li>Opsi pembayaran lengkap: transfer & bayar di tempat.</li>
                    <li>Tim kami profesional, cepat tanggap, dan ramah.</li>
                </ul>
            </div>
        </section>

        {{-- Komitmen --}}
        <section>
            <h4 class="text-lg font-semibold mb-2">Komitmen Kami</h4>
            <p class="leading-relaxed">
                Menjelajah alam tak harus ribet dan mahal. DJM Outdoor hadir sebagai mitra terpercaya petualangan Anda, 
                menyediakan perlengkapan terbaik untuk setiap ekspedisi yang aman dan berkesan.
            </p>
        </section>
    </div>
</div>
@endsection

@section('showFooter', '1')
