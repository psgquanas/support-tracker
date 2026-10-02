@props(['active'])

@php
$classes = ($active ?? false)
    ? 'rounded-lg bg-white/10 px-3 py-2 text-sm font-semibold text-white'
    : 'rounded-lg px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>