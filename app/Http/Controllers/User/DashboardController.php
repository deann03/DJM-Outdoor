<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penyewaan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalPenyewaan = Penyewaan::where('user_id', $user->id)->count();

        $penyewaanAktif = Penyewaan::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'disetujui', 'dikembalikan'])
            ->count();

        $penyewaanTerakhir = Penyewaan::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $menungguVerifikasi = Penyewaan::where('user_id', $user->id)
            ->where('status_pembayaran', 'menunggu_verifikasi')
            ->exists();

        return view('user.dashboard.index', compact(
            'totalPenyewaan',
            'penyewaanAktif',
            'penyewaanTerakhir',
            'menungguVerifikasi'
        ));
    }
}
