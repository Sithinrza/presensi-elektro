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

        // Ambil data pembimbing yang sedang login beserta relasinya
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

        // Jika nanti di form edit kamu mau menambahkan dropdown Agama / Pendidikan Terakhir
        $agama = \App\Models\Agama::all();

        return view('pembimbing.profil.edit', compact('pembimbing', 'user', 'agama'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        // Validasi form (no_induk TIDAK DIVALIDASI karena formnya disabled/terkunci)
        $request->validate([
            'email'   => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_telp' => 'nullable|string|max:20',
        ]);

        // 1. Update email di tabel users
        $userObj = User::find($user->id_user);
        $userObj->update(['email' => $request->email]);

        // 2. Update kelengkapan data di tabel pembimbing
        $pembimbing->update([
            'no_telp' => $request->no_telp,
            // Jika nanti kamu menambahkan form input lain di HTML (misal Agama/JK), cukup tambahkan di sini:
            // 'jk'       => $request->jk,
            // 'id_agama' => $request->id_agama,
        ]);

        // Redirect kembali ke halaman profil utama setelah simpan
        return redirect()->route('pembimbing.profil')->with('success', 'Biodata berhasil diperbarui!');
    }

    public function updateFoto(Request $request)
    {
        // Maksimal file 5MB (5120 KB)
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'foto.max' => 'Ukuran foto maksimal 5MB.',
            'foto.image' => 'File harus berupa gambar.'
        ]);

        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pembimbing->foto_profil && Storage::disk('public')->exists($pembimbing->foto_profil)) {
                Storage::disk('public')->delete($pembimbing->foto_profil);
            }

            // Simpan file baru
            $path = $request->file('foto')->store('profil', 'public');
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
            // Hapus file fisik dari storage
            if (Storage::disk('public')->exists($pembimbing->foto_profil)) {
                Storage::disk('public')->delete($pembimbing->foto_profil);
            }

            // Kosongkan nama file dari database
            $pembimbing->update(['foto_profil' => null]);
            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }
}
