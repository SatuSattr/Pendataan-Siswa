@props(['active'])

@php
$classes = ($active ?? false)
            ? 'group flex min-h-11 min-w-11 items-center gap-3 rounded-2xl px-3 py-3 text-sm font-semibold text-brand-800 bg-brand-50 ring-1 ring-brand-100 shadow-sm transition'
            : 'group flex min-h-11 min-w-11 items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-white hover:ring-1 hover:ring-slate-200 transition';


@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
