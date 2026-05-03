@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Pusat Kendali Admin 🌍</h1>
        <p class="text-gray-500">Selamat bekerja, {{ Auth::user()->name }}.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-2xl">👥</div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Nasabah</p>
                <p class="text-2xl font-bold">{{ $total_nasabah }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center text-2xl">⏳</div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Penarikan Pending</p>
                <p class="text-2xl font-bold">{{ $total_penarikan_pending }}</p>
            </div>
        </div>
    </div>
    <!-- Filter & Judul Grafik -->
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 mt-10">
    <h2 class="text-xl font-bold text-gray-800">📊 Statistik Bank Sampah</h2>
    
    <!-- Form Filter Responsif -->
    <form id="filterForm" method="GET" action="{{ route('admin.dashboard') }}">
        <select name="filter" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none text-sm font-bold text-gray-700 shadow-sm cursor-pointer">
            <option value="minggu" {{ $filter == 'minggu' ? 'selected' : '' }}>7 Hari Terakhir</option>
            <option value="bulan" {{ $filter == 'bulan' ? 'selected' : '' }}>30 Hari Terakhir</option>
            <option value="tahun" {{ $filter == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
        </select>
    </form>
</div>

<!-- Grid Untuk Grafik -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- Chart 1: Sampah Masuk -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Tren Sampah Masuk (Kg)</h3>
        <div class="relative h-64 w-full">
            <canvas id="chartSampah"></canvas>
        </div>
    </div>

    <!-- Chart 2: Penarikan Dana -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Tren Penarikan Saldo (Rp)</h3>
        <div class="relative h-64 w-full">
            <canvas id="chartPenarikan"></canvas>
        </div>
    </div>

    <!-- Chart 3: Harga Sampah (Full Width) -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Proporsi Sampah Terkumpul (Total Keseluruhan)</h3>
        <div class="relative h-72 w-full flex justify-center">
            <canvas id="chartJenisSampah" style="max-width: 500px;"></canvas>
        </div>
    </div>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Inisialisasi Chart Sampah Masuk (Line Chart)
    new Chart(document.getElementById('chartSampah').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_labels) !!},
            datasets: [{
                label: 'Berat Sampah (Kg)',
                data: {!! json_encode($chart_sampah) !!},
                borderColor: '#16a34a',
                backgroundColor: 'rgba(22, 163, 74, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4 // Melengkungkan garis
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 2. Inisialisasi Chart Penarikan (Bar Chart)
    new Chart(document.getElementById('chartPenarikan').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chart_labels) !!},
            datasets: [{
                label: 'Total Penarikan (Rp)',
                data: {!! json_encode($chart_penarikan) !!},
                backgroundColor: '#ef4444', // Merah agar beda
                borderRadius: 6
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 3. Inisialisasi Chart Proporsi Sampah (Doughnut Chart)
    new Chart(document.getElementById('chartJenisSampah').getContext('2d'), {
        type: 'doughnut', // Menggunakan grafik melingkar berlubang
        data: {
            labels: {!! json_encode($label_jenis) !!},
            datasets: [{
                data: {!! json_encode($data_berat_jenis) !!},
                // Memberikan variasi warna menarik untuk setiap jenis sampah
                backgroundColor: [
                    '#3b82f6', // Biru
                    '#10b981', // Hijau
                    '#f59e0b', // Kuning/Oranye
                    '#ef4444', // Merah
                    '#8b5cf6', // Ungu
                    '#64748b'  // Abu-abu
                ],
                borderWidth: 2,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: true,
                    position: 'right', // Menaruh keterangan warna di sebelah kanan
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.label + ': ' + context.raw + ' Kg';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection