@extends('layouts.app')

@section('title', 'Detail Penyewaan')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Detail Penyewaan
    </h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-4xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur-md text-gray-900">

        <div class="flex justify-end mb-4">
            <x-button-pdf :href="route('admin.penyewaan.cetak', $penyewaan->id)" />
        </div>
        <h3 class="text-lg font-bold mb-4">Informasi Penyewa</h3>
        <p><strong>Nama :</strong> {{ $penyewaan->user->name }}</p>
        <p><strong>Email :</strong> {{ $penyewaan->user->email }}</p>

        <h3 class="text-lg font-bold mt-6 mb-4">Detail Penyewaan</h3>
        <p><strong>Tanggal Ambil :</strong> {{ \Carbon\Carbon::parse($penyewaan->tanggal_ambil)->translatedFormat('d M Y') }}</p>
        <p><strong>Tanggal Kembali :</strong> {{ \Carbon\Carbon::parse($penyewaan->tanggal_kembali)->translatedFormat('d M Y') }}</p>
        <p><strong>Metode Pengambilan :</strong> 
            {{ $penyewaan->metode_pengambilan === 'ambil' ? 'Ambil Sendiri' : 'Antar ke Alamat' }}
        </p>

        @if ($penyewaan->metode_pengambilan === 'antar')
            <p><strong>Alamat Pengantaran:</strong>
                <span class="whitespace-pre-line">{{ $penyewaan->alamat_pengantaran }}</span>
            </p>
        @endif
        @if ($penyewaan->tanggal_pengembalian)
            <p><strong>Tanggal Pengembalian :</strong>
                {{ \Carbon\Carbon::parse($penyewaan->tanggal_pengembalian)->translatedFormat('d M Y H:i') }}
            </p>
        @endif
        <p><strong>Status :</strong>
            <span class="px-2 py-1 rounded-full text-sm {{ match($penyewaan->status) {
                'menunggu' => 'bg-yellow-200 text-yellow-800',
                'disetujui' => 'bg-green-200 text-green-800',
                'ditolak' => 'bg-red-200 text-red-800',
                'dikembalikan' => 'bg-yellow-200 text-yellow-800',
                'dibatalkan' => 'bg-gray-200 text-gray-800',
                'selesai' => 'bg-green-200 text-green-800',
                default => 'bg-gray-200 text-gray-800',
            } }}">
                {{ ucfirst($penyewaan->status) }}
            </span>
        </p>
        <p><strong>Jenis Identitas :</strong> {{ $penyewaan->jenis_identitas }}</p>
        <p><strong>Nomor Identitas :</strong> {{ $penyewaan->nomor_identitas }}</p>
        <p><strong>File Identitas :</strong>
            @if($penyewaan->file_identitas)
                <a href="{{ asset('storage/' . $penyewaan->file_identitas) }}" target="_blank" class="text-blue-700 underline">Lihat</a>
            @else
                <span class="italic text-gray-600">Tidak tersedia</span>
            @endif
        </p>

        <h3 class="text-lg font-bold mt-6 mb-4">Item Disewa</h3>
        <ul class="space-y-1 text-sm">
            @foreach ($penyewaan->details as $detail)
                @php
                    $model = $detail->barang ?? $detail->paket;
                    $nama = $model?->nama ?? 'Tidak ditemukan';
                    $harga = number_format($detail->harga_sewa, 0, ',', '.');
                    $jumlah = $detail->jumlah;
                    $stok = $model?->stok !== null ? $model->stok : 'N/A';
                @endphp
                <li>
                    • {{ $nama }} × {{ $jumlah }} (Rp{{ $harga }}/hari)
                    <span class="text-xs text-gray-500 italic">
                        — Stok tersisa : {{ $stok }}
                    </span>
                </li>
            @endforeach
        </ul>

        <h3 class="text-lg font-bold mt-6 mb-2">Total</h3>
        <p><strong>Total Hari :</strong> {{ $penyewaan->total_hari }} hari</p>
        <p><strong>Total Biaya :</strong> Rp. {{ number_format($penyewaan->total_biaya, 0, ',', '.') }}</p>
        <p><strong>Denda :</strong> Rp. {{ number_format($penyewaan->denda, 0, ',', '.') }}</p>
        <p><strong>Total Bayar :</strong> Rp. {{ number_format($penyewaan->total_bayar, 0, ',', '.') }}</p>
        <p><strong>Status Pembayaran :</strong>
            <span class="px-2 py-1 rounded-full text-sm {{ match($penyewaan->status_pembayaran) {
                'belum_bayar' => 'bg-red-200 text-red-800',
                'menunggu_verifikasi' => 'bg-yellow-200 text-yellow-800',
                'terverifikasi' => 'bg-green-200 text-green-800',
                default => 'bg-gray-200 text-gray-800',
            } }}">
                {{ ucfirst(str_replace('_', ' ', $penyewaan->status_pembayaran)) }}
            </span>
        </p>
        <p><strong>Metode Pembayaran :</strong> {{ strtoupper($penyewaan->metode_pembayaran) }}</p>

        @if ($penyewaan->bukti_pembayaran)
            <p><strong>Bukti Pembayaran :</strong>
                <a href="{{ asset('storage/' . $penyewaan->bukti_pembayaran) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
            </p>
        @endif

        @if (
            $penyewaan->metode_pembayaran === 'transfer' &&
            $penyewaan->status_pembayaran === 'menunggu_verifikasi' &&
            in_array($penyewaan->status, ['menunggu', 'disetujui', 'dikembalikan'])
        )
            <form action="{{ route('admin.penyewaan.verifikasi', $penyewaan->id) }}" method="POST" class="mt-3"
                onsubmit="return confirm('Yakin ingin memverifikasi pembayaran ini ?')">
                @csrf
                @method('PATCH')
                <x-primary-button>Verifikasi Pembayaran</x-primary-button>
            </form>
        @endif

        @if (
            $penyewaan->status === 'menunggu' &&
            !($penyewaan->metode_pembayaran === 'transfer' && $penyewaan->status_pembayaran === 'terverifikasi')
        )
            <div class="mt-6 flex gap-4">
                <form action="{{ route('admin.penyewaan.approval', [$penyewaan->id, 'action' => 'setujui']) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <x-primary-button>
                        Setujui
                    </x-primary-button>
                </form>

                <form action="{{ route('admin.penyewaan.approval', [$penyewaan->id, 'action' => 'tolak']) }}" method="POST" class="inline" 
                    onsubmit="return confirm('Yakin ingin menolak penyewaan ini ?')">
                    @csrf
                    @method('PATCH')
                    <x-danger-button>
                        Tolak
                    </x-danger-button>
                </form>
            </div>
        @endif

        @if ($penyewaan->isBisaDiselesaikan())
            <form action="{{ route('admin.penyewaan.selesai', $penyewaan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyelesaikan penyewaan ini ?')">
                @csrf
                @method('PATCH')
                <x-primary-button class="mt-4">
                    Selesai
                </x-primary-button>
            </form>
        @endif

        <div class="mt-6">
            <a href="{{ route('admin.penyewaan.index') }}" class="text-sm text-gray-600 underline hover:text-black">← Kembali</a>
        </div>
    </div>
</div>
@endsection
