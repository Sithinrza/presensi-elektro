<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data pembimbing yang sedang login beserta relasi user
        $pembimbing = Pembimbing::with(['user', 'agama'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        return view('pembimbing.profil.index', compact('pembimbing', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        $request->validate([
            'email'    => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_induk' => 'required|string|max:50',
            'no_telp'  => 'nullable|string|max:20',
        ]);

        // 1. Update data di tabel users
        $userObj = User::find($user->id_user);
        $userObj->update(['email' => $request->email]);

        // 2. Update data di tabel pembimbing
        $pembimbing->update([
            'no_induk' => $request->no_induk,
            'no_telp'  => $request->no_telp,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateFoto(Request $request)
    {
        // Naikkan max file jadi 5120 KB (5MB) agar aman untuk foto dari HP
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'foto.max' => 'Ukuran foto terlalu besar! Maksimal 5MB.',
            'foto.image' => 'File yang diunggah harus berupa gambar.'
        ]);

        $user = Auth::user();
        // Gunakan $user->id_user agar konsisten dengan method index()
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        if ($request->hasFile('foto')) {
            // 1. Hapus foto lama JIKA ADA
            if ($pembimbing->foto_profil && Storage::disk('public')->exists($pembimbing->foto_profil)) {
                Storage::disk('public')->delete($pembimbing->foto_profil);
            }

            // 2. Simpan file baru ke folder storage/app/public/profil
            $path = $request->file('foto')->store('profil', 'public');

            // 3. Simpan path tersebut ke database
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
            // 1. Hapus file fisik dari storage
            if (Storage::disk('public')->exists($pembimbing->foto_profil)) {
                Storage::disk('public')->delete($pembimbing->foto_profil);
            }

            // 2. Kosongkan data di database
            $pembimbing->update(['foto_profil' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }
}
