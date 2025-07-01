@extends('layouts.app')

@section('title', 'Produk')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Produk
</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="text-white font-medium mb-4 bg-green-800 p-3 rounded-xl shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex flex-wrap justify-between items-end gap-4 bg-white/70 backdrop-blur-md rounded-xl px-4 py-4 shadow-md">
        {{-- Form Filter --}}
            <form method="GET" action="{{ route('user.katalog.index') }}" id="filter-form"
                class="flex flex-wrap gap-4">

                {{-- Pencarian --}}
                <div class="flex flex-col">
                    <x-input-label for="search" :value="__('Search')" />
                    <x-text-input id="search" name="search" type="text" value="{{ request('search') }}" placeholder="Cari barang atau paket..." class="mt-1 w-56 text-sm px-2 py-1" />
                </div>

                {{-- Kategori --}}
                <div class="flex flex-col">
                    <x-input-label for="kategori" :value="__('Kategori barang :')" />
                    <select name="kategori" id="kategori" class="mt-1 w-48 text-sm px-2 py-1 bg-white/30 text-gray-900 border-green-700 rounded-lg focus:ring-green-600 focus:border-green-600">
                        <option value="">Semua</option>
                        @foreach ($daftarKategori as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $kategori)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis --}}
                <div class="flex flex-col">
                    <x-input-label for="tampilkan" :value="__('Tampilkan :')" />
                    <select name="jenis" id="jenis" class="mt-1 w-48 text-sm px-2 py-1 bg-white/30 text-gray-900 border-green-700 rounded-lg focus:ring-green-600 focus:border-green-600">
                        <option value="">Barang & Paket</option>
                        <option value="barang" {{ request('jenis') == 'barang' ? 'selected' : '' }}>Barang Satuan</option>
                        <option value="paket" {{ request('jenis') == 'paket' ? 'selected' : '' }}>Paket</option>
                    </select>
                </div>
            </form>

            {{-- Tombol Keranjang --}}
            <div class="self-end">
                <a href="{{ route('user.keranjang.index') }}">
                    <x-primary-button class="inline-flex items-center gap-2">
                        {{-- Ikon Keranjang --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 5h12m-6 0a1 1 0 11-2 0m6 0a1 1 0 102 0" />
                        </svg>
                    </x-primary-button>
                </a>
            </div>
        </div>

        {{-- Auto-submit filter --}}
        @push('scripts')
        <script>
            document.querySelectorAll('#kategori, #jenis').forEach(select => {
                select.addEventListener('change', () => {
                    document.getElementById('filter-form').submit();
                });
            });
        </script>
        @endpush

        {{-- Barang --}}
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($barangs as $barang)
                <div class="bg-white/70 backdrop-blur-md rounded-2xl shadow-lg overflow-hidden">
                    <div class="h-48 overflow-hidden">
                        @if($barang->gambar)
                            <img src="{{ asset('storage/barang/' . $barang->gambar) }}" alt="{{ $barang->nama }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full bg-white/70 text-gray-400 italic">
                                (gambar tidak tersedia)
                            </div>
                        @endif
                    </div>
                    <div class="p-4 text-gray-900">
                        <h2 class="text-lg font-bold mb-1">{{ $barang->nama }}</h2>
                        <p class="text-sm mb-2">{{ Str::limit($barang->deskripsi, 80, '...') }}</p>
                        <p class="text-sm mb-1">Kategori: <span class="font-medium">{{ ucwords(str_replace('_', ' ', $barang->kategori)) }}</span></p>
                        <p class="text-sm mb-1">Harga Sewa: <span class="font-semibold">Rp{{ number_format($barang->harga_sewa, 0, ',', '.') }}/hari</span></p>
                        <p class="text-sm mb-3">Stok: <span class="font-semibold">{{ $barang->stok }}</span></p>

                        <form action="{{ route('user.keranjang.store') }}" method="POST" class="flex flex-col gap-2">
                            @csrf
                            <x-text-input name="barang_id" type="hidden" value="{{ $barang->id }}" />
                            <x-input-label for="jumlah" :value="__('Jumlah :')" />
                            <x-text-input type="number" name="jumlah" value="1" min="1" max="{{ $barang->stok }}" class="w-16 px-2 py-1" />
                            <button type="submit"
                                    class="mt-2 px-4 py-2 text-sm font-semibold rounded-full bg-green-800 text-white hover:bg-yellow-200 hover:text-gray-900 transition">
                                + Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($barangs->isEmpty())
            <p class="text-center text-white mt-10 text-lg italic">Belum ada barang yang tersedia</p>
        @endif

        {{-- Paket --}}
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-white mb-6">Paket Hemat</h2>
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @forelse ($pakets as $paket)
                    <div class="bg-white/70 backdrop-blur-md rounded-2xl shadow-lg overflow-hidden">
                        <div class="h-48 bg-white/70 flex items-center justify-center">
                            @if($paket->gambar)
                                <img src="{{ asset('storage/paket/' . $paket->gambar) }}" alt="{{ $paket->nama }}" class="h-full object-cover w-full">
                            @else
                                <div class="flex items-center justify-center h-full bg-white/70 text-gray-400 italic">
                                    (gambar tidak tersedia)
                                </div>
                            @endif
                        </div>
                        <div class="p-4 text-gray-900">
                            <h2 class="text-lg font-bold mb-1">{{ $paket->nama }}</h2>
                            <p class="text-sm mb-2">{{ Str::limit($paket->deskripsi, 80, '...') }}</p>
                            <p class="text-sm mb-1">Harga Sewa: <span class="font-semibold">Rp{{ number_format($paket->harga_sewa, 0, ',', '.') }}/hari</span></p>
                            <p class="text-sm mb-3">Stok: <span class="font-semibold">{{ number_format($paket->stok_aktif) }}</span></p>
                            <a href="{{ route('user.paket.show', $paket->id) }}"
                               class="inline-block px-4 py-2 text-sm font-semibold rounded-full bg-green-800 text-white hover:bg-yellow-200 hover:text-gray-900 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-white text-center italic col-span-full">Belum ada paket yang tersedia</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Tombol Back to Top --}}
<div
    x-data="{
        visible: false,
        timer: null,
        show() {
            this.visible = true;
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.visible = false, 1000);
        }
    }"
    x-init="
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                show();
            } else {
                visible = false;
            }
        })
    "
    x-show="visible"
    x-transition.opacity
    class="fixed bottom-6 right-6 z-50"
    style="display: none;"
>
    <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="bg-green-700 hover:bg-green-600 text-white p-3 rounded-full shadow-lg transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>
</div>

@endsection

@section('showFooter', '1')
