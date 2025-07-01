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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-dashboard-card title="Total Penyewaan" :value="$totalPenyewaan" />
                <x-dashboard-card title="Total Pendapatan" :value="'Rp ' . number_format($totalPendapatan, 0, ',', '.')" />
                <x-dashboard-card title="Total User" :value="$totalUser" />
                <x-dashboard-card title="Total Barang" :value="$totalBarang" />
                <x-dashboard-card title="Total Paket" :value="$totalPaket" />
            </div>

            <div class="bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Penyewaan per Bulan ({{ now()->year }})</h3>
                <ul class="space-y-2 text-sm text-gray-800">
                    @foreach(range(1, 12) as $bulan)
                        @php
                            $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
                            $jumlah = $penyewaanPerBulan[$bulan] ?? 0;
                        @endphp
                        <li>{{ $namaBulan }} : {{ $jumlah }} transaksi</li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Statistik Status Penyewaan</h3>
                <ul class="space-y-2 text-sm text-gray-800">
                    @foreach ($statByStatus as $status => $total)
                        <li class="flex items-center gap-2">
                            <span class="inline-block text-xs font-semibold px-2 py-1 rounded-full
                                @switch($status)
                                    @case('menunggu') bg-yellow-200 text-yellow-800
                                    @case('disetujui') bg-green-200 text-green-800
                                    @case('selesai') bg-green-200 text-green-800
                                    @default bg-gray-200 text-gray-800
                                @endswitch">
                                {{ ucfirst($status) }}
                            </span>
                            <span>{{ $total }} transaksi</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Statistik Status Pembayaran</h3>
                <ul class="space-y-2 text-sm text-gray-800">
                    <li class="flex items-center gap-2">
                        <span class="inline-block text-xs font-semibold px-2 py-1 rounded-full bg-yellow-200 text-yellow-800">
                            Menunggu Verifikasi
                        </span>
                        <span>{{ $jumlahMenunggu }} transaksi</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="inline-block text-xs font-semibold px-2 py-1 rounded-full bg-red-200 text-red-800">
                            Belum Bayar
                        </span>
                        <span>{{ $jumlahBelumBayar }} transaksi</span>
                    </li>
                </ul>
            </div>
            <div class="bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Grafik Penyewaan per Bulan</h3>
                <canvas id="chartPenyewaanBulanan" height="100"></canvas>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        const ctx = document.getElementById('chartPenyewaanBulanan').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_map(fn($m) => \Carbon\Carbon::create()->month($m)->translatedFormat('F'), range(1, 12))) !!},
                datasets: [{
                    label: 'Jumlah Penyewaan',
                    data: {!! json_encode(array_values($penyewaanPerBulan->toArray())) !!},
                    backgroundColor: 'rgba(34,197,94,0.5)',
                    borderColor: 'rgba(34,197,94,1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        stepSize: 1
                    }
                }
            }
        });
    </script>
    @endpush
@endsection
