<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk Antrian — Q-Med Bidan Mandiri</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-900 text-slate-100 h-screen overflow-hidden antialiased font-sans flex flex-col selection:bg-teal-500 selection:text-white">
    <livewire:kiosk-display />
    @livewireScripts
</body>
</html>
