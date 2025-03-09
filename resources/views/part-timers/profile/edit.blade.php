<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Edit Part-Timer Profile') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name) }}"
                               class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>

                    <!-- Bio -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Bio</label>
                        <textarea name="bio" rows="3"
                                  class="border border-gray-300 rounded-lg p-2 w-full">{{ old('bio', $profile->bio) }}</textarea>
                    </div>

                    <!-- Contact Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Phone -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                                   class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                        <!-- Location -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location', $profile->location) }}"
                                   class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Work Experience</label>
                        <input type="text" name="work_experience" value="{{ old('work_experience', $profile->work_experience) }}"
                               class="border border-gray-300 rounded-lg p-2 w-full">
                    </div>

                    <!-- Work Photos -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Upload Work Photos</label>
                        <input type="file" name="work_photos[]" multiple
                               class="border border-gray-300 rounded-lg p-2 w-full">
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
                    <div class="mt-6 flex justify-between items-center gap-4">
                        <a href="{{ url()->previous() }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200 w-full sm:w-auto text-center flex justify-center items-center">
                            Back
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200 w-full sm:w-auto text-center">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>