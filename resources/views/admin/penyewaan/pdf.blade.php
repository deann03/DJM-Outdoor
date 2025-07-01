<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Transaksi Penyewaan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section table {
            width: 100%;
            border-collapse: collapse;
        }
        .section table th,
        .section table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        .section table th {
            background-color: #f0f0f0;
        }
        .info-table td {
            border: none;
            padding: 3px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logoDJM.png') }}" class="logo" alt="LogoDJM" style="height: 60px;">
        <h2>DJM Outdoor Equipment</h2>
        <h2>Bukti Transaksi Penyewaan</h2>
    </div>

    <div class="section">
        <table class="info-table">
            <tr>
                <td><strong>Nama :</strong></td>
                <td>{{ $penyewaan->user->name }}</td>
            </tr>
            <tr>
                <td><strong>Email :</strong></td>
                <td>{{ $penyewaan->user->email }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Ambil:</strong></td>
                <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_ambil)->translatedFormat('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Kembali :</strong></td>
                <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_kembali)->translatedFormat('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Status :</strong></td>
                <td>{{ ucfirst($penyewaan->status) }}</td>
            </tr>
            <tr>
                <td><strong>Metode Pembayaran :</strong></td>
                <td>{{ strtoupper($penyewaan->metode_pembayaran) }}</td>
            </tr>
            <tr>
                <td><strong>Status Pembayaran :</strong></td>
                <td>{{ ucfirst(str_replace('_', ' ', $penyewaan->status_pembayaran)) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Nama Item</th>
                    <th>Jumlah</th>
                    <th>Harga / Hari</th>
                    <th>Durasi</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penyewaan->details as $detail)
                    @php
                        $item = $detail->barang ?? $detail->paket;
                        $nama = $item?->nama ?? 'Tidak ditemukan';
                        $harga = $detail->harga_sewa;
                        $jumlah = $detail->jumlah;
                        $durasi = $penyewaan->total_hari ?? 1;
                        $subtotal = $harga * $jumlah * $durasi;
                    @endphp
                    <tr>
                        <td>{{ $nama }}</td>
                        <td>{{ $jumlah }}</td>
                        <td>Rp{{ number_format($harga, 0, ',', '.') }}</td>
                        <td>{{ $durasi }} hari</td>
                        <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <table class="info-table">
            <tr>
                <td><strong>Total Biaya :</strong></td>
                <td>Rp{{ number_format($penyewaan->total_biaya, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Denda :</strong></td>
                <td>Rp{{ number_format($penyewaan->denda, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Total Bayar :</strong></td>
                <td><strong>Rp{{ number_format($penyewaan->total_bayar, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="text-align:right; font-size: 11px;">
        <em>Dicetak pada {{ now()->translatedFormat('d M Y, H:i') }}</em>
    </div>
</body>
</html>
