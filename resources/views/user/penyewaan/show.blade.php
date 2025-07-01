@extends('layouts.app')

@section('title', 'Detail Penyewaan')

@section('header')
<h2 class="text-xl font-semibold text-gray-800 leading-tight">
    Detail Penyewaan
</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur-md text-gray-900">
        <div class="mt-6">
            <x-button-pdf href="{{ route('user.penyewaan.cetak', $penyewaan->id) }}">
                Cetak Bukti Transaksi (PDF)
            </x-button-pdf>
        </div>

        <h2 class="text-xl font-semibold text-gray-800 leading-tight mb-4">Detail Transaksi</h2>
        <hr class="my-4 border-green-700">
        <p><strong>Tanggal Ambil:</strong> {{ \Carbon\Carbon::parse($penyewaan->tanggal_ambil)->translatedFormat('d M Y') }}</p>
        <p><strong>Tanggal Kembali:</strong> {{ \Carbon\Carbon::parse($penyewaan->tanggal_kembali)->translatedFormat('d M Y') }}</p>
        <p><strong>Metode Pengambilan:</strong>
            {{ $penyewaan->metode_pengambilan === 'ambil' ? 'Ambil Sendiri' : 'Antar ke Alamat' }}
        </p>

        @if ($penyewaan->metode_pengambilan === 'antar')
            <p><strong>Alamat Pengantaran:</strong> {{ $penyewaan->alamat_pengantaran }}</p>
        @endif

        @if ($penyewaan->tanggal_pengembalian)
            <p><strong>Tanggal Pengembalian:</strong>
                {{ \Carbon\Carbon::parse($penyewaan->tanggal_pengembalian)->translatedFormat('d M Y H:i') }}
            </p>
        @endif

        <p><strong>Status:</strong> {{ ucfirst($penyewaan->status) }}</p>
        <p><strong>Durasi:</strong> {{ $penyewaan->total_hari }} hari</p>
        <p><strong>Total Biaya:</strong> Rp{{ number_format($penyewaan->total_biaya, 0, ',', '.') }}</p>

        <h3 class="text-lg font-bold mt-6 mb-2">Pembayaran</h3>
        <p><strong>Metode Pembayaran:</strong> {{ strtoupper($penyewaan->metode_pembayaran) }}</p>
        @php
            $statusPembayaran = match($penyewaan->status_pembayaran) {
                'belum_bayar' => 'Belum Dibayar',
                'menunggu_verifikasi' => 'Menunggu Verifikasi Admin',
                'terverifikasi' => 'Terverifikasi',
                default => ucfirst($penyewaan->status_pembayaran),
            };
        @endphp

        <p><strong>Status Pembayaran:</strong> {{ $statusPembayaran }}</p>

        @if ($penyewaan->metode_pembayaran === 'transfer' && $penyewaan->bukti_pembayaran)
            <p class="mt-2"><strong>Bukti Pembayaran:</strong></p>
            <img src="{{ asset('storage/' . $penyewaan->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="w-64 border rounded mt-2">
        @endif

        @if ($penyewaan->tanggal_bayar)
            <p><strong>Tanggal Pembayaran:</strong> {{ \Carbon\Carbon::parse($penyewaan->tanggal_bayar)->translatedFormat('d M Y H:i') }}</p>
        @endif

        <h3 class="text-lg font-bold mt-6 mb-2">Item Disewa</h3>
        <ul class="text-sm space-y-1">
            @foreach ($penyewaan->details as $detail)
                @php
                    $nama = $detail->barang?->nama ?? $detail->paket?->nama;
                    $harga = number_format($detail->harga_sewa, 0, ',', '.');
                @endphp
                <li>• {{ $nama }} × {{ $detail->jumlah }} (Rp{{ $harga }}/hari)</li>
            @endforeach
        </ul>

        <p class="mt-2 text-sm text-gray-600">Total Item: {{ $penyewaan->details->count() }}</p>

        @if ($penyewaan->status === 'disetujui')
        <div class="mt-6 flex gap-4">
            <form action="{{ route('user.penyewaan.kembalikan', $penyewaan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengembalikan barang?')">
                @csrf
                @method('PATCH')
                <x-primary-button>
                    Kembalikan Barang
                </x-primary-button>
            </form>
        </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('user.penyewaan.index') }}" class="text-sm text-gray-600 underline hover:text-black">← Kembali</a>
        </div>
    </div>
</div>
@endsection
