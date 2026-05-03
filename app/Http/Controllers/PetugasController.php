<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\JenisSampah;
use App\Models\MutasiSaldo;
use App\Models\Transaksi; // <-- TAMBAHAN: Memanggil model Transaksi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHAN: Untuk mengecek ID Petugas
use Illuminate\Support\Facades\Mail;
use App\Mail\SetorSuccessMail;

class PetugasController extends Controller
{
    // Halaman Dashboard Petugas
    public function dashboard()
    {
        $jenis_sampahs = JenisSampah::all();

        // Siapkan Data untuk Diagram (7 Hari Terakhir)
        $chart_dates = [];
        $chart_weights = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chart_dates[] = $date->format('d M'); // Format: 01 May
            
            // Hitung total berat sampah per hari
            $weight = Transaksi::whereDate('created_at', $date)->sum('berat');
            $chart_weights[] = $weight;
        }

        return view('petugas.dashboard', compact('jenis_sampahs', 'chart_dates', 'chart_weights'));
    }

    // Halaman Form Setor (Kasir)
    public function setor()
    {
        // Ambil semua data user yang rolenya 'nasabah'
        $nasabahs = User::where('role', 'nasabah')->get();
        // Ambil semua master data jenis sampah
        $jenis_sampahs = JenisSampah::all();
        
        return view('petugas.setor', compact('nasabahs', 'jenis_sampahs'));
    }

    // Proses Simpan Setoran
    public function simpanSetor(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat' => 'required|numeric|min:0.1'
        ]);

        $jenis = JenisSampah::find($request->jenis_sampah_id);
        $total_harga = $jenis->harga_per_kg * $request->berat;

        // Cari saldo terakhir nasabah ini (jika belum ada, maka 0)
        $saldo_terakhir = MutasiSaldo::where('user_id', $request->user_id)
                                     ->orderBy('id', 'desc')
                                     ->value('saldo_akhir') ?? 0;
        
        $saldo_baru = $saldo_terakhir + $total_harga;

        // --- TAMBAHAN KODE: Simpan ke tabel Transaksi (untuk rekap berat/Kg) ---
        Transaksi::create([
            'user_id' => $request->user_id,
            'petugas_id' => Auth::id(), // Mencatat siapa petugas yang melayani
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat' => $request->berat,
            'total_harga' => $total_harga
        ]);
        // -----------------------------------------------------------------------

        // Simpan ke mutasi (otomatis jadi riwayat dan update saldo)
        MutasiSaldo::create([
            'user_id' => $request->user_id,
            'tipe' => 'kredit', // Kredit = Saldo masuk
            'nominal' => $total_harga,
            'keterangan' => 'Setor ' . $jenis->nama_sampah . ' (' . $request->berat . ' Kg)',
            'saldo_akhir' => $saldo_baru
        ]);

        $nasabah = User::find($request->user_id);

        // 2. Siapkan data yang mau dikirim ke email
        $data_email = [
            'nama_nasabah' => $nasabah->name,
            'jenis_sampah' => $jenis->nama_sampah,
            'berat' => $request->berat,
            'nominal' => $total_harga,
            'saldo_akhir' => $saldo_baru
        ];

        // 3. Terbangkan emailnya!
        Mail::to($nasabah->email)->send(new SetorSuccessMail($data_email));
        // --------------------------------------------------------

        return back()->with('success', 'Setoran berhasil! Saldo Nasabah bertambah Rp ' . number_format($total_harga, 0, ',', '.'));
    }

    public function requestJemput()
    {
        // Ambil ID cabang tempat petugas ini bekerja
        $cabang_petugas = Auth::user()->bank_sampah_id;

        $requests = \App\Models\RequestJemput::with('user')
            // HANYA tampilkan request yang diarahkan ke cabang tempat petugas ini dinas!
            ->where('bank_sampah_id', $cabang_petugas) 
            ->orderByRaw("FIELD(status, 'menunggu', 'dijadwalkan', 'selesai')")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('petugas.request_jemput', compact('requests'));
    }

    // Proses Update Status Jemput
    public function prosesRequestJemput(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:dijadwalkan,selesai'
        ]);

        $jemput = \App\Models\RequestJemput::findOrFail($id);
        $jemput->update(['status' => $request->status]);

        $pesan = $request->status == 'dijadwalkan' 
            ? 'Request berhasil diterima! Silakan jemput ke lokasi sesuai jadwal.' 
            : 'Penjemputan selesai! Jangan lupa arahkan nasabah ke menu Setor untuk menimbang sampahnya.';

        return back()->with('success', $pesan);
    }

    public function riwayatSetoran(Request $request)
    {
        $jenis_sampahs = JenisSampah::all();
        $query = Transaksi::with(['user', 'jenisSampah']);

        // Fitur Filter
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('jenis_sampah_id')) {
            $query->where('jenis_sampah_id', $request->jenis_sampah_id);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $transaksis = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('petugas.riwayat_setoran', compact('transaksis', 'jenis_sampahs'));
    }

    // 3. TAMBAH FUNGSI EXPORT CSV
    public function exportRiwayat(Request $request)
    {
        $fileName = 'riwayat-setoran-petugas-' . date('Y-m-d') . '.csv';
        $query = Transaksi::with(['user', 'jenisSampah']);

        // Terapkan filter yang sama persis
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) { $q->where('name', 'like', '%' . $request->search . '%'); });
        }
        if ($request->filled('jenis_sampah_id')) {
            $query->where('jenis_sampah_id', $request->jenis_sampah_id);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Waktu Setor', 'Nama Nasabah', 'Jenis Sampah', 'Berat (Kg)', 'Total Harga (Rp)'];

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($tasks as $task) {
                fputcsv($file, [
                    $task->created_at->format('Y-m-d H:i'),
                    $task->user->name ?? 'Anonim',
                    $task->jenisSampah->nama_sampah ?? '-',
                    $task->berat,
                    $task->total_harga
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}