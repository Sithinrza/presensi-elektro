<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembimbing;
use App\Models\User;
use App\Models\Agama;
use App\Models\PendidikanTerakhir;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data pembimbing beserta relasi yang ada di skema
        $pembimbing = Pembimbing::with(['user', 'agama', 'pendidikanTerakhir'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        return view('pembimbing.profil.index', compact('pembimbing', 'user'));
    }

    public function edit()
    {
        $user = Auth::user();

        $pembimbing = Pembimbing::with(['user', 'agama', 'pendidikanTerakhir'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        $agama = Agama::all();
        $pendidikan = PendidikanTerakhir::all();

        return view('pembimbing.profil.edit', compact('pembimbing', 'user', 'agama', 'pendidikan'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        // 🚨 PERBAIKAN: Hanya validasi data yang benar-benar ada di form Blade Edit Mandiri
        $request->validate([
            'email'    => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_telp'  => 'required|string|max:20',
            'id_agama' => 'required|exists:agama,id_agama',
            'jk'       => 'required|in:L,P',
        ]);

        // 1. Update email di tabel users
        $userObj = User::find($user->id_user);
        $userObj->update(['email' => $request->email]);

        // 2. Update data di tabel pembimbing (JABATAN & PENDIDIKAN TIDAK IKUT DIUPDATE DI SINI)
        $pembimbing->update([
            'no_telp'  => $request->no_telp,
            'id_agama' => $request->id_agama,
            'jk'       => $request->jk,
        ]);

        return redirect()->route('pembimbing.profil.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateFoto(Request $request)
    {
        // 🚨 PERBAIKAN: Validasi Foto Max 3MB (3072 KB)
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:3072',
        ], [
            'foto.required' => 'Silakan pilih foto terlebih dahulu.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format gambar harus JPG, JPEG, atau PNG.',
            'foto.max'      => 'Ukuran foto maksimal adalah 3 MB.',
        ]);

        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pembimbing->foto_profil && Storage::disk('public')->exists($pembimbing->foto_profil)) {
                Storage::disk('public')->delete($pembimbing->foto_profil);
            }

            // Simpan file baru (Disamakan dengan folder admin: profil/pembimbing)
            $path = $request->file('foto')->store('profil/pembimbing', 'public');
            $pembimbing->update(['foto_profil' => $path]);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }

    public function deleteFoto()
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->first();

        if ($pembimbing && $pembimbing->foto_profil) {
            if (Storage::disk('public')->exists($pembimbing->foto_profil)) {
                Storage::disk('public')->delete($pembimbing->foto_profil);
            }

            $pembimbing->update(['foto_profil' => null]);
            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }
}
