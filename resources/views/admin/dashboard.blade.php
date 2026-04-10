@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col items-center justify-center">
        <i data-lucide="users" class="w-8 h-8 text-slate-400 mb-3"></i>
        <div class="text-3xl font-black text-slate-800 tracking-tight">{{ $stats['patients_today'] }}</div>
        <div class="text-sm font-medium text-slate-500 uppercase tracking-widest mt-1">Total Pasien</div>
    </div>
    
    <div class="bg-amber-50 rounded-2xl p-6 border border-amber-200 shadow-sm flex flex-col items-center justify-center">
        <i data-lucide="clock" class="w-8 h-8 text-amber-500 mb-3"></i>
        <div class="text-3xl font-black text-amber-700 tracking-tight">{{ $stats['waiting'] }}</div>
        <div class="text-sm font-medium text-amber-600 uppercase tracking-widest mt-1">Antri/Menunggu</div>
    </div>
    
    <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200 shadow-sm flex flex-col items-center justify-center">
        <i data-lucide="activity" class="w-8 h-8 text-blue-500 mb-3"></i>
        <div class="text-3xl font-black text-blue-700 tracking-tight">{{ $stats['serving'] }}</div>
        <div class="text-sm font-medium text-blue-600 uppercase tracking-widest mt-1">Dilayani</div>
    </div>
    
    <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-200 shadow-sm flex flex-col items-center justify-center">
        <i data-lucide="check-circle-2" class="w-8 h-8 text-emerald-500 mb-3"></i>
        <div class="text-3xl font-black text-emerald-700 tracking-tight">{{ $stats['done'] }}</div>
        <div class="text-sm font-medium text-emerald-600 uppercase tracking-widest mt-1">Selesai</div>
    </div>
    
    <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-2xl p-6 border border-teal-600 shadow-md text-white flex flex-col items-center justify-center">
        <i data-lucide="banknote" class="w-8 h-8 text-teal-200 mb-3 opacity-80"></i>
        <div class="text-2xl font-black tracking-tight" title="Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}">
            Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}
        </div>
        <div class="text-sm font-medium text-teal-100 uppercase tracking-widest mt-1">Pendapatan</div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
            <i data-lucide="list-ordered" class="w-5 h-5 text-slate-400"></i> Antrian Terbaru
        </h3>
        <a href="{{ route('admin.queue.index') }}" class="text-sm font-semibold text-teal-600 hover:text-teal-700 flex items-center gap-1 transition-colors">
            Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-semibold border-b border-slate-200">
                    <th class="px-6 py-4">No. Urut</th>
                    <th class="px-6 py-4">Nama Pasien</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Waktu Daftar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($recentQueues as $queue)
                <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-700 font-bold text-sm">
                            {{ $queue->queue_number }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $queue->patient->name }}</td>
                    <td class="px-6 py-4">
                        @if($queue->status === 'waiting')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">Menunggu</span>
                        @elseif($queue->status === 'called')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200 animate-pulse">Dipanggil</span>
                        @elseif($queue->status === 'serving')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">Dilayani</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">Selesai</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right text-slate-500 font-medium text-sm">{{ $queue->created_at->format('H:i') }}</td>
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
