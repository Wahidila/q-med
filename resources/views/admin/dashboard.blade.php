@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] flex flex-col items-center justify-center group hover:-translate-y-1 transition-all duration-300">
        <div class="p-3 bg-slate-50 text-slate-400 rounded-xl mb-4 group-hover:bg-slate-100 group-hover:text-slate-600 transition-colors">
            <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <div class="text-4xl font-black text-slate-800 tracking-tight">{{ $stats['patients_today'] }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Total Pasien</div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] flex flex-col items-center justify-center group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-amber-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-3 bg-amber-50 text-amber-500 rounded-xl mb-4 relative z-10">
            <i data-lucide="clock" class="w-6 h-6"></i>
        </div>
        <div class="text-4xl font-black text-slate-800 tracking-tight relative z-10">{{ $stats['waiting'] }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2 relative z-10">Menunggu</div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] flex flex-col items-center justify-center group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-3 bg-blue-50 text-blue-500 rounded-xl mb-4 relative z-10">
            <i data-lucide="activity" class="w-6 h-6"></i>
        </div>
        <div class="text-4xl font-black text-slate-800 tracking-tight relative z-10">{{ $stats['serving'] }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2 relative z-10">Dilayani</div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] flex flex-col items-center justify-center group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-3 bg-emerald-50 text-emerald-500 rounded-xl mb-4 relative z-10">
            <i data-lucide="check-circle-2" class="w-6 h-6"></i>
        </div>
        <div class="text-4xl font-black text-slate-800 tracking-tight relative z-10">{{ $stats['done'] }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2 relative z-10">Selesai</div>
    </div>
    
    <div class="bg-gradient-to-br from-teal-600 to-teal-800 rounded-2xl p-6 border border-teal-700 shadow-[0_8px_30px_-12px_rgba(13,148,136,0.5)] text-white flex flex-col items-center justify-center group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-4 -top-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
            <i data-lucide="banknote" class="w-24 h-24"></i>
        </div>
        <div class="p-3 bg-white/10 text-teal-100 rounded-xl mb-4 backdrop-blur-sm relative z-10">
            <i data-lucide="wallet" class="w-6 h-6"></i>
        </div>
        <div class="text-2xl font-black tracking-tight relative z-10" title="Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}">
            Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}
        </div>
        <div class="text-xs font-bold text-teal-200/80 uppercase tracking-widest mt-2 relative z-10">Pendapatan</div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
        <h3 class="font-extrabold text-slate-800 flex items-center gap-3 text-lg tracking-tight">
            <div class="p-2 bg-slate-50 rounded-lg text-slate-400"><i data-lucide="list-ordered" class="w-5 h-5"></i></div> 
            Antrian Terbaru
        </h3>
        <a href="{{ route('admin.queue.index') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700 flex items-center gap-1.5 transition-colors bg-teal-50 px-4 py-2 rounded-xl hover:bg-teal-100">
            Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50">
                <tr class="text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                    <th class="px-8 py-5">No. Urut</th>
                    <th class="px-8 py-5">Nama Pasien</th>
                    <th class="px-8 py-5">Status</th>
                    <th class="px-8 py-5 text-right">Waktu Daftar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($recentQueues as $queue)
                <tr class="hover:bg-slate-50/80 transition-colors duration-200 group">
                    <td class="px-8 py-5">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-700 font-black text-sm border border-slate-200 shadow-sm group-hover:border-teal-200 group-hover:text-teal-700 group-hover:bg-teal-50 transition-colors">
                            {{ $queue->queue_number }}
                        </div>
                    </td>
                    <td class="px-8 py-5 font-bold text-slate-800">{{ $queue->patient->name }}</td>
                    <td class="px-8 py-5">
                        @if($queue->status === 'waiting')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200 shadow-sm">Menunggu</span>
                        @elseif($queue->status === 'called')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200 shadow-sm animate-pulse">Dipanggil</span>
                        @elseif($queue->status === 'serving')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200 shadow-sm">Dilayani</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm">Selesai</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right text-slate-500 font-semibold text-sm">{{ $queue->created_at->format('H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center">
                            <i data-lucide="inbox" class="w-10 h-10 mb-2 opacity-50"></i>
                            <p>Belum ada antrian yang terdaftar hari ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
