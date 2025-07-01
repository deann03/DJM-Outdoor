<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Paket;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->search;
        $kategori = $request->kategori;
        $jenis    = $request->jenis;

        $queryBarang = Barang::where('khusus_paket', false)
            ->when($kategori, fn($q) => $q->where('kategori', $kategori))
            ->when($search, fn($q) => $q->where('nama', 'like', "%{$search}%"))
            ->orderBy('nama')
            ->get();

        $queryPaket = Paket::query()
            ->when($search, fn($q) => $q->where('nama', 'like', "%{$search}%"))
            ->orderBy('nama')
            ->get();

        $barangs = $queryBarang;
        $pakets  = $queryPaket;

        if ($jenis === 'barang') {
            $pakets = collect();
        } elseif ($jenis === 'paket') {
            $barangs = collect();
        }

        $daftarKategori = Barang::where('khusus_paket', false)
            ->distinct()
            ->pluck('kategori');

        return view('user.katalog.index', compact(
            'barangs', 'pakets', 'daftarKategori', 'search', 'kategori', 'jenis'
        ));
    }
}
