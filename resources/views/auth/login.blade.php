<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bank Sampah</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-hijau-utama mb-2">♻️ Login</h1>
            <p class="text-gray-500">Masuk ke akun Bank Sampah Anda</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none transition" 
                    placeholder="contoh@gmail.com">
            </div>

            <div class="mb-6 relative">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none transition pr-10" 
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword('password', 'eye-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-hijau-utama">
                        <span id="eye-icon">👁️</span>
                    </button>
                </div>
            </div>

            <div class="mb-6 text-right">
                <a href="{{ url('/forgot-password') }}" class="text-sm text-hijau-utama font-medium hover:underline">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="w-full bg-hijau-utama text-white font-bold py-3 rounded-lg hover:bg-hijau-gelap transition">
                Masuk Sekarang
            </button>
        </form>

        <div class="text-center mt-6 text-sm text-gray-500 border-t border-gray-100 pt-6">
            Belum punya akun? <a href="{{ url('/register') }}" class="text-hijau-utama font-bold hover:underline">Daftar di sini</a>
        </div>
        
        <script>
            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                
                if (input.type === "password") {
                    input.type = "text";
                    icon.innerText = "🙈"; // Ikon mata tertutup
                } else {
                    input.type = "password";
                    icon.innerText = "👁️"; // Ikon mata terbuka
                }
            }
        </script>


        <div class="text-center mt-6 text-sm text-gray-500">
            <a href="{{ route('landing') }}" class="hover:text-hijau-utama">&larr; Kembali ke Halaman Utama</a>
        </div>
        
    </div>

</body>
</html>