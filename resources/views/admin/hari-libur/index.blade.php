@extends('layouts.admin')
@section('page_title', 'Hari Libur')

@section('content')
<main class="p-4 sm:p-6 lg:p-10 space-y-6 lg:space-y-8 animate-in">

    @if(session('success'))
        <div class="p-3 sm:p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 font-bold rounded-xl sm:rounded-2xl mb-4 text-xs sm:text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <section class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-6">
        <div class="flex items-center gap-2 sm:gap-4 p-1.5 sm:p-2 bg-maroon-50 w-full lg:w-fit rounded-2xl sm:rounded-3xl border border-maroon-100">
            <div class="px-4 sm:px-6 py-2 flex-1 text-center lg:text-left">
                <p class="text-[9px] sm:text-[10px] font-black text-maroon-400 uppercase tracking-widest">Tahun Aktif</p>
                <p class="text-lg sm:text-xl font-black text-maroon-950 tracking-tighter leading-none mt-0.5">{{ date('Y') }}</p>
            </div>
            <div class="w-[1px] h-8 bg-maroon-200 shrink-0"></div>
            <div class="px-4 sm:px-6 py-2 flex-1 text-center">
                <p class="text-[9px] sm:text-[10px] font-black text-maroon-400 uppercase tracking-widest">Total Libur</p>
                <p class="text-lg sm:text-xl font-black text-rose-600 tracking-tighter leading-none mt-0.5">{{ $totalHariLibur ?? 0 }} Hari</p>
            </div>
        </div>

        <button onclick="openModal('add')" class="w-full lg:w-auto bg-maroon-950 text-white px-6 py-3.5 sm:px-8 sm:py-4 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 active:scale-95 transition-all flex items-center justify-center gap-2 sm:gap-3 shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[18px] sm:h-[18px]"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Hari Libur
        </button>
    </section>

    <section class="bg-white rounded-3xl lg:rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
        <div class="px-5 sm:px-8 lg:px-10 py-5 sm:py-8 border-b border-maroon-50 flex items-center justify-between bg-white">
            <h3 class="text-base sm:text-lg font-black text-maroon-950 tracking-tight italic">Daftar Libur & Cuti Bersama</h3>
        </div>

        <div class="overflow-x-auto custom-scroll pb-2">
            <table class="w-full text-left border-collapse min-w-[550px] lg:min-w-[700px]">
                <thead>
                    <tr class="bg-maroon-50/20">
                        <th class="px-4 sm:px-6 lg:px-10 py-4 sm:py-6 text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest whitespace-nowrap">Tanggal</th>
                        <th class="px-4 sm:px-6 lg:px-10 py-4 sm:py-6 text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest">Nama Hari Libur / Keterangan</th>
                        <th class="px-4 sm:px-6 lg:px-10 py-4 sm:py-6 text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Kategori</th>
                        <th class="px-4 sm:px-6 lg:px-10 py-4 sm:py-6 text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Aksi</th>
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
                        <td class="px-4 sm:px-6 lg:px-10 py-4 sm:py-6 whitespace-nowrap">
                            <p class="text-xs sm:text-sm font-extrabold text-maroon-950 tracking-tight">
                                @if($libur->tanggal_mulai == $libur->tanggal_selesai)
                                    {{ $mulai->translatedFormat('d M Y') }}
                                @else
                                    {{ $mulai->format('d') }} - {{ $selesai->translatedFormat('d M Y') }}
                                @endif
                            </p>
                            <p class="text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase mt-0.5 sm:mt-1">{{ $durasi }} Hari</p>
                        </td>
                        <td class="px-4 sm:px-6 lg:px-10 py-4 sm:py-6">
                            <p class="text-xs sm:text-sm font-bold text-slate-700 leading-tight">{{ $libur->nama_libur }}</p>
                            <p class="text-[8px] sm:text-[9px] font-bold text-maroon-300 uppercase mt-0.5 sm:mt-1 italic">{{ $libur->keterangan ?? '-' }}</p>
                        </td>
                        <td class="px-4 sm:px-6 lg:px-10 py-4 sm:py-6 text-center">
                            <span class="inline-flex px-2 py-1 sm:px-3 sm:py-1.5 {{ $libur->kategori == 'cuti' ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600' }} rounded-md sm:rounded-lg text-[8px] sm:text-[9px] font-black uppercase tracking-tighter whitespace-nowrap">
                                {{ $libur->kategori == 'cuti' ? 'Cuti Bersama' : 'Hari Libur' }}
                            </span>
                        </td>
                        <td class="px-4 sm:px-6 lg:px-10 py-4 sm:py-6">
                            <div class="flex justify-end gap-1.5 sm:gap-2 text-right">
                                <button type="button" onclick="openModal('edit', {{ json_encode($libur) }})" class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg sm:rounded-xl bg-slate-50 text-slate-400 hover:bg-maroon-100 hover:text-maroon-900 transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                </button>

                                <form action="{{ route('admin.hari-libur.destroy', $libur->id_libur) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Diubah menggunakan button type="button" dengan onClick konfirmasi SweetAlert2 -->
                                    <button type="button" onclick="confirmDelete(event, this)" class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg sm:rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-100 hover:text-rose-600 transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 sm:px-10 py-6 sm:py-8 text-center text-slate-400 font-bold text-[10px] sm:text-xs uppercase tracking-widest">Belum ada data hari libur</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

