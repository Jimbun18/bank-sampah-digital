@extends('layouts.app')

@section('title', 'Dashboard Nasabah')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Halo, <span class="text-emerald-500">{{ Auth::user()->name }}!</span> 👋</h1>
        <p class="text-slate-500 mt-1">Kelola tabungan sampahmu dan terus tingkatkan demi Purwokerto yang bersih.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <h2 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-4 relative z-10 flex items-center justify-between">
                Total Saldo Aktif
                <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm"><i class="fas fa-wallet"></i></span>
            </h2>
            <div class="relative z-10">
                <div class="text-3xl font-extrabold text-slate-800 mb-1">Rp {{ number_format($saldo_terakhir, 0, ',', '.') }}</div>
                <p class="text-sm text-emerald-500 font-medium mt-1">Saldo siap dicairkan</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-cyan-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <h2 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-4 relative z-10 flex items-center justify-between">
                Total Sampah
                <span class="w-8 h-8 rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center text-sm"><i class="fas fa-weight-hanging"></i></span>
            </h2>
            <div class="relative z-10">
                <div class="text-3xl font-extrabold text-slate-800 mb-1">{{ number_format($total_sampah, 1, ',', '.') }} <span class="text-xl text-slate-500 font-medium">Kg</span></div>
                <p class="text-sm text-slate-400 font-medium mt-1">Total kontribusi daur ulang</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <h2 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-4 relative z-10 flex items-center justify-between">
                Total Transaksi
                <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-sm"><i class="fas fa-exchange-alt"></i></span>
            </h2>
            <div class="relative z-10">
                <div class="text-3xl font-extrabold text-slate-800 mb-1">{{ $total_transaksi }} <span class="text-xl text-slate-500 font-medium">Kali</span></div>
                <p class="text-sm text-slate-400 font-medium mt-1">Transaksi berhasil diproses</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('nasabah.request_jemput') }}" class="flex flex-col items-center justify-center p-4 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors border border-emerald-100 group">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-emerald-500 text-xl shadow-sm mb-3 group-hover:scale-110 transition-transform">🚛</div>
                        <span class="text-sm font-bold text-emerald-700">Jemput</span>
                    </a>
                    <a href="{{ route('nasabah.penarikan') }}" class="flex flex-col items-center justify-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors border border-blue-100 group">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-500 text-xl shadow-sm mb-3 group-hover:scale-110 transition-transform">💸</div>
                        <span class="text-sm font-bold text-blue-700">Tarik Saldo</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800">Harga Hari Ini</h3>
                    <span class="text-xs bg-emerald-100 text-emerald-600 px-2 py-1 rounded-md font-bold uppercase tracking-wider">Live</span>
                </div>
                
                <div class="space-y-3">
                    @forelse($jenis_sampahs as $sampah)
                    <div class="flex justify-between items-center p-3 hover:bg-slate-50 rounded-lg transition-colors border border-transparent hover:border-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold text-slate-600 uppercase">{{ $sampah->nama_sampah }}</span>
                        </div>
                        <span class="text-sm font-bold text-slate-800">Rp {{ number_format($sampah->harga_per_kg, 0, ',', '.') }}/kg</span>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500 text-center py-2">Data harga belum tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800">Riwayat Transaksi</h3>
                <a href="{{ route('nasabah.mutasi') }}" class="text-sm font-bold text-emerald-500 hover:text-emerald-600 hover:underline transition">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-medium rounded-tl-lg">Tanggal</th>
                            <th class="px-6 py-4 font-medium">Keterangan</th>
                            <th class="px-6 py-4 font-medium text-right">Nominal</th>
                            <th class="px-6 py-4 font-medium text-right rounded-tr-lg">Saldo Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($riwayat_transaksi as $trx)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-slate-500">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $trx->keterangan }}</td>
                                
                                @if($trx->tipe === 'kredit')
                                    <td class="px-6 py-4 text-right text-emerald-500 font-bold">+ Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
                                @else
                                    <td class="px-6 py-4 text-right text-red-500 font-bold">- Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
                                @endif
                                
                                <td class="px-6 py-4 text-right font-bold text-slate-800">Rp {{ number_format($trx->saldo_akhir, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                    <div class="text-4xl mb-3">🍃</div>
                                    <p>Belum ada transaksi. Ayo mulai menabung sampah!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection