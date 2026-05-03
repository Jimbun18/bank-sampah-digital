@extends('layouts.app')
@section('title', 'Master Data')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">🏢 Kelola Master Data</h1>
        <p class="text-gray-500 text-sm">Atur jenis sampah beserta harganya, serta kelola cabang lokasi bank sampah.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm">
            <p class="text-green-700 font-bold">Berhasil!</p>
            <p class="text-green-600 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-6">
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><span>🏷️</span> Tambah Kategori Baru</h3>
                <form action="{{ route('admin.store_kategori') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Nama Jenis Sampah</label>
                        <input type="text" name="nama_sampah" required placeholder="Contoh: Botol Kaca" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Harga per Kg (Rp)</label>
                        <input type="number" name="harga_per_kg" required placeholder="Contoh: 1500" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">
                    </div>
                    <button type="submit" class="w-full bg-hijau-utama text-white font-bold py-2 rounded-lg hover:bg-hijau-gelap transition">Simpan Kategori</button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Nama Sampah</th>
                            <th class="px-4 py-3">Harga/Kg</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($kategoris as $k)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $k->nama_sampah }}</td>
                                <td class="px-4 py-3 text-green-600 font-bold">Rp {{ number_format($k->harga_per_kg, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 flex gap-2">
    <!-- Tombol Edit -->
    <button type="button" onclick="bukaModalEditKategori('{{ $k->id }}', '{{ $k->nama_sampah }}', '{{ $k->harga_per_kg }}')" class="bg-blue-100 text-blue-600 hover:bg-blue-200 px-3 py-1 rounded-md text-xs font-bold transition">
        Edit
    </button>
    
    <!-- Tombol Hapus (Kembali ke Kode Aslimu) -->
    <form action="{{ route('admin.destroy_kategori', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
        @csrf 
        @method('DELETE')
        <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1 rounded-md text-xs font-bold transition">Hapus</button>
    </form>
</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-6">
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><span>🏢</span> Tambah Cabang Bank Sampah</h3>
                <form action="{{ route('admin.store_bank') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Nama Cabang / Unit</label>
                        <input type="text" name="nama_bank" required placeholder="Contoh: Bank Sampah Unit 2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Titik Lokasi Cabang</label>
                        <div id="map-admin" class="w-full rounded-xl border border-gray-200 mb-2 z-10 relative" style="height: 250px;"></div>
                        <p class="text-[10px] text-gray-400 italic">*Klik pada peta untuk memindahkan titik lokasi cabang.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-xs font-medium mb-1">Latitude</label>
                            <input type="text" name="latitude" id="lat-admin" readonly required class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-xs outline-none">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-xs font-medium mb-1">Longitude</label>
                            <input type="text" name="longitude" id="lng-admin" readonly required class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-xs outline-none">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat-admin" rows="2" required placeholder="Jalan, Desa, Kecamatan..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau-utama outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">Simpan Cabang</button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Nama Cabang & Alamat</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($banks as $b)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <span class="font-bold text-gray-800 block">{{ $b->nama_bank }}</span>
                                    <span class="text-xs text-gray-500">{{ $b->alamat }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('admin.destroy_bank', $b->id) }}" method="POST" onsubmit="return confirm('Hapus cabang ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 px-2 py-1 rounded text-xs font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi Peta Admin (Default di Purwokerto)
        var mapAdmin = L.map('map-admin').setView([-7.4245, 109.2302], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(mapAdmin);

        // Marker Cabang Baru
        var markerAdmin = L.marker([-7.4245, 109.2302], {draggable: true}).addTo(mapAdmin);

        function updateAdminCoords(lat, lng) {
            document.getElementById('lat-admin').value = lat;
            document.getElementById('lng-admin').value = lng;

            // Fetch alamat otomatis (Reverse Geocoding)
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if(data.display_name) {
                        document.getElementById('alamat-admin').value = data.display_name;
                    }
                })
                .catch(error => console.log("Gagal ambil alamat"));
        }

        // Saat peta diklik
        mapAdmin.on('click', function(e) {
            markerAdmin.setLatLng(e.latlng);
            updateAdminCoords(e.latlng.lat, e.latlng.lng);
        });

        // Saat marker digeser
        markerAdmin.on('dragend', function(e) {
            var pos = markerAdmin.getLatLng();
            updateAdminCoords(pos.lat, pos.lng);
        });

        // Set koordinat awal
        updateAdminCoords(-7.4245, 109.2302);
    </script>

    <div id="modalEditKategori" class="hidden fixed inset-0 bg-gray-900/70 backdrop-blur-sm z-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-2xl w-full max-w-md shadow-xl transform transition-all">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">✏️ Edit Jenis Sampah</h3>
            <button onclick="tutupModalEditKategori()" class="text-gray-400 hover:text-red-500">✖</button>
        </div>
        
        <form id="formEditKategori" method="POST" action="">
            @csrf
            @method('PUT') 
            
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2">Nama Jenis Sampah</label>
                <input type="text" name="nama_sampah" id="edit_nama_sampah" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm">
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-600 mb-2">Harga per Kg (Rp)</label>
                <input type="number" name="harga_per_kg" id="edit_harga_sampah" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm">
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="tutupModalEditKategori()" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalEditKategori(id, nama, harga) {
        document.getElementById('modalEditKategori').classList.remove('hidden');
        // Isi action URL
        document.getElementById('formEditKategori').action = `/admin/master-data/kategori/${id}`;
        // Isi nilai inputan dengan data yang mau diedit
        document.getElementById('edit_nama_sampah').value = nama;
        document.getElementById('edit_harga_sampah').value = harga;
    }

    function tutupModalEditKategori() {
        document.getElementById('modalEditKategori').classList.add('hidden');
    }
</script>
@endsection