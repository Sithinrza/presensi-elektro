@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 font-bold rounded-2xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <section class="flex flex-col xl:flex-row xl:items-center justify-between gap-6">
        <div class="flex items-center gap-4 p-2 bg-maroon-50 w-fit rounded-3xl border border-maroon-100">
            <div class="px-6 py-2">
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Tahun Aktif</p>
                <p class="text-xl font-black text-maroon-950 tracking-tighter">{{ date('Y') }}</p>
            </div>
            <div class="w-[1px] h-8 bg-maroon-200"></div>
            <div class="px-6 py-2 text-center">
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Total Libur</p>
                <p class="text-xl font-black text-rose-600 tracking-tighter">{{ $totalHariLibur ?? 0 }} Hari</p>
            </div>
        </div>

        <button onclick="openModal('add')" class="bg-maroon-950 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 active:scale-95 transition-all flex items-center justify-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Hari Libur
        </button>
    </section>

    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
        <div class="px-10 py-8 border-b border-maroon-50 flex items-center justify-between bg-white">
            <h3 class="text-lg font-black text-maroon-950 tracking-tight italic">Daftar Libur & Cuti Bersama</h3>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-maroon-50/20">
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Tanggal</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Nama Hari Libur / Keterangan</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Kategori</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50/50">
                    @forelse($dataLibur as $libur)
                        @php
                            $mulai = \Carbon\Carbon::parse($libur->tanggal_mulai);
                            $selesai = \Carbon\Carbon::parse($libur->tanggal_selesai);
                            $durasi = $mulai->diffInDays($selesai) + 1;
                        @endphp
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200">
                        <td class="px-10 py-6">
                            <p class="text-sm font-extrabold text-maroon-950 tracking-tight">
                                @if($libur->tanggal_mulai == $libur->tanggal_selesai)
                                    {{ $mulai->translatedFormat('d F Y') }}
                                @else
                                    {{ $mulai->format('d') }} - {{ $selesai->translatedFormat('d F Y') }}
                                @endif
                            </p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">{{ $durasi }} Hari</p>
                        </td>
                        <td class="px-10 py-6">
                            <p class="text-sm font-bold text-slate-700 leading-tight">{{ $libur->nama_libur }}</p>
                            <p class="text-[9px] font-bold text-maroon-300 uppercase mt-1 italic">{{ $libur->keterangan ?? '-' }}</p>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <span class="px-3 py-1 {{ $libur->kategori == 'cuti' ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600' }} rounded-lg text-[9px] font-black uppercase tracking-tighter">
                                {{ $libur->kategori == 'cuti' ? 'Cuti Bersama' : 'Hari Libur' }}
                            </span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex justify-end gap-2 text-right">
                                <button onclick="openModal('edit', {{ json_encode($libur) }})" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-maroon-100 hover:text-maroon-900 transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                </button>

                                <form action="{{ route('admin.hari-libur.destroy', $libur->id_libur) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus libur ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-100 hover:text-rose-600 transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-10 py-8 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada data hari libur</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

<div id="crudModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-maroon-950/40 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="relative w-full max-w-lg animate-in">

        <form id="liburForm" action="{{ route('admin.hari-libur.store') }}" method="POST" class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-maroon-100 flex flex-col">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="bg-maroon-950 px-8 py-6 text-white flex items-center justify-between shrink-0">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black tracking-tight italic">Tambah Hari Libur</h3>
                </div>
                <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-8 space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Nama Hari Libur</label>
                    <input type="text" name="nama_libur" id="nama_libur" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Mulai Tanggal</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Selesai Tanggal</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold outline-none">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Kategori Libur</label>
                    <select name="kategori" id="kategori" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold outline-none">
                        <option value="nasional">Hari Libur Nasional</option>
                        <option value="cuti">Cuti Bersama</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Keterangan Tambahan</label>
                    <textarea name="keterangan" id="keterangan" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none resize-none"></textarea>
                </div>
            </div>

            <div class="p-8 pt-0 flex gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-500 py-4 rounded-2xl font-black text-xs uppercase tracking-widest">Batal</button>
                <button type="submit" class="flex-2 bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('crudModal');
        const form = document.getElementById('liburForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('formMethod');

        if(mode === 'edit' && data) {
            title.textContent = "Edit Hari Libur";
            // Ganti action URL untuk Edit (Sesuaikan dengan nama rute kamu)
            form.action = `/admin/hari-libur/${data.id_libur}`;
            methodInput.value = 'PUT'; // Ubah method jadi PUT

            // Isi form dengan data lama
            document.getElementById('nama_libur').value = data.nama_libur;
            document.getElementById('tanggal_mulai').value = data.tanggal_mulai;
            document.getElementById('tanggal_selesai').value = data.tanggal_selesai;
            document.getElementById('kategori').value = data.kategori;
            document.getElementById('keterangan').value = data.keterangan || '';
        } else {
            title.textContent = "Tambah Hari Libur";
            // Kembalikan ke URL Store
            form.action = "{{ route('admin.hari-libur.store') }}";
            methodInput.value = 'POST'; // Kembalikan ke POST
            form.reset(); // Bersihkan form
        }

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('crudModal').classList.add('hidden');
    }
</script>
@endsection
