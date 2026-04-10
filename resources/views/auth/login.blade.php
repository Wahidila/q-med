<!DOCTYPE html>
<html lang="id" class="antialiased font-sans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin Q-Med</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
    
    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 inset-x-0 h-64 bg-gradient-to-b from-teal-600 to-teal-800 -z-10 shadow-lg"></div>
    <div class="absolute top-10 left-1/2 -translate-x-1/2 text-white/5 -z-10">
        <i data-lucide="activity" class="w-96 h-96"></i>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md z-10 flex flex-col items-center">
        <div class="flex items-center justify-center gap-3 mb-6 mix-blend-overlay text-white">
            <div class="p-3 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/20">
                <i data-lucide="crossbox" class="w-10 h-10 text-teal-100"></i>
            </div>
            <h2 class="text-4xl font-black tracking-tight">Q-Med</h2>
        </div>
        <h2 class="text-center text-xl font-bold tracking-wide text-teal-100/90">Sistem Antrian & Manajemen Pasien</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md z-10">
        <div class="bg-white py-10 px-6 sm:rounded-3xl sm:px-10 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.1)] border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-teal-400 to-teal-600"></div>
                <h3 class="text-2xl font-bold text-slate-800">Halo, selamat datang!</h3>
                <p class="text-slate-500 text-sm mt-2">Silakan login untuk mengakses dashboard bidan.</p>
            </div>

            @if($errors->any())
                <div class="rounded-xl bg-red-50 p-4 mb-6 border border-red-100 flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0"></i>
                    <div class="text-sm text-red-700 font-medium">
                        @foreach($errors->all() as $err)
                            <p>{{ $err }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm bg-slate-50 focus:bg-white transition-colors" placeholder="admin@qmed.test">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm bg-slate-50 focus:bg-white transition-colors" placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-slate-600 cursor-pointer select-none">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-2xl shadow-[0_4px_14px_0_rgba(13,148,136,0.39)] text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 hover:shadow-[0_6px_20px_rgba(13,148,136,0.23)] hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                        <i data-lucide="log-in" class="w-4 h-4 mr-2"></i> Masuk ke Dashboard
                    </button>
                </div>
            </form>
        </div>
        
        <p class="mt-8 text-center text-xs text-slate-500 uppercase tracking-widest font-semibold">
            Sistem Informasi Q-Med &copy; {{ date('Y') }}
        </p>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
    </script>
</body>
</html>
