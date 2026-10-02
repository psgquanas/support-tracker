@props(['dark' => false])

<div class="flex items-center gap-2.5">
    <span class="grid h-9 w-9 place-items-center rounded-xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
    </span>
    <span class="text-lg font-bold tracking-tight {{ $dark ? 'text-white' : 'text-slate-900' }}">
        {{ config('app.name') }}
    </span>
</div>