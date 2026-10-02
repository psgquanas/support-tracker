<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Activity</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('activities.store') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
                @csrf

                <div>
                    <x-input-label for="title" value="Activity title" />
                    <x-text-input id="title" name="title" class="block mt-1 w-full"
                        :value="old('title', 'Daily SMS count vs SMS count from logs')" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="activity_date" value="Date" />
                    <x-text-input id="activity_date" type="date" name="activity_date" class="block mt-1 w-full"
                        :value="old('activity_date', today()->toDateString())" required />
                    <x-input-error :messages="$errors->get('activity_date')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="system_count" value="Daily SMS count (system)" />
                        <x-text-input id="system_count" type="number" min="0" name="system_count" class="block mt-1 w-full" :value="old('system_count')" />
                        <x-input-error :messages="$errors->get('system_count')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="log_count" value="SMS count from logs" />
                        <x-text-input id="log_count" type="number" min="0" name="log_count" class="block mt-1 w-full" :value="old('log_count')" />
                        <x-input-error :messages="$errors->get('log_count')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Description (optional)" />
                    <textarea id="description" name="description" rows="3"
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>Save Activity</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>