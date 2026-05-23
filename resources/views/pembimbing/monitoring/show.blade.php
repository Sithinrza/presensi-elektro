@extends('layouts.pembimbing')

@section('content')
<main class="max-w-5xl mx-auto p-5 lg:p-10 space-y-8 animate-in">
    <div class="space-y-8">
        @forelse($riwayatLog as $log)
        <div class="bg-white rounded-[2.5rem] p-8 border border-maroon-50 relative overflow-hidden group border-l-8 {{ $log->status == 'diterima' ? 'border-l-emerald-400' : ($log->status == 'ditolak' ? 'border-l-rose-400' : 'border-l-amber-400') }}">

            <div class="space-y-6">
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-sm">
                    "{{ $log->description }}"
                </div>

                @if($log->status == 'pending')
                    <form action="{{ route('pembimbing.monitoring.validasi', $log->id_log) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <textarea name="catatan_pembimbing" rows="2" class="w-full p-4 border rounded-2xl"></textarea>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" name="status" value="diterima" class="flex-1 bg-emerald-500 text-white py-3 rounded-2xl uppercase font-black text-[10px]">Terima</button>
                            <button type="submit" name="status" value="ditolak" class="flex-1 bg-rose-50 text-rose-600 py-3 rounded-2xl uppercase font-black text-[10px]">Tolak</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
        @empty
            <div class="text-center p-10">Belum ada jurnal.</div>
        @endforelse
    </div>
</main>
@endsection
