<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenyewaanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyewaan_id',
        'barang_id',
        'paket_id',
        'jumlah',
        'harga_sewa',
        'subtotal',
    ];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
}
