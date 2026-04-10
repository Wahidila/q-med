@extends('layouts.admin')
@section('page-title', 'Pendaftaran Pasien')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden" 
    x-data="registrationForm()">
    
    <div class="px-8 py-6 border-b border-slate-100 bg-white flex items-center gap-4">
        <div class="p-3 bg-teal-50 text-teal-600 rounded-xl">
            <i data-lucide="clipboard-signature" class="w-6 h-6"></i>
        </div>
        <div>
            <h3 class="font-extrabold text-slate-800 text-xl tracking-tight">Pendaftaran & Ambil Antrian</h3>
            <p class="text-sm text-slate-500 mt-0.5 font-medium">Cari pasien yang sudah ada atau daftarkan pasien baru.</p>
        </div>
    </div>

    <form action="{{ route('admin.registration.store') }}" method="POST" class="p-8">
        @csrf
        <input type="hidden" name="patient_id" x-model="form.patient_id">

        {{-- Autocomplete Search --}}
        <div class="mb-8 relative">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Cari Database Pasien</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
                </div>
                <input type="text" x-model="searchQuery" @input="fetchPatients" @focus="open = true" @click.away="open = false" 
                    class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm bg-slate-50 focus:bg-white transition-colors" 
                    placeholder="Ketik nama atau NIK pasien..." autocomplete="off">
                
                {{-- Dropdown --}}
                <div x-show="open && (patients.length > 0 || searchQuery.length >= 2)" x-transition.opacity 
                    class="absolute z-10 mt-1 sm:text-sm w-full bg-white rounded-xl shadow-lg border border-slate-200 max-h-60 overflow-y-auto" style="display: none;">
                    <template x-if="patients.length === 0 && searchQuery.length >= 2">
                        <div class="px-4 py-3 text-slate-500 flex items-center gap-2">
                            <i data-lucide="user-plus" class="w-4 h-4 text-teal-500"></i> Pasien baru akan dibuat
                        </div>
                    </template>
                    <template x-for="patient in patients" :key="patient.id">
                        <div @click="selectPatient(patient)" class="px-4 py-3 hover:bg-teal-50 cursor-pointer border-b border-slate-50 last:border-0 transition-colors">
                            <div class="font-semibold text-slate-800 flex items-center gap-2">
                                <span x-text="patient.name"></span>
                                <span x-show="patient.nik" class="text-xs font-normal text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full" x-text="patient.nik"></span>
                            </div>
                            <div class="text-xs text-slate-500 mt-1">
                                <span x-text="patient.gender === 'P' ? 'Perempuan' : 'Laki-laki'"></span>, 
                                <span x-text="patient.age + ' thn'"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="relative flex py-5 items-center">
            <div class="flex-grow border-t border-slate-200"></div>
            <span class="flex-shrink-0 mx-4 text-slate-400 text-xs font-medium uppercase tracking-widest">Atau isi manual</span>
            <div class="flex-grow border-t border-slate-200"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">NIK <span class="text-slate-400 font-normal ml-1">(opsional)</span></label>
                <input type="text" name="nik" x-model="form.nik" maxlength="16" class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" x-model="form.name" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat <span class="text-red-500">*</span></label>
            <textarea name="address" x-model="form.address" rows="3" required class="block w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors resize-none"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Umur <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" name="age" x-model="form.age" min="0" max="150" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors pr-12">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-slate-400 sm:text-sm">thn</span>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="gender" x-model="form.gender" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors bg-white">
                    <option value="">-- Pilih --</option>
                    <option value="P">Perempuan</option>
                    <option value="L">Laki-laki</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end pt-8 border-t border-slate-100 mb-2">
            <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent rounded-2xl shadow-[0_4px_14px_0_rgba(13,148,136,0.39)] text-base font-bold text-white bg-teal-600 hover:bg-teal-700 hover:shadow-[0_6px_20px_rgba(13,148,136,0.23)] hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                <i data-lucide="printer" class="w-5 h-5 mr-2.5"></i> Daftar & Ambil Antrian
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('registrationForm', () => ({
            searchQuery: '',
            open: false,
            patients: [],
            form: {
                patient_id: '',
                nik: '{{ old('nik') }}',
                name: '{{ old('name') }}',
                address: '{{ old('address') }}',
                age: '{{ old('age') }}',
                gender: '{{ old('gender') }}'
            },
            fetchPatients() {
                if (this.searchQuery.length < 2) {
                    this.patients = [];
                    return;
                }
                fetch(`{{ route('admin.patients.search') }}?q=${encodeURIComponent(this.searchQuery)}`)
                    .then(res => res.json())
                    .then(data => {
                        this.patients = data;
                        this.open = true;
                    });
            },
            selectPatient(patient) {
                this.form.patient_id = patient.id;
                this.form.nik = patient.nik || '';
                this.form.name = patient.name;
                this.form.address = patient.address;
                this.form.age = patient.age;
                this.form.gender = patient.gender;
                this.searchQuery = patient.name;
                this.open = false;
            }
        }));
    });
</script>
@endpush
@endsection
