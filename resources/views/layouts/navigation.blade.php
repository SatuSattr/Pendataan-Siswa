@php
$navItems = [
['route' => 'dashboard', 'label' => __('Dashboard'), 'icon' => 'fa-house'],
[
'route' => 'tahun-ajar.index',
'pattern' => 'tahun-ajar.*',
'label' => 'Tahun Ajar',
'icon' => 'fa-calendar-days',
],
['route' => 'jurusan.index', 'pattern' => 'jurusan.*', 'label' => 'Jurusan', 'icon' => 'fa-shapes'],
['route' => 'kelas.index', 'pattern' => 'kelas.*', 'label' => 'Kelas', 'icon' => 'fa-chalkboard'],
['route' => 'siswa.index', 'pattern' => 'siswa.*', 'label' => 'Siswa', 'icon' => 'fa-user-graduate'],
['route' => 'users.index', 'pattern' => 'users.*', 'label' => 'Pengguna', 'icon' => 'fa-users'],
];
@endphp

<div x-cloak x-show="mobileOpen" class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm lg:hidden"
    @click="mobileOpen = false"></div>

<aside x-cloak
    class="fixed inset-y-0 left-0 z-40 flex h-screen flex-col border-r border-white/60 bg-white/85 backdrop-blur-xl shadow-xl shadow-slate-200/70"
    x-bind:class="[
        sidebarCollapsed ? 'w-20' : 'w-72',
        mobileOpen ? 'translate-x-0' : '-translate-x-full',
        'lg:translate-x-0'
    ]">
    <div class="flex items-center gap-3 px-4 pt-4">
        <a href="{{ route('dashboard') }}" class="flex flex-1 items-center gap-3">
            <div
                class="flex min-h-11 min-w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 to-cyan-500 text-white shadow-lg shadow-brand-200/60">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="flex flex-col gap-0 leading-tight" x-show="!sidebarCollapsed">
                <span class="font-semibold m-0 text-brand-700">Pendataan</span>
                <span class="font-medium m-0 text-slate-900">Siswa</span>
            </div>

        </a>
        <button
            class="hidden rounded-xl p-2 text-slate-500 ring-1 ring-slate-200 hover:bg-slate-100 hover:text-slate-900 lg:inline-flex"
            @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebarCollapsed', sidebarCollapsed)">
            <svg class="h-5 w-5" x-bind:class="sidebarCollapsed ? 'rotate-180' : ''" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button
            class="inline-flex items-center justify-center rounded-xl p-2 text-slate-500 ring-1 ring-slate-200 hover:bg-slate-100 hover:text-slate-900 lg:hidden"
            @click="mobileOpen = false">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="mt-6 flex-1 overflow-y-auto px-3 overflow-x-hidden">
        <p class="px-2 text-[11px] font-semibold uppercase tracking-[0.25em] text-slate-400">Menu</p>
        <nav class="mt-3 space-y-2">
            @foreach ($navItems as $item)
            @php
            // cek apakah route sekarang cocok dengan item ini
            $isActive = request()->routeIs($item['pattern'] ?? $item['route']);

            $baseClasses = 'group flex items-center overflow-hidden text-sm font-semibold transition';
            $stateClasses = $isActive
            ? 'rounded-2xl text-brand-800 bg-brand-50 ring-1 ring-brand-100 shadow-sm'
            : 'rounded-xl text-slate-600 hover:text-slate-900 hover:bg-white hover:ring-1 hover:ring-slate-200';

            $classes = $baseClasses . ' ' . $stateClasses;
            @endphp

            <a href="{{ route($item['route']) }}" class="{{ $classes }}"
                x-bind:class="sidebarCollapsed ? 'justify-center max-w-11' : ''">
                <div class="w-11 h-11 flex items-center justify-center">
                    <i class="fa-solid {{ $item['icon'] }}"></i>
                </div>
                <span class="whitespace-nowrap" x-show="!sidebarCollapsed">
                    {{ $item['label'] }}
                </span>
            </a>
            @endforeach
        </nav>
    </div>


    <div class="border-t border-white/60 px-4 py-4">
        <div x-show="sidebarCollapsed" class="flex flex-col items-center gap-2">
            <a href="{{ route('profile.edit') }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-700 ring-1 ring-brand-100">
                <span class="text-sm font-semibold">
                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(Auth::user()->name, 0, 1)) }}
                </span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="h-10 w-10 btn-brand ">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>

        <div x-show="!sidebarCollapsed" class="flex items-center gap-3">
            <a href="{{ route('profile.edit') }}"
                class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 ring-1 ring-brand-100">
                <span class="text-sm font-semibold">
                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(Auth::user()->name, 0, 1)) }}
                </span>
            </a>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                <p class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                @csrf
                <button type="submit"
                    class="h-10 w-10 btn-brand ">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>