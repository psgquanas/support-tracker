<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white text-slate-900" style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">

    {{-- Nav --}}
    <header class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5">
        <x-brand />
        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ route('activities.index') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    Open handover
                </a>
            @else
                <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900">Sign in</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Get started</a>
            @endauth
        </nav>
    </header>

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 -z-10 h-[520px] bg-gradient-to-b from-emerald-50 to-white"></div>
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-6 pb-20 pt-12 lg:grid-cols-2 lg:pt-20">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Built for applications support teams
                </span>
                <h1 class="mt-5 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                    Shift handovers that
                    <span class="text-emerald-600">never lose a task.</span>
                </h1>
                <p class="mt-5 max-w-xl text-lg text-slate-600">
                    Log daily checks like SMS count versus log count, mark them done or pending with a remark,
                    and give the next person a clear trail of who did what and when.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('activities.index') }}" class="rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white shadow-lg shadow-emerald-600/25 hover:bg-emerald-700">
                            Go to today's handover
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white shadow-lg shadow-emerald-600/25 hover:bg-emerald-700">
                            Create an account
                        </a>
                        <a href="{{ route('login') }}" class="rounded-xl bg-white px-6 py-3 font-semibold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50">
                            Sign in
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Product preview --}}
            <div class="relative">
                <div class="absolute -inset-4 -z-10 rounded-3xl bg-gradient-to-tr from-emerald-200/50 to-sky-200/40 blur-2xl"></div>
                <div class="rounded-2xl bg-white p-6 shadow-2xl shadow-slate-300/50 ring-1 ring-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500">{{ now()->format('D, d M Y') }}</p>
                            <h3 class="font-bold">Daily SMS count vs logs</h3>
                        </div>
                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">PENDING</span>
                    </div>

                    <div class="mt-4 flex gap-6 text-sm">
                        <div>System: <strong>48,210</strong></div>
                        <div>Logs: <strong>48,172</strong></div>
                        <div class="font-semibold text-red-600">Mismatch of 38</div>
                    </div>

                    <div class="mt-5 space-y-4 border-l-2 border-slate-200 pl-4 text-sm">
                        <div>
                            <strong class="text-red-700">PENDING</strong> by <strong>Kofi</strong>
                            <span class="text-slate-400">· 14:10</span>
                            <p class="italic text-slate-600">"Waiting on Telecel logs"</p>
                        </div>
                        <div>
                            <strong class="text-green-700">DONE</strong> by <strong>Ama</strong>
                            <span class="text-slate-400">· 08:42</span>
                            <p class="italic text-slate-600">"MTN route verified"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="mx-auto max-w-6xl px-6 py-16">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([
                ['Clear handovers', 'Every day shows each activity, every update, who made it and the exact time.', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['Count reconciliation', 'Enter system and log counts side by side and spot mismatches instantly.', 'M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z'],
                ['Reports on demand', 'Query any date range, filter by status and export the history to CSV.', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ] as [$title, $text, $icon])
                <div class="rounded-2xl p-6 ring-1 ring-slate-200 transition hover:shadow-lg">
                    <span class="grid h-10 w-10 place-items-center rounded-lg bg-emerald-100 text-emerald-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                        </svg>
                    </span>
                    <h3 class="mt-4 font-bold">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <footer class="border-t border-slate-100 py-8 text-center text-sm text-slate-500">
        © {{ date('Y') }} {{ config('app.name') }}
    </footer>
</body>
</html>