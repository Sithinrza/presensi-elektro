<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Pembimbing;
use App\Models\SiswaMagang; // Jangan lupa panggil model SiswaMagang
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PembimbingController extends Controller
{
    public function index()
    {
        $pembimbing = Pembimbing::with('user')->get();
        $totalPembimbing = $pembimbing->count();
        $totalBimbingan = 0;

        return view('admin.data.pembimbing.index', compact('pembimbing', 'totalPembimbing', 'totalBimbingan'));
    }

    public function create()
    {
        return view('admin.data.pembimbing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'no_induk'     => 'nullable|string|max:50',
            'jabatan'      => 'nullable|string|max:100',
            'no_telp'      => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $rolePembimbing = Role::firstOrCreate(['name' => 'Pembimbing']);
            $user->roles()->attach($rolePembimbing->getKey());

            Pembimbing::create([
                'id_user'      => $user->id_user,
                'nama_lengkap' => $request->nama_lengkap,
                'status'       => 'Aktif',
                'no_induk'     => $request->no_induk,
                'jabatan'      => $request->jabatan,
                'no_telp'      => $request->no_telp,
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
            'status'       => 'required|in:Aktif,Nonaktif',
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

            // ==========================================
            // LOGIKA EFEK DOMINO ADA DI SINI
            // ==========================================
            // Jika pembimbing diubah jadi "Nonaktif", maka lepaskan siswa bimbingannya
            if ($request->status === 'Nonaktif') {
                SiswaMagang::where('id_pembimbing', $id)->update([
                    'id_pembimbing' => null
                ]);
            }

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
        $pembimbing = Pembimbing::with('user')->where('id_pembimbing', $id)->firstOrFail();
        return view('admin.data.pembimbing.show', compact('pembimbing'));
    }
}
