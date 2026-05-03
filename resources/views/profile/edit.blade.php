@extends('layouts.app')
@section('title', 'Pengaturan Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">👤 Pengaturan Profil</h1>
        <p class="text-gray-500 text-sm">Kelola informasi identitas dan keamanan akun Anda.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm">
            <p class="text-green-700 font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-4">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                <div class="w-20 h-20 bg-hijau-utama text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mt-1">{{ $user->role }}</p>
            </div>
        </div>

        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>📝</span> Informasi Identitas
                </h3>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('patch')
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">No. WhatsApp (HP)</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxx" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-hijau-utama text-white font-bold py-2 px-6 rounded-lg hover:bg-hijau-gelap transition">Simpan Perubahan</button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>🔒</span> Keamanan & Kata Sandi
                </h3>
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('put')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Kata Sandi Baru</label>
                            <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-gray-800 text-white font-bold py-2 px-6 rounded-lg hover:bg-black transition">Update Kata Sandi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection