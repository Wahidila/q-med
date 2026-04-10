<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk Antrian — Q-Med Bidan Mandiri</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
<body class="bg-slate-900 text-slate-100 h-screen overflow-hidden antialiased font-sans flex flex-col selection:bg-teal-500 selection:text-white">
    <livewire:kiosk-display />
    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        document.addEventListener('livewire:navigated', () => lucide.createIcons());
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', ({ el, component }) => {
                lucide.createIcons();
            });
        });
    </script>
</body>
</html>
