@extends('layouts.app')

@section('title', 'Tambah Paket')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Paket</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur-md">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Tambah Paket</h2>

        <div class="max-w-2xl">
            <form action="{{ route('admin.paket.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Nama -->
                <div>
                    <x-input-label for="nama" :value="__('Nama Paket')" />
                    <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama')" required autofocus autocomplete="off" />
                    <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                </div>

                <!-- Deskripsi -->
                <div>
                    <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="mt-1 block w-full rounded-lg border-green-700 bg-white/30 text-gray-900 focus:ring-green-600 focus:border-green-600 shadow-sm backdrop-blur-md">{{ old('deskripsi') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                </div>

                <!-- Harga Sewa -->
                <div>
                    <x-input-label for="harga_sewa" :value="__('Harga Sewa (per hari)')" />
                    <x-text-input id="harga_sewa" name="harga_sewa" type="number" class="mt-1 block w-full" :value="old('harga_sewa')" required min="0" />
                    <x-input-error class="mt-2" :messages="$errors->get('harga_sewa')" />
                </div>

                <!-- Stok Paket -->
                <div>
                    <x-input-label for="stok" :value="__('Stok Paket')" />
                    <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full" :value="old('stok')" required min="1" />
                    <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                </div>

                <!-- Gambar -->
                <div>
                    <x-input-label for="gambar" :value="__('Gambar')" />
                    <x-file-input name="gambar" />
                    <x-input-error class="mt-2" :messages="$errors->get('gambar')" />
                </div>

                <!-- Isi Paket -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">Isi Paket (Pilih Barang dan Jumlah)</label>
                    <!-- Daftar Barang -->
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach ($barangs as $barang)
                            <div class="flex items-start gap-2 bg-white/40 p-3 rounded-lg shadow-sm backdrop-blur-md">
                                <label for="barang_{{ $barang->id }}" class="flex items-start gap-2 cursor-pointer">
                                    <x-checkbox-input :id="'barang_' . $barang->id" :name="'isi_paket[' . $barang->id . ']'" value="1" :checked="old('isi_paket.' . $barang->id)" class="mt-1" />
                                    <div class="text-sm text-gray-900">
                                        <div class="font-medium">{{ $barang->nama }}</div>
                                        <div class="text-gray-600 text-xs">
                                            Stok: {{ $barang->stok }} | Rp{{ number_format($barang->harga_sewa, 0, ',', '.') }}/hari
                                        </div>
                                        <x-text-input type="number" name="jumlah[{{ $barang->id }}]" min="1" class="mt-1 block w-full" placeholder="Jumlah" value="{{ old('jumlah.' . $barang->id) }}" />
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <x-input-error class="mt-2" :messages="$errors->get('isi_paket')" />
                </div>

                <!-- Tombol -->
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                    <a href="{{ route('admin.paket.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
