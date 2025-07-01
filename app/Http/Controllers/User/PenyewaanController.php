<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use App\Models\PenyewaanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PenyewaanController extends Controller
{
    public function index()
    {
        $penyewaans = auth()->user()
            ->penyewaans()
            ->latest()
            ->get();

        return view('user.penyewaan.index', compact('penyewaans'));
    }

    public function create()
    {
        $items = auth()->user()->keranjang()->with(['barang', 'paket'])->get();

        $total_per_hari = $items->sum(fn($item) =>
            ($item->barang?->harga_sewa ?? $item->paket?->harga_sewa ?? 0) * $item->jumlah
        );

        return view('user.penyewaan.create', compact('items', 'total_per_hari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_ambil' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_ambil',
            'jenis_identitas' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|max:255',
            'file_identitas' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            'metode_pengambilan' => 'required|in:ambil,antar',
            'alamat_pengantaran' => 'required_if:metode_pengambilan,antar|string|nullable|max:1000',
            'metode_pembayaran' => 'required|in:transfer,cod'
        ],
        [
            'tanggal_kembali.after' => 'Tanggal kembali harus lebih dari tanggal ambil',
            'file_identitas.mimes' => 'File harus berupa jpg, jpeg, png, atau pdf',
            'alamat_pengantaran.required_if' => 'Alamat pengantaran harus diisi jika memilih metode antar barang.'
        ]);

        if ($request->metode_pembayaran === 'transfer') {
            $request->validate([
                'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
        }

        $user = auth()->user();
        $keranjang = $user->keranjang()->with(['barang', 'paket'])->get();

        if ($keranjang->isEmpty()) {
            return to_route('user.penyewaan.index')->with('error', 'Keranjang masih kosong.');
        }

        foreach ($keranjang as $item) {
            $model = $item->barang ?? $item->paket;

            if (!$model) {
                return back()->withErrors(['stok' => 'Barang atau paket tidak ditemukan.']);
            }

            $jumlahDisewa = DB::table('penyewaan_details')
                ->join('penyewaans', 'penyewaan_details.penyewaan_id', '=', 'penyewaans.id')
                ->where(function($q) use ($request) {
                    $q->whereBetween('penyewaans.tanggal_ambil', [$request->tanggal_ambil, $request->tanggal_kembali])
                    ->orWhereBetween('penyewaans.tanggal_kembali', [$request->tanggal_ambil, $request->tanggal_kembali])
                    ->orWhere(function($query) use ($request) {
                        $query->where('penyewaans.tanggal_ambil', '<=', $request->tanggal_ambil)
                                ->where('penyewaans.tanggal_kembali', '>=', $request->tanggal_kembali);
                    });
                })
                ->whereIn('penyewaans.status', ['disetujui', 'dikembalikan'])
                ->when($item->barang_id, fn($q) => $q->where('penyewaan_details.barang_id', $item->barang_id))
                ->when($item->paket_id, fn($q) => $q->where('penyewaan_details.paket_id', $item->paket_id))
                ->sum('penyewaan_details.jumlah');

            $stokTersedia = $model->stok - $jumlahDisewa;

            if ($item->jumlah > $stokTersedia) {
                return back()->withErrors([
                    'stok' => "Stok tidak mencukupi untuk {$model->nama}. Tersisa $stokTersedia, kamu minta {$item->jumlah}.",
                ]);
            }
        }

        $carbonAmbil = Carbon::parse($request->tanggal_ambil)->startOfDay();
        $carbonKembali = Carbon::parse($request->tanggal_kembali)->endOfDay();
        $totalHari = max(1, $carbonAmbil->diffInDays($carbonKembali));

        $filePath = null;
        $buktiPembayaranPath = null;
        $totalBiaya = 0;

        DB::beginTransaction();

        try {
            $filePath = $request->file('file_identitas')->store('identitas', 'public');

            if ($request->metode_pembayaran === 'transfer' && $request->hasFile('bukti_pembayaran')) {
                $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            $penyewaan = Penyewaan::create([
                'user_id' => $user->id,
            'tanggal_ambil' => $carbonAmbil,
            'tanggal_kembali' => $carbonKembali,
            'jenis_identitas' => $request->jenis_identitas,
            'nomor_identitas' => $request->nomor_identitas,
            'file_identitas' => $filePath,
            'bukti_pembayaran' => $buktiPembayaranPath,
            'status_pembayaran' => $request->metode_pembayaran === 'cod' ? 'belum_bayar' : 'menunggu_verifikasi',
            'tanggal_bayar' => null,
            'metode_pengambilan' => $request->metode_pengambilan,
            'alamat_pengantaran' => $request->metode_pengambilan === 'antar' ? $request->alamat_pengantaran : null,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_hari' => $totalHari,
            'total_biaya' => 0,
            'denda' => 0,
            'total_bayar' => 0,
            'status' => 'menunggu',
            ]);

            foreach ($keranjang as $item) {
                $model = $item->barang ?? $item->paket;

                if (!$model) {
                    throw new \Exception("Barang atau paket tidak ditemukan.");
                }

                $harga = $model->harga_sewa;
                $subtotal = $harga * $item->jumlah * $totalHari;
                $totalBiaya += $subtotal;

                PenyewaanDetail::create([
                    'penyewaan_id' => $penyewaan->id,
                    'barang_id' => $item->barang_id,
                    'paket_id' => $item->paket_id,
                    'jumlah' => $item->jumlah,
                    'harga_sewa' => $harga,
                ]);
            }

            $penyewaan->update([
                'total_biaya' => $totalBiaya,
                'total_bayar' => $totalBiaya,
            ]);

            $user->keranjang()->delete();

            DB::commit();
            return to_route('user.penyewaan.index')->with('success', 'Penyewaan berhasil dilakukan');
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            
            if ($buktiPembayaranPath && Storage::disk('public')->exists($buktiPembayaranPath)) {
                Storage::disk('public')->delete($buktiPembayaranPath);
            }

            return back()->withErrors([
                'checkout' => 'Gagal menyimpan penyewaan: ' . $e->getMessage(),
            ]);
        }
    }

    public function show(Penyewaan $penyewaan)
    {
        if ($penyewaan->user_id !== auth()->id()) {
            abort(403);
        }

        $penyewaan->load(['details.barang', 'details.paket']);
        return view('user.penyewaan.show', compact('penyewaan'));
    }

    public function batal(Penyewaan $penyewaan)
    {
        if ($penyewaan->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$penyewaan->isBisaDibatalkan()) {
            return back()->with('error', 'Penyewaan tidak bisa dibatalkan.');
        }

        $penyewaan->update(['status' => 'dibatalkan']);
        return back()->with('success', 'Penyewaan berhasil dibatalkan');
    }

    public function kembalikan(Penyewaan $penyewaan)
    {
        if ($penyewaan->user_id !== auth()->id()) {
            abort(403);
        }

        if ($penyewaan->status !== 'disetujui') {
            return back()->with('error', 'Hanya penyewaan yang disetujui yang bisa dikembalikan.');
        }

        DB::transaction(function () use ($penyewaan) {
            $penyewaan->load('details.barang', 'details.paket');

            foreach ($penyewaan->details as $detail) {
                if ($detail->barang_id) {
                    $detail->barang?->increment('stok', $detail->jumlah);
                }

                if ($detail->paket_id) {
                    $detail->paket?->increment('stok', $detail->jumlah);
                }
            }

            $tanggalPengembalian = now();
            $jatuhTempo = \Carbon\Carbon::parse($penyewaan->tanggal_kembali);

            $denda = 0;
            if ($tanggalPengembalian->gt($jatuhTempo)) {
                $selisihHari = $tanggalPengembalian->diffInDays($jatuhTempo);
                $denda = ($selisihHari * $penyewaan->total_biaya) / max(1, $penyewaan->total_hari);
            }

            $penyewaan->update([
                'status' => 'dikembalikan',
                'tanggal_pengembalian' => $tanggalPengembalian,
                'denda' => $denda,
                'total_bayar' => $penyewaan->total_biaya + $denda,
            ]);
        });

        return to_route('user.penyewaan.index')->with('success', 'Barang berhasil dikembalikan');
    }

    public function cetakPDF(Penyewaan $penyewaan)
    {
        if ($penyewaan->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('user.penyewaan.pdf', compact('penyewaan'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('bukti_penyewaan_' . $penyewaan->id . '.pdf');
    }
}
