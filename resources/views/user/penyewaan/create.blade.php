@extends('layouts.app')

@section('title', 'Checkout')

@section('header')
<h2 class="text-xl font-semibold text-gray-800 leading-tight">
    Checkout
</h2>
@endsection

@section('content')
<div class="py-12 px-8">
    <div class="max-w-7xl mx-auto bg-white/70 p-4 sm:p-8 rounded-xl shadow-md backdrop-blur-md">
        @if (session('success'))
            <div class="mb-4 bg-white/70 text-gray-900 p-3 rounded shadow">{{ session('success') }}</div>
        @endif

        <div class="max-w-xl">
            <form action="{{ route('user.penyewaan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Ups! Ada kesalahan:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf

                <!-- Tanggal Pengambilan -->
                <div>
                    <x-input-label for="tanggal_ambil" :value="__('Tanggal Pengambilan')" />
                    <x-text-input id="tanggal_ambil" name="tanggal_ambil" type="date" class="mt-1 block w-full"
                    :value="old('tanggal_ambil')" required min="{{ now()->toDateString() }}" />
                    <x-input-error :messages="$errors->get('tanggal_ambil')" class="mt-2" />
                </div>

                <!-- Tanggal Kembali -->
                <div>
                    <x-input-label for="tanggal_kembali" :value="__('Tanggal Pengembalian')" />
                    <x-text-input id="tanggal_kembali" name="tanggal_kembali" type="date" class="mt-1 block w-full"
                    :value="old('tanggal_kembali')" required />
                    <x-input-error :messages="$errors->get('tanggal_kembali')" class="mt-2" />
                </div>

                <!-- Jenis Identitas -->
                <div>
                    <x-input-label for="jenis_identitas" :value="__('Jenis Identitas')" />
                    <select name="jenis_identitas" id="jenis_identitas" class="block w-full bg-white/30 text-gray-900 border-green-700 rounded-lg focus:ring-green-600 focus:border-green-600">
                        <option value="">--Pilih Jenis Identitas--</option>
                        <option value="KTP" {{ old('jenis_identitas') == 'KTP' ? 'selected' : '' }}>KTP</option>
                        <option value="SIM" {{ old('jenis_identitas') == 'SIM' ? 'selected' : '' }}>SIM</option>
                        <option value="Kartu Pelajar" {{ old('jenis_identitas') == 'Kartu Pelajar' ? 'selected' : '' }}>Kartu Pelajar</option>
                        <option value="Lainnya" {{ old('jenis_identitas') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_identitas')" class="mt-2" />
                </div>

                <!-- Nomor Identitas -->
                <div class="mt-4">
                    <x-input-label for="nomor_identitas" :value="__('Nomor Identitas')" />
                    <x-text-input id="nomor_identitas" name="nomor_identitas" type="text" class="block w-full"
                    :value="old('nomor_identitas')" required />
                    <x-input-error :messages="$errors->get('nomor_identitas')" class="mt-2" />
                </div>

                <!-- File Identitas -->
                <div class="mt-4">
                    <x-input-label for="file_identitas" :value="__('File Identitas')" />
                    <x-file-input name="file_identitas" />
                    <x-input-error :messages="$errors->get('file_identitas')" class="mt-2" />
                </div>

                <!-- Metode Pengambilan -->
                <div>
                    <x-input-label for="metode_pengambilan" :value="__('Metode Pengambilan')" />
                    <select name="metode_pengambilan" id="metode_pengambilan" class="block w-full bg-white/30 text-gray-900 border-green-700 rounded-lg focus:ring-green-600 focus:border-green-600">
                        <option value="ambil" {{ old('metode_pengambilan') == 'ambil' ? 'selected' : '' }}>Ambil Sendiri</option>
                        <option value="antar" {{ old('metode_pengambilan') == 'antar' ? 'selected' : '' }}>Antar ke Alamat</option>
                    </select>
                </div>

                <!-- Alamat Pengantaran -->
                <div class="mb-4" id="alamat-container" style="display: none;">
                    <x-input-label for="alamat_pengantaran" :value="__('Alamat Pengantaran')" />
                    <textarea name="alamat_pengantaran" id="alamat_pengantaran" rows="3" class="mt-1 block w-full rounded-lg border-green-700 bg-white/30 text-gray-900 focus:ring-green-600 focus:border-green-600 shadow-sm backdrop-blur-md">{{ old('alamat_pengantaran') }}</textarea>
                    <x-input-error :messages="$errors->get('alamat_pengantaran')" class="mt-2" />
                </div>

                <!-- Rincian Penyewaan -->
                <div class="bg-white/30 p-4 rounded-lg text-gray-900 mt-6">
                    <h3 class="font-medium mb-2">Rincian Penyewaan:</h3>
                    <ul class="text-sm space-y-1 mb-3">
                        @foreach ($items as $item)
                            @php
                                $nama = $item->barang?->nama ?? $item->paket?->nama;
                                $harga = $item->barang?->harga_sewa ?? $item->paket?->harga_sewa;
                                $jumlah = $item->jumlah;
                                $subtotal = $harga * $jumlah;
                            @endphp
                            <li>• {{ $nama }} ({{ $jumlah }} x Rp{{ number_format($harga, 0, ',', '.') }}) = 
                                <span class="font-medium">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <p><strong>Total per Hari:</strong> Rp{{ number_format($total_per_hari, 0, ',', '.') }}</p>
                    <p><strong>Total Hari:</strong> <span id="hari">0</span></p>
                    <p><strong>Total Biaya:</strong> <span id="total">Rp0</span></p>
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <x-input-label for="metode_pembayaran" :value="__('Metode Pembayaran')" />
                    <select name="metode_pembayaran" id="metode_pembayaran" required class="block w-full bg-white/30 text-gray-900 border-green-700 rounded-lg focus:ring-green-600 focus:border-green-600">
                        <option value="">--Pilih Metode Pembayaran--</option>
                        <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="cod" {{ old('metode_pembayaran') == 'cod' ? 'selected' : '' }}>Bayar di Tempat (COD)</option>
                    </select>
                    <x-input-error :messages="$errors->get('metode_pembayaran')" class="mt-2" />
                </div>

                <!-- Info Nomor Rekening -->
                <div class="mt-2 text-sm text-gray-800 bg-white/40 p-3 rounded shadow" id="rekening-info" style="display: none;">
                    <p><strong>Transfer ke:</strong></p>
                    <ul class="list-disc list-inside mt-1">
                        <li>Bank BCA - 1234567890 a.n. DJM Outdoor Equipment</li>
                        <li>Bank BJB - 9876543210 a.n. DJM Outdoor Equipment</li>
                    </ul>
                    <p class="mt-1 text-xs text-gray-600">* Silakan upload bukti transfer di bawah ini.</p>
                </div>

                <!-- Bukti Pembayaran (Hanya jika Transfer) -->
                <div class="mt-4" id="bukti-container" style="display: none;">
                    <x-input-label for="bukti_pembayaran" :value="__('Bukti Pembayaran (Transfer)')" />
                    <x-file-input name="bukti_pembayaran" />
                    <x-input-error :messages="$errors->get('bukti_pembayaran')" class="mt-2" />
                </div>

                <div class="pt-4">
                    <x-primary-button>
                        Checkout
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ============ Toggle alamat pengantaran ============
    const metodeSelect = document.getElementById('metode_pengambilan');
    const alamatContainer = document.getElementById('alamat-container');

    function toggleAlamat() {
        alamatContainer.style.display = metodeSelect.value === 'antar' ? 'block' : 'none';
    }

    metodeSelect.addEventListener('change', toggleAlamat);
    document.addEventListener('DOMContentLoaded', toggleAlamat);

    // ============ Toggle bukti pembayaran ============
    const metodeBayarSelect = document.getElementById('metode_pembayaran');
    const buktiContainer = document.getElementById('bukti-container');
    const rekeningInfo = document.getElementById('rekening-info');

    function toggleBuktiPembayaran() {
        const isTransfer = metodeBayarSelect.value === 'transfer';
        buktiContainer.style.display = isTransfer ? 'block' : 'none';
        rekeningInfo.style.display = isTransfer ? 'block' : 'none';
    }

    metodeBayarSelect.addEventListener('change', toggleBuktiPembayaran);
    document.addEventListener('DOMContentLoaded', toggleBuktiPembayaran);

    // ============ Hitung total hari & biaya ============
    function updateTotal() {
        const ambil = document.getElementById('tanggal_ambil').value;
        const kembali = document.getElementById('tanggal_kembali').value;
        const totalPerHari = Number({{ $total_per_hari ?? 0 }});

        if (ambil && kembali) {
            const start = new Date(ambil);
            const end = new Date(kembali);
            const msPerDay = 1000 * 60 * 60 * 24;
            const selisihHari = Math.ceil((end - start) / msPerDay);

            if (selisihHari < 1) {
                alert('Tanggal kembali harus setelah tanggal ambil.');
                document.getElementById('tanggal_kembali').value = '';
                document.getElementById('hari').innerText = '0 hari';
                document.getElementById('total').innerText = 'Rp0';
                return;
            }

            const total = totalPerHari * selisihHari;
            document.getElementById('hari').innerText = selisihHari + ' hari';
            document.getElementById('total').innerText = 'Rp' + total.toLocaleString('id-ID');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('tanggal_ambil').addEventListener('change', updateTotal);
        document.getElementById('tanggal_kembali').addEventListener('change', updateTotal);
    });
</script>
@endpush

@endsection
