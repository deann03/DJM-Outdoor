@extends('layouts.app')

@section('title', 'Beranda')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Beranda') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 px-8">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Kartu Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-dashboard-card title="Total Penyewaan" :value="$totalPenyewaan" />
                <x-dashboard-card title="Penyewaan Aktif" :value="$penyewaanAktif" />
                @if ($menungguVerifikasi)
                    <x-dashboard-card title="Menunggu Verifikasi" value="Ada" color="text-yellow-600" />
                @endif
            </div>

            {{-- Riwayat Penyewaan Terakhir --}}
            <div class="bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Penyewaan Terakhir</h3>
                @if ($penyewaanTerakhir->isEmpty())
                    <p class="text-gray-600 italic">Belum ada penyewaan yang tercatat</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto text-sm text-left text-gray-900">
                            <thead class="text-gray-700 font-medium">
                                <tr class="font-medium border-b border-green-700">
                                    <th class="px-4 py-2">Tanggal Ambil</th>
                                    <th class="px-4 py-2">Tanggal Kembali</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Metode Bayar</th>
                                    <th class="px-4 py-2">Status Bayar</th>
                                    <th class="px-4 py-2">Total Bayar</th>
                                    <th class="px-4 py-2">Info Tambahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penyewaanTerakhir as $p)
                                    <tr class="border-b hover:bg-green-50 transition">
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($p->tanggal_ambil)->translatedFormat('d M Y') }}</td>
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($p->tanggal_kembali)->translatedFormat('d M Y') }}</td>
                                        <td class="px-4 py-2">
                                            <span class="inline-block px-2 py-1 text-xs rounded-full
                                                @if ($p->status == 'menunggu') bg-yellow-100 text-yellow-700
                                                @elseif ($p->status == 'disetujui') bg-blue-100 text-blue-700
                                                @elseif ($p->status == 'selesai') bg-green-100 text-green-700
                                                @elseif ($p->status == 'ditolak') bg-red-100 text-red-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 capitalize">{{ $p->metode_pembayaran }}</td>
                                        <td class="px-4 py-2 capitalize">
                                            <span class="text-xs px-2 py-1 rounded-full
                                                @if ($p->status_pembayaran === 'terverifikasi') bg-green-100 text-green-700
                                                @elseif ($p->status_pembayaran === 'belum_bayar') bg-red-100 text-red-700
                                                @elseif ($p->status_pembayaran === 'menunggu_verifikasi') bg-yellow-100 text-yellow-700
                                                @else bg-gray-100 text-gray-700
                                                @endif">
                                                {{ str_replace('_', ' ', ucfirst($p->status_pembayaran)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">Rp{{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-sm space-y-1">
                                            @if ($p->denda > 0)
                                                <span class="text-red-600 font-semibold block">Denda: Rp{{ number_format($p->denda, 0, ',', '.') }}</span>
                                            @endif
                                            @if ($p->status === 'disetujui')
                                                @php
                                                    $sisa = ceil(now()->diffInHours($p->tanggal_kembali, false) / 24);
                                                @endphp
                                                @if ($sisa > 0)
                                                    <span class="text-emerald-700">Sisa {{ $sisa }} hari</span>
                                                @elseif ($sisa === 0)
                                                    <span class="text-yellow-700">Kembali hari ini</span>
                                                @else
                                                    <span class="text-red-600">Terlambat {{ abs($sisa) }} hari</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

@section('showFooter', '1')
