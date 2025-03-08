<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-100 shadow-xl rounded-lg p-8">
                
                <!-- Profile Header -->
                <div class="flex items-center space-x-6 mb-8">
                    <img class="w-20 h-20 rounded-full object-cover" 
                         src="{{ Auth::user()->profile_photo_url }}" 
                         alt="{{ Auth::user()->name }}" />
                    <!-- Name and Bio -->
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $profile->full_name }}</h3>
                        <p class="text-gray-600 italic">{{ $profile->bio ?? 'No bio available' }}</p>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Phone -->
                    <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-4">
                            <div class="text-2xl text-blue-600">
                                <i class="bi bi-telephone"></i> <!-- Bootstrap Phone Icon -->
                            </div>
                            <div>
                                <h4 class="text-gray-700 font-semibold">Phone</h4>
                                <p class="text-gray-900 text-lg">{{ $profile->phone ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-4">
                            <div class="text-2xl text-purple-600">
                                <i class="bi bi-geo-alt"></i> <!-- Bootstrap Location Icon -->
                            </div>
                            <div>
                                <h4 class="text-gray-700 font-semibold">Location</h4>
                                <p class="text-gray-900 text-lg">{{ $profile->location ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-4">
                            <div class="text-2xl text-green-600">
                                <i class="bi bi-briefcase"></i> <!-- Bootstrap Work Experience Icon -->
                            </div>
                            <div>
                                <h4 class="text-gray-700 font-semibold">Work Experience</h4>
                                <p class="text-gray-900 text-lg">{{ $profile->work_experience ?? 'No experience added' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Work Photos -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Previous Work Photos</h3>
                    
                    @php
                        $workPhotos = is_array($profile->work_photos) ? $profile->work_photos : json_decode($profile->work_photos ?? '[]', true);
                    @endphp

                    @if (!empty($workPhotos))
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($workPhotos as $photo)
                                <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                    <img src="{{ asset('storage/' . $photo) }}" 
                                         alt="Work Photo" 
                                         class="w-full h-48 object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition"></div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 italic">No photos uploaded</p>
                    @endif
                </div>

                   <!-- Ratings and Feedback Section -->
                   <a href="{{ route('ratings.show', ['userId' => auth()->id()]) }}" 
                    class="bg-green-500 text-white px-4 py-2.5 rounded-md text-sm hover:bg-green-600 transition">
                        View Ratings
                    </a>
                </div>

                <!-- Edit Button -->
                <div class="mt-8 text-center">
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out">
                    Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</x-app-layout>