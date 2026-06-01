<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaMagang;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        $siswa = SiswaMagang::where('id_user', Auth::id())->firstOrFail();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // Format nama file: foto_profil_12_1634567890.jpg
            $fileName = 'foto_profil_' . $siswa->id_siswa . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder public/uploads/profil
            $file->move(public_path('uploads/profil'), $fileName);

            // PERUBAHAN DI SINI: Hapus foto lama jika ada
            if ($siswa->foto_profil && file_exists(public_path('uploads/profil/' . $siswa->foto_profil))) {
                unlink(public_path('uploads/profil/' . $siswa->foto_profil));
            }

            // PERUBAHAN DI SINI: Simpan nama file ke kolom 'foto_profil'
            $siswa->update(['foto_profil' => $fileName]);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }
    public function deleteFoto()
    {
        $siswa = SiswaMagang::where('id_user', auth()->id())->first();

        if ($siswa && $siswa->foto_profil) {
            $fotoPath = public_path('uploads/profil/' . $siswa->foto_profil);
            
            // Menghapus file fisik foto
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }

            // Hapus nama file dari database
            $siswa->update(['foto_profil' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }
}
