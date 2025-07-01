@extends('layouts.app')

@section('title', 'Detail Paket')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Detail Paket
</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur-md">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Gambar -->
            <div class="md:w-1/3">
                @if($paket->gambar)
                    <img src="{{ asset('storage/paket/' . $paket->gambar) }}" alt="{{ $paket->nama }}" class="rounded-lg shadow">
                @else
                    <div class="text-sm italic text-gray-500">(gambar tidak tersedia)</div>
                @endif
            </div>

            <!-- Informasi -->
            <div class="md:flex-1 space-y-3">
                <h1 class="text-2xl font-medium">{{ $paket->nama }}</h1>
                <p class="text-sm text-gray-600">{{ $paket->deskripsi }}</p>
                <p class="text-medium font-semibold mt-2">Rp {{ number_format($paket->harga_sewa, 0, ',', '.') }}/hari</p>
                <p class="text-sm text-gray-600">Stok tersedia: {{ number_format($paket->stok_aktif) }} / {{ $paket->stok }}</p>

                <div class="mt-4">
                    <h3 class="text-md font-medium mb-2">Isi Paket:</h3>
                    <ul class="list-disc list-inside space-y-1 text-gray-600">
                        @foreach ($paket->details as $detail)
                            <li>{{ $detail->barang->nama }} × {{ $detail->jumlah }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6">
                    <form action="{{ route('user.keranjang.store') }}" method="POST" class="flex flex-col gap-2">
                        @csrf
                        <x-text-input name="paket_id" type="hidden" value="{{ $paket->id }}" />
                        <div class="flex flex-col gap-1 items-start">
                            <x-input-label for="jumlah" :value="__('Jumlah :')" class="text-sm" />
                            <x-text-input type="number" name="jumlah" value="1" min="1" max="{{ $paket->stok_aktif }}" class="w-16 px-2 py-1" />

                            <div class="flex gap-4 items-center">
                                <x-primary-button class="mt-2">
                                    + Keranjang
                                </x-primary-button>

                                <a href="{{ route('user.katalog.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('showFooter', '1')
