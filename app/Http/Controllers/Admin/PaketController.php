<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Paket;
use App\Models\PaketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::with('details.barang')->orderBy('nama')->get();
        return view('admin.paket.index', compact('pakets'));
    }

    public function create(Request $request)
{
    $query = Barang::query();

    $barangs = $query->get();

    $kategoriList = Barang::select('kategori')->distinct()->pluck('kategori');

    return view('admin.paket.create', compact('barangs', 'kategoriList'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_sewa' => 'required|numeric',
            'stok' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'isi_paket' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        $gambarPath = $request->file('gambar')?->store('paket', 'public');

        $paket = Paket::create([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'harga_sewa' => $validated['harga_sewa'],
            'stok' => $validated['stok'],
            'gambar' => $gambarPath,
        ]);

        foreach ($validated['isi_paket'] as $barang_id => $checked) {
            $jumlah = max(1, (int) ($validated['jumlah'][$barang_id] ?? 1));

            $paket->details()->create([
                'barang_id' => $barang_id,
                'jumlah' => $jumlah,
            ]);
        }

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil ditambahkan');
    }

    public function show(Paket $paket)
    {
        $paket->load('details.barang');
        return view('admin.paket.show', compact('paket'));
    }

    public function edit(Paket $paket)
    {
        $paket->load('details');
        $barangs = Barang::orderBy('nama')->get();
        $isiPaket = $paket->details->pluck('jumlah', 'barang_id')->toArray();

        return view('admin.paket.edit', compact('paket', 'barangs', 'isiPaket'));
    }

    public function update(Request $request, Paket $paket)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_sewa' => 'required|numeric',
            'stok' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'isi_paket' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        if ($request->hasFile('gambar')) {
            if ($paket->gambar && Storage::disk('public')->exists($paket->gambar)) {
                Storage::disk('public')->delete($paket->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('paket', 'public');
        } else {
            $validated['gambar'] = $paket->gambar;
        }

        $paket->update([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'harga_sewa' => $validated['harga_sewa'],
            'stok' => $validated['stok'],
            'gambar' => $validated['gambar'],
        ]);

        $paket->details()->delete();

        foreach ($validated['isi_paket'] as $barang_id => $checked) {
            $jumlah = max(1, (int) ($validated['jumlah'][$barang_id] ?? 1));

            $paket->details()->create([
                'barang_id' => $barang_id,
                'jumlah' => $jumlah,
            ]);
        }

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy(Paket $paket)
    {
        if ($paket->gambar && Storage::disk('public')->exists($paket->gambar)) {
            Storage::disk('public')->delete($paket->gambar);
        }

        $paket->delete();

        return back()->with('success', 'Paket berhasil dihapus');
    }
}