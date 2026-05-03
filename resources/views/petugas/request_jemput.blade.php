@extends('layouts.app')
@section('title', 'Daftar Penjemputan')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">🚛 Request Jemput Masuk</h1>
        <p class="text-gray-500 text-sm">Pantau dan kelola permintaan penjemputan dari nasabah.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
            <p class="text-green-700 font-bold">Berhasil!</p>
            <p class="text-green-600 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-8">
        <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase">📍 Peta Sebaran Tugas (Pending & OTW)</h3>
        <div id="map" class="w-full h-80 rounded-xl border border-gray-200 z-10 relative"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($requests as $req)
            <div class="bg-white rounded-2xl border {{ $req->status == 'menunggu' ? 'border-yellow-200' : ($req->status == 'dijadwalkan' ? 'border-blue-200' : 'border-gray-200') }} shadow-sm overflow-hidden flex flex-col">
                
                <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center {{ $req->status == 'menunggu' ? 'bg-yellow-50' : ($req->status == 'dijadwalkan' ? 'bg-blue-50' : 'bg-gray-50') }}">
                    <span class="font-bold text-gray-800">{{ $req->user->name }}</span>
                    @if($req->status == 'menunggu')
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded font-bold">Baru / Menunggu</span>
                    @elseif($req->status == 'dijadwalkan')
                        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded font-bold">OTW / Dijadwalkan</span>
                    @else
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded font-bold">Selesai</span>
                    @endif
                </div>

                <div class="p-5 flex-grow">
                    <div class="flex items-center gap-2 mb-3 text-sm text-gray-600">
                        <span class="text-lg">📅</span>
                        <span>{{ \Carbon\Carbon::parse($req->tanggal_jemput)->format('d M Y') }} - <strong>{{ \Carbon\Carbon::parse($req->jam_jemput)->format('H:i') }}</strong></span>
                    </div>
                    <div class="flex items-start gap-2 mb-3 text-sm text-gray-600">
                        <span class="text-lg">🏠</span>
                        <span>{{ $req->alamat_lengkap }}</span>
                    </div>
                    @if($req->catatan)
                        <div class="bg-gray-50 p-3 rounded-lg text-sm text-gray-500 italic mb-3">
                            "{{ $req->catatan }}"
                        </div>
                    @endif
                </div>

                <div class="p-4 border-t border-gray-100 bg-gray-50 flex gap-2">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $req->latitude }},{{ $req->longitude }}" target="_blank" class="flex-1 bg-white border border-gray-300 text-gray-700 font-bold py-2 rounded-lg text-center text-sm hover:bg-gray-100 transition shadow-sm">
                        🗺️ Rute GPS
                    </a>

                    @if($req->status == 'menunggu')
                        <form action="{{ route('petugas.proses_request_jemput', $req->id) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="status" value="dijadwalkan">
                            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded-lg text-sm hover:bg-blue-600 transition shadow-sm">
                                Terima Tugas
                            </button>
                        </form>
                    @elseif($req->status == 'dijadwalkan')
                        <form action="{{ route('petugas.proses_request_jemput', $req->id) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="w-full bg-hijau-utama text-white font-bold py-2 rounded-lg text-sm hover:bg-hijau-gelap transition shadow-sm">
                                Tandai Selesai
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-8 rounded-2xl border border-gray-200 text-center text-gray-500">
                <div class="text-4xl mb-3">🎉</div>
                <p>Tidak ada tugas penjemputan saat ini. Anda bisa bersantai sejenak!</p>
            </div>
        @endforelse
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Siapkan data dari PHP ke JavaScript (Hanya ambil yang belum selesai)
        var locations = [
            @foreach($requests->whereIn('status', ['menunggu', 'dijadwalkan']) as $req)
            {
                lat: {{ $req->latitude }},
                lng: {{ $req->longitude }},
                nama: "{{ $req->user->name }}",
                status: "{{ $req->status }}"
            },
            @endforeach
        ];

        // Inisialisasi Peta
        var map = L.map('map').setView([-7.4245, 109.2302], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan marker jika ada lokasi
        if(locations.length > 0) {
            var bounds = [];
            locations.forEach(function(loc) {
                // Pin warna berbeda: Kuning untuk menunggu, Biru untuk OTW
                var pinColor = loc.status === 'menunggu' ? 'yellow' : 'blue';
                
                var marker = L.marker([loc.lat, loc.lng]).addTo(map)
                    .bindPopup(`<b>${loc.nama}</b><br>Status: ${loc.status.toUpperCase()}`);
                
                bounds.push([loc.lat, loc.lng]);
            });
            // Sesuaikan zoom agar semua pin terlihat
            map.fitBounds(bounds, {padding: [50, 50]});
        }
    </script>
@endsection