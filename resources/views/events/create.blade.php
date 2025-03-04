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
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
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
                            <select id="job_type" name="job_type" class="mt-2 p-2 border border-gray-300 rounded" required>
                                <option value="">Select Job Type</option>
                                @foreach(App\Models\Event::jobTypes() as $type)
                                    <option value="{{ $type }}" {{ old('job_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('job_type')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Other Job Type (Conditional) -->
                        <div id="other_job_type_container" class="flex flex-col hidden">
                            <label for="other_job_type" class="text-lg font-semibold text-gray-800">Specify Job Type</label>
                            <input type="text" id="other_job_type" name="other_job_type" class="mt-2 p-2 border border-gray-300 rounded" value="{{ old('other_job_type') }}">
                            @error('other_job_type')
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
                            <label for="start_date" class="text-lg font-semibold text-gray-800">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="mt-2 p-2 border border-gray-300 rounded" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Event End Date -->
                        <div class="flex flex-col">
                            <label for="end_date" class="text-lg font-semibold text-gray-800">End Date</label>
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

                        <!-- Job Photos -->
                        <div class="mb-6">
                            <label for="job_photos" class="block text-gray-700 font-medium mb-2">Upload Job Photos</label>
                            <input type="file" id="job_photos" name="job_photos[]" multiple
                                class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <small class="text-gray-500">Upload up to 5 images</small>

                            <!-- Display Existing Photos -->
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                                @php
                                    $jobPhotos = isset($event) ? (is_array($event->job_photos) ? $event->job_photos : json_decode($event->job_photos ?? '[]', true)) : [];
                                @endphp

                                @forelse ($jobPhotos as $photo)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-full h-32 object-cover rounded-lg shadow">
                                        
                                        <!-- Checkbox with Tailwind styling -->
                                        <label class="absolute top-2 right-2 flex items-center space-x-1 bg-white p-2 rounded-full shadow">
                                            <input type="checkbox" name="remove_photos[]" value="{{ $photo }}" class="w-4 h-4">
                                            <span class="text-sm text-gray-700">Remove</span>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-gray-500 italic">No photos uploaded</p>
                                @endforelse
                            </div>
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

    <script>
        // Show/hide "Other Job Type" field based on selection
        const jobTypeSelect = document.getElementById('job_type');
        const otherJobTypeContainer = document.getElementById('other_job_type_container');

        jobTypeSelect.addEventListener('change', function() {
            if (this.value === 'Others') {
                otherJobTypeContainer.classList.remove('hidden');
            } else {
                otherJobTypeContainer.classList.add('hidden');
            }
        });

        // Trigger change event on page load if "Others" is selected
        if (jobTypeSelect.value === 'Others') {
            otherJobTypeContainer.classList.remove('hidden');
        }

        // Not more than 5 photos
        document.addEventListener('DOMContentLoaded', function () {
            const jobPhotosInput = document.getElementById('job_photos');

            jobPhotosInput.addEventListener('change', function (event) {
                const existingPhotos = document.querySelectorAll('input[name="remove_photos[]"]').length;
                const selectedFiles = this.files.length;
                const totalPhotos = existingPhotos + selectedFiles;

                if (totalPhotos > 5) {
                    alert(`You can only have up to 5 images. You already have ${existingPhotos} existing images.`);
                    this.value = ''; // Reset file input
                }
            });
        });

    </script>

</x-app-layout>