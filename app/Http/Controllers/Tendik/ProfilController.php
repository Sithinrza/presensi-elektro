<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tendik;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tendik = Tendik::with(['user', 'unitKerja', 'pangkatGolongan.pangkat', 'pangkatGolongan.golongan', 'jabatan', 'agama', 'pendidikanTerakhir'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        return view('tendik.profil.index', compact('tendik', 'user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $tendik = Tendik::with(['user', 'unitKerja', 'pangkatGolongan.pangkat', 'pangkatGolongan.golongan'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        $agama = \App\Models\Agama::all();

        return view('tendik.profil.edit', compact('tendik', 'agama'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $tendik = Tendik::where('id_user', $user->id_user)->firstOrFail();

        // 🚨 PERBAIKAN: Dikembalikan menjadi nullable (opsional)
        $request->validate([
            'email'         => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_hp'         => 'nullable|string|max:20', // Opsional
            'tempat_lahir'  => 'nullable|string|max:40', // Opsional
            'tanggal_lahir' => 'nullable|date', // Opsional
            'id_agama'      => 'nullable|exists:agama,id_agama', // Opsional
            'jk'            => 'nullable|in:L,P', // Opsional
            'alamat'        => 'nullable|string', // Opsional
        ]);

        // 1. Update email di tabel users
        $userObj = User::find($user->id_user);
        $userObj->update(['email' => $request->email]);

        // 2. Update kelengkapan data di tabel tendik
        $tendik->update([
            'no_hp'         => $request->no_hp,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'id_agama'      => $request->id_agama,
            'jk'            => $request->jk,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->route('tendik.profil.index')->with('success', 'Biodata berhasil diperbarui!');
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

        $tendik = Tendik::where('id_user', Auth::user()->id_user)->firstOrFail();

        if ($request->hasFile('foto')) {
            if ($tendik->foto_profil && Storage::disk('public')->exists($tendik->foto_profil)) {
                Storage::disk('public')->delete($tendik->foto_profil);
            }

            $path = $request->file('foto')->store('profil/tendik', 'public');
            $tendik->update(['foto_profil' => $path]);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }

    public function deleteFoto()
    {
        $tendik = Tendik::where('id_user', Auth::user()->id_user)->first();

        if ($tendik && $tendik->foto_profil) {
            if (Storage::disk('public')->exists($tendik->foto_profil)) {
                Storage::disk('public')->delete($tendik->foto_profil);
            }

            $tendik->update(['foto_profil' => null]);
            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }
}
