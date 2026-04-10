<!DOCTYPE html>
<html lang="id" class="bg-slate-50 text-slate-800 antialiased font-sans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Q-Med') — Sistem Antrian Bidan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    @livewireStyles
</head>
<body class="min-h-screen flex text-sm sm:text-base">
    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-[#0d9488] to-teal-900 border-r border-teal-700/50 flex flex-col z-50 shadow-[4px_0_30px_rgba(13,148,136,0.5)]">
        <div class="px-6 py-8 flex flex-col items-center relative z-10 border-b border-white/5">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 text-white p-3.5 rounded-[1.25rem] mb-4 shadow-lg ring-1 ring-white/10">
                <i data-lucide="heart-pulse" class="w-8 h-8 drop-shadow-sm"></i>
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight drop-shadow-md">Q-Med</h1>
            <span class="text-[0.65rem] font-extrabold text-teal-200 tracking-[0.2em] uppercase mt-1.5 opacity-90">{{ \App\Models\Setting::get('clinic_name', 'Bidan Mandiri') }}</span>
        </div>
        
        <nav class="flex-1 px-5 py-6 space-y-2.5 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3.5 rounded-2xl font-bold transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white shadow-inner border border-white/10 backdrop-blur-md' : 'text-teal-100/70 hover:bg-white/10 hover:text-white group' }} cursor-pointer">
                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-teal-300 drop-shadow-[0_0_8px_rgba(94,234,212,0.5)]' : 'text-teal-400/50 group-hover:text-teal-300 transition-colors duration-300' }}"></i> Dashboard
            </a>
            <a href="{{ route('admin.registration.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl font-bold transition-all duration-300 {{ request()->routeIs('admin.registration.*') ? 'bg-white/15 text-white shadow-inner border border-white/10 backdrop-blur-md' : 'text-teal-100/70 hover:bg-white/10 hover:text-white group' }} cursor-pointer">
                <i data-lucide="user-plus" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.registration.*') ? 'text-teal-300 drop-shadow-[0_0_8px_rgba(94,234,212,0.5)]' : 'text-teal-400/50 group-hover:text-teal-300 transition-colors duration-300' }}"></i> Pendaftaran
            </a>
            <a href="{{ route('admin.queue.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl font-bold transition-all duration-300 {{ request()->routeIs('admin.queue.*') ? 'bg-white/15 text-white shadow-inner border border-white/10 backdrop-blur-md' : 'text-teal-100/70 hover:bg-white/10 hover:text-white group' }} cursor-pointer">
                <i data-lucide="users" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.queue.*') ? 'text-teal-300 drop-shadow-[0_0_8px_rgba(94,234,212,0.5)]' : 'text-teal-400/50 group-hover:text-teal-300 transition-colors duration-300' }}"></i> Antrian
            </a>
            <a href="{{ route('admin.patients.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl font-bold transition-all duration-300 {{ request()->routeIs('admin.patients.*') ? 'bg-white/15 text-white shadow-inner border border-white/10 backdrop-blur-md' : 'text-teal-100/70 hover:bg-white/10 hover:text-white group' }} cursor-pointer">
                <i data-lucide="folder-search" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.patients.*') ? 'text-teal-300 drop-shadow-[0_0_8px_rgba(94,234,212,0.5)]' : 'text-teal-400/50 group-hover:text-teal-300 transition-colors duration-300' }}"></i> Data Pasien
            </a>
            <a href="{{ route('admin.services.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl font-bold transition-all duration-300 {{ request()->routeIs('admin.services.*') ? 'bg-white/15 text-white shadow-inner border border-white/10 backdrop-blur-md' : 'text-teal-100/70 hover:bg-white/10 hover:text-white group' }} cursor-pointer">
                <i data-lucide="clipboard-list" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.services.*') ? 'text-teal-300 drop-shadow-[0_0_8px_rgba(94,234,212,0.5)]' : 'text-teal-400/50 group-hover:text-teal-300 transition-colors duration-300' }}"></i> Riwayat Pelayanan
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl font-bold transition-all duration-300 {{ request()->routeIs('admin.settings.*') ? 'bg-white/15 text-white shadow-inner border border-white/10 backdrop-blur-md' : 'text-teal-100/70 hover:bg-white/10 hover:text-white group' }} cursor-pointer">
                <i data-lucide="settings" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.settings.*') ? 'text-teal-300 drop-shadow-[0_0_8px_rgba(94,234,212,0.5)]' : 'text-teal-400/50 group-hover:text-teal-300 transition-colors duration-300' }}"></i> Pengaturan
            </a>
        </nav>
        
        <div class="p-6 border-t border-white/5 space-y-3 bg-black/10">
            <a href="{{ route('kiosk') }}" target="_blank" class="flex items-center justify-center w-full px-4 py-3.5 bg-teal-800/40 border border-teal-500/30 text-teal-50 hover:bg-teal-700/60 hover:text-white rounded-2xl font-bold transition-all duration-300 shadow-inner group cursor-pointer">
                <i data-lucide="monitor" class="w-5 h-5 mr-2 text-teal-400 group-hover:text-teal-300 transition-colors duration-300"></i> Buka Kiosk
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center w-full px-4 py-3.5 rounded-2xl font-bold text-teal-200/80 hover:bg-rose-500 hover:text-white hover:shadow-[0_4px_14px_0_rgba(244,63,94,0.39)] transition-all duration-300 group cursor-pointer border border-transparent hover:border-rose-400/50">
                    <i data-lucide="log-out" class="w-5 h-5 mr-2 text-teal-400/50 group-hover:text-white transition-colors duration-300"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <main class="flex-1 ml-64 flex flex-col min-w-0">
        <header class="bg-white border-b border-slate-100 px-8 py-5 flex items-center justify-between z-10 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)]">
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">@yield('page-title', 'Dashboard')</h2>
            <div class="flex items-center gap-4">
                <div class="text-sm font-semibold text-slate-600 flex items-center gap-2 bg-slate-50 border border-slate-100 px-4 py-2 rounded-xl">
                    <i data-lucide="calendar" class="w-4 h-4 text-teal-600"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white font-bold shadow-md shadow-teal-600/20">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="p-8 flex-1 overflow-y-auto">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 flex-shrink-0"></i>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('info'))
                <div class="mb-6 p-4 rounded-xl font-medium bg-blue-50 text-blue-800 border border-blue-200 flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
                    <i data-lucide="info" class="w-5 h-5 text-blue-500 flex-shrink-0"></i>
                    <p>{{ session('info') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl font-medium bg-red-50 text-red-800 border border-red-200 flex items-start gap-3 shadow-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 flex-shrink-0"></i>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl font-medium bg-red-50 text-red-800 border border-red-200 flex items-start gap-3 shadow-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 flex-shrink-0"></i>
                    <div>
                        @foreach($errors->all() as $err)
                            <p>{{ $err }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @livewireScripts
    @stack('scripts')
    <script>
        // Init Lucide icons
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        // Re-init lucide on livewire updates if present
        document.addEventListener('livewire:navigated', () => lucide.createIcons());
        document.addEventListener('livewire:load', () => lucide.createIcons());
    </script>
</body>
</html>
