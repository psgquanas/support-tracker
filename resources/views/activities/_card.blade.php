@php
    $mismatch = !is_null($activity->system_count) && !is_null($activity->log_count)
        && $activity->system_count !== $activity->log_count;
@endphp

<div class="bg-white shadow sm:rounded-lg p-5">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h3 class="font-semibold text-gray-900">{{ $activity->title }}</h3>
            @if ($showDate)
                <p class="text-xs text-gray-500">From {{ $activity->activity_date->format('d M Y') }}</p>
            @endif
            @if ($activity->description)
                <p class="text-sm text-gray-600 mt-1">{{ $activity->description }}</p>
            @endif
        </div>

        <span class="px-3 py-1 rounded-full text-xs font-semibold
            {{ $activity->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ strtoupper($activity->status) }}
        </span>
    </div>

    @if (!is_null($activity->system_count) || !is_null($activity->log_count))
        <div class="mt-3 flex gap-6 text-sm">
            <div>System: <strong>{{ number_format($activity->system_count ?? 0) }}</strong></div>
            <div>Logs: <strong>{{ number_format($activity->log_count ?? 0) }}</strong></div>
            <div class="{{ $mismatch ? 'text-red-600 font-semibold' : 'text-green-600' }}">
                @if ($mismatch)
                    Mismatch of {{ number_format(abs($activity->system_count - $activity->log_count)) }}
                @else
                    Counts match
                @endif
            </div>
        </div>
    @endif

    {{-- Update timeline --}}
    <div class="mt-4 border-l-2 border-gray-200 pl-4 space-y-3">
        @forelse ($activity->updates as $update)
            <div class="text-sm">
                <span class="font-semibold {{ $update->status === 'done' ? 'text-green-700' : 'text-red-700' }}">
                    {{ strtoupper($update->status) }}
                </span>
                by <strong>{{ $update->user->name }}</strong>
                <span class="text-gray-500">
                    ({{ $update->user->staff_id }}, {{ $update->user->phone }})
                </span>
                at <strong>{{ $update->created_at->format('H:i') }}</strong>
                <span class="text-gray-400">on {{ $update->created_at->format('d M Y') }}</span>
                @if ($update->remark)
                    <p class="text-gray-700 italic">"{{ $update->remark }}"</p>
                @endif
            </div>
        @empty
            <p class="text-sm text-gray-400">No updates yet.</p>
        @endforelse
    </div>

    {{-- Update form --}}
    <form method="POST" action="{{ route('activities.updates.store', $activity) }}"
        class="mt-4 flex flex-wrap items-end gap-2">
        @csrf
        <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
            <option value="pending" @selected($activity->status === 'pending')>Pending</option>
            <option value="done" @selected($activity->status === 'done')>Done</option>
        </select>
        <input type="text" name="remark" placeholder="Remark (e.g. waiting on telco logs)"
            class="flex-1 min-w-[200px] border-gray-300 rounded-md shadow-sm text-sm">
        <x-primary-button>Update</x-primary-button>
    </form>
</div>