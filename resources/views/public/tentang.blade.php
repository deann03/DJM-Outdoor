@extends('layouts.public')

@section('title', 'Tentang DJM Outdoor')

@section('content')
<div class="flex-grow px-4 sm:px-6 lg:px-8 py-12 max-w-4xl mx-auto space-y-12">
    <a href="{{ url('/') }}" class="inline-flex items-center text-sm text-white hover:underline mb-4">
        ← Kembali ke Halaman Awal
    </a>

    <section>
        <h1 class="text-3xl font-bold mb-4">Tentang DJM Outdoor</h1>
        <p class="leading-relaxed text-base text-gray-100">
            <strong>DJM Outdoor</strong> adalah penyedia layanan penyewaan perlengkapan kegiatan alam terbuka seperti hiking, camping, dan trail run. Berdiri sejak <strong>2023</strong>, kami hadir untuk memberikan solusi sewa yang praktis, berkualitas, dan terjangkau bagi siapa pun yang ingin menikmati alam tanpa ribet.
        </p>
    </section>

    <section class="grid md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-xl font-semibold mb-3">Visi</h2>
            <p class="text-gray-100">
                Menjadi platform penyewaan outdoor terdepan di Indonesia yang mengedepankan kemudahan, kenyamanan, dan kepuasan pelanggan.
            </p>
        </div>
        <div>
            <h2 class="text-xl font-semibold mb-3">Misi</h2>
            <ul class="list-disc list-inside space-y-1 text-gray-100">
                <li>Menyediakan perlengkapan outdoor yang berkualitas dan bersih.</li>
                <li>Memberikan sistem pemesanan online yang mudah dan efisien.</li>
                <li>Menjamin harga yang transparan dan layanan yang ramah.</li>
                <li>Mendukung gaya hidup aktif dan cinta alam.</li>
            </ul>
        </div>
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">Keunggulan Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-100">
            <ul class="list-disc list-inside space-y-2">
                <li>Stok real-time dan selalu diperbarui.</li>
                <li>Opsi antar-jemput alat sewa ke lokasi Anda.</li>
                <li>Antarmuka pemesanan simpel & mobile-friendly.</li>
            </ul>
            <ul class="list-disc list-inside space-y-2">
                <li>Opsi pembayaran lengkap: transfer dan bayar di tempat.</li>
                <li>Tim kami cepat tanggap, ramah, dan berpengalaman.</li>
            </ul>
        </div>
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-3">Komitmen Kami</h2>
        <p class="text-gray-100 leading-relaxed">
            Kami percaya bahwa menjelajah alam tidak harus mahal atau merepotkan. DJM Outdoor hadir sebagai mitra petualangan Anda, menyediakan perlengkapan terbaik untuk setiap ekspedisi yang aman, menyenangkan, dan tak terlupakan.
        </p>
    </section>

    {{-- Slogan --}}
    <section class="bg-white/10 p-6 rounded-xl shadow text-center">
        <p class="text-xl italic text-white">
            "Yuk, <strong>#SewaAjaDulu</strong> bareng DJM Outdoor — petualangan lebih hemat, ringan, dan siap menjelajah!"
        </p>
    </section>
</div>
@endsection