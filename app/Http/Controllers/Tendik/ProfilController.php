<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Wajib di-import untuk fitur Storage
use App\Models\Tendik;
use App\Models\User;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data tendik yang sedang login beserta relasinya yang lengkap
        $tendik = Tendik::with(['user', 'unitKerja', 'pangkatGolongan.pangkat', 'pangkatGolongan.golongan', 'jabatan', 'agama', 'pendidikanTerakhir'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        return view('tendik.profil.index', compact('tendik', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $tendik = Tendik::where('id_user', $user->id_user)->firstOrFail();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'nip'   => 'required|string|max:50', // Menggunakan NIP untuk Tendik
            'no_hp' => 'nullable|string|max:20',
        ]);

        // 1. Update email di tabel users
        $userObj = User::find($user->id_user);
        $userObj->update(['email' => $request->email]);

        // 2. Update data di tabel tendik
        $tendik->update([
            'nip'   => $request->nip,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        $tendik = Tendik::where('id_user', Auth::user()->id_user)->firstOrFail();

        if ($request->hasFile('foto')) {
            // 1. Hapus foto lama dari storage jika ada
            if ($tendik->foto_profil && Storage::disk('public')->exists($tendik->foto_profil)) {
                Storage::disk('public')->delete($tendik->foto_profil);
            }

            // 2. Simpan file baru ke folder storage/app/public/profil
            $path = $request->file('foto')->store('profil', 'public');

            // 3. Simpan path tersebut ke database
            $tendik->update(['foto_profil' => $path]);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }

    public function deleteFoto()
    {
        // Ganti auth()->id() ke Auth::user()->id_user agar aman dari error Intelephense
        $tendik = Tendik::where('id_user', Auth::user()->id_user)->first();

        if ($tendik && $tendik->foto_profil) {
            // 1. Hapus file fisik dari storage
            if (Storage::disk('public')->exists($tendik->foto_profil)) {
                Storage::disk('public')->delete($tendik->foto_profil);
            }

            // 2. Hapus nama file dari database
            $tendik->update(['foto_profil' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }
}
