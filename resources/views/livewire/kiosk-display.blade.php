<div wire:poll.3s x-data="{ started: false, startKiosk() { this.started = true; try { let ctx = new (window.AudioContext || window.webkitAudioContext)(); if(ctx.state==='suspended') ctx.resume(); window.__kioskAudioCtx = ctx; } catch(e){} if('speechSynthesis' in window){ let m = new SpeechSynthesisUtterance(''); window.speechSynthesis.speak(m); } } }" class="flex-1 flex flex-col h-full bg-slate-950 font-sans text-slate-200 relative overflow-hidden">
    {{-- Overlay for Autoplay Policy --}}
    <div x-show="!started" x-transition.opacity.duration.500ms class="absolute inset-0 z-[100] bg-slate-950/95 backdrop-blur-2xl flex flex-col items-center justify-center">
        <div class="text-center space-y-10">
            <div class="w-40 h-40 mx-auto bg-teal-500/20 rounded-[2.5rem] border-2 border-teal-400 flex items-center justify-center p-8 shadow-[0_0_80px_rgba(45,212,191,0.3)] cursor-pointer animate-pulse" @click="startKiosk()">
                <i data-lucide="play" class="w-full h-full text-teal-300 ml-3"></i>
            </div>
            <h2 class="text-5xl font-black text-white tracking-tight drop-shadow-lg">Mulai Layar Kiosk</h2>
            <button @click="startKiosk()" class="px-12 py-5 bg-teal-600 hover:bg-teal-500 text-white rounded-3xl font-extrabold text-3xl shadow-[0_10px_50px_-10px_rgba(20,184,166,0.6)] transition-all hover:scale-105 active:scale-95 border-b-4 border-teal-800">
                Aktifkan Suara & Tampilan
            </button>
        </div>
    </div>


    {{-- Header --}}
    <header class="flex-none flex items-center justify-between px-12 py-8 bg-slate-950/80 backdrop-blur-xl border-b border-white/5 shadow-sm z-20 relative">
        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-teal-500/30 to-transparent"></div>
        <div class="flex items-center gap-6">
            <div class="p-3.5 bg-teal-500/10 rounded-[1.25rem] border border-teal-500/20 shadow-inner ring-1 ring-white/5" wire:ignore>
                <i data-lucide="heart-pulse" class="w-10 h-10 text-teal-400 drop-shadow-sm"></i>
            </div>
            <div>
                <h1 class="text-4xl font-black text-white tracking-tight drop-shadow-md">Q-<span class="text-teal-400">Med</span></h1>
                <p class="text-sm font-bold text-teal-100/60 uppercase tracking-[0.25em] mt-1.5">{{ \App\Models\Setting::get('clinic_name', 'Bidan Mandiri') }}</p>
            </div>
        </div>
        <div class="text-5xl font-black text-white tracking-wider tabular-nums drop-shadow-lg" id="kioskClock" wire:ignore></div>
    </header>

    <div class="flex-1 flex overflow-hidden">
        {{-- Main display --}}
        <main class="flex-1 flex items-center justify-center p-12 bg-gradient-to-br from-slate-950 via-[#041d1a] to-slate-950 relative overflow-hidden">
            
            {{-- Background decorative glows --}}
            <div class="absolute pointer-events-none w-[900px] h-[900px] bg-teal-600/10 blur-[150px] rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-70"></div>
            <div class="absolute pointer-events-none w-[600px] h-[600px] bg-teal-400/5 blur-[100px] rounded-full bottom-0 left-0 -translate-x-1/3 translate-y-1/3"></div>
            
            @if($currentQueue)
            <div class="w-full max-w-4xl relative z-10" id="currentQueueCard">
                <div class="bg-black/20 backdrop-blur-3xl rounded-[3rem] border border-white/10 p-16 text-center transform transition-all duration-700 ring-1 ring-white/5 relative overflow-hidden group shadow-[0_20px_60px_-15px_rgba(20,184,166,0.3)]">
                    <div class="absolute inset-0 bg-gradient-to-b from-white/5 to-transparent opacity-0 transition-opacity duration-1000 group-hover:opacity-100 pointer-events-none"></div>

                    <div class="text-2xl font-black uppercase tracking-[0.3em] text-teal-400 mb-8 drop-shadow-md flex items-center justify-center gap-3">
                        <i data-lucide="megaphone" class="w-8 h-8 text-teal-300"></i> Nomor Antrian Saat Ini
                    </div>
                    
                    <div class="font-black text-[13rem] leading-none mb-6 tracking-tighter text-white drop-shadow-[0_0_50px_rgba(45,212,191,0.5)] flex items-center justify-center" id="currentNumber">
                        {{ str_pad($currentQueue['number'], 3, '0', STR_PAD_LEFT) }}
                    </div>
                    
                    <div class="text-6xl font-black text-white mt-10 mb-8 drop-shadow-xl tracking-tight" id="currentName">
                        {{ $currentQueue['name'] }}
                    </div>
                    
                    <div class="inline-flex items-center gap-4 px-10 py-5 bg-white/5 rounded-[2rem] border border-white/10 shadow-inner backdrop-blur-md">
                        <span class="relative flex h-5 w-5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-5 w-5 bg-teal-500 shadow-[0_0_15px_rgba(45,212,191,0.8)]"></span>
                        </span>
                        <div class="text-3xl text-white font-extrabold tracking-tight drop-shadow-md">Silakan menuju ruang periksa</div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center relative z-10 flex flex-col items-center">
                <div class="w-32 h-32 p-8 bg-slate-800/50 rounded-full border border-slate-700 mx-auto mb-8 shadow-inner flex items-center justify-center">
                    <i data-lucide="coffee" class="w-full h-full text-slate-500"></i>
                </div>
                <div class="text-4xl font-bold text-slate-400 mb-3 tracking-tight">Belum ada antrian.</div>
                <div class="text-xl text-slate-500 font-medium tracking-wide">Layanan loket tersedia.</div>
            </div>
            @endif
        </main>

        {{-- Upcoming queue sidebar --}}
        <aside class="w-[28rem] bg-slate-950 border-l border-white/5 flex flex-col shadow-[-20px_0_50px_rgba(0,0,0,0.5)] z-20 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none bg-gradient-to-b from-teal-500/5 to-transparent opacity-50"></div>
            
            <div class="p-8 border-b border-white/5 relative z-10">
                <h2 class="text-sm font-bold uppercase tracking-[0.25em] text-teal-400/80 flex items-center gap-3">
                    <i data-lucide="list-ordered" class="w-5 h-5 text-teal-500"></i> Antrian Berikutnya
                </h2>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 space-y-4 relative z-10">
                @forelse($upcomingQueues as $upcoming)
                <div class="flex items-center bg-white/5 border border-white/5 rounded-3xl p-5 hover:bg-white/10 transition-all duration-300 shadow-sm group">
                    <div class="flex-shrink-0 w-20 h-20 bg-black/30 rounded-2xl border border-white/10 flex items-center justify-center text-3xl font-black text-white shadow-inner group-hover:shadow-[0_0_20px_rgba(45,212,191,0.2)] group-hover:border-teal-500/50 group-hover:text-teal-300 transition-all duration-300 ring-1 ring-white/5">
                        {{ str_pad($upcoming['number'], 3, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="ml-6 min-w-0 flex-1">
                        <div class="text-2xl font-black text-white truncate drop-shadow-sm">{{ $upcoming['name'] }}</div>
                        <div class="text-base text-teal-100/50 font-semibold tracking-wide flex items-center gap-2 mt-1.5">
                            <i data-lucide="clock" class="w-4 h-4"></i> Menunggu...
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full text-slate-500 space-y-5 p-8 text-center bg-white/5 rounded-3xl border border-white/5 border-dashed">
                    <i data-lucide="users" class="w-16 h-16 opacity-40"></i>
                    <div class="text-xl font-bold text-slate-400">Tidak ada antrian menunggu</div>
                </div>
                @endforelse
            </div>
            
            <div class="p-6 border-t border-white/5 bg-black/20 text-center relative z-10 backdrop-blur-md">
                <p class="text-xs font-bold text-teal-100/30 uppercase tracking-[0.3em]">
                    Q-Med System &copy; {{ date('Y') }}
                </p>
            </div>
        </aside>
    </div>

    {{-- Styles --}}
    <style>
        .pulse-card {
            animation: ringGlow 1.5s cubic-bezier(0.3, 0, 0.5, 1) 3;
        }
        @keyframes ringGlow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.4), 0 20px 60px -15px rgba(20, 184, 166, 0.3); border-color: rgba(255, 255, 255, 0.2); transform: scale(1); }
            50% { box-shadow: 0 0 0 25px rgba(45, 212, 191, 0), 0 0 100px rgba(45, 212, 191, 0.5); border-color: rgba(45, 212, 191, 0.8); transform: scale(1.02); }
        }
    </style>

    @script
    <script>
        // Clock
        function updateClock() {
            const now = new Date();
            const clock = document.getElementById('kioskClock');
            if (clock) clock.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Re-initialize Lucide after Livewire morph
        setTimeout(() => window.lucide && window.lucide.createIcons(), 500);

        // Listen for queue-called event
        $wire.on('queue-called', (data) => {
            console.log('[KioskAudio] queue-called event received:', data);
            const detail = Array.isArray(data) ? data[0] : data;
            const number = detail.number;
            const name = detail.name;

            // Bell sound  
            try {
                const audioCtx = window.__kioskAudioCtx || new (window.AudioContext || window.webkitAudioContext)();
                window.__kioskAudioCtx = audioCtx;
                if (audioCtx.state === 'suspended') audioCtx.resume();

                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.frequency.setValueAtTime(880, audioCtx.currentTime);
                osc.type = 'sine';
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.5, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 1.2);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 1.5);
                console.log('[KioskAudio] Bell played');
            } catch (e) {
                console.error('[KioskAudio] Bell failed:', e);
            }

            // Pulse animation
            const card = document.getElementById('currentQueueCard')?.firstElementChild;
            if (card) {
                card.classList.remove('pulse-card');
                void card.offsetWidth;
                card.classList.add('pulse-card');
            }

            // TTS
            setTimeout(() => {
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                    const msg = new SpeechSynthesisUtterance(`Nomor antrian ${number}, atas nama ${name}, silakan menuju ruang periksa.`);
                    msg.lang = 'id-ID';
                    msg.rate = 0.85;
                    msg.pitch = 1.1;
                    const voices = window.speechSynthesis.getVoices();
                    const idVoice = voices.find(v => v.lang.includes('id'));
                    if (idVoice) msg.voice = idVoice;
                    window.speechSynthesis.speak(msg);
                    console.log('[KioskAudio] TTS spoken');
                }
            }, 1400);
        });
    </script>
    @endscript
</div>
