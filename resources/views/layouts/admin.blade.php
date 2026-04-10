<!DOCTYPE html>
<html lang="id" class="bg-slate-50 text-slate-800 antialiased font-sans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Q-Med') — Sistem Antrian Bidan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen flex text-sm sm:text-base">
    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-white flex flex-col z-50">
        <div class="px-6 py-6 border-b border-white/10 flex flex-col items-center">
            <i data-lucide="crossbox" class="w-10 h-10 text-teal-400 mb-2"></i>
            <h1 class="text-xl font-bold text-white tracking-tight">Q-Med</h1>
            <span class="text-xs font-medium text-slate-400 tracking-wider uppercase mt-1">Bidan Mandiri</span>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg font-medium transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i> Dashboard
            </a>
            <a href="{{ route('admin.registration.index') }}" class="flex items-center px-3 py-2.5 rounded-lg font-medium transition-colors duration-200 {{ request()->routeIs('admin.registration.*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="user-plus" class="w-5 h-5 mr-3"></i> Pendaftaran
            </a>
            <a href="{{ route('admin.queue.index') }}" class="flex items-center px-3 py-2.5 rounded-lg font-medium transition-colors duration-200 {{ request()->routeIs('admin.queue.*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="users" class="w-5 h-5 mr-3"></i> Antrian
            </a>
            <a href="{{ route('admin.patients.index') }}" class="flex items-center px-3 py-2.5 rounded-lg font-medium transition-colors duration-200 {{ request()->routeIs('admin.patients.*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="folder-search" class="w-5 h-5 mr-3"></i> Data Pasien
            </a>
            <a href="{{ route('admin.services.index') }}" class="flex items-center px-3 py-2.5 rounded-lg font-medium transition-colors duration-200 {{ request()->routeIs('admin.services.*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="clipboard-list" class="w-5 h-5 mr-3"></i> Riwayat Pelayanan
            </a>
        </nav>
        
        <div class="p-4 border-t border-white/10 space-y-2">
            <a href="{{ route('kiosk') }}" target="_blank" class="flex items-center justify-center w-full px-3 py-2.5 border border-teal-500/30 text-teal-400 bg-teal-500/10 hover:bg-teal-500/20 rounded-lg font-medium transition-colors duration-200">
                <i data-lucide="monitor" class="w-4 h-4 mr-2"></i> Buka Kiosk
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center w-full px-3 py-2 rounded-lg font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors duration-200">
                    <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <main class="flex-1 ml-64 flex flex-col min-w-0">
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between z-10 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900">@yield('page-title', 'Dashboard')</h2>
            <div class="flex items-center gap-4">
                <div class="text-sm font-medium text-slate-500 flex items-center gap-1.5 bg-slate-100 px-3 py-1.5 rounded-full">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
                <div class="h-8 w-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold border border-teal-200">
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
        // Init lucide on livewire updates if present
        document.addEventListener('livewire:navigated', () => lucide.createIcons());
        document.addEventListener('livewire:load', () => lucide.createIcons());
    </script>
</body>
</html>
