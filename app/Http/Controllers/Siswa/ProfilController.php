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

        // Validasi semua form KECUALI NIS (karena NIS sifatnya disabled/dikunci)
        $request->validate([
            'email'         => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_hp'         => 'nullable|string|max:20',
            'tempat_lahir'  => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'id_agama'      => 'nullable|exists:agama,id_agama', // Pastikan nama tabelnya 'agama'
            'jk'            => 'nullable|in:L,P',
            'alamat'        => 'nullable|string',
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
        ]);

        return redirect()->route('siswa.profil')->with('success', 'Biodata berhasil diperbarui!');
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Maks 5MB
        ], [
            'foto.max' => 'Ukuran foto maksimal 5MB.'
        ]);

        $siswa = SiswaMagang::where('id_user', Auth::id())->firstOrFail();

        if ($request->hasFile('foto')) {
            if ($siswa->foto_profil && Storage::disk('public')->exists($siswa->foto_profil)) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }

            $path = $request->file('foto')->store('profil', 'public');
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
