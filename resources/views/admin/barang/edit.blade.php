@extends('layouts.app')

@section('title', 'Edit Barang')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Barang</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur">
        <div class="max-w-xl">
            <form method="POST" action="{{ route('admin.barang.update', $barang->id) }}" enctype="multipart/form-data" class="space-y-6 mt-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="nama" :value="__('Nama Barang')" />
                    <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $barang->nama)" required autofocus autocomplete="nama" />
                    <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                </div>

                <div>
                    <label for="kategori" class="block font-medium text-sm text-gray-700">Kategori</label>
                    <x-select-input name="kategori" :options="collect([
                        'tenda',
                        'alat_masak_makan',
                        'alat_tidur',
                        'pakaian_alas',
                        'penerangan',
                        'lainnya'
                        ])->mapWithKeys(fn($k) => [$k => ucwords(str_replace('_', ' ', $k))])->toArray()"
                        :selected="old('kategori', $barang->kategori)"
                        placeholder="-- Pilih Kategori --"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('kategori')" />
                </div>

                <div>
                    <x-input-label for="stok" :value="__('Stok')" />
                    <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full" :value="old('stok', $barang->stok)" required min="0" />
                    <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                </div>

                <div>
                    <x-input-label for="harga_sewa" :value="__('Harga Sewa')" />
                    <x-text-input id="harga_sewa" name="harga_sewa" type="number" class="mt-1 block w-full" :value="old('harga_sewa', $barang->harga_sewa)" required min="0" />
                    <x-input-error class="mt-2" :messages="$errors->get('harga_sewa')" />
                </div>

                <div>
                    <x-input-label for="gambar" :value="__('Ganti Gambar (optional)')" />
                    <x-file-input name="gambar" />
                    @if ($barang->gambar)
                        <div class="mt-2">
                            <p class="text-sm text-gray-700">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/barang/' . $barang->gambar) }}" alt="Gambar Barang" class="mt-1 w-48 rounded shadow border border-gray-300">
                        </div>
                    @endif
                    <x-input-error class="mt-2" :messages="$errors->get('gambar')" />
                </div>

                <div class="flex item-center gap-4">
                    <x-primary-button>
                        {{ __('Perbarui') }}
                    </x-primary-button>
                    <a href="{{ route('admin.barang.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Batal
                    </a>

                    @if (session('success'))
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-600">
                            {{ session('success') }}
                        </p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
