@extends('layouts.public')

@section('title', 'DJM Outdoor')

@section('content')
<div class ="flex flex-col flex-grow items-center justify-center text-center px-6 py-12">
    <img src="{{ asset('images/logoDJM.png') }}" alt="DJM Logo"
            class="mx-auto w-40 mb-6 drop-shadow-lg hover:scale-105 transition duration-500">

    <h1 class="text-5xl font-extrabold mb-3 tracking-widest uppercase">DJM Outdoor</h1>
    <p class="text-lg text-gray-200 italic mb-6">
        Jasa sewa peralatan hiking, camping & trail run dengan sentuhan kalcer —<br>
        hemat, ringan, dan siap menjelajah!
    </p>

    <div class="space-x-4 mb-2">
        <a href="{{ route('login') }}"
            class="inline-block px-6 py-3 bg-white text-green-900 font-bold rounded-full shadow hover:bg-yellow-200 transition">
            Masuk
        </a>
        <a href="{{ route('register') }}"
            class="inline-block px-6 py-3 border-2 border-white rounded-full font-semibold hover:bg-white hover:text-green-900 transition">
            Gabung Sekarang
        </a>
    </div>

    {{-- Kenapa Pilih Kami --}}
    <section class="mt-16 px-6 text-center max-w-5xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Kenapa Pilih DJM Outdoor ?</h2>
        <div class="grid md:grid-cols-3 gap-6 text-left text-sm text-gray-200">
            <div>
                <h3 class="font-semibold text-lg">💰 Harga Terjangkau</h3>
                <p>Mulai Rp 10.000/hari. Cocok untuk semua kalangan.</p>
            </div>
            <div>
                <h3 class="font-semibold text-lg">🎒 Peralatan Lengkap</h3>
                <p>Tenda, matras, kompor, kursi, headlamp, dan masih banyak lagi.</p>
            </div>
            <div>
                <h3 class="font-semibold text-lg">🚚 Antar-Jemput</h3>
                <p>Layanan pengantaran & pengambilan barang sewaan.</p>
            </div>
        </div>
    </section>

    {{-- Galeri Produk --}}
    <section class="mt-20 px-6 text-center max-w-6xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Galeri Produk</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 rounded-xl">
            <img src="{{ asset('storage/barang/TendaTendaki.jpg') }}" class="rounded shadow hover:scale-105 transition" alt="TendaTendaki">
            <img src="{{ asset('storage/barang/KomporWindProof.jpg') }}" class="rounded shadow hover:scale-105 transition" alt="KomporWindProof">
            <img src="{{ asset('storage/barang/KursiLipat.jpg') }}" class="rounded shadow hover:scale-105 transition" alt="KursiLipat">
            <img src="{{ asset('storage/barang/HeadLamp.jpg') }}" class="rounded shadow hover:scale-105 transition" alt="HeadLamp">
        </div>
    </section>

    {{-- Testimoni --}}
    <section class="mt-20 px-6 text-center max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Apa Kata Mereka ?</h2>
        <div class="space-y-6 text-left">
            <blockquote class="bg-white/10 p-4 rounded shadow text-sm italic border-l-4 border-yellow-400">
                “Barangnya bersih dan terawat. Booking online nya juga simpel banget!” — <span class="not-italic font-semibold">Dicky, Kuningan</span>
            </blockquote>
            <blockquote class="bg-white/10 p-4 rounded shadow text-sm italic border-l-4 border-yellow-400">
                “Dipake untuk camping keluarga cukup hemat, karna banyak paket hematnya!” — <span class="not-italic font-semibold">Wulan, Kuningan</span>
            </blockquote>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="mt-20 px-6 text-center max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Pertanyaan Umum</h2>
        <div class="space-y-4 text-left text-sm text-gray-200">
            <div>
                <h3 class="font-semibold">Bagaimana cara memesan barangnya ?</h3>
                <p>Buat akun, pilih barang, isi data penyewaan, lalu lakukan pembayaran.</p>
            </div>
            <div>
                <h3 class="font-semibold">Apakah bisa bayar di tempat ?</h3>
                <p>Ya, tersedia metode COD untuk wilayah tertentu.</p>
            </div>
        </div>
    </section>
</div>
@endsection