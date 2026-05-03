<?php

namespace App\Http\Controllers;

use App\Models\MutasiSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // <-- TAMBAHAN IMPORT UNTUK EMAIL
use App\Mail\RequestJemputMail; // <-- TAMBAHAN IMPORT KURIR JEMPUT
use App\Mail\PenarikanRequestMail; // <-- TAMBAHAN IMPORT KURIR PENARIKAN

class NasabahController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::id();

        // 1. Ambil saldo terakhir
        $saldo_terakhir = \App\Models\MutasiSaldo::where('user_id', $user_id)->orderBy('id', 'desc')->value('saldo_akhir') ?? 0;
        
        // 2. Hitung total berapa kali transaksi
        $total_transaksi = \App\Models\MutasiSaldo::where('user_id', $user_id)->count(); 
        
        // 3. Hitung total kilogram sampah yang disetor
        $total_sampah = \App\Models\Transaksi::where('user_id', $user_id)->sum('berat');

        // 4. Ambil 5 riwayat transaksi terakhir
        $riwayat_transaksi = \App\Models\MutasiSaldo::where('user_id', $user_id)->orderBy('id', 'desc')->take(5)->get();

        $jenis_sampahs = \App\Models\JenisSampah::all();

        // Tambahkan 'jenis_sampahs' ke dalam compact()
        return view('nasabah.dashboard', compact('saldo_terakhir', 'total_transaksi', 'total_sampah', 'riwayat_transaksi', 'jenis_sampahs'));
    }

    // Halaman Form Penarikan
    public function penarikan()
    {
        $user_id = Auth::id();
        
        // 1. Ambil saldo total asli
        $saldo_terakhir = MutasiSaldo::where('user_id', $user_id)->orderBy('id', 'desc')->value('saldo_akhir') ?? 0;

        // 2. Hitung berapa nominal penarikan yang masih PENDING (belum disetujui)
        $saldo_pending = \App\Models\Penarikan::where('user_id', $user_id)->where('status', 'pending')->sum('nominal');

        // 3. Saldo yang benar-benar bisa ditarik
        $saldo_tersedia = $saldo_terakhir - $saldo_pending;

        $riwayat_penarikan = \App\Models\Penarikan::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        
        return view('nasabah.penarikan', compact('saldo_tersedia', 'saldo_pending', 'riwayat_penarikan'));
    }

    // Proses Simpan Pengajuan
    public function simpanPenarikan(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:10000',
            'metode' => 'required|in:transfer,sembako',
        ]);

        $user_id = Auth::id();
        $saldo_terakhir = MutasiSaldo::where('user_id', $user_id)->orderBy('id', 'desc')->value('saldo_akhir') ?? 0;
        $saldo_pending = \App\Models\Penarikan::where('user_id', $user_id)->where('status', 'pending')->sum('nominal');
        $saldo_tersedia = $saldo_terakhir - $saldo_pending;

        // Validasi: Cek terhadap Saldo Tersedia, bukan Saldo Total
        if ($request->nominal > $saldo_tersedia) {
            return back()->withErrors(['nominal' => 'Saldo tersedia Anda (setelah dikurangi penarikan pending) tidak mencukupi.'])->withInput();
        }

        $detail_tujuan = '';
        if ($request->metode === 'transfer') {
            $request->validate(['nama_bank' => 'required', 'no_rekening' => 'required', 'atas_nama' => 'required']);
            $detail_tujuan = "Transfer ke: " . $request->nama_bank . " - " . $request->no_rekening . " (a.n " . $request->atas_nama . ")";
        } else {
            $request->validate(['paket_sembako' => 'required']);
            $detail_tujuan = "Tukar Sembako: " . $request->paket_sembako;
        }

        \App\Models\Penarikan::create([
            'user_id' => $user_id,
            'nominal' => $request->nominal, 
            'metode' => $request->metode,
            'detail_tujuan' => $detail_tujuan,
            'status' => 'pending'
        ]);

        // --- TAMBAHAN KODE: TRIGGER EMAIL PENARIKAN DIPROSES ---
        Mail::to(Auth::user()->email)->send(new PenarikanRequestMail([
            'nama' => Auth::user()->name,
            'nominal' => $request->nominal
        ]));
        // -------------------------------------------------------

        return back()->with('success', 'Pengajuan penarikan berhasil dibuat. Saldo tersedia Anda telah disesuaikan.');
    }

    // Halaman Request Jemput (Maps)
    public function requestJemput()
    {
        $riwayat_jemput = \App\Models\RequestJemput::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')->get();
        
        return view('nasabah.request_jemput', compact('riwayat_jemput'));
    }

    // Proses Simpan Request Jemput (DENGAN AUTO-DETEKSI TERDEKAT)
    public function simpanRequestJemput(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'alamat_lengkap' => 'required',
            'tanggal_jemput' => 'required|date|after_or_equal:today',
            'jam_jemput' => 'required',
        ]);

        $latNasabah = $request->latitude;
        $lngNasabah = $request->longitude;

        // =========================================================================
        // ALGORITMA HAVERSINE: Hitung Jarak (KM) & Cari Bank Sampah Terdekat
        // =========================================================================
        $bank_terdekat = \App\Models\BankSampah::selectRaw(
            "id, nama_bank, ( 6371 * acos( cos( radians(?) ) *
            cos( radians( latitude ) ) *
            cos( radians( longitude ) - radians(?) ) +
            sin( radians(?) ) *
            sin( radians( latitude ) ) ) ) AS jarak_km", 
            [$latNasabah, $lngNasabah, $latNasabah]
        )
        ->orderBy('jarak_km', 'ASC') // Urutkan dari yang jaraknya paling kecil (terdekat)
        ->first(); // Ambil 1 data teratas

        // Jika kebetulan database Bank Sampah kosong sama sekali
        if (!$bank_terdekat) {
            return back()->withErrors(['msg' => 'Maaf, saat ini belum ada titik cabang Bank Sampah yang terdaftar di sistem.']);
        }

        // Simpan Request ke database, arahkan ke Bank Sampah terdekat yang ditemukan!
        \App\Models\RequestJemput::create([
            'user_id' => Auth::id(),
            'bank_sampah_id' => $bank_terdekat->id, // Otomatis terisi ID Bank Terdekat!
            'latitude' => $latNasabah,
            'longitude' => $lngNasabah,
            'alamat_lengkap' => $request->alamat_lengkap,
            'tanggal_jemput' => $request->tanggal_jemput,
            'jam_jemput' => $request->jam_jemput,
            'catatan' => $request->catatan,
            'status' => 'menunggu'
        ]);

        // --- TRIGGER EMAIL REQUEST JEMPUT ---
        Mail::to(Auth::user()->email)->send(new RequestJemputMail([
            'nama' => Auth::user()->name
        ]));
        // ------------------------------------

        // Beri tahu nasabah cabang mana yang akan menjemput
        return back()->with('success', 'Request penjemputan berhasil! Petugas dari cabang "' . $bank_terdekat->nama_bank . '" akan segera menjadwalkan.');
    }

    // Halaman Saldo & Mutasi
    public function mutasi(Request $request)
    {
        $user_id = Auth::id();

        // Ambil saldo terakhir
        $saldo_terakhir = MutasiSaldo::where('user_id', $user_id)
                                     ->orderBy('id', 'desc')
                                     ->value('saldo_akhir') ?? 0;

        // Query Builder untuk Mutasi dengan Filter
        $query = MutasiSaldo::where('user_id', $user_id);

        if ($request->has('tipe') && $request->tipe != '') {
            $query->where('tipe', $request->tipe);
        }

        $mutasis = $query->orderBy('created_at', 'desc')->get();

        // Hitung statistik singkat
        $total_masuk = MutasiSaldo::where('user_id', $user_id)->where('tipe', 'kredit')->sum('nominal');
        $total_keluar = MutasiSaldo::where('user_id', $user_id)->where('tipe', 'debit')->sum('nominal');

        return view('nasabah.mutasi', compact('mutasis', 'saldo_terakhir', 'total_masuk', 'total_keluar'));
    }

    // Halaman Semua Riwayat Transaksi
    public function riwayat()
    {
        $riwayat_transaksi = \App\Models\MutasiSaldo::where('user_id', Auth::id())
                                ->orderBy('id', 'desc')
                                ->paginate(10); // Menampilkan 10 data per halaman

        return view('nasabah.riwayat', compact('riwayat_transaksi'));
    }
}