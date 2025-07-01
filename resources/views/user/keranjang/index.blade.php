@extends('layouts.app')

@section('title', 'Keranjang')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Keranjang
</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur-md">
        @if (session('success'))
            <div class="text-white font-medium mb-4 bg-green-800 p-3 rounded-xl shadow-md">
                {{ session('success') }}
            </div>
        @endif

        @if ($items->isEmpty())
            <p class="text-center text-gray-500 text-medium">Keranjang kosong</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left text-gray-900">
                    <thead>
                        <tr class="font-medium border-b border-green-700">
                            <th class="px-4 py-2">Item</th>
                            <th class="px-4 py-2">Jenis</th>
                            <th class="px-4 py-2 text-center">Jumlah</th>
                            <th class="px-4 py-2 text-right">Harga</th>
                            <th class="px-4 py-2 text-right">Subtotal</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($items as $item)
                            @php
                                $nama = $item->barang ? $item->barang->nama : $item->paket->nama;
                                $jenis = $item->barang ? 'Barang' : 'Paket';
                                $harga = $item->barang ? $item->barang->harga_sewa : $item->paket->harga_sewa;
                                $subtotal = $harga * $item->jumlah;
                                $total += $subtotal;
                            @endphp
                            <tr class="font-medium border-b hover:bg-green-50 transition">
                                <td class="px-4 py-2">{{ $nama }}</td>
                                <td class="px-4 py-2">{{ $jenis }}</td>
                                <td class="px-4 py-2 text-center">
                                    <form action="{{ route('user.keranjang.update', $item->id) }}" method="POST" class="flex justify-center items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <x-text-input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" class="w-16 px-2 py-1" />
                                        <button type="submit" class="px-2 py-1 text-xs rounded-md bg-yellow-300 text-gray-800 hover:bg-yellow-200 transition">
                                            Update
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-2 text-right">Rp{{ number_format($harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-center">
                                    <form action="{{ route('user.keranjang.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 border border-transparent text-white text-sm rounded-lg hover:bg-red-500 transition ease-in-out duration-150">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-medium text-gray-900">
                            <td colspan="4" class="px-3 py-2 text-right">Total per hari</td>
                            <td class="px-3 py-2 text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right">
                <form action="{{ route('user.penyewaan.create') }}" method="GET">
                    <x-primary-button>
                        {{ __('Checkout') }}
                    </x-primary-button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection

@section('showFooter', '1')
