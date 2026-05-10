@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">

    <!-- FILTER BAR -->
    <section class="bg-white rounded-[2.5rem] p-8 border border-maroon-50 shadow-premium">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Cari Siswa</label>
                <div class="relative">
                    <input type="text" placeholder="Nama atau NIS..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 pl-10 text-xs font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Status Validasi</label>
                <select class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-maroon-950 outline-none cursor-pointer">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu (Pending)</option>
                    <option value="accepted">Diterima (Accepted)</option>
                    <option value="rejected">Ditolak (Rejected)</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Periode Bulan</label>
                <select class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-maroon-950 outline-none cursor-pointer">
                    <option value="4">April 2024</option>
                    <option value="3">Maret 2024</option>
                </select>
            </div>
            <button class="bg-maroon-950 text-white py-3.5 rounded-xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 active:scale-95 transition-all">Terapkan Filter</button>
        </div>
    </section>

    <!-- LOG FEED TABLE -->
    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-maroon-50/30">
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest w-1/5">Siswa & Tanggal</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest w-2/5 text-center">Uraian Pekerjaan</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest w-1/5 text-center">Status & Pembimbing</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest w-1/5 text-right">Catatan Respon</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50/50">

                    <!-- Row 1: Menunggu -->
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200 group">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shrink-0 border-2 border-white group-hover:border-maroon-100">
                                    <img src="https://i.pravatar.cc/100?img=11" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-tight">Ahmad Fauzi</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter italic">Senin, 15 April 2024</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 italic text-[11px] font-semibold text-slate-600 leading-relaxed shadow-inner">
                                "Melakukan pemeliharaan rutin pada server lokal di Lab Elektro dan mendokumentasikan topologi jaringan baru."
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center space-y-2">
                            <span class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Menunggu</span>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Oleh: Dr. Heru S.</p>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">Belum ada respon</p>
                        </td>
                    </tr>

                    <!-- Row 2: Diterima -->
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200 group">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shrink-0 border-2 border-white group-hover:border-maroon-100">
                                    <img src="https://i.pravatar.cc/100?img=1" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-tight">Budi Santoso</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter italic">Senin, 15 April 2024</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 italic text-[11px] font-semibold text-slate-600 leading-relaxed">
                                "Instalasi sistem operasi pada workstation laboratorium Komputer Dasar."
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center space-y-2">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Diterima ✅</span>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Oleh: Siti Aminah</p>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <p class="text-[10px] font-bold text-emerald-700/60 leading-snug italic">"Pekerjaan bagus, lanjutkan dokumentasinya."</p>
                        </td>
                    </tr>

                    <!-- Row 3: Ditolak -->
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200 group">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shrink-0 border-2 border-white group-hover:border-maroon-100">
                                    <img src="https://i.pravatar.cc/100?img=3" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-tight">Rian Hidayat</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter italic">Jumat, 12 April 2024</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 italic text-[11px] font-semibold text-slate-400 leading-relaxed line-through">
                                "Membantu beres-beres laboratorium."
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center space-y-2">
                            <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Ditolak ❌</span>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Oleh: Dr. Heru S.</p>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <p class="text-[10px] font-bold text-rose-700 leading-snug italic">"Laporan terlalu umum, jelaskan detail teknisnya."</p>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-10 py-8 border-t border-maroon-50 bg-maroon-50/10 flex items-center justify-between">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Menampilkan data logbook periode berjalan</p>
            <div class="flex gap-2">
                <button class="w-10 h-10 rounded-xl bg-white border border-maroon-100 flex items-center justify-center text-maroon-900 shadow-sm active:scale-90 transition-all"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg></button>
                <button class="w-10 h-10 rounded-xl bg-white border border-maroon-100 flex items-center justify-center text-maroon-900 shadow-sm active:scale-90 transition-all"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></button>
            </div>
        </div>
    </section>
</main>
@endsection
