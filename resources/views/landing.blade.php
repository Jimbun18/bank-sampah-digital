<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah Digital</title>
    
    <!-- Memanggil Tailwind CSS (Sesuaikan jika kamu menggunakan Vite/Mix) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Konfigurasi Warna Khusus Tailwind (Bisa dihapus jika sudah di-setting di tailwind.config.js) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'hijau-utama': '#16a34a',
                        'hijau-gelap': '#15803d',
                    }
                }
            }
        }
    </script>

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts: Plus Jakarta Sans (Agar modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Efek bayangan halus bergaya modern */
        .shadow-soft { box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 overflow-x-hidden selection:bg-hijau-utama selection:text-white">

    <!-- NAVBAR -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100" data-aos="fade-down" data-aos-duration="800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 text-hijau-utama rounded-xl flex items-center justify-center text-2xl shadow-sm">
                        ♻️
                    </div>
                    <span class="font-extrabold text-xl tracking-tight text-gray-900">Bank Sampah</span>
                </div>
                <div class="flex items-center gap-6">
                    <a href="/login" class="font-bold text-gray-600 hover:text-hijau-utama transition">Masuk</a>
                    <a href="/register" class="bg-hijau-utama hover:bg-hijau-gelap text-white px-6 py-2.5 rounded-full font-bold shadow-lg shadow-green-500/30 transition hover:-translate-y-0.5">
                        📝 Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-green-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-40 -left-40 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in" data-aos-duration="1000">
            <span class="bg-green-100 text-hijau-utama px-4 py-1.5 rounded-full text-sm font-bold tracking-wide uppercase mb-6 inline-block">Ubah Sampah Jadi Berkah</span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 mb-6 leading-tight tracking-tight">
                Mulai Menabung Sampah <br class="hidden md:block"/> <span class="text-transparent bg-clip-text bg-gradient-to-r from-hijau-utama to-emerald-400">Selamatkan Bumi Kita</span>
            </h1>
            <p class="text-lg text-gray-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform digital yang memudahkanmu mengelola, menyetor, dan mencairkan tabungan sampah langsung dari genggaman. Lingkungan bersih, dompet pun terisi.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/register" class="bg-gray-900 hover:bg-gray-800 text-white px-8 py-4 rounded-full font-bold shadow-xl transition hover:-translate-y-1 flex items-center justify-center gap-2">
                    Mulai Sekarang &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- FITUR UTAMA -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Fitur 1 -->
                <div class="bg-white p-10 rounded-[2rem] shadow-soft border border-gray-50 hover:-translate-y-2 transition duration-300 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">⚖️</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Setor & Timbang Transparan</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">Bawa sampahmu ke cabang terdekat. Harga disesuaikan dengan nilai pasar dan saldo langsung masuk ke akunmu saat itu juga tanpa potongan.</p>
                </div>
                
                <!-- Fitur 2 -->
                <div class="bg-white p-10 rounded-[2rem] shadow-soft border border-gray-50 hover:-translate-y-2 transition duration-300 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">🚛</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Request Jemput ke Rumah</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">Malas keluar rumah? Cukup tandai lokasimu di peta pintar kami, dan armada penjemputan terdekat akan datang sesuai jadwal yang kamu tentukan.</p>
                </div>

                <!-- Fitur 3 -->
                <div class="bg-white p-10 rounded-[2rem] shadow-soft border border-gray-50 hover:-translate-y-2 transition duration-300 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">💸</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Cairkan Kapan Saja</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">Tarik saldomu menjadi uang tunai langsung ke rekening bank pribadimu, atau tukarkan dengan paket sembako pilihan untuk kebutuhan harian.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- SECTION HARGA SAMPAH HARI INI -->
    <section class="py-20 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <span class="bg-emerald-100 text-hijau-utama px-4 py-1.5 rounded-full text-sm font-bold tracking-wide uppercase mb-4 inline-block">Transparan & Terpercaya</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Update Harga Sampah Hari Ini 📈</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Harga selalu diperbarui mengikuti nilai pasar. Kumpulkan sampahmu, bawa ke cabang, dan jadikan cuan!</p>
            </div>

            <!-- Grid Harga (Otomatis menyesuaikan jumlah data dari database) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($jenis_sampahs as $sampah)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 hover:-translate-y-2 transition duration-300" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-12 h-12 bg-green-50 text-hijau-utama rounded-xl flex items-center justify-center text-2xl mb-4">
                        ♻️
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 uppercase">{{ $sampah->nama_sampah }}</h3>
                    <div class="mt-2 flex items-baseline gap-1">
                        <span class="text-2xl font-black text-hijau-utama">Rp {{ number_format($sampah->harga_per_kg, 0, ',', '.') }}</span>
                        <span class="text-sm text-gray-400 font-medium">/ kg</span>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center p-8 bg-white rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada informasi harga sampah saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- KENAPA HARUS PILIH KAMI (SECTION BARU) -->
    <section class="py-24 bg-slate-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Kenapa Memilih Kami?</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Kami hadir untuk memberikan solusi pengelolaan sampah yang terpercaya, mudah, dan menguntungkan bagi semua pihak.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Sisi Gambar/Ilustrasi -->
                <div class="relative" data-aos="fade-right">
                    <div class="absolute inset-0 bg-gradient-to-tr from-green-200 to-emerald-100 rounded-[3rem] transform rotate-3 scale-105 -z-10"></div>
                    <div class="bg-white p-8 rounded-[3rem] shadow-soft border border-gray-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-green-50 h-40 rounded-2xl flex flex-col justify-center items-center text-center p-4">
                                <span class="text-4xl font-black text-hijau-utama mb-2">100+</span>
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Nasabah Aktif</span>
                            </div>
                            <div class="bg-blue-50 h-40 rounded-2xl flex flex-col justify-center items-center text-center p-4 mt-8">
                                <span class="text-4xl font-black text-blue-500 mb-2">50T</span>
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Sampah Terdanaui</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sisi Poin-poin -->
                <div class="space-y-8" data-aos="fade-left">
                    <div class="flex gap-5">
                        <div class="flex-shrink-0 w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-xl border border-gray-100">🎯</div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Sistem Terintegrasi & Akurat</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Catatan riwayat setor, penarikan, hingga perhitungan jarak lokasi penjemputan dilakukan secara presisi oleh sistem pintar kami.</p>
                        </div>
                    </div>
                    <div class="flex gap-5">
                        <div class="flex-shrink-0 w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-xl border border-gray-100">🔒</div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Keamanan Data & Saldo</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Kami menerapkan notifikasi email di setiap transaksi pencairan dana untuk memastikan saldo Anda tetap aman dan terlindungi.</p>
                        </div>
                    </div>
                    <div class="flex gap-5">
                        <div class="flex-shrink-0 w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-xl border border-gray-100">🌱</div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Dampak Nyata Lingkungan</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Setiap kilogram sampah yang Anda setorkan berkontribusi langsung dalam mengurangi timbunan sampah di wilayah Purwokerto dan sekitarnya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white pt-20 pb-10 border-t-4 border-hijau-utama">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in" data-aos-offset="0">
            <div class="flex items-center justify-center gap-3 mb-6">
                <div class="text-3xl text-emerald-400">♻️</div>
                <span class="font-extrabold text-2xl tracking-tight text-white">Bank Sampah Digital</span>
            </div>
            
            <p class="text-gray-400 mb-10 max-w-xl mx-auto text-sm">
                Dibangun untuk bumi yang lebih baik dan masyarakat yang lebih sejahtera secara finansial melalui inovasi teknologi pengelolaan sampah.
            </p>

            <div class="border-t border-gray-800 pt-8 mt-10 flex flex-col items-center justify-center gap-6">
                <!-- NAMA TIM PENGEMBANG -->
                <div class="text-center">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Developed By Team:</p>
                    <div class="flex flex-wrap justify-center gap-x-4 gap-y-2 text-sm text-gray-300 font-medium">
                        <!-- Ganti "username_ig" dengan username asli masing-masing -->
                        <a href="https://www.instagram.com/fatahul_qorib?igsh=bXFwMGh4NjR2enUx" target="_blank" class="hover:text-emerald-400 hover:underline transition">Fatahul Qorib</a> 
                        <span class="text-gray-700">&bull;</span> 
                        
                        <a href="https://www.instagram.com/annizar12/" target="_blank" class="hover:text-emerald-400 hover:underline transition">An Nizar Miftahul Hakin</a> 
                        <span class="text-gray-700">&bull;</span> 
                        
                        <a href="https://www.instagram.com/mdc_165?igsh=MXQ5NGJ6bWYxcjg1aQ==" target="_blank" class="hover:text-emerald-400 hover:underline transition">Meiliana Dwi Conita</a> 
                        <span class="text-gray-700">&bull;</span> 
                        
                        <a href="https://www.instagram.com/grreylnk?igsh=eHQwcTN1czJhZ250" target="_blank" class="hover:text-emerald-400 hover:underline transition">Qurotul 'Aeni Nur Azmi</a>
                    </div>
                </div>

                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Bank Sampah Digital Purwokerto. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    <!-- AOS JS LIBRARY -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi Animasi On Scroll
        AOS.init({
            duration: 800,        // Durasi animasi (millisecond)
            offset: 100,          // Jarak trigger animasi dari bawah layar
            once: false,          // FALSE = Animasi akan terus diulang saat di-scroll naik/turun
            mirror: true,         // TRUE = Elemen akan menganimasi "keluar" saat di-scroll melebihi posisinya
            easing: 'ease-out-cubic' // Gaya gerakan animasi agar mulus
        });
    </script>
</body>
</html>