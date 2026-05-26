<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Pembimbing;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PembimbingController extends Controller
{
    public function index()
    {
        // Ambil semua data pembimbing beserta akunnya
        $pembimbing = Pembimbing::with('user')->get();
        $totalPembimbing = $pembimbing->count();

        // Asumsi: Jika kamu punya relasi ke siswa, bisa dihitung total bimbingannya.
        // Sementara kita buat 0 dulu agar tidak error.
        $totalBimbingan = 0;

        return view('admin.data.pembimbing.index', compact('pembimbing', 'totalPembimbing', 'totalBimbingan'));
    }
    public function create()
    {
        return view('admin.data.pembimbing.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Fleksibel
        $request->validate([
            // Wajib
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',

            // Opsional
            'no_induk'     => 'nullable|string|max:50',
            'jabatan'      => 'nullable|string|max:100',
            'no_telp'      => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // 2. Buat Akun User
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Beri Role Pembimbing
            $rolePembimbing = Role::firstOrCreate(['name' => 'Pembimbing']);
            $user->roles()->attach($rolePembimbing->getKey());

            // 3. Buat Cangkang Profil Pembimbing
            Pembimbing::create([
                'id_user'      => $user->id_user,
                'nama_lengkap' => $request->nama_lengkap,
                'status'       => 'Aktif',
                // Data Opsional
                'no_induk'     => $request->no_induk,
                'jabatan'      => $request->jabatan,
                'no_telp'      => $request->no_telp,
                // id_agama dibiarkan NULL agar dilengkapi mandiri oleh pembimbing
            ]);

            DB::commit();
            return redirect()->route('admin.data.pembimbing.index')->with('success', 'Akun Pembimbing berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        // Cari data pembimbing berdasarkan ID
        $pembimbing = Pembimbing::with('user')->findOrFail($id);
    
        return view('admin.data.pembimbing.edit', compact('pembimbing'));
    }

    public function update(Request $request, $id)
    {
        $pembimbing = Pembimbing::findOrFail($id);
        $user = User::findOrFail($pembimbing->id_user);

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'password'     => 'nullable|min:6',
            'status'       => 'required|in:Aktif,Tidak Aktif',
            'no_induk'     => 'nullable|string|max:50',
            'jabatan'      => 'nullable|string|max:100',
            'no_telp'      => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $pembimbing->update([
                'nama_lengkap' => $request->nama_lengkap,
                'status'       => $request->status,
                'no_induk'     => $request->no_induk,
                'jabatan'      => $request->jabatan,
                'no_telp'      => $request->no_telp,
            ]);

            DB::commit();
            return redirect()->route('admin.data.pembimbing.index')->with('success', 'Data Pembimbing berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pembimbing = Pembimbing::findOrFail($id);
        $user = User::findOrFail($pembimbing->id_user);

        DB::beginTransaction();
        try {
            $pembimbing->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('admin.data.pembimbing.index')->with('success', 'Akun Pembimbing berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        // Mengambil data pembimbing
        $pembimbing = Pembimbing::with('user')->where('id_pembimbing', $id)->firstOrFail();

        // Pastikan pakai compact('pembimbing') agar namanya cocok dengan yang ada di view
        return view('admin.data.pembimbing.show', compact('pembimbing'));
    }
}
