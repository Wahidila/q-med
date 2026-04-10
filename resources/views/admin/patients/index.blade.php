@extends('layouts.admin')
@section('page-title', 'Data Pasien')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
        <form method="GET" action="{{ route('admin.patients.index') }}" class="flex relative items-center max-w-md w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
            </div>
            <input type="text" name="search" value="{{ $search }}" class="block w-full pl-10 pr-20 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm" placeholder="Cari nama atau NIK...">
            @if($search)
                <a href="{{ route('admin.patients.index') }}" class="absolute inset-y-0 right-16 px-2 flex items-center text-slate-400 hover:text-slate-600" title="Clear">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </a>
            @endif
            <button type="submit" class="absolute inset-y-0 right-0 px-4 text-sm font-medium text-slate-700 bg-slate-100 border-l border-slate-300 rounded-r-lg hover:bg-slate-200 transition-colors">
                Cari
            </button>
        </form>
        
        <a href="{{ route('admin.registration.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Tambah Pasien
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-semibold border-b border-slate-200">
                    <th class="px-6 py-4">NIK</th>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Umur & JK</th>
                    <th class="px-6 py-4">Alamat</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($patients as $patient)
                <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm text-slate-500 font-medium">{{ $patient->nik ?: '-' }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $patient->name }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $patient->age }} thn <span class="mx-1 text-slate-300">•</span> {{ $patient->gender === 'P' ? 'Perempuan' : 'Laki-laki' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ Str::limit($patient->address, 40) }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.patients.edit', $patient) }}" class="inline-flex items-center text-teal-600 hover:text-teal-900 mr-3" title="Edit">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center text-red-500 hover:text-red-700" title="Hapus">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
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
