<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketDetail extends Model
{
    protected $fillable = ['paket_id', 'barang_id', 'jumlah'];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function getNamaBarangAttribute()
    {
        return $this->barang->nama ?? '(Barang telah dihapus)';
    }
}
