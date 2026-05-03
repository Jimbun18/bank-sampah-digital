@extends('layouts.app')
@section('title', 'Ajukan Penarikan')

@section('content')
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-2">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">💸 Ajukan Penarikan</h1>
                <p class="text-gray-500 text-sm">Cairkan saldo Anda ke rekening bank atau tukar dengan sembako.</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                    <p class="text-green-700 font-bold">Berhasil!</p>
                    <p class="text-green-600 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                    <p class="text-red-700 font-bold">Peringatan</p>
                    <ul class="text-red-600 text-sm list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="flex flex-col gap-2 mb-6">
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex justify-between items-center shadow-sm">
                        <span class="text-blue-800 font-medium">Saldo Bisa Ditarik:</span>
                        <span class="text-xl font-bold text-blue-900">Rp {{ number_format($saldo_tersedia, 0, ',', '.') }}</span>
                    </div>
                    @if($saldo_pending > 0)
                    <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 flex justify-between items-center text-sm">
                        <span class="text-yellow-700">Saldo ditahan (Pending):</span>
                        <span class="font-bold text-yellow-800">Rp {{ number_format($saldo_pending, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>

                <form action="{{ route('nasabah.simpan_penarikan') }}" method="POST">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 font-medium mb-2">Metode Penarikan</label>
                        <select name="metode" id="metode" required onchange="toggleForm()" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none bg-gray-50">
                            <option value="">-- Pilih Metode --</option>
                            <option value="transfer">Transfer Bank / E-Wallet</option>
                            <option value="sembako">Tukar Paket Sembako</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 font-medium mb-2">Jumlah Penarikan (Rp)</label>
                        <input type="number" id="nominal" name="nominal" required min="10000" placeholder="Minimal Rp 10.000" value="{{ old('nominal') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none bg-gray-50 transition">
                        <p id="bantuan-nominal" class="text-xs text-gray-500 mt-1 hidden">Nominal otomatis terisi sesuai harga paket sembako.</p>
                    </div>

                    <div id="form-transfer" class="hidden bg-gray-50 p-4 rounded-xl border border-gray-200 mb-5 space-y-4">
                        <h4 class="font-bold text-gray-700 text-sm uppercase">Detail Rekening Tujuan</h4>
                        <div>
                            <label class="block text-gray-600 text-sm mb-1">Nama Bank / E-Wallet</label>
                            <input type="text" name="nama_bank" placeholder="Contoh: BCA / Dana" class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none">
                        </div>
                        <div>
                            <label class="block text-gray-600 text-sm mb-1">Nomor Rekening</label>
                            <input type="number" name="no_rekening" placeholder="Contoh: 1234567890" class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none">
                        </div>
                        <div>
                            <label class="block text-gray-600 text-sm mb-1">Nama Pemilik Rekening</label>
                            <input type="text" name="atas_nama" placeholder="Contoh: Jim Bun" class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none">
                        </div>
                    </div>

                    <div id="form-sembako" class="hidden bg-orange-50 p-4 rounded-xl border border-orange-200 mb-5">
                        <h4 class="font-bold text-orange-800 text-sm uppercase mb-3">Pilih Paket Sembako</h4>
                        <select name="paket_sembako" id="paket_sembako" onchange="updateNominalSembako()" class="w-full px-4 py-2 border border-orange-300 rounded-lg outline-none bg-white">
                            <option value="">-- Pilih Paket --</option>
                            <option value="Beras 5kg" data-harga="75000">Beras 5kg (Setara Rp 75.000)</option>
                            <option value="Minyak Goreng 2L" data-harga="35000">Minyak Goreng 2L (Setara Rp 35.000)</option>
                            <option value="Gula Pasir 1kg" data-harga="18000">Gula Pasir 1kg (Setara Rp 18.000)</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-hijau-utama text-white font-bold py-3 rounded-xl hover:bg-hijau-gelap transition shadow-md">
                        Kirim Pengajuan
                    </button>
                </form>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-gray-800 text-lg mb-4">Riwayat Penarikan</h3>
            <div class="space-y-4">
                @forelse($riwayat_penarikan as $rw)
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-bold text-gray-800">Rp {{ number_format($rw->nominal, 0, ',', '.') }}</span>
                            @if($rw->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">Pending</span>
                            @elseif($rw->status === 'disetujui')
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">Disetujui</span>
                            @else
                                <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-medium">Ditolak</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600">{{ $rw->detail_tujuan }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $rw->created_at->format('d M Y, H:i') }}</p>
                    </div>
                @empty
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-center text-sm text-gray-500">
                        Belum ada riwayat penarikan.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <script>
        const inputNominal = document.getElementById('nominal');
        const bantuanNominal = document.getElementById('bantuan-nominal');

        function toggleForm() {
            const metode = document.getElementById('metode').value;
            const formTransfer = document.getElementById('form-transfer');
            const formSembako = document.getElementById('form-sembako');

            if(metode === 'transfer') {
                formTransfer.classList.remove('hidden');
                formSembako.classList.add('hidden');
                
                // Kembalikan input nominal jadi bisa diedit
                inputNominal.readOnly = false;
                inputNominal.classList.remove('bg-gray-200', 'cursor-not-allowed');
                bantuanNominal.classList.add('hidden');
                inputNominal.value = '';

            } else if(metode === 'sembako') {
                formSembako.classList.remove('hidden');
                formTransfer.classList.add('hidden');
                
                // Kunci input nominal
                inputNominal.readOnly = true;
                inputNominal.classList.add('bg-gray-200', 'cursor-not-allowed');
                bantuanNominal.classList.remove('hidden');
                updateNominalSembako();

            } else {
                formTransfer.classList.add('hidden');
                formSembako.classList.add('hidden');
                inputNominal.readOnly = false;
            }
        }

        function updateNominalSembako() {
            const paket = document.getElementById('paket_sembako');
            if(paket.value) {
                // Ambil harga dari data-harga
                const harga = paket.options[paket.selectedIndex].getAttribute('data-harga');
                inputNominal.value = harga;
            } else {
                inputNominal.value = '';
            }
        }
    </script>
@endsection