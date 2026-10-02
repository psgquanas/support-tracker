<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Activity Reports</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filters --}}
            <form method="GET" action="{{ route('reports.index') }}"
                class="bg-white shadow sm:rounded-lg p-5 flex flex-wrap items-end gap-4">
                <div>
                    <x-input-label for="from" value="From" />
                    <x-text-input id="from" type="date" name="from" :value="$from" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="to" value="To" />
                    <x-text-input id="to" type="date" name="to" :value="$to" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="mt-1 border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All</option>
                        <option value="done" @selected($status === 'done')>Done</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                    </select>
                </div>
                <x-primary-button>Run Report</x-primary-button>
                <a href="{{ route('reports.export', request()->query()) }}"
                    class="text-sm text-indigo-600 underline pb-2">Export CSV</a>
            </form>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Summary --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white shadow sm:rounded-lg p-4">
                    <div class="text-xs text-gray-500">Total activities</div>
                    <div class="text-2xl font-bold">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-4">
                    <div class="text-xs text-gray-500">Done</div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['done'] }}</div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-4">
                    <div class="text-xs text-gray-500">Pending</div>
                    <div class="text-2xl font-bold text-red-600">{{ $stats['pending'] }}</div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-4">
                    <div class="text-xs text-gray-500">Count mismatches</div>
                    <div class="text-2xl font-bold text-amber-600">{{ $stats['mismatches'] }}</div>
                </div>
            </div>

            {{-- Results --}}
            @forelse ($activities as $activity)
                <div class="bg-white shadow sm:rounded-lg p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-xs text-gray-500">{{ $activity->activity_date->format('D, d M Y') }}</div>
                            <h3 class="font-semibold text-gray-900">{{ $activity->title }}</h3>
                            @if (!is_null($activity->system_count) || !is_null($activity->log_count))
                                <div class="text-sm text-gray-600">
                                    System: <strong>{{ number_format($activity->system_count ?? 0) }}</strong> |
                                    Logs: <strong>{{ number_format($activity->log_count ?? 0) }}</strong>
                                </div>
                            @endif
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $activity->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ strtoupper($activity->status) }}
                        </span>
                    </div>

                    <div class="mt-3 border-l-2 border-gray-200 pl-4 space-y-2">
                        @forelse ($activity->updates->sortBy('created_at') as $update)
                            <div class="text-sm">
                                <strong class="{{ $update->status === 'done' ? 'text-green-700' : 'text-red-700' }}">
                                    {{ strtoupper($update->status) }}
                                </strong>
                                by {{ $update->user->name }} ({{ $update->user->staff_id }})
                                at {{ $update->created_at->format('d M Y, H:i') }}
                                @if ($update->remark)
                                    <span class="text-gray-600 italic">: "{{ $update->remark }}"</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">No updates recorded.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="bg-white shadow sm:rounded-lg p-8 text-center text-gray-500">
                    No activities found for this period.
                </div>
            @endforelse

            {{ $activities->links() }}
        </div>
    </div>
</x-app-layout>