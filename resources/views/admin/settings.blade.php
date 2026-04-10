@extends('layouts.admin')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-10">
    
    {{-- Card 1: Account Security --}}
    <div class="bg-white rounded-3xl shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 bg-white flex items-center gap-4">
            <div class="p-3 bg-teal-50 text-teal-600 rounded-[1.25rem]">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-800 text-xl tracking-tight">Keamanan & Profil Akun</h3>
                <p class="text-sm text-slate-500 mt-0.5 font-medium">Ubah alamat email login dan password kredensial admin Anda.</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.security.update') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required 
                            class="block w-full pl-12 pr-4 py-3.5 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all shadow-sm">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password Baru <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diubah" 
                            class="block w-full pl-12 pr-4 py-3.5 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all shadow-sm placeholder:text-slate-400">
                    </div>
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Ulangi Password Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock-keyhole" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" 
                            class="block w-full pl-12 pr-4 py-3.5 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all shadow-sm placeholder:text-slate-400">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent rounded-2xl shadow-[0_4px_14px_0_rgba(13,148,136,0.39)] text-base font-bold text-white bg-teal-600 hover:bg-teal-700 hover:shadow-[0_6px_20px_rgba(13,148,136,0.23)] hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-300 cursor-pointer">
                    <i data-lucide="shield-check" class="w-5 h-5 mr-2.5"></i> Perbarui Keamanan
                </button>
            </div>
        </form>
    </div>

    {{-- Card 2: Kiosk Identity --}}
    <div class="bg-white rounded-3xl shadow-[0_8px_30px_-12px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden mt-8">
        <div class="px-8 py-6 border-b border-slate-100 bg-white flex items-center gap-4">
            <div class="p-3 bg-teal-50 text-teal-600 rounded-[1.25rem]">
                <i data-lucide="monitor-check" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-800 text-xl tracking-tight">Identitas Kiosk</h3>
                <p class="text-sm text-slate-500 mt-0.5 font-medium">Ubah nama layanan/praktik untuk layar antrian.</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="p-8">
            @csrf
            <div class="mb-8">
                <label for="clinic_name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Klinik / Praktik <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="building-2" class="w-5 h-5 text-slate-400"></i>
                    </div>
                    <input type="text" id="clinic_name" name="clinic_name" value="{{ old('clinic_name', $clinicName) }}" required 
                        class="block w-full pl-12 pr-4 py-3.5 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all shadow-sm">
                </div>
                <p class="mt-2.5 text-sm text-slate-500">Nama ini akan menggantikan tulisan "Bidan Mandiri" di menu navigasi, layar pasien, dan struk antrian.</p>
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent rounded-2xl shadow-[0_4px_14px_0_rgba(13,148,136,0.39)] text-base font-bold text-white bg-teal-600 hover:bg-teal-700 hover:shadow-[0_6px_20px_rgba(13,148,136,0.23)] hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-300 cursor-pointer">
                    <i data-lucide="save" class="w-5 h-5 mr-2.5"></i> Simpan Nama Klinik
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
