<!-- resources/views/events/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-4">Edit Event</h1>
                
                <!-- Edit Event Form -->
                <form action="{{ route('events.update', $event->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Event Name</label>
                        <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('name', $event->name) }}">
                    </div>

                    <div class="mb-4">
                        <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type</label>
                        <input type="text" id="job_type" name="job_type" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('job_type', $event->job_type) }}">
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('location', $event->location) }}">
                    </div>

                    <div class="mb-4">
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" id="date" name="date" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('date', $event->date) }}">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" class="w-full p-3 border border-gray-300 rounded-md">{{ old('description', $event->description) }}</textarea>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
