<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\User;
use Carbon\Carbon;

class ProfilePasswordController extends Controller
{
    // 1. Eksekusi Kirim OTP (Otomatis ambil email dari Auth)
    public function sendOtp()
    {
        $user = Auth::user();
        $this->generateAndSendOtp($user->email);

        // Tandai session bahwa OTP sedang berjalan untuk profil ini
        session(['profile_otp_sent' => true]);

        return redirect()->route('profile.password.verify')->with('success', 'Kode Keamanan (OTP) telah dikirim ke email Anda.');
    }

    // 1.b Fungsi Kirim Ulang OTP
    public function resendOtp()
    {
        if (!session('profile_otp_sent')) {
            return redirect()->back();
        }

        $email = Auth::user()->email;

        // Cek jeda pengiriman (1 menit)
        $lastRecord = DB::table('password_reset_tokens')->where('email', $email)->first();
        if ($lastRecord) {
            $waktuDibuat = Carbon::parse($lastRecord->created_at, 'Asia/Makassar');
            if (Carbon::now('Asia/Makassar')->diffInMinutes($waktuDibuat) < 1) {
                return redirect()->back()->withErrors(['otp' => 'Harap tunggu 1 menit sebelum mengirim ulang OTP.']);
            }
        }

        $this->generateAndSendOtp($email);

        return redirect()->route('profile.password.verify')->with('success', 'Kode OTP baru telah berhasil dikirim ulang ke email Anda.');
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
    }

    // 2. Tampilkan Halaman Input OTP
    public function showVerifyForm()
    {
        if (!session('profile_otp_sent')) {
            return redirect()->back();
        }

        $record = DB::table('password_reset_tokens')->where('email', Auth::user()->email)->first();
        if (!$record) {
            return redirect()->back();
        }

        // Ambil waktu OTP dibuat untuk dikirim ke Blade
        $createdAt = Carbon::parse($record->created_at, 'Asia/Makassar');

        return view('auth.reset-password.verify-otp-profile', compact('createdAt'));
    }

    // 3. Validasi Kode OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        $email = Auth::user()->email;

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return redirect()->back()->withErrors(['otp' => 'Kode OTP salah atau tidak sesuai!']);
        }

        $waktuDibuat = Carbon::parse($record->created_at, 'Asia/Makassar');
        if (Carbon::now('Asia/Makassar')->diffInMinutes($waktuDibuat) > 15) {
            return redirect()->back()->withErrors(['otp' => 'Kode OTP kedaluwarsa, silakan minta ulang.']);
        }

        session(['profile_otp_verified' => true]);
        return redirect()->route('profile.password.reset');
    }

    // 4. Tampilkan Halaman Password Baru
    public function showResetForm()
    {
        if (!session('profile_otp_verified')) {
            return redirect()->route('profile.password.verify');
        }
        return view('auth.reset-password.reset-password-profile');
    }

    // 5. Simpan Password Baru
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok!'
        ]);

        $user = User::find(Auth::id());
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        session()->forget(['profile_otp_sent', 'profile_otp_verified']);

        // Arahkan kembali ke dashboard sesuai role masing-masing
        $roleName = strtolower($user->roles->first()->name ?? '');
        $redirectRoute = 'login'; // Default fallback

        if ($roleName == 'admin') $redirectRoute = 'admin.dashboard';
        elseif ($roleName == 'pembimbing') $redirectRoute = 'pembimbing.dashboard';
        elseif ($roleName == 'tendik') $redirectRoute = 'tendik.dashboard';
        elseif (in_array($roleName, ['siswa magang', 'siswa'])) $redirectRoute = 'siswa.dashboard';

        return redirect()->route($redirectRoute)->with('success', 'Password keamanan berhasil diperbarui!');
    }
}
