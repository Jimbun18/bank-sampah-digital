@extends('layouts.app')
@section('title', 'Kelola Penarikan')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">💰 Kelola Penarikan</h1>
            <p class="text-gray-500 text-sm">Manajemen data pencairan saldo nasabah.</p>
        </div>
        <a href="{{ route('admin.export_penarikan') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-sm flex items-center justify-center gap-2">
            📥 Export CSV
        </a>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-6">
        <form action="{{ route('admin.penarikan') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Cari Nasabah</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none text-sm bg-gray-50">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="md:col-span-2 flex items-end gap-2">
                <button type="submit" class="bg-hijau-utama text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-hijau-gelap transition">
                    Filter Data
                </button>
                <a href="{{ route('admin.penarikan') }}" class="bg-gray-100 text-gray-600 px-6 py-2 rounded-lg font-bold text-sm hover:bg-gray-200 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-4 font-medium">Tanggal</th>
                        <th class="px-6 py-4 font-medium">Nasabah</th>
                        <th class="px-6 py-4 font-medium">Nominal / Metode</th>
                        <th class="px-6 py-4 font-medium">Detail Tujuan</th>
                        <th class="px-6 py-4 font-medium text-center">Status</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($penarikans as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-600">{{ $p->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $p->user->name }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">Rp {{ number_format($p->nominal, 0, ',', '.') }}</div>
                                <div class="text-xs text-gray-500 uppercase">{{ $p->metode }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $p->detail_tujuan }}">{{ $p->detail_tujuan }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($p->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-medium">Pending</span>
                                @elseif($p->status === 'disetujui')
                                    <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">Disetujui</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-medium">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                @if($p->status === 'pending')
                                    <form action="{{ route('admin.proses_penarikan', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin MENYETUJUI penarikan ini? Saldo nasabah akan dipotong.')">
                                        @csrf
                                        <input type="hidden" name="status" value="disetujui">
                                        <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition tooltip" title="Setujui">✅</button>
                                    </form>
                                    <form action="{{ route('admin.proses_penarikan', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin MENOLAK penarikan ini? Uang akan dikembalikan ke saldo aktif nasabah.')">
                                        @csrf
                                        <input type="hidden" name="status" value="ditolak">
                                        <!-- Tombol Tolak Baru -->
                                        <button type="button" onclick="bukaModalTolak({{ $p->id }})" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-md transition">
                                            ❌
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pengajuan penarikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Tolak Penarikan -->
<div id="modalTolak" class="hidden fixed inset-0 bg-gray-900/70 backdrop-blur-sm z-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-2xl w-full max-w-md shadow-xl transform transition-all">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Tolak Penarikan Saldo</h3>
            <button onclick="tutupModalTolak()" class="text-gray-400 hover:text-red-500">✖</button>
        </div>
        <p class="text-sm text-gray-500 mb-4">Uang akan otomatis dikembalikan ke saldo aktif nasabah. Silakan berikan alasan penolakan.</p>
        
        <!-- Form Penolakan -->
        <form id="formTolak" method="POST" action="">
            @csrf
            <!-- Sesuaikan method PUT/POST dengan route-mu yang sudah ada -->
            @method('PUT') 
            
            <div class="mb-5">
                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Alasan Ditolak</label>
                <textarea name="catatan_penolakan" required rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 outline-none text-sm" placeholder="Contoh: Nomor e-wallet tidak ditemukan / salah ketik..."></textarea>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="tutupModalTolak()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md transition">Kirim & Tolak</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalTolak(id) {
        // Tampilkan modal
        document.getElementById('modalTolak').classList.remove('hidden');
        // Set action URL form secara dinamis (SESUAIKAN DENGAN URL ROUTE TOLAK-MU)
        // Contoh jika route kamu: /admin/penarikan/tolak/{id}
        document.getElementById('formTolak').action = `/admin/penarikan/tolak/${id}`;
    }

    function tutupModalTolak() {
        // Sembunyikan modal
        document.getElementById('modalTolak').classList.add('hidden');
    }
</script>
@endsection