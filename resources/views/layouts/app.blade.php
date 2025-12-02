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
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://kit.fontawesome.com/35d8865ade.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.12.1/dist/JsBarcode.all.min.js"></script>
</head>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div
        x-data="{ sidebarCollapsed: false, mobileOpen: false }"
        x-init="sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true'"
        class="relative min-h-screen overflow-hidden">
        @include('layouts.navigation')

        <div x-cloak class="flex min-h-screen flex-col"
            x-bind:class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-72'">

            <div
                class="sticky top-0 z-20 flex items-center justify-between gap-3 border-b border-white/60 bg-white/80 px-4 py-3 backdrop-blur lg:hidden">
                <button @click="mobileOpen = true"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white ring-1 ring-slate-200 text-slate-600 transition hover:text-slate-900">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex flex-1 items-center justify-end gap-2">
                    <span class="badge-soft capitalize">{{ Auth::user()->role }}</span>
                    <div class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                </div>
            </div>

            @isset($header)
                <header class="px-4 pt-6 sm:px-6 lg:px-10">
                    <div class="glass-panel rounded-3xl px-6 py-5 shadow-lg">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 px-4 pb-12 pt-6 sm:px-6 lg:px-10">
                <div
                    class="rounded-3xl glass-panel p-4 shadow-lg ring-1 ring-white/60 backdrop-blur">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });

            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: @json(session('success'))
                });
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: @json(session('error'))
                });
            @endif
        });
    </script>
    @stack('scripts')
</body>

</html>
