<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'deskripsi', 'harga_sewa', 'stok', 'gambar'];

    public function details()
    {
        return $this->hasMany(PaketDetail::class);
    }

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'paket_details')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function getStokAktifAttribute()
    {
        $details = $this->relationLoaded('details') ? $this->details : $this->details()->with('barang')->get();

        if ($details->isEmpty()) {
            return 0;
        }

        $stokBarang = $details->map(function ($detail) {
            if (!$detail->barang || $detail->jumlah == 0) return INF;
            return floor($detail->barang->stok / $detail->jumlah);
        })->min();

        return min($this->stok, $stokBarang);
    }

    public function getHargaFormattedAttribute()
    {
        return 'Rp. ' . number_format($this->harga_sewa, 0, ',', '.') . '/hari';
    }
}
