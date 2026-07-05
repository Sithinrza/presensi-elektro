<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HariLiburController extends Controller
{
    public function index()
    {
        // Ambil data libur, urutkan dari yang terbaru
        $dataLibur = HariLibur::orderBy('tanggal_mulai', 'desc')->get();

        // Hitung total hari libur di tahun ini (opsional untuk header)
        $totalHariLibur = 0;
        foreach ($dataLibur as $libur) {
            $mulai = Carbon::parse($libur->tanggal_mulai);
            $selesai = Carbon::parse($libur->tanggal_selesai);
            $totalHariLibur += $mulai->diffInDays($selesai) + 1;
        }

        return view('admin.hari-libur.index', compact('dataLibur', 'totalHariLibur'));
    }

    public function store(Request $request)
    {
        // 1. Tambahkan Validasi
        $request->validate([
            'nama_libur' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'kategori' => 'required',
        ], [
            // Pesan error custom biar bahasanya enak dibaca
            'tanggal_selesai.after_or_equal' => 'Selesai tanggal tidak boleh lebih mundur dari mulai tanggal!'
        ]);

        HariLibur::create([
            'nama_libur' => $request->nama_libur,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal_mulai,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Hari libur berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // 1. Tambahkan Validasi
        $request->validate([
            'nama_libur' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'kategori' => 'required',
        ], [
            'tanggal_selesai.after_or_equal' => 'Selesai tanggal tidak boleh lebih mundur dari mulai tanggal!'
        ]);

        $libur = HariLibur::findOrFail($id);
        $libur->update([
            'nama_libur' => $request->nama_libur,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal_mulai,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Hari libur berhasil diubah!');
    }

    public function destroy($id)
    {
        HariLibur::findOrFail($id)->delete();
        return back()->with('success', 'Hari libur berhasil dihapus!');
    }
}
