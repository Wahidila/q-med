@extends('layouts.admin')
@section('page-title', 'Data Pasien')

@section('content')
<div class="bg-white rounded-3xl shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden">
    
    <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
        <form method="GET" action="{{ route('admin.patients.index') }}" class="flex relative items-center max-w-md w-full shadow-sm rounded-xl">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
            </div>
            <input type="text" name="search" value="{{ $search }}" class="block w-full pl-12 pr-24 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm font-medium text-slate-800 transition-colors" placeholder="Cari nama atau NIK...">
            @if($search)
                <a href="{{ route('admin.patients.index') }}" class="absolute inset-y-0 right-[4.5rem] px-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors" title="Clear">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </a>
            @endif
            <button type="submit" class="absolute right-1 top-1 bottom-1 px-5 text-sm font-bold text-white bg-slate-800 rounded-lg hover:bg-slate-700 transition-colors">
                Cari
            </button>
        </form>
        
        <a href="{{ route('admin.registration.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-[0_4px_14px_0_rgba(13,148,136,0.39)] text-white bg-teal-600 hover:bg-teal-700 hover:shadow-[0_6px_20px_rgba(13,148,136,0.23)] hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i> Tambah Pasien
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50">
                <tr class="text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                    <th class="px-8 py-5">NIK</th>
                    <th class="px-8 py-5">Nama</th>
                    <th class="px-8 py-5">Umur & JK</th>
                    <th class="px-8 py-5">Alamat</th>
                    <th class="px-8 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($patients as $patient)
                <tr class="hover:bg-slate-50/80 transition-colors duration-200 group">
                    <td class="px-8 py-5 text-sm text-slate-500 font-semibold">{{ $patient->nik ?: '-' }}</td>
                    <td class="px-8 py-5 font-bold text-slate-800">{{ $patient->name }}</td>
                    <td class="px-8 py-5 text-sm font-semibold text-slate-600">
                        {{ $patient->age }} thn <span class="mx-1.5 text-slate-300 pointer-events-none">•</span> <span class="text-slate-500">{{ $patient->gender === 'P' ? 'Perempuan' : 'Laki-laki' }}</span>
                    </td>
                    <td class="px-8 py-5 text-sm font-medium text-slate-500">{{ Str::limit($patient->address, 40) }}</td>
                    <td class="px-8 py-5 text-right">
                        <div class="inline-flex gap-2 justify-end">
                            <a href="{{ route('admin.patients.edit', $patient) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-teal-50 text-teal-600 hover:bg-teal-600 hover:text-white transition-colors" title="Edit">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center">
                            <i data-lucide="user-x" class="w-10 h-10 mb-2 opacity-50"></i>
                            <p>Data pasien tidak ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
        {{ $patients->links('pagination::tailwind') }}
    </div>
</div>
@endsection
