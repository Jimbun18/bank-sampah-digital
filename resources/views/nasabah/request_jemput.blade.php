@extends('layouts.app')
@section('title', 'Request Jemput Sampah')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div>
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">🚛 Request Jemput</h1>
                <p class="text-gray-500 text-sm">Tentukan titik lokasi Anda. Petugas kami akan datang mengambil sampah.</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                    <p class="text-green-700 font-bold">Berhasil!</p>
                    <p class="text-green-600 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('nasabah.simpan_request_jemput') }}" method="POST">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 font-medium mb-2">Titik Lokasi Jemput <span class="text-red-500">*</span></label>
                        <div class="bg-blue-50 text-blue-700 text-xs p-2 rounded mb-2 flex items-center gap-2">
                            <span>💡</span> Geser PIN merah di peta ke lokasi rumah Anda, alamat akan otomatis terisi.
                        </div>
                        <div id="map" class="w-full h-64 rounded-xl border-2 border-gray-200 mb-2 z-10 relative"></div>
                        
                        <div class="flex gap-2">
                            <button type="button" onclick="gunakanLokasiSaya()" class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition flex items-center gap-1">
                                📍 Gunakan GPS HP Saya
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Detail Alamat</label>
                        <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" required placeholder="Contoh: Jl. Pahlawan No 10, RT 01/RW 02. Pagar warna hitam." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none bg-gray-50"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal</label>
                            <input type="date" name="tanggal_jemput" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Jam</label>
                            <input type="time" name="jam_jemput" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none bg-gray-50">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Catatan Tambahan (Opsional)</label>
                        <input type="text" name="catatan" placeholder="Contoh: Sampah kardus lumayan banyak" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-hijau-utama outline-none bg-gray-50">
                    </div>

                    <button type="submit" class="w-full bg-hijau-utama text-white font-bold py-3 rounded-xl hover:bg-hijau-gelap transition shadow-md">
                        Kirim Request Jemput
                    </button>
                </form>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-gray-800 text-lg mb-4 mt-2">Riwayat Penjemputan</h3>
            <div class="space-y-4">
                @forelse($riwayat_jemput as $rj)
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-2 
                            {{ $rj->status == 'menunggu' ? 'bg-yellow-400' : ($rj->status == 'dijadwalkan' ? 'bg-blue-500' : 'bg-green-500') }}">
                        </div>
                        
                        <div class="pl-4 flex justify-between items-start mb-3">
                            <div>
                                <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($rj->tanggal_jemput)->format('d M Y') }}</p>
                                <p class="text-sm text-gray-500 font-medium">Pukul {{ \Carbon\Carbon::parse($rj->jam_jemput)->format('H:i') }}</p>
                            </div>
                            @if($rj->status == 'menunggu')
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-medium">Menunggu Petugas</span>
                            @elseif($rj->status == 'dijadwalkan')
                                <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-medium">Dijadwalkan (OTW)</span>
                            @else
                                <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">Selesai</span>
                            @endif
                        </div>
                        <p class="pl-4 text-sm text-gray-600 mb-1">📍 {{ Str::limit($rj->alamat_lengkap, 60) }}</p>
                        @if($rj->catatan)
                            <p class="pl-4 text-xs text-gray-400 italic">"{{ $rj->catatan }}"</p>
                        @endif
                    </div>
                @empty
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 text-center text-gray-500 flex flex-col items-center">
                        <div class="text-4xl mb-2">📭</div>
                        <p>Belum ada request penjemputan.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // 1. Inisialisasi Peta (Default di Purwokerto)
        var map = L.map('map').setView([-7.4245, 109.2302], 13);

        // 2. Tambahkan Tile/Tampilan Peta dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // 3. Buat Marker (Bisa Digeser)
        var marker = L.marker([-7.4245, 109.2302], {draggable: true}).addTo(map);

        // 4. Update Form saat Peta diklik
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateFormLokasi(e.latlng.lat, e.latlng.lng);
        });

        // 5. Update Form saat Marker selesai digeser
        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            updateFormLokasi(position.lat, position.lng);
        });

        // Fungsi Auto-Fill Alamat Menggunakan API Nominatim
        function updateFormLokasi(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Fetch alamat otomatis
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if(data.display_name) {
                        document.getElementById('alamat_lengkap').value = data.display_name;
                    }
                })
                .catch(error => console.log("Gagal mengambil alamat"));
        }

        // Fitur GPS HP
        function gunakanLokasiSaya() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    
                    // Pindah peta dan marker ke lokasi HP
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    updateFormLokasi(lat, lng);
                }, function(error) {
                    alert("Gagal mendapatkan lokasi. Pastikan GPS aktif dan diizinkan oleh browser.");
                });
            } else {
                alert("Browser Anda tidak mendukung fitur GPS.");
            }
        }
        
        // Inisialisasi posisi awal ke form
        updateFormLokasi(-7.4245, 109.2302);
    </script>
@endsection