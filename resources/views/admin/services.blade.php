@extends('layouts.admin')
@section('page-title', 'Riwayat Pelayanan')

@section('content')
<div class="bg-white rounded-3xl shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden">
    
    <div class="px-8 py-6 border-b border-slate-100 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 bg-white">
        
        <form method="GET" action="{{ route('admin.services.index') }}" class="flex flex-col sm:flex-row items-center gap-3 sm:gap-0 w-full xl:w-auto">
            <div class="flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-teal-500 focus-within:border-teal-500 shadow-sm transition-all sm:rounded-r-none w-full sm:w-auto">
                <div class="px-4 py-2.5 bg-slate-50 border-r border-slate-200 text-slate-500 text-sm font-bold flex items-center gap-2 whitespace-nowrap">
                    <i data-lucide="calendar-search" class="w-4 h-4"></i> Referensi
                </div>
                <input type="date" name="date" value="{{ $date }}" class="block w-full border-0 focus:ring-0 sm:text-sm px-4 py-2.5 text-slate-700 font-medium">
            </div>
            
            <div class="flex w-full sm:w-auto">
                <select name="filter" class="w-full sm:w-auto block border-y border-r border-l sm:border-l-0 border-slate-200 focus:ring-0 sm:text-sm px-4 py-2.5 text-slate-700 font-bold bg-white outline-none cursor-pointer sm:rounded-none rounded-xl mt-3 sm:mt-0">
                    <option value="daily" {{ $filter === 'daily' ? 'selected' : '' }}>Harian</option>
                    <option value="weekly" {{ $filter === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                    <option value="monthly" {{ $filter === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-teal-50 border border-teal-100 sm:border-l-0 text-sm font-bold text-teal-700 hover:bg-teal-100/80 transition-colors sm:rounded-r-xl rounded-xl ml-3 sm:ml-0 shadow-sm w-full sm:w-auto mt-3 sm:mt-0 whitespace-nowrap">
                    Terapkan Filter
                </button>
            </div>
        </form>
        
        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center gap-4 w-full xl:w-auto">
            <a href="{{ route('admin.services.export', ['date' => $date, 'filter' => $filter]) }}" class="flex items-center justify-center w-full sm:w-auto bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-5 py-3 font-bold hover:bg-emerald-600 hover:text-white transition-all shadow-sm group">
                <i data-lucide="file-spreadsheet" class="w-5 h-5 mr-2.5 text-emerald-500 group-hover:text-emerald-200 transition-colors"></i>
                Export Excel
            </a>
            
            <div class="flex items-center w-full sm:w-auto bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl px-6 py-3 shadow-[0_4px_14px_0_rgba(13,148,136,0.39)]">
                <i data-lucide="wallet" class="w-6 h-6 text-teal-100 mr-3"></i>
                <div class="text-sm text-teal-50 font-medium whitespace-nowrap truncate">
                    Total: <span class="font-extrabold text-xl text-white ml-2 tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50">
                <tr class="text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                    <th class="px-8 py-5">No. Antrian</th>
                    <th class="px-8 py-5">Nama Pasien</th>
                    <th class="px-8 py-5 w-1/3">Hasil Pelayanan</th>
                    <th class="px-8 py-5">Biaya</th>
                    <th class="px-8 py-5 text-right">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($services as $service)
                <tr class="hover:bg-slate-50/80 transition-colors duration-200 group">
                    <td class="px-8 py-5">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-teal-50 text-teal-700 font-black text-sm border border-teal-100 shadow-sm group-hover:bg-teal-100 transition-colors">
                            {{ $service->queue->queue_number }}
                        </div>
                    </td>
                    <td class="px-8 py-5 font-bold text-slate-800">{{ $service->queue->patient->name }}</td>
                    <td class="px-8 py-5 text-sm font-medium text-slate-600 leading-relaxed">{{ $service->description }}</td>
                    <td class="px-8 py-5 font-bold text-teal-700">Rp {{ number_format($service->cost, 0, ',', '.') }}</td>
                    <td class="px-8 py-5 text-right text-sm font-semibold text-slate-500">{{ $service->created_at->format('H:i') }}</td>
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
