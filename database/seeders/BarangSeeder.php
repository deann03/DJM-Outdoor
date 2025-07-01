<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::create([
            'nama' => 'Tenda Tendaki Borneo 4 Person',
            'kategori' => 'tenda',
            'deskripsi' => 'Tenda dome berkualitas tinggi untuk 4 orang dari Tendaki, tahan air dan mudah dipasang. Ideal untuk keluarga kecil atau grup.',
            'harga_sewa' => 55000,
            'stok' => 4,
            'gambar' => 'TendaTendaki.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Tenda Arei Eliot 4 Person',
            'kategori' => 'tenda',
            'deskripsi' => 'Tenda ringan dan mudah dipasang dari Arei untuk 4 orang. Desain kompak dan cocok untuk petualangan yang lebih jauh.',
            'harga_sewa' => 50000,
            'stok' => 6,
            'gambar' => 'TendaArei.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Kompor Portable Tendaki',
            'kategori' => 'alat_masak_makan',
            'deskripsi' => 'Kompor gas kecil, ringan, dan efisien, cocok untuk memasak cepat di alam bebas. Menggunakan gas kaleng.',
            'harga_sewa' => 15000,
            'stok' => 8,
            'gambar' => 'KomporTendaki.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Gas Camping Portable',
            'kategori' => 'alat_masak_makan',
            'deskripsi' => 'Tabung gas isi ulang standar untuk kompor portable. Penting untuk setiap kegiatan memasak.',
            'harga_sewa' => 10000,
            'stok' => 30,
            'gambar' => 'GasPortable.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Tas Hydropack 5L',
            'kategori' => 'lainnya',
            'deskripsi' => 'Tas ringan dengan kantong air 5 liter, ideal untuk trail run atau hiking ringan. Memudahkan hidrasi saat bergerak.',
            'harga_sewa' => 20000,
            'stok' => 7,
            'gambar' => 'TasHydropack.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Headlamp',
            'kategori' => 'penerangan',
            'deskripsi' => 'Lampu kepala LED dengan beberapa mode pencahayaan, baterai awet. Penting untuk aktivitas malam hari.',
            'harga_sewa' => 10000,
            'stok' => 18,
            'gambar' => 'HeadLamp.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Lampu Tenda Antarestar',
            'kategori' => 'penerangan',
            'deskripsi' => 'Lampu gantung LED portabel untuk di dalam tenda, sangat terang dan hemat energi.',
            'harga_sewa' => 10000,
            'stok' => 12,
            'gambar' => 'LampuTenda.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Flysheet Antarestar Size 4x3',
            'kategori' => 'lainnya',
            'deskripsi' => 'Terpal serbaguna ukuran 4x3 meter, cocok sebagai atap tambahan, alas bivak, atau pelindung dari hujan/panas.',
            'harga_sewa' => 20000,
            'stok' => 8,
            'gambar' => 'FlysheetAntarestar.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Sleeping Bag',
            'kategori' => 'alat_tidur',
            'deskripsi' => 'Kantong tidur standar untuk suhu moderat, nyaman dan ringan. Cocok untuk camping di dataran rendah.',
            'harga_sewa' => 10000,
            'stok' => 25,
            'gambar' => 'SleepingBag.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Matras',
            'kategori' => 'alat_tidur',
            'deskripsi' => 'Matras gulung standar untuk alas tidur yang nyaman, memberikan isolasi dari tanah dingin.',
            'harga_sewa' => 5000,
            'stok' => 30,
            'gambar' => 'Matras.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Kursi Lipat Speeds Size XL',
            'kategori' => 'lainnya',
            'deskripsi' => 'Kursi lipat camping ukuran XL, kokoh dan nyaman. Mudah dibawa dan dipasang.',
            'harga_sewa' => 15000,
            'stok' => 10,
            'gambar' => 'KursiLipat.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Sepatu Outdoor Arei',
            'kategori' => 'sepatu',
            'deskripsi' => 'Sepatu hiking keluaran Arei, dirancang untuk kenyamanan dan daya cengkeram maksimal di medan licin maupun terjal. Cocok untuk trekking ringan hingga pendakian multi-day.',
            'harga_sewa' => 15000,
            'stok' => 4,
            'gambar' => 'SepatuArei.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Kompor Portable Wind Proof',
            'kategori' => 'alat_masak_makan',
            'deskripsi' => 'Kompor gas portable anti-angin, ringan dan hemat bahan bakar. Wajib dibawa buat kamu yang suka masak cepat dan aman di gunung tanpa khawatir api mati kena angin.',
            'harga_sewa' => 15000,
            'stok' => 7,
            'gambar' => 'KomporWindProof.jpg',
            'khusus_paket' => false,
        ]);

        Barang::create([
            'nama' => 'Cooking Set DS 311',
            'kategori' => 'alat_masak_makan',
            'deskripsi' => 'Satu set alat masak aluminium anti lengket, cocok untuk 2–3 orang. Isi: panci, wajan, mangkok lipat, dan sendok. Simple dibawa, lengkap untuk semua kebutuhan masak outdoor.',
            'harga_sewa' => 20000,
            'stok' => 9,
            'gambar' => 'CookingSet.jpg',
            'khusus_paket' => false,
        ]);
        

        // Barang khusus paket
        Barang::create([
            'nama' => 'Tenda Pavillo 4 Person',
            'kategori' => 'tenda',
            'deskripsi' => 'Tenda Pavillo kapasitas 4 orang, praktis dan ringkas, hanya bisa disewa sebagai bagian dari paket. Tidak disewakan terpisah.',
            'harga_sewa' => 0,
            'stok' => 3,
            'gambar' => null,
            'khusus_paket' => true,
        ]);

        Barang::create([
            'nama' => 'Nesting TNI',
            'kategori' => 'alat_masak_makan',
            'deskripsi' => 'Set nesting ala TNI, durable dan multifungsi, hanya bisa disewa sebagai bagian dari paket. Ideal untuk memasak di alam.',
            'harga_sewa' => 0,
            'stok' => 5,
            'gambar' => null,
            'khusus_paket' => true,
        ]);

        Barang::create([
            'nama' => 'Meja Lipat Speeds',
            'kategori' => 'lainnya',
            'deskripsi' => 'Meja lipat camping dari Speeds, kokoh dan praktis. Hanya bisa disewa sebagai bagian dari paket.',
            'harga_sewa' => 0,
            'stok' => 4,
            'gambar' => null,
            'khusus_paket' => true,
        ]);

        Barang::create([
            'nama' => 'Tripod',
            'kategori' => 'lainnya',
            'deskripsi' => 'Tripod kamera portable, ringan dan stabil. Hanya bisa disewa sebagai bagian dari paket.',
            'harga_sewa' => 0,
            'stok' => 2,
            'gambar' => null,
            'khusus_paket' => true,
        ]);
    }
}
