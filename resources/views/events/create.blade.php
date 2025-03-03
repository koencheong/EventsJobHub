<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post a New Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form to post a job -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <form action="{{ route('events.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Job Name -->
                        <div class="flex flex-col">
                            <label for="name" class="text-lg font-semibold text-gray-800">Job Name</label>
                            <input type="text" id="name" name="name" class="mt-2 p-2 border border-gray-300 rounded" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Job Type -->
                        <div class="flex flex-col">
                            <label for="job_type" class="text-lg font-semibold text-gray-800">Job Type</label>
                            <input type="text" id="job_type" name="job_type" class="mt-2 p-2 border border-gray-300 rounded" value="{{ old('job_type') }}" required>
                            @error('job_type')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Job Description -->
                        <div class="flex flex-col">
                            <label for="description" class="text-lg font-semibold text-gray-800">Job Description</label>
                            <textarea id="description" name="description" class="mt-2 p-2 border border-gray-300 rounded" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Event Start Date -->
                        <div class="flex flex-col">
                            <label for="start_date" class="text-lg font-semibold text-gray-800">Event Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="mt-2 p-2 border border-gray-300 rounded" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Event End Date -->
                        <div class="flex flex-col">
                            <label for="end_date" class="text-lg font-semibold text-gray-800">Event End Date</label>
                            <input type="date" id="end_date" name="end_date" class="mt-2 p-2 border border-gray-300 rounded" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Event Location -->
                        <div class="flex flex-col">
                            <label for="location" class="text-lg font-semibold text-gray-800">Event Location</label>
                            <input type="text" id="location" name="location" class="mt-2 p-2 border border-gray-300 rounded" value="{{ old('location') }}" required>
                            @error('location')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Rate -->
                        <div class="flex flex-col">
                            <label for="payment_amount" class="text-lg font-semibold text-gray-800">Payment Amount (RM)</label>
                            <input type="number" id="payment_amount" name="payment_amount" class="mt-2 p-2 border border-gray-300 rounded" step="0.01" value="{{ old('payment_amount') }}" required>
                            @error('payment_amount')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Post Job
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>