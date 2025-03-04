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
                <form id="edit-event-form" action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Job Name -->
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
                        <select id="job_type" name="job_type" class="w-full p-3 border border-gray-300 rounded-md" required>
                            @foreach(App\Models\Event::jobTypes() as $type)
                                <option value="{{ $type }}" {{ old('job_type', $event->job_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('job_type')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Other Job Type (Conditional) -->
                    <div id="other_job_type_container" class="mb-4 {{ $event->job_type === 'Others' ? '' : 'hidden' }}">
                        <label for="other_job_type" class="block text-sm font-medium text-gray-700">Specify Job Type</label>
                        <input type="text" id="other_job_type" name="other_job_type" class="w-full p-3 border border-gray-300 rounded-md" value="{{ old('other_job_type', $event->other_job_type) }}">
                        @error('other_job_type')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Event Location -->
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

                    <!-- Job Photos -->
                    <div class="mb-6">
                        <label for="job_photos" class="block text-gray-700 font-medium mb-2">Upload Job Photos</label>
                        <input type="file" id="job_photos" name="job_photos[]" multiple
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <small class="text-gray-500">Upload up to 5 images</small>

                        <!-- Display Existing Photos -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            @php
                                $jobPhotos = is_array($event->job_photos) ? $event->job_photos : json_decode($event->job_photos ?? '[]', true);
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
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Save Changes
                    </button>
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