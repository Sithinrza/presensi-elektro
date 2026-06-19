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
use App\Models\PendidikanTerakhir;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TendikController extends Controller
{
    public function index(Request $request)
    {
        $query = Tendik::with(['user', 'agama', 'unitKerja', 'pangkatGolongan.pangkat', 'pangkatGolongan.golongan']);

        // Filter Pencarian (Nama / NIP)
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
        }

        // Filter Status Aktif/Nonaktif
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Urutkan Aktif duluan, lalu nama, lalu Pagination
        $tendik = $query->orderBy('status', 'asc')
                        ->orderBy('nama_lengkap', 'asc')
                        ->paginate(10)->withQueryString();

        $totalTendik = Tendik::count();
        $tendikAktif = Tendik::where('status', 'Aktif')->count();

        return view('admin.data.tendik.index', compact('tendik', 'totalTendik', 'tendikAktif'));
    }

    public function create()
    {
        $agama = Agama::all();
        $unit_kerja = UnitKerja::all();
        $pangkat_golongan = PangkatGolongan::with(['pangkat', 'golongan'])->get();
        $pendidikan = PendidikanTerakhir::all();
        $jabatan = Jabatan::all();

        return view('admin.data.tendik.create', compact('agama', 'unit_kerja', 'pangkat_golongan', 'pendidikan', 'jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // WAJIB
            'nama_lengkap'        => 'required|string|max:100',
            'email'               => 'required|email|unique:users,email',
            'password'            => 'required|min:6',
            'id_unit_kerja'       => 'required|integer|exists:unit_kerja,id_unit_kerja',
            'id_pangkat_golongan' => 'required|integer|exists:pangkat_golongan,id_pangkat_golongan',

            // OPSIONAL (DIBERI VALIDASI UNIQUE UNTUK NIP)
            'nip'                 => 'nullable|string|max:50|unique:tendik,nip',

            'id_jabatan'          => 'nullable|integer',
            'id_agama'            => 'nullable|integer',
            'id_pend_terakhir'    => 'nullable|integer',
            'jk'                  => 'nullable|in:L,P',
            'tempat_lahir'        => 'nullable|string|max:50',
            'tanggal_lahir'       => 'nullable|date',
            'no_hp'               => 'nullable|string|max:20',
            'alamat'              => 'nullable|string',
            'foto_profil'         => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ], [
            'nip.unique' => 'NIP / NIDN tersebut sudah terdaftar di sistem!',
            'foto_profil.max'  => 'Ukuran foto profil maksimal 3 MB!',
             'foto_profil.image'=> 'File yang diupload harus berupa gambar (JPEG, PNG, JPG).'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $roleTendik = Role::firstOrCreate(['name' => 'tendik']);
            $user->roles()->attach($roleTendik->getKey());

            $fotoPath = null;
            if ($request->hasFile('foto_profil')) {
                $fotoPath = $request->file('foto_profil')->store('profil/tendik', 'public');
            }

            Tendik::create([
                'id_user'             => $user->id_user,
                'status'              => 'Aktif',
                'nama_lengkap'        => $request->nama_lengkap,
                'id_unit_kerja'       => $request->id_unit_kerja,
                'id_pangkat_golongan' => $request->id_pangkat_golongan,
                'nip'                 => $request->nip,
                'id_jabatan'          => $request->id_jabatan,
                'id_agama'            => $request->id_agama,
                'id_pend_terakhir'    => $request->id_pend_terakhir,
                'jk'                  => $request->jk,
                'tempat_lahir'        => $request->tempat_lahir,
                'tanggal_lahir'       => $request->tanggal_lahir,
                'no_hp'               => $request->no_hp,
                'alamat'              => $request->alamat,
                'foto_profil'         => $fotoPath,
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
        $tendik = Tendik::findOrFail($id);
        $agama = Agama::all();
        $unit_kerja = UnitKerja::all();
        $pangkat_golongan = PangkatGolongan::with(['pangkat', 'golongan'])->get();
        $pendidikan = PendidikanTerakhir::all();
        $jabatan = Jabatan::all();

        return view('admin.data.tendik.edit', compact('tendik', 'agama', 'unit_kerja', 'pangkat_golongan', 'pendidikan', 'jabatan'));
    }

    public function update(Request $request, $id)
    {
        $tendik = Tendik::findOrFail($id);
        $user = User::findOrFail($tendik->id_user);

        $request->validate([
            // WAJIB
            'nama_lengkap'        => 'required|string|max:100',
            'email'               => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'password'            => 'nullable|min:6',
            'status'              => 'required|in:Aktif,Nonaktif',
            'id_unit_kerja'       => 'required|integer|exists:unit_kerja,id_unit_kerja',
            'id_pangkat_golongan' => 'required|integer|exists:pangkat_golongan,id_pangkat_golongan',

            'nip'                 => 'nullable|numeric|max:50|unique:tendik,nip,' . $tendik->id_tendik . ',id_tendik',

            'id_jabatan'          => 'nullable|integer',
            'id_agama'            => 'nullable|integer',
            'id_pend_terakhir'    => 'nullable|integer',
            'jk'                  => 'nullable|in:L,P',
            'tempat_lahir'        => 'nullable|string|max:50',
            'tanggal_lahir'       => 'nullable|date',
            'no_hp'               => 'nullable|string|max:20',
            'alamat'              => 'nullable|string',
            'foto_profil'         => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ], [
            'nip.unique' => 'NIP / NIDN tersebut sudah digunakan oleh staf lain!',
            'foto_profil.max'  => 'Ukuran foto profil maksimal 3 MB!',
             'foto_profil.image'=> 'File yang diupload harus berupa gambar (JPEG, PNG, JPG).',

             'nip.numeric'       => 'NIP hanya boleh berisi karakter angka numerik.',
        ]);

        DB::beginTransaction();
        try {
            $userData = ['email' => $request->email];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            $fotoPath = $tendik->foto_profil;
            if ($request->hasFile('foto_profil')) {
                if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
                $fotoPath = $request->file('foto_profil')->store('profil/tendik', 'public');
            }

            $tendik->update([
                'status'              => $request->status,
                'nama_lengkap'        => $request->nama_lengkap,
                'id_unit_kerja'       => $request->id_unit_kerja,
                'id_pangkat_golongan' => $request->id_pangkat_golongan,
                'nip'                 => $request->nip,
                'id_jabatan'          => $request->id_jabatan,
                'id_agama'            => $request->id_agama,
                'id_pend_terakhir'    => $request->id_pend_terakhir,
                'jk'                  => $request->jk,
                'tempat_lahir'        => $request->tempat_lahir,
                'tanggal_lahir'       => $request->tanggal_lahir,
                'no_hp'               => $request->no_hp,
                'alamat'              => $request->alamat,
                'foto_profil'         => $fotoPath,
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
        $tendik = Tendik::with(['user', 'unitKerja', 'pangkatGolongan.pangkat', 'pangkatGolongan.golongan', 'jabatan', 'agama', 'pendidikanTerakhir'])
                ->where('id_tendik', $id)
                ->firstOrFail();

        return view('admin.data.tendik.show', compact('tendik'));
    }
}
