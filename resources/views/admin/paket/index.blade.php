@extends('layouts.app')

@section('title', 'Kelola Paket')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Kelola Paket
    </h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-6 rounded-xl shadow-md backdrop-blur-md">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900">Daftar Paket</h2>
            <a href="{{ route('admin.paket.create') }}"
               class="px-4 py-2 rounded-lg bg-white/30 text-gray-700 hover:bg-yellow-100 hover:text-gray-900 transition font-sm shadow">
                + Tambah Paket
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-gray-900 font-medium bg-white p-3 rounded-xl shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left text-gray-900">
                <thead>
                    <tr class="font-medium border-b border-green-700">
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Harga Sewa</th>
                        <th class="px-4 py-2 text-center">Stok</th>
                        <th class="px-4 py-2">Jumlah Barang</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pakets as $paket)
                        <tr class="border-b hover:bg-green-50 transition">
                            <td class="px-4 py-2">{{ $paket->nama }}</td>
                            <td class="px-4 py-2">{{ $paket->harga_formatted }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ $paket->stok_aktif }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900 space-y-1">
                                @forelse ($paket->details as $detail)
                                    <div>{{ $detail->barang->nama }} <span class="font-medium">× {{ $detail->jumlah }}</span></div>
                                @empty
                                    <div class="italic text-gray-900">Tidak ada barang</div>
                                @endforelse
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.paket.edit', $paket->id) }}"
                                       class="inline-flex px-3 py-1 bg-yellow-300 border border-transparent text-gray-900 text-sm rounded-lg hover:bg-yellow-200">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.paket.destroy', $paket->id) }}" method="POST" class="inline-flex"
                                          onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 border border-transparent text-white text-sm rounded-lg hover:bg-red-500">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-4 italic text-gray-900">Belum ada paket yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
