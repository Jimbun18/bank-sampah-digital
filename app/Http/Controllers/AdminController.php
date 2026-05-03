<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penarikan;
use App\Models\MutasiSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // <-- TAMBAHAN: Import library Mail
use App\Mail\PenarikanSuccessMail; // <-- TAMBAHAN: Import kurir email
use App\Models\Transaksi;
use App\Models\JenisSampah;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Halaman Dashboard Admin
    public function dashboard(Request $request)
    {
        // =========================================================
        // 1. KEMBALIKAN VARIABEL RINGKASAN LAMA (JANGAN DIHAPUS)
        // =========================================================
        $total_nasabah = \App\Models\User::where('role', 'nasabah')->count();
        // Jika sebelumnya ada variabel lain seperti total petugas atau total transaksi, 
        // kamu bisa menambahkannya kembali di bawah baris ini.
        // Contoh: $total_petugas = \App\Models\User::where('role', 'petugas')->count();
        $total_penarikan_pending = \App\Models\Penarikan::where('status', 'pending')->count();


        // =========================================================
        // 2. LOGIKA UNTUK GRAFIK (CHART) BARU
        // =========================================================
        $filter = $request->query('filter', 'minggu');

        $chart_labels = [];
        $chart_sampah = [];
        $chart_penarikan = [];

        if ($filter == 'tahun') {
            for ($i = 1; $i <= 12; $i++) {
                $date = \Carbon\Carbon::create()->month($i);
                $chart_labels[] = $date->translatedFormat('F'); 
                $chart_sampah[] = \App\Models\Transaksi::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->sum('berat');
                $chart_penarikan[] = \App\Models\Penarikan::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->where('status', 'Disetujui')->sum('nominal');
            }
        } elseif ($filter == 'bulan') {
            for ($i = 29; $i >= 0; $i--) {
                $date = \Carbon\Carbon::today()->subDays($i);
                $chart_labels[] = $date->format('d M');
                $chart_sampah[] = \App\Models\Transaksi::whereDate('created_at', $date)->sum('berat');
                $chart_penarikan[] = \App\Models\Penarikan::whereDate('created_at', $date)->where('status', 'Disetujui')->sum('nominal');
            }
        } else { 
            for ($i = 6; $i >= 0; $i--) {
                $date = \Carbon\Carbon::today()->subDays($i);
                $chart_labels[] = $date->format('d M');
                $chart_sampah[] = \App\Models\Transaksi::whereDate('created_at', $date)->sum('berat');
                $chart_penarikan[] = \App\Models\Penarikan::whereDate('created_at', $date)->where('status', 'Disetujui')->sum('nominal');
            }
        }

        // 3. Data Chart Proporsi Sampah (Berdasarkan Total Berat)
        $jenis_sampahs = \App\Models\JenisSampah::all();
        $label_jenis = [];
        $data_berat_jenis = [];

        foreach ($jenis_sampahs as $js) {
            $label_jenis[] = $js->nama_sampah;
            // Hitung total berat yang masuk untuk masing-masing jenis
            $data_berat_jenis[] = \App\Models\Transaksi::where('jenis_sampah_id', $js->id)->sum('berat');
        }

        // =========================================================
        // PASTIKAN COMPACT()-NYA JUGA DIUBAH MENJADI:
        // =========================================================
        return view('admin.dashboard', compact(
            'total_nasabah', 'total_penarikan_pending',
            'filter', 'chart_labels', 'chart_sampah', 'chart_penarikan', 
            'label_jenis', 'data_berat_jenis' // <--- Pakai variabel yang baru
        ));
    }

    // Halaman Kelola Penarikan
    public function penarikan(Request $request)
    {
        // Penulisan Query Filter yang lebih rapi dan canggih ala Laravel
        $penarikans = Penarikan::with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                // Filter jika kolom pencarian diisi
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                // Filter jika dropdown status dipilih
                $query->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.penarikan', compact('penarikans'));
    }

    public function exportPenarikan()
    {
        $fileName = 'laporan-penarikan-' . date('Y-m-d') . '.csv';
        $tasks = Penarikan::with('user')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Tanggal', 'Nama Nasabah', 'Nominal', 'Metode', 'Detail', 'Status');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                fputcsv($file, array(
                    $task->created_at,
                    $task->user->name,
                    $task->nominal,
                    $task->metode,
                    $task->detail_tujuan,
                    $task->status
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Proses Approve / Reject
    public function prosesPenarikan(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak'
        ]);

        $penarikan = Penarikan::findOrFail($id);
        
        // Cegah proses ganda jika status sudah bukan pending
        if ($penarikan->status !== 'pending') {
            return back()->withErrors(['msg' => 'Penarikan ini sudah diproses sebelumnya.']);
        }

        // Update status di tabel penarikan
        $penarikan->update(['status' => $request->status]);

        // LOGIKA KEUANGAN: Jika disetujui, baru kita potong saldo asli di Mutasi
        if ($request->status === 'disetujui') {
            $saldo_terakhir = MutasiSaldo::where('user_id', $penarikan->user_id)
                                         ->orderBy('id', 'desc')
                                         ->value('saldo_akhir') ?? 0;
            
            MutasiSaldo::create([
                'user_id' => $penarikan->user_id,
                'tipe' => 'debit', // Debit = Uang Keluar / Potong Saldo
                'nominal' => $penarikan->nominal,
                'keterangan' => 'Pencairan Saldo (' . ucfirst($penarikan->metode) . ') - Disetujui',
                'saldo_akhir' => $saldo_terakhir - $penarikan->nominal
            ]);

            // --- TAMBAHAN KODE: TRIGGER EMAIL BUKTI TRANSFER ---
            $nasabah = User::find($penarikan->user_id);

            Mail::to($nasabah->email)->send(new PenarikanSuccessMail([
                'nama' => $nasabah->name,
                'id_penarikan' => $penarikan->id,
                // Mengakali struktur agar tetap pas di tabel email:
                'bank' => strtoupper($penarikan->metode), // Menulis 'TRANSFER' atau 'SEMBAKO'
                'no_rekening' => $penarikan->detail_tujuan, // Menuliskan isi detailnya lengkap
                'nominal' => $penarikan->nominal
            ]));
            // ---------------------------------------------------
        }

        return back()->with('success', 'Pengajuan penarikan berhasil di' . $request->status . '!');
    }

    // ==========================================
    // KELOLA MASTER DATA (BANK & KATEGORI)
    // ==========================================
    public function masterData()
    {
        $banks = \App\Models\BankSampah::all();
        $kategoris = \App\Models\JenisSampah::all();
        return view('admin.master_data', compact('banks', 'kategoris'));
    }

    // CRUD Kategori Sampah
    public function storeKategori(Request $request)
    {
        $request->validate(['nama_sampah' => 'required', 'harga_per_kg' => 'required|numeric']);
        \App\Models\JenisSampah::create($request->except('_token'));
        return back()->with('success', 'Kategori sampah berhasil ditambahkan!');
    }

    public function destroyKategori(string $id)
    {
        \App\Models\JenisSampah::destroy($id);
        return back()->with('success', 'Kategori sampah berhasil dihapus!');
    }

    // Update Kategori Sampah (Edit Harga/Nama)
    public function updateKategori(Request $request, string $id)
    {
        $request->validate([
            'nama_sampah' => 'required',
            'harga_per_kg' => 'required|numeric'
        ]);

        $kategori = \App\Models\JenisSampah::findOrFail($id);
        
        $kategori->update([
            'nama_sampah' => $request->nama_sampah,
            'harga_per_kg' => $request->harga_per_kg
        ]);

        return back()->with('success', 'Data kategori sampah berhasil diperbarui!');
    }

    // CRUD Bank Sampah
    public function storeBank(Request $request)
    {
        $request->validate(['nama_bank' => 'required', 'alamat' => 'required']);
        \App\Models\BankSampah::create($request->except('_token'));
        return back()->with('success', 'Lokasi Bank Sampah berhasil ditambahkan!');
    }

    public function destroyBank(string $id)
    {
        \App\Models\BankSampah::destroy($id);
        return back()->with('success', 'Lokasi Bank Sampah berhasil dihapus!');
    }

    // ==========================================
    // KELOLA DATA PENGGUNA
    // ==========================================
    public function dataPengguna(Request $request)
    {
        $query = User::query();

        // Filter Pencarian Nama/Email
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->get();
        $banks = \App\Models\BankSampah::all();

        return view('admin.data_pengguna', compact('users', 'banks'));
    }

    // Menambah Pengguna Baru (Termasuk Petugas + Lokasi Dinas)
    public function storePengguna(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,petugas,nasabah',
            // bank_sampah_id tidak wajib bagi nasabah/admin, tapi ada di form jika dia petugas
            'bank_sampah_id' => 'nullable|exists:bank_sampahs,id' 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            // Jika role yang dipilih adalah petugas, masukkan ID bank sampahnya. Jika bukan, kosongkan (null).
            'bank_sampah_id' => $request->role === 'petugas' ? $request->bank_sampah_id : null,
        ]);

        return back()->with('success', 'Akun ' . ucfirst($request->role) . ' berhasil ditambahkan!');
    }

    // Fitur Reset Password
    public function resetPassword(string $id)
    {
        $user = User::findOrFail($id);
        
        // Reset password menjadi default: password123
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make('password123')
        ]);

        return back()->with('success', 'Password akun ' . $user->name . ' berhasil direset menjadi: password123');
    }

    // ==========================================
    // KELOLA LAPORAN SAMPAH MASUK
    // ==========================================
    public function laporanSampah(Request $request)
    {
        // 1. Hitung Statistik (Menggunakan library Carbon bawaan Laravel)
        $hariIni = Carbon::today();
        
        $total_hari_ini = Transaksi::whereDate('created_at', $hariIni)->sum('berat');
        $total_bulan_ini = Transaksi::whereMonth('created_at', $hariIni->month)
                                    ->whereYear('created_at', $hariIni->year)
                                    ->sum('berat');
        $total_tahun_ini = Transaksi::whereYear('created_at', $hariIni->year)->sum('berat');

        // 2. Siapkan Master Data untuk Dropdown Filter
        $jenis_sampahs = JenisSampah::all();

        // 3. Query Builder untuk Filter Data
        $query = Transaksi::with(['user', 'jenisSampah']);

        // Filter Nama Nasabah
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        // Filter Jenis Sampah
        if ($request->filled('jenis_sampah_id')) {
            $query->where('jenis_sampah_id', $request->jenis_sampah_id);
        }
        // Filter Tanggal Spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Ambil data (menggunakan Pagination 15 per halaman) dan simpan parameter filternya
        $transaksis = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.laporan_sampah', compact(
            'transaksis', 'total_hari_ini', 'total_bulan_ini', 'total_tahun_ini', 'jenis_sampahs'
        ));
    }

    // Fitur Export CSV (Sesuai Filter yang sedang aktif)
    public function exportLaporanSampah(Request $request)
    {
        $fileName = 'laporan-sampah-masuk-' . date('Y-m-d') . '.csv';
        
        // Terapkan filter yang sama persis dengan halaman laporan
        $query = Transaksi::with(['user', 'jenisSampah']);

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

        $columns = ['Tanggal', 'Nama Nasabah', 'Jenis Sampah', 'Berat (Kg)', 'Total Harga (Rp)'];

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

    public function tolakPenarikan(Request $request, $id)
    {
        // 1. Validasi catatan wajib diisi
        $request->validate([
            'catatan_penolakan' => 'required|string'
        ]);

        $penarikan = \App\Models\Penarikan::findOrFail($id);
        
        // Cek jika statusnya masih pending agar tidak ter-dobel
        if ($penarikan->status == 'pending') {
            $penarikan->status = 'ditolak';
            // $penarikan->catatan = $request->catatan_penolakan; // Opsional: Buka komentar ini jika kamu membuat kolom catatan di tabel penarikans
            $penarikan->save();

            // 2. Kembalikan saldo utuh ke nasabah
            $user = $penarikan->user;

            // 3. Kirim Email Penolakan + Alasan
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\PenarikanRejectedMail([
                'nama' => $user->name,
                'nominal' => $penarikan->nominal,
                'alasan' => $request->catatan_penolakan,
                'tanggal' => now()->format('d M Y, H:i')
            ]));

            return back()->with('success', 'Penarikan berhasil ditolak, saldo dikembalikan, dan email notifikasi telah dikirim ke nasabah.');
        }

        return back()->with('error', 'Penarikan ini sudah diproses sebelumnya.');
    }
}