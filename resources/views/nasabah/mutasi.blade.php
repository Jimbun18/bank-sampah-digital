@extends('layouts.app')
@section('title', 'Saldo & Mutasi')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">💳 Saldo & Mutasi</h1>
            <p class="text-gray-500 text-sm">Rincian seluruh transaksi keluar dan masuk akun Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 shadow-sm">
            <p class="text-blue-800 font-medium text-sm mb-1">Saldo Saat Ini</p>
            <p class="text-3xl font-extrabold text-blue-900">Rp {{ number_format($saldo_terakhir, 0, ',', '.') }}</p>
        </div>
        <div class="bg-green-50 border border-green-100 rounded-2xl p-6 shadow-sm">
            <p class="text-green-800 font-medium text-sm mb-1">Total Pemasukan (Kredit)</p>
            <p class="text-2xl font-bold text-green-700">Rp {{ number_format($total_masuk, 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-50 border border-red-100 rounded-2xl p-6 shadow-sm">
            <p class="text-red-800 font-medium text-sm mb-1">Total Pengeluaran (Debit)</p>
            <p class="text-2xl font-bold text-red-700">Rp {{ number_format($total_keluar, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-6 flex items-center justify-between">
        <h3 class="font-bold text-gray-700">Riwayat Transaksi</h3>
        <form action="{{ route('nasabah.mutasi') }}" method="GET" class="flex gap-2">
            <select name="tipe" class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none text-sm bg-gray-50" onchange="this.form.submit()">
                <option value="">Semua Transaksi</option>
                <option value="kredit" {{ request('tipe') == 'kredit' ? 'selected' : '' }}>Pemasukan Saja</option>
                <option value="debit" {{ request('tipe') == 'debit' ? 'selected' : '' }}>Pengeluaran Saja</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-4 font-medium">Tanggal</th>
                        <th class="px-6 py-4 font-medium">Keterangan</th>
                        <th class="px-6 py-4 font-medium text-right">Mutasi (Rp)</th>
                        <th class="px-6 py-4 font-medium text-right">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mutasis as $m)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-600">{{ $m->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-800 block">{{ $m->keterangan }}</span>
                                <span class="text-xs {{ $m->tipe == 'kredit' ? 'text-green-600' : 'text-red-500' }} uppercase font-medium">
                                    {{ $m->tipe }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($m->tipe === 'kredit')
                                    <span class="text-green-600 font-bold">+ {{ number_format($m->nominal, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-red-500 font-bold">- {{ number_format($m->nominal, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-gray-800">
                                {{ number_format($m->saldo_akhir, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection