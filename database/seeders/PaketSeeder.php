<?php

namespace Database\Seeders;

use App\Models\Paket;
use App\Models\PaketDetail;
use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $tenda1  = Barang::where('nama', 'Tenda Arei Eliot 4 Person')->first();
        $tenda2  = Barang::where('nama', 'Tenda Pavillo 4 Person')->first();
        $kompor  = Barang::where('nama', 'Kompor Portable Tendaki')->first();
        $nesting = Barang::where('nama', 'Nesting TNI')->first();
        $gas     = Barang::where('nama', 'Gas Camping Portable')->first();
        $slbag   = Barang::where('nama', 'Sleeping Bag')->first();
        $matras  = Barang::where('nama', 'Matras')->first();
        $kursi   = Barang::where('nama', 'Kursi Lipat Speeds Size XL')->first();
        $meja    = Barang::where('nama', 'Meja Lipat Speeds')->first();
        $tripod  = Barang::where('nama', 'Tripod')->first();

        $paket1 = Paket::create([
            'nama' => 'Paket Camping Solo',
            'deskripsi' => 'Sendirian tapi tetap siap jelajah! Paket ini dirancang khusus buat kamu yang ingin camping solo dengan perlengkapan lengkap—dari tenda, kompor, sampai sleeping bag. Praktis, ringan, dan siap dipakai kapan pun.',
            'harga_sewa' => 100000,
            'stok' => 4,
            'gambar' => 'PaketSolo.jpg',
        ]);

        PaketDetail::insert([
            [
                'paket_id' => $paket1->id,
                'barang_id' => $tenda1->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket1->id,
                'barang_id' => $kompor->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket1->id,
                'barang_id' => $nesting->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket1->id,
                'barang_id' => $slbag->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket1->id,
                'barang_id' => $matras->id,
                'jumlah' => 1,
            ]
        ]);

        $paket2 = Paket::create([
            'nama' => 'Paket Camping Duo 1',
            'deskripsi' => 'Buat kamu yang suka petualangan berdua! Paket ini pas untuk 2 orang, lengkap dengan dua sleeping bag, matras empuk, kompor, dan tenda berkualitas. Simpel tapi cukup untuk malam yang nyaman di tengah alam.',
            'harga_sewa' => 100000,
            'stok' => 3,
            'gambar' => 'PaketDuo1.jpg',
        ]);

        PaketDetail::insert([
            [
                'paket_id' => $paket2->id,
                'barang_id' => $tenda2->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket2->id,
                'barang_id' => $kompor->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket2->id,
                'barang_id' => $nesting->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket2->id,
                'barang_id' => $slbag->id,
                'jumlah' => 2,
            ],
            [
                'paket_id' => $paket2->id,
                'barang_id' => $matras->id,
                'jumlah' => 2,
            ]
        ]);

        $paket3 = Paket::create([
            'nama' => 'Paket Konten',
            'deskripsi' => 'Bikin konten makin keren! Paket ini siap nemenin kamu bikin video, foto, atau vlog outdoor dengan tripod stabil, meja lipat, dan kursi santai. Cocok buat konten kreator atau sekadar dokumentasi momen epic di alam!',
            'harga_sewa' => 50000,
            'stok' => 2,
            'gambar' => 'PaketKonten.jpg',
        ]);

        PaketDetail::insert([
            [
                'paket_id' => $paket3->id,
                'barang_id' => $kursi->id,
                'jumlah' => 2,
            ],
            [
                'paket_id' => $paket3->id,
                'barang_id' => $meja->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket3->id,
                'barang_id' => $tripod->id,
                'jumlah' => 1,
            ],
        ]);

        $paket4 = Paket::create([
            'nama' => 'Paket Camping Duo 2',
            'deskripsi' => 'Paket komplit untuk dua orang camping santai. Sudah termasuk tenda, kompor windproof, nesting set, gas, dan matras dobel. Cocok untuk camping couple, bestie trip, atau bapack-an ringan tanpa ribet bawa peralatan sendiri.',
            'harga_sewa' => 100000,
            'stok' => 3,
            'gambar' => 'PaketDuo2.jpg',
        ]);

        PaketDetail::insert([
            [
                'paket_id' => $paket4->id,
                'barang_id' => $tenda1->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket4->id,
                'barang_id' => $kompor->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket4->id,
                'barang_id' => $nesting->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket4->id,
                'barang_id' => $gas->id,
                'jumlah' => 1,
            ],
            [
                'paket_id' => $paket4->id,
                'barang_id' => $matras->id,
                'jumlah' => 2,
            ]
        ]);
    }
}
