<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\User;
use App\Models\Barang;
use App\Models\Paket;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenyewaan = Penyewaan::count();
        $totalPendapatan = Penyewaan::sum('total_bayar');
        $totalUser = User::where('role', 'user')->count();
        $totalBarang = Barang::count();
        $totalPaket = Paket::count();

        // Penyewaan per bulan (12 bulan terakhir)
        $penyewaanPerBulanRaw = Penyewaan::selectRaw('MONTH(tanggal_ambil) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_ambil', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $penyewaanPerBulan = collect(range(1, 12))->mapWithKeys(fn($bulan) => [
            $bulan => $penyewaanPerBulanRaw->get($bulan, 0)
        ]);

        // Statistik status
        $statByStatus = Penyewaan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $jumlahMenunggu = Penyewaan::where('status', 'menunggu')->count();
        $jumlahBelumBayar = Penyewaan::where('status_pembayaran', 'belum_bayar')->count();

        return view('admin.dashboard.index', compact(
            'totalPenyewaan',
            'totalPendapatan',
            'totalUser',
            'totalBarang',
            'totalPaket',
            'penyewaanPerBulan',
            'statByStatus',
            'jumlahMenunggu',
            'jumlahBelumBayar'
        ));
    }
}
