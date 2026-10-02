<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daily Handover: {{ $date->format('D, d M Y') }}
            </h2>
            <form method="GET" class="flex items-center gap-2">
                <input type="date" name="date" value="{{ $date->toDateString() }}"
                    class="border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Carry-over banner --}}
            @if ($carryOver->count())
                <div class="bg-amber-50 border border-amber-300 rounded-lg p-4">
                    <h3 class="font-semibold text-amber-800 mb-2">
                        ⚠ {{ $carryOver->count() }} pending from earlier days
                    </h3>
                    <div class="space-y-4">
                        @foreach ($carryOver as $activity)
                            @include('activities._card', ['activity' => $activity, 'showDate' => true])
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Today's activities --}}
            @forelse ($activities as $activity)
                @include('activities._card', ['activity' => $activity, 'showDate' => false])
            @empty
                <div class="bg-white shadow sm:rounded-lg p-8 text-center text-gray-500">
                    No activities for this date.
                    <a href="{{ route('activities.create') }}" class="text-indigo-600 underline">Add one</a>.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>