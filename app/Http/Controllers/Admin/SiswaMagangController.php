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
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $roleSiswa = Role::where('name', 'siswa')->first();
            $user->roles()->attach($roleSiswa->getKey());

            SiswaMagang::create([
                'id_user'         => $user->id_user,
                'nama_lengkap'    => $request->nama_lengkap,
                'status'          => 'Aktif',

                'no_hp'           => $request->no_hp,
                'id_pembimbing'   => $request->id_pembimbing,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
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
            'password'        => 'nullable|min:6', // Password opsional saat edit
            'status'          => 'required|in:Aktif,Nonaktif',
            'id_pembimbing'   => 'nullable|integer',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'email' => $request->email,
            ];
            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            $siswa->update([
                'nama_lengkap'    => $request->nama_lengkap,
                'status'          => $request->status,
                'no_hp'           => $request->no_hp,
                'id_pembimbing'   => $request->id_pembimbing,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
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
        $siswa = SiswaMagang::with('user')->where('id_siswa', $id)->firstOrFail();
        return view('admin.data.siswa.show', compact('siswa'));
    }
}
