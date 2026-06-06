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

        // LOGIKA FILTER PERIODE
        if ($request->filled('filter_periode')) {
            $query->where('periode', $request->filter_periode);
        }

        $kajurs = $query->orderBy('created_at', 'desc')->get();

        // Ambil daftar periode unik yang ada di database untuk dropdown filter
        $listPeriode = Kajur::select('periode')->distinct()->orderBy('periode', 'desc')->pluck('periode');

        return view('admin.kajur.index', compact('kajurs', 'listPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'nip' => 'required|string',
            'tahun_mulai' => 'required|numeric|digits:4',
            'tahun_selesai' => 'required|numeric|digits:4',
        ]);

        // Gabungkan tahun mulai dan tahun selesai menjadi 1 string ("2022 - 2026")
        $periodeGabungan = $request->tahun_mulai . ' - ' . $request->tahun_selesai;

        $isAktif = $request->has('status_aktif');
        if ($isAktif) {
            Kajur::where('status_aktif', true)->update(['status_aktif' => false]);
        }

        Kajur::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $request->nip,
            'periode' => $periodeGabungan, // Masukkan string gabungan
            'status_aktif' => $isAktif,
        ]);

        return back()->with('success', 'Data Kajur berhasil ditambahkan!');
    }

    // FUNGSI BARU: UPDATE DATA KAJUR
    public function update(Request $request, $id_kajur)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'nip' => 'required|string',
            'tahun_mulai' => 'required|numeric|digits:4',
            'tahun_selesai' => 'required|numeric|digits:4',
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
}