<!-- MODAL TAMBAH/EDIT -->
<div id="crudModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-maroon-950/40 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="relative w-full max-w-lg animate-in zoom-in-95 duration-200">

        <!-- Ditambahkan onsubmit="confirmSave(event)" pada form -->
        <form id="liburForm" onsubmit="confirmSave(event)" action="{{ route('admin.hari-libur.store') }}" method="POST" class="bg-white rounded-3xl sm:rounded-[2.5rem] shadow-2xl overflow-hidden border border-maroon-100 flex flex-col">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="bg-maroon-950 px-5 py-4 sm:px-8 sm:py-6 text-white flex items-center justify-between shrink-0">
                <div>
                    <h3 id="modalTitle" class="text-base sm:text-lg font-black tracking-tight italic">Tambah Hari Libur</h3>
                </div>
                <button type="button" onclick="closeModal()" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-5 sm:p-8 space-y-4 sm:space-y-6">
                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Nama Hari Libur</label>
                    <input type="text" name="nama_libur" id="nama_libur" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Mulai Tanggal</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[10px] sm:text-xs font-bold focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Selesai Tanggal</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[10px] sm:text-xs font-bold focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                </div>

                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Kategori Libur</label>
                    <select name="kategori" id="kategori" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm cursor-pointer">
                        <option value="nasional">Hari Libur Nasional</option>
                        <option value="cuti">Cuti Bersama</option>
                    </select>
                </div>

                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Keterangan Tambahan</label>
                    <textarea name="keterangan" id="keterangan" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-maroon-500 outline-none resize-none transition-all shadow-sm"></textarea>
                </div>
            </div>

            <div class="p-5 sm:p-8 pt-0 flex gap-3 sm:gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-500 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest hover:bg-slate-200 transition-colors active:scale-95">Batal</button>
                <button type="submit" class="flex-[2] bg-maroon-950 text-white py-3.5 sm:py-4 px-6 sm:px-10 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 transition-all active:scale-95">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- TAMBAHKAN LIBRARY SWEETALERT 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('crudModal');
        const form = document.getElementById('liburForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('formMethod');

        if(mode === 'edit' && data) {
            title.textContent = "Edit Hari Libur";
            // Ganti action URL untuk Edit
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

    // FUNGSI KONFIRMASI SIMPAN (TAMBAH & EDIT) DENGAN SWEETALERT2
    function confirmSave(event) {
        event.preventDefault(); // Cegah submit otomatis
        const form = document.getElementById('liburForm');

        // Pastikan HTML5 validation bawaan browser berjalan (kolom required dsb)
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const isEdit = document.getElementById('formMethod').value === 'PUT';
        const actionText = isEdit ? 'menyimpan perubahan' : 'menambahkan';
        const titleText = isEdit ? 'Simpan Perubahan?' : 'Tambah Hari Libur?';

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: titleText,
                text: `Pastikan data hari libur yang akan Anda ${actionText} sudah benar.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4d182b', // Warna maroon-900
                cancelButtonColor: '#94a3b8',  // Warna slate-400
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true, // Tombol batal di kiri, simpan di kanan
                customClass: {
                    // Kelas khusus agar responsive di HP
                    popup: 'rounded-[2rem] p-4 sm:p-6 w-11/12 sm:w-auto',
                    title: 'text-lg sm:text-xl font-black text-maroon-950',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm shadow-lg',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Lanjutkan submit form jika user klik 'Ya'
                }
            });
        } else {
            // Fallback jika CDN SweetAlert gagal dimuat
            if (confirm(`Apakah Anda yakin ingin ${actionText} data hari libur ini?`)) {
                form.submit();
            }
        }
    }

    // FUNGSI KONFIRMASI HAPUS DENGAN SWEETALERT2
    function confirmDelete(event, button) {
        event.preventDefault(); // Cegah submit otomatis
        const form = button.closest('form');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Hari Libur?',
                text: "Data hari libur ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48', // Warna rose-600
                cancelButtonColor: '#94a3b8',  // Warna slate-400
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2rem] p-4 sm:p-6 w-11/12 sm:w-auto',
                    title: 'text-lg sm:text-xl font-black text-slate-800',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm shadow-lg',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form jika user menyetujui
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus data hari libur ini?')) {
                form.submit();
            }
        }
    }
</script>
@endsection