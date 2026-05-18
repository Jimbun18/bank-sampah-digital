<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Bank Sampah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <nav class="bg-hijau-utama shadow-md px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2 rounded-xl px-3 py-1.5 bg-white shadow-sm transition hover:bg-gray-50">
            <span class="text-xl">♻</span>
            <span class="font-bold text-lg md:text-xl text-hijau-utama">Bank Sampah</span>
        </div>
        <div class="flex items-center gap-2 sm:gap-4">
                    
                    <div class="hidden sm:block text-right mr-1">
                        <p class="text-[10px] text-green-100 uppercase font-bold tracking-wider">{{ Auth::user()->role }}</p>
                        <p class="text-sm text-white font-bold">{{ Auth::user()->name }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="w-9 h-9 flex justify-center items-center bg-green-700 hover:bg-green-800 border border-green-500 text-white rounded-full transition shadow-sm" title="Pengaturan Profil">
                        👤
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="bg-white text-red-600 px-4 py-2 rounded-full font-bold text-sm hover:bg-gray-100 transition shadow-sm">
                            Keluar
                        </button>
                    </form>
                </div>
    </nav>

    @if(Auth::check() && in_array(Auth::user()->role, ['nasabah', 'petugas', 'admin']))
    <div class="bg-white shadow-sm border-b border-gray-200 px-6 py-3 overflow-x-auto whitespace-nowrap">
        <div class="max-w-7xl mx-auto flex gap-6 text-sm font-medium">
            @if(Auth::user()->role === 'nasabah')
                <a href="{{ route('nasabah.dashboard') }}" class="{{ request()->routeIs('nasabah.dashboard') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Dashboard</a>
                <a href="{{ route('nasabah.penarikan') }}" class="{{ request()->routeIs('nasabah.penarikan') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Penarikan</a>
                <a href="{{ route('nasabah.mutasi') }}" class="{{ request()->routeIs('nasabah.mutasi') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Saldo & Mutasi</a>
                <a href="{{ route('nasabah.request_jemput') }}" class="{{ request()->routeIs('nasabah.request_jemput') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Request Jemput</a>
            @elseif(Auth::user()->role === 'petugas')
                <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Dashboard Petugas</a>
                <a href="{{ route('petugas.riwayat') }}" class="{{ request()->routeIs('petugas.riwayat') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Riwayat Setoran</a>
                <a href="{{ route('petugas.setor') }}" class="{{ request()->routeIs('petugas.setor') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Transaksi Setor</a>
                <a href="{{ route('petugas.request_jemput') }}" class="{{ request()->routeIs('petugas.request_jemput') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Request Jemput Masuk</a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Dashboard Admin</a>
                <a href="{{ route('admin.penarikan') }}" class="{{ request()->routeIs('admin.penarikan') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Kelola Penarikan</a>
                <a href="{{ route('admin.master_data') }}" class="{{ request()->routeIs('admin.master_data') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Kelola Bank & Kategori</a>
                <a href="{{ route('admin.laporan_sampah') }}" class="{{ request()->routeIs('admin.laporan_sampah') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Data Sampah Masuk</a>
                <a href="{{ route('admin.data_pengguna') }}" class="{{ request()->routeIs('admin.data_pengguna') ? 'text-hijau-utama border-b-2 border-hijau-utama' : 'text-gray-500 hover:text-hijau-utama' }} pb-1 transition">Data Pengguna</a>
            @endif
        </div>
    </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

</body>
</html>