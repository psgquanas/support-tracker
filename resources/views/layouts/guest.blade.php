<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-slate-900" style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- Brand panel --}}
        <aside class="hidden lg:flex flex-col justify-between bg-slate-900 text-white p-12 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-emerald-500/20 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-20 h-96 w-96 rounded-full bg-sky-500/10 blur-3xl"></div>

            <a href="/" class="relative"><x-brand :dark="true" /></a>

            <div class="relative">
                <h2 class="text-4xl font-extrabold leading-tight tracking-tight">
                    Hand over every shift<br>
                    <span class="text-emerald-400">without dropping a task.</span>
                </h2>
                <p class="mt-4 max-w-md text-slate-300">
                    Track daily checks, see who updated what and when, and know exactly what is still pending.
                </p>

                {{-- Mini timeline preview --}}
                <div class="mt-10 max-w-md rounded-2xl bg-white/5 ring-1 ring-white/10 p-5 backdrop-blur">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Daily SMS count vs logs</span>
                        <span class="rounded-full bg-amber-400/20 px-2.5 py-0.5 text-xs font-semibold text-amber-300">PENDING</span>
                    </div>
                    <div class="mt-4 space-y-3 border-l border-white/15 pl-4 text-sm">
                        <div>
                            <span class="font-semibold text-emerald-400">DONE</span>
                            <span class="text-slate-300"> by Ama · 08:42</span>
                            <p class="text-slate-400 italic">"Counts match for MTN route"</p>
                        </div>
                        <div>
                            <span class="font-semibold text-amber-300">PENDING</span>
                            <span class="text-slate-300"> by Kofi · 14:10</span>
                            <p class="text-slate-400 italic">"Waiting on Telecel logs"</p>
                        </div>
                    </div>
                </div>
            </div>

            <p class="relative text-xs text-slate-500">© {{ date('Y') }} {{ config('app.name') }}</p>
        </aside>

        {{-- Form panel --}}
        <main class="flex flex-col justify-center bg-slate-50 px-6 py-12 sm:px-12">
            <div class="mx-auto w-full max-w-md">
                <a href="/" class="lg:hidden mb-8 inline-block"><x-brand /></a>
                <div class="rounded-2xl bg-white p-8 shadow-xl shadow-slate-200/60 ring-1 ring-slate-100">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>