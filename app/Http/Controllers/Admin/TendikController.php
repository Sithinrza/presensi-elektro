<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Tendik;
use App\Models\Agama;
use App\Models\UnitKerja;
use App\Models\PangkatGolongan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TendikController extends Controller
{
    public function index()
    {
        $tendik = Tendik::with(['user', 'agama', 'unitKerja', 'pangkatGolongan.pangkat', 'pangkatGolongan.golongan'])->get();

        $totalTendik = $tendik->count();
        $tendikAktif = $tendik->where('status', 'Aktif')->count();

        $agama = Agama::all();
        $unit_kerja = UnitKerja::all();

        $pangkat_golongan = PangkatGolongan::with(['pangkat', 'golongan'])->get();

        return view('admin.data.tendik.index', compact(
            'tendik', 'totalTendik', 'tendikAktif', 'agama', 'unit_kerja', 'pangkat_golongan'
        ));
    }
    public function create()
    {
        // Ambil data untuk dropdown (sesuaikan dengan nama Model Anda)
        $pangkat_golongan = PangkatGolongan::with(['pangkat', 'golongan'])->get();
        $unit_kerja = UnitKerja::all();
        $agama = Agama::all();

        return view('admin.data.tendik.create', compact('pangkat_golongan', 'unit_kerja', 'agama'));
    }
    public function store(Request $request)
    {
        $request->validate([
            // Akun
            'email'               => 'required|email|unique:users,email',
            'password'            => 'required|min:6',

            // Data Kepegawaian Dasar (Wajib)
            'nama_lengkap'        => 'required|string|max:50',
            'id_unit_kerja'       => 'required|integer|exists:unit_kerja,id_unit_kerja',
            'id_pangkat_golongan' => 'required|integer|exists:pangkat_golongan,id_pangkat_golongan',

            // Opsional (Bisa diisi Admin sekarang, atau diisi Tendik nanti)
            'nip'                 => 'nullable|string|max:50',
            'id_jabatan'          => 'nullable|integer',
            'id_agama'            => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $roleTendik = Role::where('name', 'tendik')->first();
            $user->roles()->attach($roleTendik->getKey());

            Tendik::create([
                'id_user'             => $user->id_user,
                'nama_lengkap'        => $request->nama_lengkap,
                'status'              => 'Aktif', // Otomatis Aktif sesuai instruksimu
                'id_unit_kerja'       => $request->id_unit_kerja,
                'id_pangkat_golongan' => $request->id_pangkat_golongan,

                'nip'                 => $request->nip,
                'id_jabatan'          => $request->id_jabatan,
                'id_agama'            => $request->id_agama,
            ]);

            DB::commit();
            return redirect()->route('admin.data.tendik.index')->with('success', 'Akun & Profil Tendik berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $t = Tendik::findOrFail($id);

        $agama = Agama::all();
        $unit_kerja = UnitKerja::all();
        $pangkat_golongan = PangkatGolongan::with(['pangkat', 'golongan'])->get();

        return view('admin.data.tendik.edit', compact('t', 'agama', 'unit_kerja', 'pangkat_golongan'));
    }

    public function update(Request $request, $id)
    {
        $tendik = Tendik::findOrFail($id);
        $user = User::findOrFail($tendik->id_user);

        $request->validate([
            'nama_lengkap'        => 'required|string|max:50',
            'email'               => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'password'            => 'nullable|min:6',
            'status'              => 'required|in:Aktif,Tidak Aktif',
            'id_unit_kerja'       => 'required|integer|exists:unit_kerja,id_unit_kerja',
            'id_pangkat_golongan' => 'required|integer|exists:pangkat_golongan,id_pangkat_golongan',
            'nip'                 => 'nullable|string|max:50',
            'id_agama'            => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $tendik->update([
                'nama_lengkap'        => $request->nama_lengkap,
                'status'              => $request->status,
                'id_unit_kerja'       => $request->id_unit_kerja,
                'id_pangkat_golongan' => $request->id_pangkat_golongan,
                'nip'                 => $request->nip,
                'id_agama'            => $request->id_agama,
            ]);

            DB::commit();
            return redirect()->route('admin.data.tendik.index')->with('success', 'Data Tendik berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $tendik = Tendik::findOrFail($id);
        $user = User::findOrFail($tendik->id_user);

        DB::beginTransaction();
        try {
            $tendik->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('admin.data.tendik.index')->with('success', 'Data Tendik dan Akun berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        // Mengambil data tendik beserta semua relasinya
        $tendik = Tendik::with(['user', 'unitKerja', 'pangkatGolongan.pangkat', 'pangkatGolongan.golongan', 'jabatan', 'agama'])
                ->where('id_tendik', $id)
                ->firstOrFail();

        return view('admin.data.tendik.show', compact('tendik'));
    }

}
