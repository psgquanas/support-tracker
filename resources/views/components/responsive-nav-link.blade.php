@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block rounded-lg bg-white/10 px-3 py-2 text-base font-semibold text-white'
    : 'block rounded-lg px-3 py-2 text-base font-medium text-slate-300 transition hover:bg-white/5 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>