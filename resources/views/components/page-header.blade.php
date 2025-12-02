@props([
    'path',
    'title',
    'description' => null,
])

<div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <div class="space-y-1">
        <p class="text-xs uppercase tracking-[0.18em] text-brand-600">{{ $path }}</p>
        <h2 class="text-2xl font-bold text-slate-900">{{ $title }}</h2>
        @if ($description)
            <p class="text-sm text-slate-500">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
