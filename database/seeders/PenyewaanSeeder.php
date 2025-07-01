<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyewaan;
use App\Models\PenyewaanDetail;
use App\Models\User;
use App\Models\Barang;
use App\Models\Paket;
use Carbon\Carbon;

class PenyewaanSeeder extends Seeder
{
    public function run(): void
    {
        $users   = User::where('role', 'user')->get();
        $barangs = Barang::all();
        $pakets  = Paket::all();

        for ($i = 0; $i < 20; $i++) {
            $user        = $users->random();
            $pakaiPaket  = rand(0, 1);
            $metodeBayar = rand(0, 1) ? 'transfer' : 'cod';

            // Batas maksimal = 1 bulan dari sekarang
            $start = Carbon::now()->startOfYear();
            $end   = Carbon::now()->copy()->addMonth()->endOfDay();

            $tanggalAmbil = Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp))->startOfDay();
            $tanggalKembali = (clone $tanggalAmbil)->addDays(rand(2, 5));

            if ($tanggalKembali->gt($end)) {
                $tanggalKembali = clone $end;
            }
            
            $totalHari       = $tanggalAmbil->diffInDays($tanggalKembali);

            // Status awal
            $statusList = ['menunggu', 'disetujui', 'selesai', 'dibatalkan'];
            $status     = $tanggalAmbil->isFuture() ? 'menunggu' : collect($statusList)->random();

            if ($status === 'disetujui' && rand(0, 1)) {
                $status = 'dikembalikan';
            }

            if (
                $status === 'menunggu' &&
                $metodeBayar !== 'transfer' &&
                rand(0, 3) === 0
            ) {
                $status = 'ditolak';
            }

            // Ubah status jadi selesai otomatis jika disetujui + sudah lewat tanggal kembali
            if ($status === 'disetujui' && $tanggalKembali->isPast()) {
                $status = 'selesai';
            }

            // Status pembayaran default
            if (in_array($status, ['disetujui', 'selesai'])) {
                $statusPembayaran = 'terverifikasi';
            } elseif ($metodeBayar === 'transfer') {
                $statusPembayaran = collect(['belum_bayar', 'menunggu_verifikasi'])->random();
            } else {
                $statusPembayaran = 'belum_bayar';
            }

            // Validasi aturan utama
            if ($metodeBayar === 'transfer' && $statusPembayaran === 'terverifikasi' && !in_array($status, ['disetujui', 'selesai'])) {
                $status = 'disetujui';
            }

            $tanggalBayar = $statusPembayaran === 'terverifikasi'
                ? (clone $tanggalAmbil)->addHours(rand(1, 12))
                : null;

            // Hitung pengembalian dan denda
            $tanggalPengembalian = null;
            $denda = 0;
            if ($status === 'selesai' && $tanggalKembali->isPast()) {
                $telatHari = rand(0, 3); // bisa tepat waktu
                $tanggalPengembalian = (clone $tanggalKembali)->addDays($telatHari);
                $denda = $telatHari * 20000;
            }

            // Detail penyewaan (paket atau barang)
            $details = [];
            $totalBiaya = 0;

            if ($pakaiPaket && $pakets->isNotEmpty()) {
                $paket = $pakets->random();
                $jumlah = rand(1, 2);
                $subtotal = $paket->harga_sewa * $jumlah;
                $details[] = [
                    'paket_id' => $paket->id,
                    'jumlah' => $jumlah,
                    'harga_sewa' => $paket->harga_sewa,
                    'subtotal' => $subtotal,
                ];
                $totalBiaya += $subtotal;
            } elseif ($barangs->isNotEmpty()) {
                $selected = $barangs->random(rand(1, min(3, $barangs->count())));
                foreach ($selected as $barang) {
                    $jumlah = rand(1, 2);
                    $subtotal = $barang->harga_sewa * $jumlah;
                    $details[] = [
                        'barang_id' => $barang->id,
                        'jumlah' => $jumlah,
                        'harga_sewa' => $barang->harga_sewa,
                        'subtotal' => $subtotal,
                    ];
                    $totalBiaya += $subtotal;
                }
            }

            $totalBayar = $totalBiaya + $denda;

            if (empty($details)) continue;

            $penyewaan = Penyewaan::create([
                'user_id' => $user->id,
                'tanggal_ambil' => $tanggalAmbil,
                'tanggal_kembali' => $tanggalKembali,
                'tanggal_pengembalian' => $tanggalPengembalian,
                'status' => $status,
                'metode_pembayaran' => $metodeBayar,
                'status_pembayaran' => $statusPembayaran,
                'tanggal_bayar' => $tanggalBayar,
                'metode_pengambilan' => 'ambil',
                'jenis_identitas' => 'KTP',
                'nomor_identitas' => '1234567890123456',
                'total_hari' => $totalHari,
                'total_biaya' => $totalBiaya,
                'denda' => $denda,
                'total_bayar' => $totalBayar,
                'created_at' => $tanggalAmbil,
                'updated_at' => $tanggalKembali,
            ]);

            $penyewaan->details()->createMany($details);
        }
    }
}
