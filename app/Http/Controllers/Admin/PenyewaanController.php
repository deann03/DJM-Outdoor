<?php

namespace App\Http\Controllers\Admin;

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
    public function index(Request $request)
    {
        $status = $request->query('status');

        $penyewaans = Penyewaan::with('user')
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->get();

        return view('admin.penyewaan.index', compact('penyewaans', 'status'));
    }

    public function admin(Penyewaan $penyewaan)
    {
        $penyewaan->load(['user', 'details.barang', 'details.paket']);
        return view('admin.penyewaan.show', compact('penyewaan'));
    }

    public function verifikasiPembayaran(Penyewaan $penyewaan)
    {
        if (
            $penyewaan->metode_pembayaran !== 'transfer' ||
            $penyewaan->status_pembayaran !== 'menunggu_verifikasi'
        ) {
            return back()->with('error', 'Pembayaran tidak bisa diverifikasi.');
        }

        $penyewaan->update([
            'status_pembayaran' => 'terverifikasi',
            'tanggal_bayar' => now(),
            'status' => 'disetujui'
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi');
    }

    public function approveOrReject(Penyewaan $penyewaan, string $action)
    {
        if (!in_array($action, ['setujui', 'tolak'])) {
            abort(400, 'Aksi tidak valid');
        }

        if (
            $action === 'tolak' &&
            $penyewaan->metode_pembayaran === 'transfer' &&
            $penyewaan->status_pembayaran === 'terverifikasi'
        ) {
            return back()->with('error', 'Penyewaan tidak bisa ditolak karena sudah dibayar via transfer dan terverifikasi.');
        }

        if ($action === 'setujui') {
            foreach ($penyewaan->details as $detail) {
                if ($detail->barang_id) {
                    $barang = $detail->barang;
                    if ($barang->stok < $detail->jumlah) {
                        return back()->with('error', "Stok tidak cukup untuk barang '{$barang->nama}'. Tersisa {$barang->stok}, diminta {$detail->jumlah}.");
                    }
                }

                if ($detail->paket_id) {
                    $paket = $detail->paket;
                    if ($paket->stok < $detail->jumlah) {
                        return back()->with('error', "Stok tidak cukup untuk paket '{$paket->nama}'. Tersisa {$paket->stok}, diminta {$detail->jumlah}.");
                    }
                }
            }

            DB::transaction(function () use ($penyewaan) {
                $penyewaan->update([
                    'status' => 'disetujui',
                    'status_pembayaran' => $penyewaan->metode_pembayaran === 'cod' ? 'terverifikasi' : $penyewaan->status_pembayaran,
                    'tanggal_bayar' => $penyewaan->metode_pembayaran === 'cod' ? now() : $penyewaan->tanggal_bayar,
                ]);

                foreach ($penyewaan->details as $detail) {
                    if ($detail->barang_id) {
                        $detail->barang->decrement('stok', $detail->jumlah);
                    }

                    if ($detail->paket_id) {
                        $detail->paket->decrement('stok', $detail->jumlah);
                    }
                }
            });
        } else {
            $penyewaan->update(['status' => 'ditolak']);
        }

        return redirect()->route('admin.penyewaan.index')->with('success', 'Penyewaan berhasil diperbarui');
    }

    public function markAsSelesai(Penyewaan $penyewaan)
    {
        if (!$penyewaan->isBisaDiselesaikan()) {
            return back()->with('error', 'Hanya penyewaan yang disetujui atau dikembalikan yang dapat diselesaikan.');
        }

        $penyewaan->update(['status' => 'selesai']);

        if (
            $penyewaan->metode_pembayaran === 'cod' &&
            $penyewaan->status_pembayaran !== 'terverifikasi'
        ) {
            $penyewaan->update([
                'status_pembayaran' => 'terverifikasi',
                'tanggal_bayar' => now(),
            ]);
        }

        return to_route('admin.penyewaan.index')->with('success', 'Penyewaan diselesaikan');
    }

    public function cetakPDF(Penyewaan $penyewaan)
    {
        $penyewaan->load(['user', 'details.barang', 'details.paket']);

        $pdf = Pdf::loadView('admin.penyewaan.pdf', compact('penyewaan'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('bukti_transaksi_'.$penyewaan->id.'.pdf');
    }
}
