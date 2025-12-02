@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-lg px-4 py-2 text-start text-sm font-semibold text-brand-700 bg-brand-50 ring-1 ring-brand-100 shadow-sm'
            : 'block w-full rounded-lg px-4 py-2 text-start text-sm font-semibold text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
