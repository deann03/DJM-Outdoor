@extends('layouts.app')

@section('title', 'Kelola Penyewaan')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Penyewaan</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow backdrop-blur">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Penyewaan</h3>

        @if(session('success'))
            <div class="mb-4 text-white font-medium bg-green-800 p-3 rounded-xl shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <div class="mb-6 flex flex-wrap gap-2 justify-center sm:justify-start">
                @php
                    $statuses = ['' => 'Semua', 'menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'dibatalkan' => 'Dibatalkan', 'selesai' => 'Selesai'];
                    $active = request('status');
                @endphp

                @foreach ($statuses as $key => $label)
                    <a href="{{ route('admin.penyewaan.index', ['status' => $key]) }}"
                        class="px-4 py-1 rounded-full text-sm font-medium transition
                               {{ $active === $key ? 'bg-green-800 text-white' : 'bg-white/50 text-gray-800 hover:bg-white' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <table class="w-full table-auto text-left text-gray-900">
                <thead>
                    <tr class="border-b border-green-700 font-semibold">
                        <th class="px-4 py-2">Penyewa</th>
                        <th class="px-4 py-2">Tanggal Ambil</th>
                        <th class="px-4 py-2">Tanggal Kembali</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Pembayaran</th>
                        <th class="px-4 py-2 text-right">Total Biaya</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penyewaans as $penyewaan)
                        <tr class="border-b hover:bg-green-50 transition">
                            <td class="px-4 py-2">{{ $penyewaan->user->name }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($penyewaan->tanggal_ambil)->translatedFormat('d-M-Y') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($penyewaan->tanggal_kembali)->translatedFormat('d-M-Y') }}</td>
                            <td class="px-4 py-2 text-center">
                                <span class="px-2 py-1 rounded-full text-sm {{ match($penyewaan->status) {
                                    'menunggu' => 'bg-yellow-200 text-yellow-800',
                                    'disetujui' => 'bg-green-200 text-green-800',
                                    'ditolak' => 'bg-red-200 text-red-800',
                                    'dibatalkan' => 'bg-gray-200 text-gray-800',
                                    'dikembalikan' => 'bg-yellow-200 text-yellow-800',
                                    'selesai' => 'bg-green-200 text-green-800'
                                } }}">
                                    {{ ucfirst($penyewaan->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="px-2 py-1 rounded-full text-sm {{ match($penyewaan->status_pembayaran) {
                                    'belum_bayar' => 'bg-red-200 text-red-800',
                                    'menunggu_verifikasi' => 'bg-yellow-200 text-yellow-800',
                                    'terverifikasi' => 'bg-green-200 text-green-800',
                                    default => 'bg-gray-200 text-gray-800',
                                } }}">
                                    {{ ucfirst(str_replace('_', ' ', $penyewaan->status_pembayaran)) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                Rp. {{ number_format($penyewaan->total_bayar, 0, ',', '.') }}
                                <div class="text-xs text-gray-600 italic">{{ strtoupper($penyewaan->metode_pembayaran) }}</div>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('admin.penyewaan.show', $penyewaan->id) }}" class="text-sm text-blue-600 hover:underline">Lihat</a>

                                @if($penyewaan->status === 'disetujui')
                                    <form action="{{ route('admin.penyewaan.selesai', $penyewaan->id) }}" method="POST" class="inline ml-2"
                                          onsubmit="return confirm('Tandai penyewaan ini sebagai selesai?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-sm text-green-700 hover:underline">
                                            Selesaikan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 italic text-gray-600">Belum ada data penyewaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
