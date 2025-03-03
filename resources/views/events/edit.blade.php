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

                    <!-- Event Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Event Name</label>
                        <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('name', $event->name) }}">
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Job Type -->
                    <div class="mb-4">
                        <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type</label>
                        <input type="text" id="job_type" name="job_type" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('job_type', $event->job_type) }}">
                        @error('job_type')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('location', $event->location) }}">
                        @error('location')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('start_date', $event->start_date) }}">
                        @error('start_date')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="mb-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('end_date', $event->end_date) }}">
                        @error('end_date')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" class="w-full p-3 border border-gray-300 rounded-md">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Payment Amount -->
                    <div class="mb-4">
                        <label for="payment_amount" class="block text-sm font-medium text-gray-700">Payment Amount (RM)</label>
                        <input type="number" id="payment_amount" name="payment_amount" class="w-full p-3 border border-gray-300 rounded-md" step="0.01" value="{{ old('payment_amount', $event->payment_amount) }}">
                        @error('payment_amount')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>