<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kajur;
use Illuminate\Http\Request;

class KajurController extends Controller
{
    public function index(Request $request)
    {
        $query = Kajur::query();

        if ($request->filled('filter_periode')) {
            $query->where('periode', $request->filter_periode);
        }

        $kajurs = $query->orderBy('created_at', 'desc')->get();
        $listPeriode = Kajur::select('periode')->distinct()->orderBy('periode', 'desc')->pluck('periode');

        return view('admin.kajur.index', compact('kajurs', 'listPeriode'));
    }

    public function store(Request $request)
    {
        // VALIDASI KETAT NIP DAN TAHUN
        $request->validate([
            'nama_lengkap' => 'required|string',
            'nip' => 'required|numeric', // Harus murni angka
            'tahun_mulai' => 'required|numeric|digits:4',
            'tahun_selesai' => 'required|numeric|digits:4|gte:tahun_mulai', // Selesai >= Mulai
        ], [
            'nip.numeric' => 'NIP hanya boleh berisi karakter angka numerik.',
            'tahun_selesai.gte' => 'Tahun Selesai tidak boleh lebih kecil dari Tahun Mulai.'
        ]);

        $periodeGabungan = $request->tahun_mulai . ' - ' . $request->tahun_selesai;

        $isAktif = $request->has('status_aktif');
        if ($isAktif) {
            Kajur::where('status_aktif', true)->update(['status_aktif' => false]);
        }

        Kajur::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $request->nip,
            'periode' => $periodeGabungan,
            'status_aktif' => $isAktif,
        ]);

        return back()->with('success', 'Data Kajur berhasil ditambahkan!');
    }

    public function update(Request $request, $id_kajur)
    {
        // VALIDASI KETAT NIP DAN TAHUN
        $request->validate([
            'nama_lengkap' => 'required|string',
            'nip' => 'required|numeric', // Harus murni angka
            'tahun_mulai' => 'required|numeric|digits:4',
            'tahun_selesai' => 'required|numeric|digits:4|gte:tahun_mulai', // Selesai >= Mulai
        ], [
            'nip.numeric' => 'NIP hanya boleh berisi karakter angka numerik.',
            'tahun_selesai.gte' => 'Tahun Selesai tidak boleh lebih kecil dari Tahun Mulai.'
        ]);

        $periodeGabungan = $request->tahun_mulai . ' - ' . $request->tahun_selesai;

        $kajur = Kajur::findOrFail($id_kajur);
        $kajur->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $request->nip,
            'periode' => $periodeGabungan,
        ]);

        return back()->with('success', 'Data Kajur berhasil diperbarui!');
    }

    public function setAktif($id_kajur)
    {
        Kajur::where('status_aktif', true)->update(['status_aktif' => false]);
        Kajur::findOrFail($id_kajur)->update(['status_aktif' => true]);

        return back()->with('success', 'Status Kajur Aktif berhasil diperbarui!');
    }

    // FUNGSI BARU: HAPUS KAJUR
    public function destroy($id_kajur)
    {
        $kajur = Kajur::findOrFail($id_kajur);
        $kajur->delete();
        return back()->with('success', 'Data Kajur berhasil dihapus!');
    }
}
