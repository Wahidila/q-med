<div wire:poll.3s class="flex-1 flex flex-col h-full bg-slate-950">
    {{-- Header --}}
    <header class="flex-none flex items-center justify-between px-10 py-6 bg-slate-900 border-b border-slate-800 shadow-sm z-10 relative">
        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-teal-500/50 to-transparent"></div>
        <div class="flex items-center gap-5">
            <div class="p-3 bg-teal-500/10 rounded-2xl border border-teal-500/20">
                <i data-lucide="activity" class="w-10 h-10 text-teal-400"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-white tracking-tight uppercase">Q-<span class="text-teal-400">Med</span></h1>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-[0.2em] mt-1">Sistem Antrian Praktik Bidan</p>
            </div>
        </div>
        <div class="text-4xl font-bold font-mono text-slate-100 tracking-wider tabular-nums drop-shadow-md" id="kioskClock"></div>
    </header>

    <div class="flex-1 flex overflow-hidden">
        {{-- Main display --}}
        <main class="flex-1 flex items-center justify-center p-12 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 relative">
            
            {{-- Background decorative glows --}}
            <div class="absolute pointer-events-none w-[800px] h-[800px] bg-teal-500/5 blur-[120px] rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
            
            @if($currentQueue)
            <div class="w-full max-w-4xl relative z-10" id="currentQueueCard">
                <div class="bg-slate-900/80 backdrop-blur-xl rounded-[2.5rem] border border-teal-500/20 p-16 text-center transform transition-all duration-500 ring-1 ring-white/5 relative overflow-hidden group shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-b from-teal-500/5 to-transparent opacity-0 transition-opacity duration-1000 group-hover:opacity-100"></div>

                    <div class="text-xl font-bold uppercase tracking-[0.3em] text-teal-400 mb-6 drop-shadow-sm flex items-center justify-center gap-3">
                        <i data-lucide="megaphone" class="w-6 h-6"></i> Nomor Antrian Saat Ini
                    </div>
                    
                    <div class="font-black text-[12rem] leading-none mb-4 tracking-tighter text-white drop-shadow-[0_0_40px_rgba(20,184,166,0.3)]" id="currentNumber">
                        {{ str_pad($currentQueue['number'], 3, '0', STR_PAD_LEFT) }}
                    </div>
                    
                    <div class="text-5xl font-extrabold text-slate-100 mt-8 mb-6 drop-shadow-md" id="currentName">
                        {{ $currentQueue['name'] }}
                    </div>
                    
                    <div class="inline-flex items-center gap-3 px-8 py-4 bg-slate-800/50 rounded-full border border-slate-700/50">
                        <span class="relative flex h-4 w-4">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-4 w-4 bg-teal-500"></span>
                        </span>
                        <div class="text-2xl text-slate-300 font-medium">Silakan menuju ruang periksa</div>
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
        <aside class="w-96 bg-slate-900 border-l border-slate-800 flex flex-col shadow-[-10px_0_30px_rgba(0,0,0,0.3)] z-20">
            <div class="p-8 border-b border-slate-800/80 bg-slate-800/20">
                <h2 class="text-sm font-bold uppercase tracking-[0.2em] text-teal-500 flex items-center gap-3">
                    <i data-lucide="list-ordered" class="w-5 h-5"></i> Antrian Berikutnya
                </h2>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                @forelse($upcomingQueues as $upcoming)
                <div class="flex items-center bg-slate-800/40 border border-slate-700/50 rounded-2xl p-5 hover:bg-slate-800/60 transition-colors shadow-sm">
                    <div class="flex-shrink-0 w-16 h-16 bg-slate-900 rounded-xl border border-slate-700 flex items-center justify-center text-2xl font-black text-teal-400 shadow-inner">
                        {{ str_pad($upcoming['number'], 3, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="ml-5 min-w-0">
                        <div class="text-lg font-bold text-slate-200 truncate">{{ $upcoming['name'] }}</div>
                        <div class="text-sm text-slate-500 font-medium tracking-wide flex items-center gap-1.5 mt-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i> Menunggu...
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full text-slate-600 space-y-4 p-8 text-center bg-slate-800/10 rounded-3xl border border-slate-800 border-dashed">
                    <i data-lucide="users" class="w-12 h-12 opacity-50"></i>
                    <div class="text-lg font-medium">Tidak ada antrian menunggu</div>
                </div>
                @endforelse
            </div>
            
            <div class="p-6 border-t border-slate-800 bg-slate-900/50 text-center">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">
                    Q-Med System &copy; {{ date('Y') }}
                </p>
            </div>
        </aside>
    </div>

    {{-- Script for Audio & TTS --}}
    @script
    <style>
        .pulse-card {
            animation: ringGlow 1.5s cubic-bezier(0.4, 0, 0.6, 1) 3;
        }
        @keyframes ringGlow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(20, 184, 166, 0.4), 0 0 40px rgba(20, 184, 166, 0.1); border-color: rgba(20, 184, 166, 0.2); transform: scale(1); }
            50% { box-shadow: 0 0 0 20px rgba(20, 184, 166, 0), 0 0 100px rgba(20, 184, 166, 0.3); border-color: rgba(20, 184, 166, 0.8); transform: scale(1.02); }
        }
    </style>
    <script>
        // Start lucide icons explicitly here in case they are missing on first ping
        setTimeout(() => window.lucide && window.lucide.createIcons(), 500);

        function updateClock() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            const clock = document.getElementById('kioskClock');
            if (clock) clock.textContent = now.toLocaleTimeString('id-ID', options);
        }
        setInterval(updateClock, 1000);
        updateClock();

        $wire.on('queue-called', (data) => {
            const detail = Array.isArray(data) ? data[0] : data;
            const number = detail.number;
            const name = detail.name;

            // Bell sound effect using AudioContext
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                if (audioCtx.state === 'suspended') { audioCtx.resume(); }

                const oscillator = audioCtx.createOscillator();
                const gainNode = audioCtx.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                
                oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // A5 note
                oscillator.type = 'sine';
                
                gainNode.gain.setValueAtTime(0, audioCtx.currentTime);
                gainNode.gain.linearRampToValueAtTime(0.5, audioCtx.currentTime + 0.05); // Fade in
                gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 1.2); // Long fade out
                
                oscillator.start(audioCtx.currentTime);
                oscillator.stop(audioCtx.currentTime + 1.5);
                
            } catch (e) {
                console.log("Audio API failed:", e);
            }

            // Pulser animation on the card
            const card = document.getElementById('currentQueueCard')?.firstElementChild;
            if (card) {
                card.classList.remove('pulse-card');
                void card.offsetWidth; // trigger reflow
                card.classList.add('pulse-card');
            }

            // Web Speech API (TTS) 
            setTimeout(() => {
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                    const utterance = new SpeechSynthesisUtterance(`Nomor antrian ${number}. atas nama ${name}. silakan menuju ruang periksa.`);
                    utterance.lang = 'id-ID';
                    utterance.rate = 0.85;
                    utterance.pitch = 1.1;
                    
                    // Try to find an Indonesian female voice if available
                    const voices = window.speechSynthesis.getVoices();
                    const idVoice = voices.find(v => v.lang.includes('id') && v.name.toLowerCase().includes('female'));
                    if(idVoice) utterance.voice = idVoice;

                    window.speechSynthesis.speak(utterance);
                }
            }, 1400); // Wait for the bell sound to finish
        });
    </script>
    @endscript
</div>
