<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Bank Sampah</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center py-10">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-hijau-utama mb-2">📝 Daftar Akun</h1>
            <p class="text-gray-500">Mulai menabung sampah hari ini</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none transition" 
                    placeholder="Nama Lengkap Anda">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none transition" 
                    placeholder="contoh@gmail.com">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nomor HP</label>
                <input type="number" name="no_hp" value="{{ old('no_hp') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none transition" 
                    placeholder="08123456789">
            </div>

            <div class="mb-4 relative">
                <label class="block text-gray-700 font-medium mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="reg-password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none transition pr-10">
                    <button type="button" onclick="togglePassword('reg-password', 'eye-reg')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                        <span id="eye-reg">👁️</span>
                    </button>
                </div>
            </div>

            <div class="mb-6 relative">
                <label class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="reg-password-confirm" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none transition pr-10">
                    <button type="button" onclick="togglePassword('reg-password-confirm', 'eye-confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                        <span id="eye-confirm">👁️</span>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-hijau-utama text-white font-bold py-3 rounded-lg hover:bg-hijau-gelap transition">
                Daftar & Kirim OTP
            </button>
        </form>

        <div class="text-center mt-6 text-sm text-gray-500">
            Sudah punya akun? <a href="{{ url('/login') }}" class="text-hijau-utama font-bold hover:underline">Masuk di sini</a>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.innerText = "🙈";
            } else {
                input.type = "password";
                icon.innerText = "👁️";
            }
        }
    </script>
</body>
</html>