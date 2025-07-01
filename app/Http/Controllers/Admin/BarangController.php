<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Barang;
use App\Models\Paket;

class BarangController extends Controller
{
    public function index()
    {
        
        $barangs = Barang::orderBy('nama')->get();

        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('admin.barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:tenda,alat_masak_makan,alat_tidur,pakaian_alas,penerangan,lainnya',
            'stok' => 'required|integer|min:0',
            'harga_sewa' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'khusus_paket' => 'nullable|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = basename($path);
        }

        $validated['khusus_paket'] = $request->has('khusus_paket');

        Barang::create($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:tenda,alat_masak_makan,alat_tidur,pakaian_alas,penerangan,lainnya',
            'stok' => 'required|integer|min:0',
            'harga_sewa' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'khusus_paket' => 'nullable|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($barang->gambar && Storage::disk('public')->exists('barang/' . $barang->gambar)) {
                Storage::disk('public')->delete('barang/' . $barang->gambar);
            }

            $path = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = basename($path);
        }

        $validated['khusus_paket'] = $request->has('khusus_paket');

        $barang->update($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->gambar && Storage::disk('public')->exists('barang/' . $barang->gambar)) {
            Storage::disk('public')->delete('barang/' . $barang->gambar);
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
