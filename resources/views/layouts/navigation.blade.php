<nav x-data="{ open: false }" class="bg-slate-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- Left: brand + links --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('activities.index') }}">
                    <x-brand :dark="true" />
                </a>

                <div class="hidden sm:flex sm:items-center sm:gap-1">
                    <x-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.index')">
                        {{ __('Handover') }}
                    </x-nav-link>
                    <x-nav-link :href="route('activities.create')" :active="request()->routeIs('activities.create')">
                        {{ __('New Activity') }}
                    </x-nav-link>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                        {{ __('Reports') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- Right: user menu --}}
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm text-slate-200 transition hover:bg-white/10 focus:outline-none">
                            <span class="grid h-8 w-8 place-items-center rounded-full bg-emerald-500 text-sm font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="border-b border-slate-100 px-4 py-2 text-xs text-slate-500">
                            Staff ID: {{ Auth::user()->staff_id ?? 'N/A' }}
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile hamburger --}}
            <button @click="open = !open" class="rounded-lg p-2 text-slate-300 hover:bg-white/10 sm:hidden">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak class="border-t border-white/10 sm:hidden">
        <div class="space-y-1 px-4 py-3">
            <x-responsive-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.index')">{{ __('Handover') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('activities.create')" :active="request()->routeIs('activities.create')">{{ __('New Activity') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">{{ __('Reports') }}</x-responsive-nav-link>
        </div>

        <div class="border-t border-white/10 px-4 py-3">
            <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
            <div class="text-xs text-slate-400">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>