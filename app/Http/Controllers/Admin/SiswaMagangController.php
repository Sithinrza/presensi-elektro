<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\SiswaMagang;
use App\Models\Agama;
use App\Models\Pembimbing;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiswaMagangController extends Controller
{
    public function index()
    {
        $siswa = SiswaMagang::with('user', 'agama')->get();
        $totalSiswa = $siswa->count();
        $siswaAktif = $siswa->where('status', 'Aktif')->count();

        $agama = Agama::all();
        $pembimbing = Pembimbing::all();

        return view('admin.data.siswa.index', compact('siswa', 'totalSiswa', 'siswaAktif', 'agama', 'pembimbing'));
    }

    public function create()
    {
        $agama = Agama::all();
        $pembimbing = Pembimbing::where('status', 'Aktif')->get();

        return view('admin.data.siswa.create', compact('agama', 'pembimbing'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'    => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6',
            'no_hp'           => 'nullable|string|max:20',
            'id_pembimbing'   => 'nullable|integer',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',

            // Data Opsional Tambahan
            'nis'             => 'nullable|string|max:50',
            'id_agama'        => 'nullable|integer',
            'sekolah_asal'    => 'nullable|string|max:100',
            'jurusan'         => 'nullable|string|max:100',
            'jk'              => 'nullable|in:L,P',
            'tempat_lahir'    => 'nullable|string|max:50',
            'tanggal_lahir'   => 'nullable|date',
            'alamat'          => 'nullable|string',
            'foto_profil'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $roleSiswa = Role::where('name', 'siswa')->first();
            $user->roles()->attach($roleSiswa->getKey());

            // Handle Upload Foto Profil
            $fotoPath = null;
            if ($request->hasFile('foto_profil')) {
                $fotoPath = $request->file('foto_profil')->store('profil/siswa', 'public');
            }

            SiswaMagang::create([
                'id_user'         => $user->id_user,
                'nama_lengkap'    => $request->nama_lengkap,
                'status'          => 'Aktif',
                'no_hp'           => $request->no_hp,
                'id_pembimbing'   => $request->id_pembimbing,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,

                'nis'             => $request->nis,
                'id_agama'        => $request->id_agama,
                'sekolah_asal'    => $request->sekolah_asal,
                'jurusan'         => $request->jurusan,
                'jk'              => $request->jk,
                'tempat_lahir'    => $request->tempat_lahir,
                'tanggal_lahir'   => $request->tanggal_lahir,
                'alamat'          => $request->alamat,
                'foto_profil'     => $fotoPath,
            ]);

            DB::commit();
            return redirect()->route('admin.data.siswa.index')->with('success', 'Akun & Profil Siswa berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }


    public function edit($id)
    {
        $siswa = SiswaMagang::findOrFail($id);

        $agama = Agama::all();
        $pembimbing = Pembimbing::where('status', 'Aktif')->get();

        return view('admin.data.siswa.edit', compact('siswa', 'agama', 'pembimbing'));
    }

    public function update(Request $request, $id)
    {
        $siswa = SiswaMagang::findOrFail($id);
        $user = User::findOrFail($siswa->id_user);

        $request->validate([
            'nama_lengkap'    => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'password'        => 'nullable|min:6',
            'status'          => 'required|in:Aktif,Nonaktif',
            'id_pembimbing'   => 'nullable|integer',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'no_hp'           => 'nullable|string|max:20',

            // Data Opsional Tambahan
            'nis'             => 'nullable|string|max:50',
            'id_agama'        => 'nullable|integer',
            'sekolah_asal'    => 'nullable|string|max:100',
            'jurusan'         => 'nullable|string|max:100',
            'jk'              => 'nullable|in:L,P',
            'tempat_lahir'    => 'nullable|string|max:50',
            'tanggal_lahir'   => 'nullable|date',
            'alamat'          => 'nullable|string',
            'foto_profil'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $userData = ['email' => $request->email];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            // Handle Upload Foto Profil Baru
            $fotoPath = $siswa->foto_profil;
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
                $fotoPath = $request->file('foto_profil')->store('profil/siswa', 'public');
            }

            $siswa->update([
                'nama_lengkap'    => $request->nama_lengkap,
                'status'          => $request->status,
                'no_hp'           => $request->no_hp,
                'id_pembimbing'   => $request->id_pembimbing,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,

                'nis'             => $request->nis,
                'id_agama'        => $request->id_agama,
                'sekolah_asal'    => $request->sekolah_asal,
                'jurusan'         => $request->jurusan,
                'jk'              => $request->jk,
                'tempat_lahir'    => $request->tempat_lahir,
                'tanggal_lahir'   => $request->tanggal_lahir,
                'alamat'          => $request->alamat,
                'foto_profil'     => $fotoPath,
            ]);

            DB::commit();
            return redirect()->route('admin.data.siswa.index')->with('success', 'Data Siswa berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $siswa = SiswaMagang::findOrFail($id);
        $user = User::findOrFail($siswa->id_user);

        DB::beginTransaction();
        try {
            // Hapus profil siswa dulu, baru akun user-nya
            $siswa->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('admin.data.siswa.index')->with('success', 'Data Siswa dan Akun berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        // Cari data siswa berdasarkan ID, beserta data user/akun-nya
        $siswa = SiswaMagang::with(['user', 'agama', 'pembimbing'])->where('id_siswa', $id)->firstOrFail();
        return view('admin.data.siswa.show', compact('siswa'));
    }
}
