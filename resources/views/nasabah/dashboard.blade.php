@extends('layouts.app')

@section('title', 'Dashboard Nasabah')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Selamat datang kembali, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-gray-500">Pantau tabungan sampahmu dan terus tingkatkan demi Purwokerto yang bersih.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-hijau-utama to-hijau-gelap rounded-2xl p-6 text-white shadow-lg md:col-span-2">
            <h2 class="text-sm font-medium text-green-100 mb-1">Total Saldo Aktif</h2>
            <div class="text-4xl font-extrabold tracking-tight mb-6">Rp {{ number_format($saldo_terakhir, 0, ',', '.') }}</div>
            
            <div class="flex gap-3">
                <a href="{{ route('nasabah.penarikan') }}" class="bg-white text-hijau-gelap px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-50 transition shadow-sm flex-1 text-center">
                    💸 Ajukan Penarikan
                </a>
                <a href="{{ route('nasabah.request_jemput') }}" class="bg-green-600 text-white border border-green-400 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-green-500 transition shadow-sm flex-1 text-center">
                    🚛 Request Jemput
                </a>
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

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-center gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Total Sampah</p>
                    <div class="text-2xl font-bold text-gray-800 flex items-baseline gap-1">
                        {{ number_format($total_sampah, 1, ',', '.') }} 
                        <span class="text-sm font-normal text-gray-500">Kg</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center text-xl shadow-sm">
                    📦
                </div>
            </div>
            <hr class="border-gray-50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $total_transaksi }} <span class="text-sm font-normal text-gray-500">kali</span></p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center text-xl">🤝</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800">Transaksi Terakhir</h3>
                <a href="{{ route('nasabah.riwayat') }}" class="text-sm font-bold text-hijau-utama hover:text-hijau-gelap hover:underline transition">
                    Lihat Semua
                </a>
            </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium">Keterangan</th>
                        <th class="px-6 py-3 font-medium text-right">Nominal</th>
                        <th class="px-6 py-3 font-medium text-right">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat_transaksi as $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-600">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $trx->keterangan }}</td>
                            
                            @if($trx->tipe === 'kredit')
                                <td class="px-6 py-4 text-right text-green-600 font-bold">+ Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
                            @else
                                <td class="px-6 py-4 text-right text-red-500 font-bold">- Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
                            @endif
                            
                            <td class="px-6 py-4 text-right font-medium text-gray-800">Rp {{ number_format($trx->saldo_akhir, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi. Ayo mulai menabung sampah!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection