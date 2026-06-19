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
        return view('auth.forgot-password.forgot-password');
    }

    // 2. Proses Kirim OTP ke Email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami!'
        ]);

        $this->generateAndSendOtp($request->email);

        return redirect()->route('password.otp.verify')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    // 2.b Fungsi Kirim Ulang OTP (Resend)
    public function resendOtp()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        $email = session('reset_email');

        // Cek kapan OTP terakhir dibuat untuk mencegah spam klik
        $lastRecord = DB::table('password_reset_tokens')->where('email', $email)->first();
        if ($lastRecord) {
            $waktuDibuat = Carbon::parse($lastRecord->created_at, 'Asia/Makassar');
            if (Carbon::now('Asia/Makassar')->diffInMinutes($waktuDibuat) < 1) {
                return redirect()->back()->withErrors(['otp' => 'Harap tunggu 1 menit sebelum mengirim ulang OTP.']);
            }
        }

        $this->generateAndSendOtp($email);

        return redirect()->route('password.otp.verify')->with('success', 'Kode OTP baru telah berhasil dikirim ulang ke email Anda.');
    }

    // Fungsi Pembantu Generate & Kirim
    private function generateAndSendOtp($email)
    {
        $otp = rand(100000, 999990);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $otp,
                'created_at' => Carbon::now('Asia/Makassar')
            ]
        );

        Mail::to($email)->send(new SendOtpMail($otp));

        session(['reset_email' => $email]);
    }

    // 3. Tampilkan Halaman Input OTP
    public function showVerifyForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        $record = DB::table('password_reset_tokens')->where('email', session('reset_email'))->first();
        if (!$record) {
            return redirect()->route('password.request');
        }

        // Ambil waktu OTP dibuat untuk dikirim ke Blade
        $createdAt = Carbon::parse($record->created_at, 'Asia/Makassar');

        return view('auth.forgot-password.verify-otp', compact('createdAt'));
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

        $waktuDibuat = Carbon::parse($record->created_at, 'Asia/Makassar');
        if (Carbon::now('Asia/Makassar')->diffInMinutes($waktuDibuat) > 15) {
            return redirect()->route('password.request')->withErrors(['email' => 'Kode OTP sudah kedaluwarsa, silakan minta kode baru.']);
        }

        session(['otp_verified' => true]);

        return redirect()->route('password.otp.reset');
    }

    // 5. Tampilkan Halaman Input Password Baru
    public function showResetForm()
    {
        if (!session('reset_email') || !session('otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.forgot-password.reset-password');
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

        $user = User::where('email', $email)->firstOrFail();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password Anda berhasil diperbarui! Silakan login.');
    }
}
