<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses autentikasi
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Hapus ->intended() agar dipaksa masuk ke rute yang benar
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($role === 'petugas') {
                return redirect('/petugas/dashboard');
            } else {
                return redirect('/nasabah/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Menampilkan Halaman Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Register (Kirim OTP)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_hp' => 'required',
            'password' => 'required|min:6|confirmed'
        ], [
            'email.unique' => 'Email ini sudah terdaftar!',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Buat 6 Digit Angka Acak
        $otp = rand(100000, 999999);

        // Simpan data User (status belum login, hanya simpan OTP)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'nasabah', // Otomatis jadi nasabah
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5) // Kedaluwarsa 5 menit
        ]);

        // Kirim Email OTP
        Mail::to($user->email)->send(new OtpMail($otp));

        // Pindah ke halaman input OTP
        return redirect('/verify-otp')->with('email', $user->email)->with('success', 'Berhasil mendaftar! Kode OTP telah dikirim ke email Anda.');
    }

    // Menampilkan Halaman Input OTP
    public function showVerifyOtp()
    {
        // Pastikan ada email di session, kalau tidak lempar balik ke register
        if (!session('email')) {
            return redirect('/register');
        }
        return view('auth.verify_otp', ['email' => session('email')]);
    }

    // Proses Validasi Kode OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric', 'email' => 'required']);

        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

        // Jika kode salah
        if (!$user) {
            return back()->with('email', $request->email)->withErrors(['otp' => 'Kode OTP salah!']);
        }

        // Jika waktu sudah lewat 5 menit
        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return back()->with('email', $request->email)->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan daftar ulang.']);
        }

        // Jika OTP Benar: Kosongkan kolom OTP dan Login!
        $user->update(['otp' => null, 'otp_expires_at' => null]);
        Auth::login($user);

        return redirect('/nasabah/dashboard')->with('success', 'Registrasi berhasil dan email terverifikasi!');
    }

    // ==========================================
    // FITUR LUPA PASSWORD (RESET VIA OTP)
    // ==========================================
    
    // 1. Tampilkan form input email
    public function showForgotPassword()
    {
        return view('auth.forgot_password');
    }

    // 2. Kirim OTP ke email untuk reset
    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email'], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);
        
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        // Kirim email menggunakan template OtpMail yang sudah kita buat sebelumnya
        Mail::to($user->email)->send(new OtpMail($otp));

        return redirect('/reset-password')->with('email', $user->email)->with('success', 'Kode OTP untuk reset sandi telah dikirim ke email Anda.');
    }

    // 3. Tampilkan form input OTP & Password Baru
    public function showResetPassword()
    {
        if (!session('email')) {
            return redirect('/forgot-password');
        }
        return view('auth.reset_password', ['email' => session('email')]);
    }

    // 4. Proses update sandi
    public function processResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
            'password' => 'required|min:6|confirmed'
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

        if (!$user) {
            return back()->with('email', $request->email)->withErrors(['otp' => 'Kode OTP salah!']);
        }

        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return back()->with('email', $request->email)->withErrors(['otp' => 'Kode OTP kedaluwarsa. Silakan request ulang.']);
        }

        // Update sandi baru dan bersihkan OTP
        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return redirect('/login')->with('success', 'Password berhasil diubah! Silakan masuk dengan sandi baru Anda.');
    }
}