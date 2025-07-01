@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tambah Barang
    </h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur-md">
        <div class="max-w-xl">
            <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 mt-6">
                @csrf

                <div>
                    <x-input-label for="nama" :value="__('Nama Barang')" />
                    <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama')" required autofocus autocomplete="off" />
                    <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                </div>

                <div>
                    <x-input-label for="kategori" :value="__('Kategori')" />
                    <x-select-input name="kategori" :options="[ 
                        'tenda' => 'Tenda',
                        'alat_masak_makan' => 'Alat Masak Makan',
                        'alat_tidur' => 'Alat Tidur',
                        'pakaian_alas' => 'Pakaian Alas',
                        'penerangan' => 'Penerangan',
                        'lainnya' => 'Lainnya'
                    ]"
                    placeholder="-- Pilih Kategori --" 
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('kategori')" />
                </div>

                <div>
                    <x-input-label for="stok" :value="__('Stok')" />
                    <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full" :value="old('stok')" required min="0" />
                    <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                </div>

                <div>
                    <x-input-label for="harga_sewa" :value="__('Harga Sewa (per hari)')" />
                    <x-text-input id="harga_sewa" name="harga_sewa" type="number" placeholder="Contoh : 25000" class="mt-1 block w-full" :value="old('harga_sewa')" required min="0" />
                    <x-input-error class="mt-2" :messages="$errors->get('harga_sewa')" />
                </div>

                <div>
                    <x-input-label for="gambar" :value="__('Gambar')" />
                    <x-file-input name="gambar" />
                    <x-input-error class="mt-2" :messages="$errors->get('gambar')" />
                </div>

                <div class="flex items-center">
                    <x-checkbox-input id="khusus_paket" name="khusus_paket" value="1" :checked="old('khusus_paket')" class="mr-2" />
                    <label for="khusus_paket" class="text-sm font-medium text-gray-700">
                        Khusus untuk Paket
                        <span class="block text-xs text-gray-500">Barang ini hanya akan ditampilkan di bagian paket</span>
                    </label>
                </div>

                <div class="flex item-center gap-4">
                    <x-primary-button>
                        {{ __('Simpan') }}
                    </x-primary-button>
                    <a href="{{ route('admin.barang.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
