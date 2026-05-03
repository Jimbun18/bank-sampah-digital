@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">📄 Riwayat Transaksi</h1>
            <p class="text-gray-500 text-sm">Seluruh catatan setoran dan penarikan saldo Anda.</p>
        </div>
        <a href="{{ route('nasabah.dashboard') }}" class="text-sm font-bold text-hijau-utama hover:underline">
            &larr; Kembali ke Dasbor
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase font-bold text-[10px] tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                        <th class="px-6 py-4 text-right">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat_transaksi as $riwayat)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-500">
                            {{ $riwayat->created_at->format('d M Y, H:i') }} WIB
                        </td>
                        <td class="px-6 py-4 text-gray-800 font-medium">
                            {{ $riwayat->keterangan }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold {{ $riwayat->tipe == 'kredit' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $riwayat->tipe == 'kredit' ? '+' : '-' }} Rp {{ number_format($riwayat->nominal, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right text-gray-800 font-medium">
                            Rp {{ number_format($riwayat->saldo_akhir, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                            Belum ada riwayat transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $riwayat_transaksi->links() }}
        </div>
    </div>
</div>
@endsection