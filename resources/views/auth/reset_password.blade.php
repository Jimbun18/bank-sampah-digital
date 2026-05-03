<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center py-10">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Buat Sandi Baru</h2>
        <p class="text-gray-500 text-sm mb-6 text-center">Masukkan 6 digit OTP yang dikirim ke <strong>{{ session('email') ?? $email }}</strong> dan buat sandi baru Anda.</p>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm font-bold">{{ $errors->first() }}</div>
        @endif
        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-3 rounded-lg mb-4 text-sm font-bold">{{ session('success') }}</div>
        @endif

        <form action="{{ url('/reset-password') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') ?? $email }}">
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Kode OTP</label>
                <input type="number" name="otp" required autofocus placeholder="123456" 
                       class="w-full text-center tracking-[0.5em] font-bold px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none">
            </div>

            <div class="mb-4 relative">
                <label class="block text-gray-700 font-medium mb-2">Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password" id="reset-pass" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none pr-10">
                    <button type="button" onclick="togglePassword('reset-pass', 'eye-reset')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                        <span id="eye-reset">👁️</span>
                    </button>
                </div>
            </div>

            <div class="mb-6 relative">
                <label class="block text-gray-700 font-medium mb-2">Konfirmasi Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="reset-confirm" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none pr-10">
                    <button type="button" onclick="togglePassword('reset-confirm', 'eye-confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                        <span id="eye-confirm">👁️</span>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-hijau-utama text-white font-bold py-3 rounded-xl hover:bg-hijau-gelap transition">
                Simpan Sandi Baru
            </button>
        </form>
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