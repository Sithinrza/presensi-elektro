<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // Gunakan Auth::user()->id_user untuk mencari data tendik
        $tendik = Tendik::where('id_user', Auth::user()->id_user)->firstOrFail();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // Format nama file disesuaikan untuk tendik: foto_profil_tendik_1_1634567890.jpg
            $fileName = 'foto_profil_tendik_' . $tendik->id_tendik . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder public/uploads/profil
            $file->move(public_path('uploads/profil'), $fileName);

            // Hapus foto lama jika ada
            if ($tendik->foto_profil && file_exists(public_path('uploads/profil/' . $tendik->foto_profil))) {
                unlink(public_path('uploads/profil/' . $tendik->foto_profil));
            }

            // Simpan nama file ke kolom 'foto_profil' di tabel tendik
            $tendik->update(['foto_profil' => $fileName]);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }
    public function deleteFoto()
    {
        // Cari data tendik berdasarkan user yang login
        $tendik = \App\Models\Tendik::where('id_user', auth()->id())->first();

        if ($tendik && $tendik->foto_profil) {
            // Path foto: sesuaikan dengan folder penyimpanan Anda (misal public/uploads/profil)
            $fotoPath = public_path('uploads/profil/' . $tendik->foto_profil);
            
            // Hapus file fisik dari folder jika ada
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }

            // Hapus nama file dari database
            $tendik->update(['foto_profil' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang dapat dihapus.');
    }
}
