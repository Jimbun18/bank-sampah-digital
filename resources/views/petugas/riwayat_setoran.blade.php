@extends('layouts.app')
@section('title', 'Riwayat Setoran Nasabah')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">📋 Riwayat Semua Setoran</h1>
            <p class="text-gray-500 text-sm">Pantau dan filter riwayat penyetoran sampah nasabah.</p>
        </div>
        <!-- Tombol Export CSV (Membawa parameter filter) -->
        <a href="{{ route('petugas.riwayat.export', request()->query()) }}" class="bg-hijau-utama hover:bg-hijau-gelap text-white px-5 py-2.5 rounded-xl font-bold shadow-sm transition flex items-center gap-2 text-sm">
            📥 Export CSV
        </a>
    </div>

    <!-- Filter & Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <!-- Form Filter -->
        <div class="p-6 border-b border-gray-100 bg-gray-50">
            <form action="{{ route('petugas.riwayat') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Nasabah</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jenis Sampah</label>
                    <select name="jenis_sampah_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none text-sm">
                        <option value="">Semua</option>
                        @foreach($jenis_sampahs as $js)
                            <option value="{{ $js->id }}" {{ request('jenis_sampah_id') == $js->id ? 'selected' : '' }}>{{ $js->nama_sampah }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none text-sm">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition">🔍 Filter</button>
                    @if(request()->hasAny(['search', 'jenis_sampah_id', 'tanggal']))
                        <a href="{{ route('petugas.riwayat') }}" class="bg-red-50 text-red-600 hover:bg-red-100 font-bold flex items-center justify-center w-11 h-10 rounded-xl transition">✖</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-white text-gray-500 uppercase font-bold text-[10px] tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Waktu Setor</th>
                        <th class="px-6 py-4">Nasabah</th>
                        <th class="px-6 py-4">Sampah</th>
                        <th class="px-6 py-4 text-right">Berat</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksis as $t)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-500">{{ $t->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 font-bold text-gray-800">{{ $t->user->name ?? '-' }}</td>
                        <td class="px-6 py-4"><span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-xs font-semibold">{{ $t->jenisSampah->nama_sampah ?? '-' }}</span></td>
                        <td class="px-6 py-4 text-right font-bold">{{ $t->berat }} Kg</td>
                        <td class="px-6 py-4 text-right text-hijau-utama font-bold">+ Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada riwayat setoran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection