<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold tracking-tight">Welcome back</h1>
        <p class="mt-1 text-sm text-slate-500">Sign in to see today's handover.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
            <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
        </label>

        <x-primary-button class="w-full">{{ __('Sign in') }}</x-primary-button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        New to the team?
        <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Create an account</a>
    </p>
</x-guest-layout>