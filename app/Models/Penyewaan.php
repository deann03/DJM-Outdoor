<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Penyewaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_ambil',
        'tanggal_kembali',
        'tanggal_pengembalian',
        'jenis_identitas',
        'nomor_identitas',
        'file_identitas',
        'total_hari',
        'total_biaya',
        'total_bayar',
        'denda',
        'status',
        'metode_pengambilan',
        'alamat_pengantaran',
        'metode_pembayaran',
        'status_pembayaran',
        'bukti_pembayaran',
        'tanggal_bayar'
    ];

    protected $casts = [
        'tanggal_ambil' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_pengembalian' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PenyewaanDetail::class);
    }

    public function hitungDenda()
    {
        $now = now();
        $jatuhTempo = \Carbon\Carbon::parse($this->tanggal_kembali);

        if ($now->gt($jatuhTempo)) {
            $selisihHari = $now->diffInDays($jatuhTempo);
            return $selisihHari * $this->total_biaya / $this->total_hari;
        }

        return 0;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'menunggu' => 'warning',
            'disetujui' => 'primary',
            'ditolak' => 'danger',
            'selesai' => 'success',
            'dibatalkan' => 'secondary',
            default => 'secondary',
        };
    }

    public function statusReadable(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function durasiSewaHari(): int
    {
        return $this->tanggal_ambil->diffInDays($this->tanggal_kembali) ?: 1;
    }

    public function isBisaDibatalkan(): bool
    {
        return $this->status === 'menunggu';
    }

    public function isBisaDiselesaikan()
    {
        return in_array($this->status, ['disetujui', 'dikembalikan']);
    }
}
