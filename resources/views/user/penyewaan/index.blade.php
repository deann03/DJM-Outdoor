@extends('layouts.app')

@section('title', 'Riwayat Penyewaan')

@section('header')
<h2 class="text-xl font-semibold text-gray-800 leading-tight">
    Riwayat Penyewaan
</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow backdrop-blur">
        @if(session('success'))
            <div class="mb-4 bg-green-800 text-white font-medium p-3 rounded-xl shadow">
                {{ session('success') }}
            </div>
        @endif

        <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Penyewaan</h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left text-gray-900">
                <thead>
                    <tr class="border-b border-green-700 font-semibold">
                        <th class="px-4 py-2">Tanggal Ambil</th>
                        <th class="px-4 py-2">Tanggal Kembali</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Pembayaran</th>
                        <th class="px-4 py-2 text-right">Total Bayar</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penyewaans as $penyewaan)
                        <tr class="border-b hover:bg-green-50 transition">
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($penyewaan->tanggal_ambil)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($penyewaan->tanggal_kembali)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 text-center">
                                <span class="px-2 py-1 rounded-full text-sm {{ match($penyewaan->status) {
                                    'menunggu' => 'bg-yellow-300 text-yellow-900',
                                    'disetujui' => 'bg-green-300 text-green-900',
                                    'ditolak' => 'bg-red-300 text-red-900',
                                    'dibatalkan' => 'bg-gray-400 text-white',
                                    default => 'bg-gray-200 text-gray-800',
                                } }}">
                                    {{ ucfirst($penyewaan->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="block text-xs text-gray-800">
                                    {{ strtoupper($penyewaan->metode_pembayaran) }}
                                </span>
                                <span class="px-2 py-1 mt-1 rounded-full text-xs inline-block {{ match($penyewaan->status_pembayaran) {
                                    'sudah_bayar' => 'bg-green-300 text-green-900',
                                    'menunggu_verifikasi' => 'bg-yellow-300 text-yellow-900',
                                    'belum_bayar' => 'bg-red-300 text-red-900',
                                    default => 'bg-gray-200 text-gray-800',
                                } }}">
                                    {{ str_replace('_', ' ', ucfirst($penyewaan->status_pembayaran)) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">Rp{{ number_format($penyewaan->total_bayar, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('user.penyewaan.show', $penyewaan->id) }}"
                                   class="inline-block text-sm text-blue-600 hover:underline">Lihat</a>

                                @if ($penyewaan->status === 'menunggu')
                                    <form action="{{ route('user.penyewaan.batal', $penyewaan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin membatalkan penyewaan ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-sm text-red-600 hover:underline">Batalkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 italic text-gray-600">Belum ada data penyewaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('showFooter', '1')
