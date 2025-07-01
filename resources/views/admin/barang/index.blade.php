@extends('layouts.app')

@section('title', 'Kelola Barang')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Kelola Barang') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 px-8">
        <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur-md">
            <div class="mb-4 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Daftar Barang</h2>
                <a href="{{ route('admin.barang.create') }}" class="px-4 py-2 rounded-lg bg-white/30 text-gray-700 hover:bg-yellow-100 hover:text-gray-900 transition font-sm shadow">
                    + Tambah Barang
                </a>
            </div>

            <div class="overflow-auto">
                <table class="w-full table-auto text-left text-gray-900">
                    <thead>
                        <tr class="font-medium border-b border-green-700">
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Kategori</th>
                            <th class="px-4 py-2">Harga Sewa</th>
                            <th class="px-4 py-2 text-center">Stok</th>
                            <th class="px-4 py-2 text-center">Jenis</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $barang)
                            <tr class="border-b hover:bg-green-50 transition">
                                <td class="px-4 py-2">{{ $barang->nama }}</td>
                                <td class="px-4 py-2">{{ ucwords(str_replace('_', ' ', $barang->kategori)) }}</td>
                                <td class="px-4 py-2">{{ $barang->harga_formatted }}</td>
                                <td class="px-4 py-2 text-center">{{ $barang->stok }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if ($barang->khusus_paket)
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-medium">Paket</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 font-medium">Umum</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('admin.barang.edit', $barang->id) }}" class="inline-flex px-3 py-1 bg-yellow-300 border border-transparent text-gray-900 text-sm rounded-lg hover:bg-yellow-200 transition ease-in-out duration-150">Edit</a>
                                    <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin ingin menghapus barang ini?')" class="px-3 py-1 bg-red-600 border border-transparent text-white text-sm rounded-lg hover:bg-red-500 transition ease-in-out duration-150">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center px-4 py-4 italic text-gray-900">Belum ada barang yang tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
