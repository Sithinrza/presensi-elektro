<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaMagang;
use App\Models\User;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data siswa yang sedang login beserta relasinya
        $siswa = SiswaMagang::with(['user', 'pembimbing', 'agama'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        return view('siswa.profil.index', compact('siswa', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $siswa = SiswaMagang::where('id_user', $user->id_user)->firstOrFail();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'nis'   => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:20',
        ]);

        // 1. Update data di tabel users
        $userObj = User::find($user->id_user);
        $userObj->update(['email' => $request->email]);

        // 2. Update data di tabel siswa_magang
        $siswa->update([
            'nis'   => $request->nis,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $siswa = SiswaMagang::where('id_user', Auth::id())->firstOrFail();

        if ($request->hasFile('foto')) {
            // 1. Hapus foto lama JIKA ADA
            if ($siswa->foto_profil && Storage::disk('public')->exists($siswa->foto_profil)) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }

            // 2. Simpan file baru ke folder storage/app/public/profil
            // Kodingan ini otomatis membuat file dengan nama unik dan mengembalikan path-nya (misal: "profil/namafile.jpg")
            $path = $request->file('foto')->store('profil', 'public');

            // 3. Simpan path tersebut ke database
            $siswa->update(['foto_profil' => $path]);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }

    public function deleteFoto()
    {
        $user = Auth::user();
        $siswa = SiswaMagang::where('id_user', $user->id_user)->first();

        if ($siswa && $siswa->foto_profil) {
            // 1. Hapus file fisik dari storage
            if (Storage::disk('public')->exists($siswa->foto_profil)) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }

            // 2. Kosongkan data di database
            $siswa->update(['foto_profil' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }
}
