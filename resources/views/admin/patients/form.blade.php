@extends('layouts.admin')
@section('page-title', $patient->exists ? 'Edit Data Pasien' : 'Tambah Pasien Baru')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
        <div class="p-2 bg-teal-100 text-teal-600 rounded-lg">
            <i data-lucide="user-{{ $patient->exists ? 'cog' : 'plus' }}" class="w-6 h-6"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-lg">{{ $patient->exists ? 'Edit Pasien' : 'Pasien Baru' }}</h3>
            <p class="text-sm text-slate-500">Lengkapi informasi pasien di bawah ini.</p>
        </div>
    </div>

    <form action="{{ $patient->exists ? route('admin.patients.update', $patient) : route('admin.patients.store') }}" method="POST" class="p-8">
        @csrf
        @if($patient->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">NIK <span class="text-slate-400 font-normal ml-1">(opsional)</span></label>
                <input type="text" name="nik" maxlength="16" value="{{ old('nik', $patient->nik) }}" class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors bg-slate-50 focus:bg-white" placeholder="Nomor Induk Kependudukan">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" required value="{{ old('name', $patient->name) }}" class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors bg-slate-50 focus:bg-white" placeholder="Nama sesuai KTP">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
            <textarea name="address" rows="3" required class="block w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors resize-none bg-slate-50 focus:bg-white" placeholder="Alamat rumah tinggal...">{{ old('address', $patient->address) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Umur <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" name="age" min="0" max="150" required value="{{ old('age', $patient->age) }}" class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors pr-12 bg-slate-50 focus:bg-white" placeholder="0">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-slate-400 sm:text-sm">thn</span>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="gender" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors bg-slate-50 focus:bg-white">
                    <option value="" disabled {{ !old('gender', $patient->gender) ? 'selected' : '' }}>-- Pilih --</option>
                    <option value="P" {{ old('gender', $patient->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    <option value="L" {{ old('gender', $patient->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.patients.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-slate-300 rounded-xl shadow-sm text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
