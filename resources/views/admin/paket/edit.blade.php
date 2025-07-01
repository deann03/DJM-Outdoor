@extends('layouts.app')

@section('title', 'Edit Paket')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Paket</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur-md">
        <div class="max-w-2xl">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Paket</h2>

            <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <x-input-label for="nama" :value="__('Nama Paket')" />
                    <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $paket->nama)" required autofocus autocomplete="off" />
                    <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                </div>

                <!-- Deskripsi -->
                <div>
                    <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="mt-1 block w-full rounded-lg border-green-700 bg-white/30 text-gray-900 focus:ring-green-600 focus:border-green-600 shadow-sm backdrop-blur-md">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                </div>

                <!-- Harga Sewa -->
                <div>
                    <x-input-label for="harga_sewa" :value="__('Harga Sewa (per hari)')" />
                    <x-text-input id="harga_sewa" name="harga_sewa" type="number" class="mt-1 block w-full" :value="old('harga_sewa', $paket->harga_sewa)" required min="0" />
                    <x-input-error class="mt-2" :messages="$errors->get('harga_sewa')" />
                </div>

                <!-- Stok -->
                <div>
                    <x-input-label for="stok" :value="__('Stok Paket')" />
                    <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full" :value="old('stok', $paket->stok)" required min="1" />
                    <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                </div>

                <!-- Gambar -->
                <div>
                    <x-input-label for="gambar" :value="__('Ganti Gambar (opsional)')" />
                    <x-file-input name="gambar" />
                    <x-input-error class="mt-2" :messages="$errors->get('gambar')" />

                    @if($paket->gambar)
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $paket->gambar) }}" alt="Gambar Paket" class="w-32 mt-1 rounded-lg shadow" loading="lazy">
                        </div>
                    @endif
                </div>

                <!-- Pilih Barang -->
                <div>
                    <x-input-label :value="__('Isi Paket (Pilih Barang dan Jumlah)')" />
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach ($barangs as $barang)
                            <div class="flex items-start gap-2 bg-white/30 p-3 rounded-lg shadow-sm backdrop-blur-md">
                                <input type="checkbox" id="barang_{{ $barang->id }}" name="isi_paket[{{ $barang->id }}]" value="1"
                                        class="mt-1 rounded border-green-700 text-green-600 shadow-sm focus:ring-green-600"
                                        {{ old("isi_paket.$barang->id", isset($isiPaket[$barang->id])) ? 'checked' : '' }}>
                                <label for="barang_{{ $barang->id }}" class="flex-1">
                                    <span class="font-medium text-gray-900">{{ $barang->nama }}</span><br>
                                    <small class="text-gray-600">Stok: {{ $barang->stok }} | Rp{{ number_format($barang->harga_sewa, 0, ',', '.') }}/hari</small>
                                    <div class="mt-1">
                                        <x-text-input type="number" name="jumlah[{{ $barang->id }}]" min="1" placeholder="Jumlah" :value="old('jumlah.$barang->id', $isiPaket[$barang->id] ?? '')"
                                        class="w-24 bg-white/30 text-gray-900" />
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('isi_paket')" />
                </div>

                <!-- Tombol -->
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Perbarui') }}</x-primary-button>
                    <a href="{{ route('admin.paket.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
