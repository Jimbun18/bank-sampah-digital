<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">✉️ Cek Email Anda</h2>
        <p class="text-gray-500 text-sm mb-6">Kami telah mengirimkan 6 digit kode OTP ke email <strong>{{ session('email') ?? $email }}</strong></p>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/verify-otp') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') ?? $email }}">
            
            <div class="mb-6">
                <input type="number" name="otp" required autofocus placeholder="Masukkan 6 Digit OTP" 
                       class="w-full text-center text-2xl tracking-[0.5em] font-bold px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none">
            </div>

            <button type="submit" class="w-full bg-hijau-utama text-white font-bold py-3 rounded-xl hover:bg-hijau-gelap transition">
                Verifikasi & Masuk
            </button>
        </form>
    </div>
</body>
</html>