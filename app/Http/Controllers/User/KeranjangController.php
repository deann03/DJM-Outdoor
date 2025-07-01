<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $items = Keranjang::with(['barang', 'paket'])
            ->where('user_id', auth()->id())
            ->get();

        return view('user.keranjang.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'nullable|exists:barangs,id',
            'paket_id' => 'nullable|exists:pakets,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        if (!$request->filled('barang_id') && !$request->filled('paket_id')) {
            return back()->withErrors(['barang_id' => 'Pilih salah satu: barang atau paket.']);
        }

        $userId = auth()->id();

        $keranjang = Keranjang::where('user_id', $userId)
            ->where('barang_id', $request->barang_id)
            ->where('paket_id', $request->paket_id)
            ->first();

        if ($keranjang) {
            $keranjang->update([
                'jumlah' => $keranjang->jumlah + $request->jumlah,
            ]);
        } else {
            Keranjang::create([
                'user_id' => $userId,
                'barang_id' => $request->barang_id,
                'paket_id' => $request->paket_id,
                'jumlah' => $request->jumlah,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $item = Keranjang::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $item->jumlah = $request->jumlah;
        $item->save();

        return redirect()->back()->with('success', 'Jumlah berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = Keranjang::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $item->delete();

        return redirect()->back()->with('success', 'Item dihapus dari keranjang');
    }
}
