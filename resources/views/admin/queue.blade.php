@extends('layouts.admin')
@section('page-title', 'Manajemen Antrian')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <form action="{{ route('admin.queue.callNext') }}" method="POST">
        @csrf
        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-xl shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
            <i data-lucide="megaphone" class="w-5 h-5 mr-2"></i> Panggil Berikutnya
        </button>
    </form>
    <a href="{{ route('admin.registration.index') }}" class="inline-flex items-center px-4 py-2.5 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Pasien Baru
    </a>
</div>

@if($currentServing)
<div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-2xl p-8 mb-8 text-white shadow-lg relative overflow-hidden flex flex-col items-center">
    <div class="absolute -right-10 -top-10 opacity-10">
        <i data-lucide="activity" class="w-48 h-48"></i>
    </div>
    
    <div class="text-sm font-bold tracking-widest uppercase text-teal-100 mb-2">Sedang Dilayani / Dipanggil</div>
    <div class="text-6xl font-black tracking-tighter mb-4">#{{ str_pad($currentServing->queue_number, 3, '0', STR_PAD_LEFT) }}</div>
    <div class="text-2xl font-semibold mb-2">{{ $currentServing->patient->name }}</div>
    
    <div class="mt-2">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 text-white border border-white/30 backdrop-blur-sm shadow-sm">
            {{ $currentServing->status === 'serving' ? 'Sedang Dilayani' : 'Sedang Dipanggil' }}
        </span>
    </div>
</div>
@endif

<div x-data="{ 
    showModal: false, 
    queueId: null, 
    patientName: '', 
    description: '', 
    cost: '',
    openModal(id, name) { 
        this.queueId = id; 
        this.patientName = name; 
        this.description = ''; 
        this.cost = ''; 
        this.showModal = true; 
    } 
}">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2 text-lg">
                <i data-lucide="list" class="w-5 h-5 text-slate-400"></i> Daftar Antrian Hari Ini
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-semibold border-b border-slate-200">
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">Nama Pasien</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($queues as $queue)
                    <tr class="hover:bg-slate-50/80 transition-colors duration-150 {{ $queue->status === 'called' ? 'bg-amber-50/50' : ($queue->status === 'serving' ? 'bg-blue-50/50' : '') }}">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-700 font-bold text-sm border border-slate-200">
                                {{ $queue->queue_number }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $queue->patient->name }}</td>
                        <td class="px-6 py-4">
                            @if($queue->status === 'waiting')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">Menunggu</span>
                            @elseif($queue->status === 'called')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">Dipanggil</span>
                            @elseif($queue->status === 'serving')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">Dilayani</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-medium text-sm">{{ $queue->created_at->format('H:i') }}</td>
                        <td class="px-6 py-4 text-right">
                            @if($queue->status === 'called')
                                <form action="{{ route('admin.queue.startService', $queue) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition">
                                        <i data-lucide="play-circle" class="w-3.5 h-3.5 mr-1.5"></i> Mulai
                                    </button>
                                </form>
                            @elseif($queue->status === 'serving')
                                <button type="button" @click="openModal({{ $queue->id }}, '{{ addslashes($queue->patient->name) }}')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 transition">
                                    <i data-lucide="check-square" class="w-3.5 h-3.5 mr-1.5"></i> Selesai
                                </button>
                            @elseif($queue->status === 'waiting')
                                <form action="{{ route('admin.queue.skip', $queue) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin melewati pasien ini?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-slate-300 text-xs font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition">
                                        <i data-lucide="skip-forward" class="w-3.5 h-3.5 mr-1.5"></i> Lewati
                                    </button>
                                </form>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <i data-lucide="users" class="w-10 h-10 mb-2 opacity-50"></i>
                                <p>Belum ada antrian hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Alpine.js Modal for Complete Service --}}
    <div x-show="showModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="showModal" x-transition.opacity.duration.300ms class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showModal" @click.away="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    
                    <form :action="`/admin/queue/${queueId}/complete`" method="POST">
                        @csrf
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10 mb-4 sm:mb-0">
                                    <i data-lucide="check-circle-2" class="h-6 w-6 text-emerald-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-lg font-bold leading-6 text-slate-900" id="modal-title">Selesaikan Pelayanan</h3>
                                    <div class="mt-1 mb-5">
                                        <p class="text-sm text-slate-500">Isi data pelayanan untuk pasien <span class="font-bold text-slate-800" x-text="patientName"></span>.</p>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Hasil Pelayanan <span class="text-red-500">*</span></label>
                                            <textarea name="description" x-model="description" required rows="3" class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm resize-none" placeholder="Catatan diagnosis atau tindakan..."></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Biaya Pelayanan (Rp) <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-slate-500 font-medium sm:text-sm">Rp</span>
                                                </div>
                                                <input type="number" name="cost" x-model="cost" required min="0" step="1000" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm" placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                            <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 sm:ml-3 sm:w-auto transition-colors">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan
                            </button>
                            <button type="button" @click="showModal = false" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
