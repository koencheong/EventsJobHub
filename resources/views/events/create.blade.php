<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post a New Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Job Name -->
                        <div>
                            <label for="name" class="block text-lg font-medium text-gray-800">Job Name</label>
                            <input type="text" id="name" name="name" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" value="{{ old('name') }}" required>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Job Type -->
                        <div>
                            <label for="job_type" class="block text-lg font-medium text-gray-800">Job Type</label>
                            <select id="job_type" name="job_type" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" required>
                                <option value="">Select Job Type</option>
                                @foreach(App\Models\Event::jobTypes() as $type)
                                    <option value="{{ $type }}" {{ old('job_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('job_type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Other Job Type (Conditional) -->
                        <div id="other_job_type_container" class="hidden">
                            <label for="other_job_type" class="block text-lg font-medium text-gray-800">Specify Job Type</label>
                            <input type="text" id="other_job_type" name="other_job_type" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" value="{{ old('other_job_type') }}">
                            @error('other_job_type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Job Description (Full width) -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="description" class="block text-lg font-medium text-gray-800">Job Description</label>
                            <textarea id="description" name="description" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-lg font-medium text-gray-800">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" value="{{ old('start_date') }}" required>
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-lg font-medium text-gray-800">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" value="{{ old('end_date') }}" required>
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-lg font-medium text-gray-800">Event Location</label>
                            <input type="text" id="location" name="location" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" value="{{ old('location') }}" required>
                            @error('location')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Payment Amount -->
                        <div>
                            <label for="payment_amount" class="block text-lg font-medium text-gray-800">Payment Amount (RM)</label>
                            <input type="number" id="payment_amount" name="payment_amount" class="mt-2 w-full p-2 border border-gray-300 rounded-lg" step="0.01" value="{{ old('payment_amount') }}" required>
                            @error('payment_amount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Job Photos (Full Width) -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="job_photos" class="block text-lg font-medium text-gray-800">Upload Job Photos</label>
                            <input type="file" id="job_photos" name="job_photos[]" multiple class="mt-2 w-full p-2 border border-gray-300 rounded-lg">
                            <small class="text-gray-500">Upload up to 5 images</small>

                            <!-- Display Existing Photos -->
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                                @php
                                    $jobPhotos = isset($event) ? (is_array($event->job_photos) ? $event->job_photos : json_decode($event->job_photos ?? '[]', true)) : [];
                                @endphp

                                @forelse ($jobPhotos as $photo)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-full h-32 object-cover rounded-lg shadow">
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
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                            Post Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jobTypeSelect = document.getElementById('job_type');
            const otherJobTypeContainer = document.getElementById('other_job_type_container');
            const jobPhotosInput = document.getElementById('job_photos');

            jobTypeSelect.addEventListener('change', function() {
                if (this.value === 'Others') {
                    otherJobTypeContainer.classList.remove('hidden');
                } else {
                    otherJobTypeContainer.classList.add('hidden');
                }
            });

            if (jobTypeSelect.value === 'Others') {
                otherJobTypeContainer.classList.remove('hidden');
            }

            jobPhotosInput.addEventListener('change', function (event) {
                const existingPhotos = document.querySelectorAll('input[name="remove_photos[]"]').length;
                const selectedFiles = this.files.length;
                const totalPhotos = existingPhotos + selectedFiles;

                if (totalPhotos > 5) {
                    alert(`You can only have up to 5 images.`);
                    this.value = ''; // Reset file input
                }
            });
        });

    </script>

</x-app-layout>