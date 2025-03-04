<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Job Name -->
                        <div>
                            <label for="name" class="block text-lg font-medium text-gray-800">Job Name</label>
                            <input type="text" id="name" name="name" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" value="{{ old('name', $event->name) }}" required>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Job Type -->
                        <div>
                            <label for="job_type" class="block text-lg font-medium text-gray-800">Job Type</label>
                            <select id="job_type" name="job_type" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" required>
                                <option value="">Select Job Type</option>
                                @foreach(App\Models\Event::jobTypes() as $type)
                                    <option value="{{ $type }}" {{ old('job_type', $event->job_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('job_type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Job Description -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="description" class="block text-lg font-medium text-gray-800">Job Description</label>
                            <textarea id="description" name="description" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" rows="4" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Start Date & End Date -->
                        <div>
                            <label for="start_date" class="block text-lg font-medium text-gray-800">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" value="{{ old('start_date', $event->start_date) }}" required>
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-lg font-medium text-gray-800">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" value="{{ old('end_date', $event->end_date) }}" required>
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Location & Payment Amount -->
                        <div>
                            <label for="location" class="block text-lg font-medium text-gray-800">Event Location</label>
                            <input type="text" id="location" name="location" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" value="{{ old('location', $event->location) }}" required>
                            @error('location')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="payment_amount" class="block text-lg font-medium text-gray-800">Payment Amount (RM)</label>
                            <input type="number" id="payment_amount" name="payment_amount" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" step="0.01" value="{{ old('payment_amount', $event->payment_amount) }}" required>
                            @error('payment_amount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Job Photos -->
                    <div class="mt-6">
                        <label class="block text-lg font-medium text-gray-800">Job Photos</label>
                        
                        <!-- Display Existing Photos -->
                        @if ($event->job_photos)
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach(json_decode($event->job_photos, true) as $photo)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-32 h-32 object-cover rounded-lg shadow">
                                         <!-- Checkbox with Tailwind styling -->
                                        <label class="absolute top-2 right-2 flex items-center space-x-1 bg-white p-2 rounded-full shadow">
                                            <input type="checkbox" name="remove_photos[]" value="{{ $photo }}" class="w-4 h-4">
                                            <span class="text-sm text-gray-700">Remove</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Upload New Photos -->
                        <div class="mt-4">
                            <input type="file" name="job_photos[]" multiple class="w-full p-2 border border-gray-300 rounded-lg">
                            <p class="text-sm text-gray-500 mt-1">You can upload up to 5 images.</p>
                            @error('job_photos')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                            Update Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
