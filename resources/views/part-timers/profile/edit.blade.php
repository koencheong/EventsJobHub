<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg p-8">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-6">
                        <label for="full_name" class="block text-gray-700 font-medium mb-2">
                            <i class="bi bi-person text-blue-600 mr-2"></i> Full Name
                        </label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name) }}"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                    </div>

                    <!-- Bio -->
                    <div class="mb-6">
                        <label for="bio" class="block text-gray-700 font-medium mb-2">
                            <i class="bi bi-pencil text-blue-600 mr-2"></i> Bio
                        </label>
                        <textarea id="bio" name="bio" rows="3"
                                  class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300">{{ old('bio', $profile->bio) }}</textarea>
                    </div>

                    <!-- Phone -->
                    <div class="mb-6">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">
                            <i class="bi bi-telephone text-blue-600 mr-2"></i> Phone
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                    </div>

                    <!-- Location -->
                    <div class="mb-6">
                        <label for="location" class="block text-gray-700 font-medium mb-2">
                            <i class="bi bi-geo-alt text-blue-600 mr-2"></i> Location
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location', $profile->location) }}"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                    </div>

                    <!-- Work Experience -->
                    <div class="mb-6">
                        <label for="work_experience" class="block text-gray-700 font-medium mb-2">
                            <i class="bi bi-briefcase text-blue-600 mr-2"></i> Work Experience
                        </label>
                        <input type="text" id="work_experience" name="work_experience"
                               value="{{ old('work_experience', $profile->work_experience) }}"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                    </div>

                    <!-- Work Photos -->
                    <div class="mb-6">
                        <label for="work_photos" class="block text-gray-700 font-medium mb-2">
                            <i class="bi bi-images text-blue-600 mr-2"></i> Upload Work Photos
                        </label>
                        <input type="file" id="work_photos" name="work_photos[]" multiple
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                        <small class="text-gray-500">Upload up to 5 images</small>

                        <!-- Display Existing Photos -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            @php
                                $workPhotos = is_array($profile->work_photos) ? $profile->work_photos : json_decode($profile->work_photos ?? '[]', true);
                            @endphp

                            @forelse ($workPhotos as $photo)
                                <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                    <img src="{{ asset('storage/' . $photo) }}" class="w-full h-32 object-cover">
                                    
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

                    <!-- Buttons -->
                    <div class="flex justify-center space-x-4">
                        <!-- Save Button -->
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</x-app-layout>