<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Pembimbing;
use App\Models\Agama;
use App\Models\SiswaMagang;
use App\Models\PendidikanTerakhir;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // 👈 Wajib ditambah untuk menghandle file

class PembimbingController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembimbing::with(['user', 'agama', 'pendidikanTerakhir'])
                           ->withCount('siswaMagang');

        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('no_induk', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pembimbing = $query->orderBy('status', 'asc')
                            ->orderBy('nama_lengkap', 'asc')
                            ->paginate(10)->withQueryString();

        $totalPembimbing = Pembimbing::count();
        $totalBimbingan = SiswaMagang::whereNotNull('id_pembimbing')->count();

        return view('admin.data.pembimbing.index', compact('pembimbing', 'totalPembimbing', 'totalBimbingan'));
    }

    public function create()
    {
        $agama = Agama::all();
        $pendidikan = PendidikanTerakhir::all();

        return view('admin.data.pembimbing.create', compact('agama', 'pendidikan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'     => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:6',
            // 🚨 PERBAIKAN: Ubah numeric menjadi string & tambah regex untuk angka
            'no_induk'         => 'required|string|regex:/^[0-9]+$/|max:50|unique:pembimbing,no_induk',
            'jabatan'          => 'required|string|max:100',
            'no_telp'          => 'required|string|max:20',
            'id_agama'         => 'required|integer',
            'id_pend_terakhir' => 'required|integer',
            'foto_profil'      => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ], [
            'no_induk.unique'  => 'NIP / Nomor Induk tersebut sudah terdaftar di sistem!',
            // 🚨 PERBAIKAN: Ubah error key dari numeric menjadi regex
            'no_induk.regex'   => 'No Induk hanya boleh berisi karakter angka numerik.',
            'foto_profil.max'  => 'Ukuran foto profil maksimal 3 MB!',
            'foto_profil.image'=> 'File yang diupload harus berupa gambar (JPEG, PNG, JPG).'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $rolePembimbing = Role::firstOrCreate(['name' => 'Pembimbing']);
            $user->roles()->attach($rolePembimbing->getKey());

            // Handle Upload Foto Profil
            $fotoPath = null;
            if ($request->hasFile('foto_profil')) {
                $fotoPath = $request->file('foto_profil')->store('profil/pembimbing', 'public');
            }

            Pembimbing::create([
                'id_user'          => $user->id_user,
                'nama_lengkap'     => $request->nama_lengkap,
                'status'           => 'Aktif',
                'no_induk'         => $request->no_induk,
                'jabatan'          => $request->jabatan,
                'no_telp'          => $request->no_telp,
                'id_agama'         => $request->id_agama,
                'id_pend_terakhir' => $request->id_pend_terakhir,
                'foto_profil'      => $fotoPath, // 👈 Simpan path foto ke database
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
        $agama = Agama::all();
        $pendidikan = PendidikanTerakhir::all();

        return view('admin.data.pembimbing.edit', compact('pembimbing', 'agama', 'pendidikan'));
    }

    public function update(Request $request, $id)
    {
        $pembimbing = Pembimbing::findOrFail($id);
        $user = User::findOrFail($pembimbing->id_user);

        $request->validate([
            'nama_lengkap'     => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'password'         => 'nullable|min:6',
            'status'           => 'required|in:Aktif,Nonaktif',
            // 🚨 PERBAIKAN: Ubah numeric menjadi string & tambah regex untuk angka
            'no_induk'         => 'required|string|regex:/^[0-9]+$/|max:50|unique:pembimbing,no_induk,' . $pembimbing->id_pembimbing . ',id_pembimbing',
            'jabatan'          => 'required|string|max:100',
            'no_telp'          => 'required|string|max:20',
            'id_agama'         => 'required|integer',
            'id_pend_terakhir' => 'required|integer',

            'foto_profil'      => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ], [
             'no_induk.unique'  => 'NIP / Nomor Induk tersebut sudah terdaftar di sistem!',
             // 🚨 PERBAIKAN: Ubah error key dari numeric menjadi regex
             'no_induk.regex'   => 'No Induk hanya boleh berisi karakter angka numerik.',
             'foto_profil.max'  => 'Ukuran foto profil maksimal 3 MB!',
             'foto_profil.image'=> 'File yang diupload harus berupa gambar (JPEG, PNG, JPG).'
        ]);

        DB::beginTransaction();
        try {
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Handle Update Foto Profil
            $fotoPath = $pembimbing->foto_profil;
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
                // Simpan foto baru
                $fotoPath = $request->file('foto_profil')->store('profil/pembimbing', 'public');
            }

            $pembimbing->update([
                'nama_lengkap'     => $request->nama_lengkap,
                'status'           => $request->status,
                'no_induk'         => $request->no_induk,
                'jabatan'          => $request->jabatan,
                'no_telp'          => $request->no_telp,
                'id_agama'         => $request->id_agama,
                'id_pend_terakhir' => $request->id_pend_terakhir,
                'foto_profil'      => $fotoPath, // 👈 Update path foto
            ]);

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
            // Hapus foto dari storage saat akun dihapus
            if ($pembimbing->foto_profil && Storage::disk('public')->exists($pembimbing->foto_profil)) {
                Storage::disk('public')->delete($pembimbing->foto_profil);
            }

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
        $pembimbing = Pembimbing::with(['user', 'agama', 'pendidikanTerakhir'])
            ->withCount('siswaMagang')
            ->where('id_pembimbing', $id)
            ->firstOrFail();

        return view('admin.data.pembimbing.show', compact('pembimbing'));
    }
}
