<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $casts = [
    'khusus_paket' => 'boolean'
    ];

    protected $fillable = [
        'nama',
        'deskripsi',
        'kategori',
        'harga_sewa',
        'stok',
        'gambar',
        'khusus_paket'
    ];

    public function paketDetails()
    {
        return $this->hasMany(PaketDetail::class);
    }

    public function pakets()
    {
        return $this->belongsToMany(Paket::class, 'paket_details')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function getHargaFormattedAttribute()
    {
        if ($this->khusus_paket) {
            return 'Hanya untuk paket';
        }

        return 'Rp. ' . number_format($this->harga_sewa, 0, ',', '.') . '/hari';
    }
}
