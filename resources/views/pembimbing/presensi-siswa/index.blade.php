@extends('layouts.pembimbing')

@section('content')
<!-- KONTEN UTAMA SISWA BIMBINGAN -->
<main class="max-w-7xl mx-auto p-5 lg:p-10">

    <!-- VIEW 1: MASTER LIST (SEMUA SISWA) -->
    <section id="view-master" class="animate-in space-y-8">

        <!-- HEADER & PENCARIAN -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <p class="text-slate-500 font-medium text-base italic leading-none mb-2 text-maroon-900/40">Monitoring Kehadiran,</p>
                <h2 class="text-3xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-tight italic">Pilih Siswa <br><span class="text-gold tracking-normal not-italic">Untuk Lihat Riwayat</span></h2>
            </div>
            <div class="relative group">
                <input type="text" placeholder="Cari nama siswa..." class="w-full md:w-64 bg-white border border-maroon-100 rounded-2xl px-10 py-3 text-xs font-bold text-maroon-900 shadow-sm focus:ring-2 focus:ring-maroon-500 outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 top-1/2 -translate-y-1/2 text-maroon-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
        </div>

        <!-- LIST CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            <!-- Student Card 1 -->
            <div onclick="goToDetail('Ahmad Fauzi')" class="bg-white rounded-[2.5rem] p-8 border border-maroon-50 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all cursor-pointer group">
                <div class="flex items-center gap-5 mb-8">
                    <div class="w-20 h-20 rounded-3xl bg-slate-100 overflow-hidden border-2 border-white group-hover:border-maroon-200 transition-all shadow-inner">
                        <img src="https://i.pravatar.cc/100?img=11" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-maroon-950 leading-none tracking-tight">Ahmad Fauzi</h4>
                        <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest italic">SMKN 5 Banjarmasin</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 py-6 border-t border-slate-50 text-center">
                    <div>
                        <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1">Hadir</p>
                        <p class="text-2xl font-black text-emerald-600 leading-none">45</p>
                    </div>
                    <div class="text-center border-x border-slate-50">
                        <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1">Telat</p>
                        <p class="text-2xl font-black text-amber-500 leading-none">02</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1">Alpa</p>
                        <p class="text-2xl font-black text-rose-500 leading-none">01</p>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-center gap-2 text-[10px] font-black text-maroon-900 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                    Lihat Detail Riwayat
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>

            <!-- Student Card 2 -->
            <div onclick="goToDetail('Budi Santoso')" class="bg-white rounded-[2.5rem] p-8 border border-maroon-50 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all cursor-pointer group">
                <div class="flex items-center gap-5 mb-8">
                    <div class="w-20 h-20 rounded-3xl bg-slate-100 overflow-hidden border-2 border-white group-hover:border-maroon-200 transition-all shadow-inner">
                        <img src="https://i.pravatar.cc/100?img=1" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-maroon-950 leading-none tracking-tight">Budi Santoso</h4>
                        <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest italic">SMK N 2 Banjarmasin</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 py-6 border-t border-slate-50 text-center">
                    <div>
                        <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1">Hadir</p>
                        <p class="text-2xl font-black text-emerald-600 leading-none">42</p>
                    </div>
                    <div class="text-center border-x border-slate-50">
                        <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1">Telat</p>
                        <p class="text-2xl font-black text-amber-500 leading-none">05</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1">Alpa</p>
                        <p class="text-2xl font-black text-rose-500 leading-none">03</p>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-center gap-2 text-[10px] font-black text-maroon-900 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                    Lihat Detail Riwayat
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>

        </div>
    </section>
</main>

<!-- SCRIPT UNTUK NAVIGASI KE DETAIL -->
<script>
    function goToDetail(studentName) {
        // Nanti bisa diganti dengan route URL dinamis, misalnya:
        // window.location.href = "{{ url('/pembimbing/siswa') }}/" + studentName;
        console.log("Navigasi ke detail riwayat: " + studentName);
        alert("Nanti ini akan pindah ke halaman detail riwayat " + studentName);
    }
</script>
@endsection
