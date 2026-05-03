<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">🔐 Lupa Kata Sandi?</h2>
        <p class="text-gray-500 text-sm mb-6">Masukkan email yang terdaftar. Kami akan mengirimkan kode OTP untuk mereset sandi Anda.</p>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm font-bold">{{ $errors->first() }}</div>
        @endif

        <form action="{{ url('/forgot-password') }}" method="POST">
            @csrf
            <div class="mb-6 text-left">
                <label class="block text-gray-700 font-medium mb-2">Alamat Email</label>
                <input type="email" name="email" required autofocus placeholder="contoh@gmail.com" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none">
            </div>
            <button type="submit" class="w-full bg-hijau-utama text-white font-bold py-3 rounded-xl hover:bg-hijau-gelap transition">
                Kirim Kode OTP
            </button>
        </form>
        
        <div class="mt-4">
            <a href="{{ url('/login') }}" class="text-sm text-gray-500 hover:text-hijau-utama font-medium">← Kembali ke Halaman Masuk</a>
        </div>
    </div>
</body>
</html>