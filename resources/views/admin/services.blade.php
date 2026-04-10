@extends('layouts.admin')
@section('page-title', 'Riwayat Pelayanan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
        <form method="GET" action="{{ route('admin.services.index') }}" class="flex items-center bg-white border border-slate-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-teal-500 focus-within:border-teal-500">
            <div class="px-3 py-2 bg-slate-50 border-r border-slate-200 text-slate-500 text-sm font-medium">
                Tanggal
            </div>
            <input type="date" name="date" value="{{ $date }}" class="block w-full border-0 focus:ring-0 sm:text-sm px-3 py-2 text-slate-700">
            <button type="submit" class="px-4 py-2 bg-slate-100 border-l border-slate-200 text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
                Filter
            </button>
        </form>
        
        <div class="flex items-center bg-teal-50 border border-teal-100 rounded-lg px-4 py-2.5">
            <i data-lucide="wallet" class="w-5 h-5 text-teal-500 mr-3"></i>
            <div class="text-sm text-teal-800">
                Total Pendapatan: <span class="font-bold text-lg text-teal-700 ml-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-semibold border-b border-slate-200">
                    <th class="px-6 py-4">No. Antrian</th>
                    <th class="px-6 py-4">Nama Pasien</th>
                    <th class="px-6 py-4 w-1/3">Hasil Pelayanan</th>
                    <th class="px-6 py-4">Biaya</th>
                    <th class="px-6 py-4 text-right">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($services as $service)
                <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 font-bold text-sm border border-emerald-200">
                            {{ $service->queue->queue_number }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $service->queue->patient->name }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 leading-relaxed">{{ $service->description }}</td>
                    <td class="px-6 py-4 font-medium text-slate-700">Rp {{ number_format($service->cost, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right text-sm text-slate-500">{{ $service->created_at->format('H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center">
                            <i data-lucide="clipboard-x" class="w-10 h-10 mb-2 opacity-50"></i>
                            <p>Tidak ada riwayat pelayanan pada tanggal ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
