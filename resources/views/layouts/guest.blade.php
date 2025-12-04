<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/35d8865ade.js" crossorigin="anonymous"></script>
</head>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="relative min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-20 -top-24 h-80 w-80 rounded-full bg-brand-200/40 blur-3xl"></div>
            <div class="absolute -right-24 top-16 h-72 w-72 rounded-full bg-sky-200/50 blur-3xl"></div>
            <div class="absolute inset-x-10 bottom-[-160px] h-96 rounded-[60px] bg-gradient-to-r from-brand-50 via-white to-sky-50 blur-3xl"></div>
        </div>
        <main class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10 sm:px-6 lg:px-10">
            <div
                class="grid w-full max-w-5xl grid-cols-1 overflow-hidden rounded-3xl border border-white/60 bg-white/90 shadow-2xl ring-1 ring-slate-200/80 backdrop-blur-xl lg:grid-cols-[1.1fr_1fr]">
                <div
                    class="hidden flex-col justify-between bg-gradient-to-br from-brand-600 via-brand-500 to-sky-500 px-8 py-8 text-white lg:flex">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 to-cyan-500 text-white ">
                            <i class="fa-solid fa-graduation-cap text-xl"></i>
                        </div>
                        <div class="leading-tight">
                            <p class="text-base font-semibold text-white/90">Pendataan</p>
                            <p class="text-base font-bold text-white">Siswa</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-4">
                        <h2 class="text-3xl font-bold leading-tight">Kelola data sekolah dengan nyaman</h2>
                        <p class="text-sm text-white/80 leading-relaxed">
                            Akses cepat untuk memantau siswa, kelas, jurusan, dan tahun ajar melalui satu dashboard terpadu.
                        </p>
                        
                    </div>
                    <div class="mt-6 flex items-center gap-3 text-sm text-white/80">
                        <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                        <span>Terhubung • {{ config('app.name', 'Laravel') }}</span>
                    </div>
                </div>
                <div class="relative bg-white px-6 py-8 sm:px-8 lg:px-10">
                    <div class="absolute top-0 h-2 bg-gradient-to-r from-brand-500 via-sky-500 to-brand-400"></div>
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>
