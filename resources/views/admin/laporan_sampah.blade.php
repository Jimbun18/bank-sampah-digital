@extends('layouts.app')
@section('title', 'Laporan Sampah Masuk')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">📊 Laporan Sampah Masuk</h1>
            <p class="text-gray-500 text-sm">Pantau statistik dan riwayat setoran sampah dari nasabah.</p>
        </div>
        <a href="{{ route('admin.laporan_sampah.export', request()->query()) }}" class="bg-hijau-utama hover:bg-hijau-gelap text-white px-5 py-2.5 rounded-xl font-bold shadow-sm transition flex items-center gap-2 text-sm">
            📥 Export CSV
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-2xl">📅</div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Masuk Hari Ini</p>
                <p class="text-2xl font-black text-gray-800">{{ number_format($total_hari_ini, 1, ',', '.') }} <span class="text-sm text-gray-500 font-medium">Kg</span></p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center text-2xl">📆</div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Bulan Ini</p>
                <p class="text-2xl font-black text-gray-800">{{ number_format($total_bulan_ini, 1, ',', '.') }} <span class="text-sm text-gray-500 font-medium">Kg</span></p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-purple-50 text-purple-500 rounded-full flex items-center justify-center text-2xl">🗓️</div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Tahun Ini</p>
                <p class="text-2xl font-black text-gray-800">{{ number_format($total_tahun_ini, 1, ',', '.') }} <span class="text-sm text-gray-500 font-medium">Kg</span></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50">
            <form action="{{ route('admin.laporan_sampah') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Cari Nasabah</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jenis Sampah</label>
                    <select name="jenis_sampah_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none text-sm">
                        <option value="">Semua Jenis</option>
                        @foreach($jenis_sampahs as $js)
                            <option value="{{ $js->id }}" {{ request('jenis_sampah_id') == $js->id ? 'selected' : '' }}>{{ $js->nama_sampah }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal Masuk</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none text-sm">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition">🔍 Filter</button>
                    @if(request()->hasAny(['search', 'jenis_sampah_id', 'tanggal']))
                        <a href="{{ route('admin.laporan_sampah') }}" class="bg-red-50 text-red-600 hover:bg-red-100 font-bold flex items-center justify-center w-11 h-10 rounded-xl transition" title="Hapus Filter">✖</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-white text-gray-500 uppercase font-bold text-[10px] tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Waktu Setor</th>
                        <th class="px-6 py-4">Nama Nasabah</th>
                        <th class="px-6 py-4">Jenis Sampah</th>
                        <th class="px-6 py-4 text-right">Berat (Kg)</th>
                        <th class="px-6 py-4 text-right">Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksis as $t)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-500">{{ $t->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 font-bold text-gray-800">{{ $t->user->name ?? 'Anonim' }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-xs font-semibold">{{ $t->jenisSampah->nama_sampah ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-gray-800">{{ number_format($t->berat, 1, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right text-hijau-utama font-bold">+ {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                            <div class="text-4xl mb-2">📭</div>
                            Tidak ada data sampah masuk yang ditemukan.
                        </td>
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