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
        $siswa = SiswaMagang::with(['user', 'pembimbing', 'agama'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        return view('siswa.profil.index', compact('siswa', 'user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $siswa = SiswaMagang::with(['user', 'pembimbing', 'agama'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        // Ambil data agama untuk dropdown form
        $agama = \App\Models\Agama::all();

        return view('siswa.profil.edit', compact('siswa', 'user', 'agama'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $siswa = SiswaMagang::where('id_user', $user->id_user)->firstOrFail();

        // 🚨 PERBAIKAN: Semua form biodata sekarang REQUIRED
        $request->validate([
            'email'         => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_hp'         => 'required|string|max:20',
            'tempat_lahir'  => 'required|string|max:50', // 👈 REQUIRED
            'tanggal_lahir' => 'required|date',          // 👈 REQUIRED
            'id_agama'      => 'required|exists:agama,id_agama',
            'jk'            => 'required|in:L,P',
            'alamat'        => 'required|string',        // 👈 REQUIRED
            'jurusan'       => 'required|string|max:100',
        ], [
            'tempat_lahir.required'  => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'alamat.required'        => 'Alamat domisili lengkap wajib diisi.',
        ]);

        // 1. Update email di tabel users
        $userObj = User::find($user->id_user);
        $userObj->update(['email' => $request->email]);

        // 2. Update kelengkapan data di tabel siswa_magang
        $siswa->update([
            'no_hp'         => $request->no_hp,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'id_agama'      => $request->id_agama,
            'jk'            => $request->jk,
            'alamat'        => $request->alamat,
            'jurusan'       => $request->jurusan,
        ]);

        return redirect()->route('siswa.profil.index')->with('success', 'Biodata berhasil diperbarui!');
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:3072',
        ], [
            'foto.required' => 'Silakan pilih foto terlebih dahulu.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format gambar harus JPG, JPEG, atau PNG.',
            'foto.max'      => 'Ukuran foto maksimal adalah 3 MB.',
        ]);

        $siswa = SiswaMagang::where('id_user', Auth::id())->firstOrFail();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto_profil && Storage::disk('public')->exists($siswa->foto_profil)) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }

            // Simpan ke folder yang rapi
            $path = $request->file('foto')->store('profil/siswa', 'public');
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
            if (Storage::disk('public')->exists($siswa->foto_profil)) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }

            $siswa->update(['foto_profil' => null]);
            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }
}
