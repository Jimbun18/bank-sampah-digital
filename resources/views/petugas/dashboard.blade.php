@extends('layouts.app')
@section('title', 'Dashboard Petugas')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Area Kerja Petugas 👷‍♂️</h1>
        <p class="text-gray-500">Semangat bertugas, {{ Auth::user()->name }}! Jangan lupa senyum saat melayani nasabah.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-3xl mb-4">⚖️</div>
            <h3 class="font-bold text-lg mb-2">Terima Setoran Baru</h3>
            <p class="text-sm text-gray-500 mb-4">Timbang sampah nasabah yang datang langsung ke bank sampah.</p>
            <a href="{{ route('petugas.setor') }}" class="w-full bg-hijau-utama text-white py-2 rounded-lg font-bold hover:bg-hijau-gelap transition">Buka Kasir</a>
        </div>
    </div>

    <!-- Widget Update Harga Hari Ini -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
            📊 Update Harga Hari Ini
        </h3>
        <span class="text-xs bg-emerald-100 text-hijau-utama px-2 py-1 rounded-md font-bold">Live</span>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($jenis_sampahs as $sampah)
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col justify-center text-center hover:bg-emerald-50 transition">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $sampah->nama_sampah }}</span>
            <span class="text-lg font-black text-hijau-utama mt-1">Rp {{ number_format($sampah->harga_per_kg, 0, ',', '.') }}</span>
        </div>
        @endforeach
    </div>
</div>

<!-- Widget Diagram Statistik Setoran -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">📉 Statistik Sampah Masuk (7 Hari Terakhir)</h3>
    <div class="relative h-72 w-full">
        <!-- Kanvas tempat diagram digambar -->
        <canvas id="chartSetoran"></canvas>
    </div>
</div>

<!-- Load Chart.js & Script Eksekusi -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartSetoran').getContext('2d');
    new Chart(ctx, {
        type: 'bar', // Bisa diubah jadi 'line' jika ingin diagram garis
        data: {
            labels: {!! json_encode($chart_dates) !!}, // Label tanggal dari controller
            datasets: [{
                label: 'Total Berat Sampah (Kg)',
                data: {!! json_encode($chart_weights) !!}, // Data berat dari controller
                backgroundColor: '#16a34a', // Warna hijau utama
                borderRadius: 8, // Ujung bar melengkung
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false } // Sembunyikan legenda agar lebih bersih
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection