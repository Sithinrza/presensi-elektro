<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ResetPasswordOtpController extends Controller
{
    // 1. Tampilkan Halaman Input Email
    public function showRequestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Proses Kirim OTP ke Email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami!'
        ]);

        // Generate 6 digit angka acak
        $otp = rand(100000, 999990);

        // Simpan atau update token di tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otp,
                'created_at' => Carbon::now('Asia/Makassar')
            ]
        );

        // Kirim email lewat Mailtrap
        Mail::to($request->email)->send(new SendOtpMail($otp));

        // Simpan email di session agar form berikutnya tahu email mana yang diverifikasi
        session(['reset_email' => $request->email]);

        return redirect()->route('password.otp.verify')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    // 3. Tampilkan Halaman Input OTP
    public function showVerifyForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

    // 4. Proses Validasi Kode OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $email = session('reset_email');

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return redirect()->back()->withErrors(['otp' => 'Kode OTP salah atau tidak sesuai!']);
        }

        // Cek kedaluwarsa (15 menit)
        $waktuDibuat = Carbon::parse($record->created_at, 'Asia/Makassar');
        if (Carbon::now('Asia/Makassar')->diffInMinutes($waktuDibuat) > 15) {
            return redirect()->route('password.request')->withErrors(['email' => 'Kode OTP sudah kedaluwarsa, silakan minta kode baru.']);
        }

        // Jika lolos, beri tanda di session bahwa OTP sukses divalidasi
        session(['otp_verified' => true]);

        return redirect()->route('password.otp.reset');
    }

    // 5. Tampilkan Halaman Input Password Baru
    public function showResetForm()
    {
        if (!session('reset_email') || !session('otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password');
    }

    // 6. Eksekusi Update Password Baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok!'
        ]);

        $email = session('reset_email');

        // Update password di tabel users
        $user = User::where('email', $email)->firstOrFail();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token dari tabel password_reset_tokens agar tidak bisa dipakai lagi
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Bersihkan session
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password Anda berhasil diperbarui! Silakan login.');
    }
}
