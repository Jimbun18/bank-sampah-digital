@extends('layouts.app')
@section('title', 'Data Pengguna')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">👥 Data Pengguna</h1>
            <p class="text-gray-500 text-sm">Kelola seluruh akun yang terdaftar di sistem Bank Sampah.</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">➕ Tambah Pengguna / Petugas Baru</h3>
    
    <form action="{{ route('admin.pengguna.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        
        <div>
            <label class="block text-sm font-bold text-gray-600 mb-2">Nama Lengkap</label>
            <input type="text" name="name" required placeholder="Masukkan nama..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-2">Alamat Email</label>
            <input type="email" name="email" required placeholder="email@contoh.com" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-2">Password Asal (Minimal 6 Karakter)</label>
            <input type="password" name="password" required placeholder="******" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-2">Peran (Role)</label>
            <select name="role" id="pilihRole" required onchange="tampilkanPilihanCabang()" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none">
                <option value="nasabah">Nasabah</option>
                <option value="petugas">Petugas</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div id="kotakCabang" style="display: none;" class="md:col-span-2 p-4 bg-gray-50 border border-gray-200 rounded-xl">
            <label class="block text-sm font-bold text-gray-600 mb-2">🏢 Lokasi Dinas (Hanya Untuk Petugas)</label>
            <select name="bank_sampah_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none">
                <option value="">-- Pilih Lokasi Bank Sampah --</option>
                @foreach($banks as $bank)
                    <option value="{{ $bank->id }}">{{ $bank->nama_bank }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-400 mt-2">*Otomatis mendeteksi pesanan penjemputan terdekat ke cabang ini.</p>
        </div>

        <div class="md:col-span-2 flex justify-end mt-2">
            <button type="submit" class="bg-hijau-utama hover:bg-hijau-gelap text-white font-bold py-2 px-6 rounded-xl transition">
                Simpan Akun
            </button>
        </div>
    </form>
</div>

<script>
    function tampilkanPilihanCabang() {
        var dropdownRole = document.getElementById("pilihRole").value;
        var kotakCabang = document.getElementById("kotakCabang");
        
        // Jika yang dipilih adalah "petugas", maka tampilkan kotak pilihan cabang
        if (dropdownRole === "petugas") {
            kotakCabang.style.display = "block";
        } else {
            kotakCabang.style.display = "none";
        }
    }
</script>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm">
            <p class="text-green-700 font-bold">Berhasil!</p>
            <p class="text-green-600 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-6">
        <form action="{{ route('admin.data_pengguna') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Cari Nama / Email</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik pencarian..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Hak Akses (Role)</label>
                <select name="role" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none text-sm bg-gray-50">
                    <option value="">Semua Role</option>
                    <option value="nasabah" {{ request('role') == 'nasabah' ? 'selected' : '' }}>Nasabah</option>
                    <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin Pusat</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-hijau-utama text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-hijau-gelap transition w-full">
                    Cari Data
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-4 font-medium">Profil Pengguna</th>
                        <th class="px-6 py-4 font-medium">Role / Hak Akses</th>
                        <th class="px-6 py-4 font-medium">Tgl Mendaftar</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi (Reset)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800 text-base">{{ $u->name }}</div>
                                <div class="text-gray-500 text-xs mt-1">📧 {{ $u->email }}</div>
                                @if($u->no_hp)
                                    <div class="text-gray-500 text-xs mt-1">📱 {{ $u->no_hp }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($u->role === 'admin')
                                    <span class="bg-purple-100 text-purple-700 text-xs px-3 py-1 rounded-full font-bold uppercase">Admin</span>
                                @elseif($u->role === 'petugas')
                                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-bold uppercase">Petugas</span>
                                    @if($u->bank_sampah_id)
                                        <div class="text-xs text-gray-400 mt-2">Cabang: {{ $u->bankSampah->nama_bank ?? 'N/A' }}</div>
                                    @endif
                                @else
                                    <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-bold uppercase">Nasabah</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $u->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.reset_password', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset password {{ $u->name }} menjadi \'password123\'?')">
                                    @csrf
                                    <button type="submit" class="bg-yellow-50 text-yellow-600 border border-yellow-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-yellow-100 transition shadow-sm">
                                        🔑 Reset Password
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Data pengguna tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection