<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8 rounded-xl overflow-hidden">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-6">
                        <label for="full_name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name) }}"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Bio -->
                    <div class="mb-6">
                        <label for="bio" class="block text-gray-700 font-medium mb-2">Bio</label>
                        <textarea id="bio" name="bio" rows="3"
                                  class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('bio', $profile->bio) }}</textarea>
                    </div>

                    <!-- Phone -->
                    <div class="mb-6">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Location -->
                    <div class="mb-6">
                        <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $profile->location) }}"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Work Experience -->
                    <div class="mb-6">
                        <label for="work_experience" class="block text-gray-700 font-medium mb-2">Work Experience</label>
                        <input type="text" id="work_experience" name="work_experience"
                               value="{{ old('work_experience', $profile->work_experience) }}"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Work Photos -->
                    <div class="mb-6">
                        <label for="work_photos" class="block text-gray-700 font-medium mb-2">Upload Work Photos</label>
                        <input type="file" id="work_photos" name="work_photos[]" multiple
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <small class="text-gray-500">Upload up to 5 images</small>

                        <!-- Display Existing Photos -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            @php
                                $workPhotos = is_array($profile->work_photos) ? $profile->work_photos : json_decode($profile->work_photos ?? '[]', true);
                            @endphp

                            @forelse ($workPhotos as $photo)
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

                    <!-- Save Button -->
                    <div class="text-center">
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-lg transition hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
