@extends('layouts.app')
@section('title', 'Transaksi Setor')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">⚖️ Transaksi Setor</h1>
                <p class="text-gray-500 text-sm">Input data sampah yang disetorkan nasabah.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                <p class="text-green-700 font-bold">Berhasil!</p>
                <p class="text-green-600 text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <form action="{{ route('petugas.simpan_setor') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">Pilih Nasabah</label>
                    <select name="user_id" id="select-nasabah" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none">
                        <option value="">-- Cari atau Ketik Nama Nasabah --</option>
                        <!-- Looping data nasabahmu -->
                        @foreach($nasabahs as $nasabah)
                            <option value="{{ $nasabah->id }}">{{ $nasabah->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Jenis Sampah</label>
                        <select name="jenis_sampah_id" id="jenis_sampah" required onchange="hitungTotal()" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none bg-gray-50">
                            <option value="" data-harga="0">-- Pilih Jenis --</option>
                            @foreach($jenis_sampahs as $js)
                                <option value="{{ $js->id }}" data-harga="{{ $js->harga_per_kg }}">
                                    {{ $js->nama_sampah }} (Rp {{ number_format($js->harga_per_kg, 0, ',', '.') }}/kg)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Berat (Kg)</label>
                        <input type="number" 
                            step="0.1" 
                            name="berat" 
                            id="berat" 
                            required 
                            min="0.1" 
                            max="999" 
                            oninput="if(this.value > 999) this.value = 999; hitungTotal()" 
                            placeholder="Contoh: 2.5" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none bg-gray-50">
                    </div>
                </div>

                <div class="bg-blue-50 p-5 rounded-xl mb-8 border border-blue-100 flex justify-between items-center">
                    <div>
                        <p class="text-blue-800 font-medium text-sm">Estimasi Saldo Masuk</p>
                        <p class="text-xs text-blue-600 mt-1">Otomatis terhitung dari harga/kg x berat</p>
                    </div>
                    <div class="text-right">
                        <input type="text" id="total_harga" readonly value="Rp 0" class="bg-transparent text-2xl font-extrabold text-blue-900 border-none outline-none text-right w-full cursor-default pointer-events-none">
                    </div>
                </div>

                <button type="submit" class="w-full bg-hijau-utama text-white font-bold text-lg py-4 rounded-xl hover:bg-hijau-gelap transition shadow-lg flex justify-center items-center gap-2">
                    ✅ Simpan Setoran
                </button>
            </form>
        </div>
    </div>

    <script>
        function hitungTotal() {
            const jenis = document.getElementById('jenis_sampah');
            const berat = document.getElementById('berat').value;
            const totalInput = document.getElementById('total_harga');

            if(jenis.value && berat > 0) {
                // Ambil harga dari atribut data-harga pada option yang dipilih
                const harga = parseFloat(jenis.options[jenis.selectedIndex].getAttribute('data-harga'));
                const total = harga * parseFloat(berat);
                
                // Format ke Rupiah
                totalInput.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            } else {
                totalInput.value = 'Rp 0';
            }
        }
    </script>

<!-- ========================================== -->
<!-- SCRIPT UNTUK SEARCHABLE DROPDOWN NASABAH -->
<!-- ========================================== -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

<!-- TAMBAHKAN KODE STYLE INI UNTUK MENGHILANGKAN GARIS GANDA -->
<style>
    .ts-control {
        border: none !important;
        box-shadow: none !important;
        padding-left: 0 !important; /* Menyesuaikan jarak padding agar pas dengan Tailwind */
    }
    .ts-wrapper.focus .ts-control {
        box-shadow: none !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect("#select-nasabah", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Cari nama nasabah..."
        });
    });
</script>
<!-- ========================================== -->
@endsection