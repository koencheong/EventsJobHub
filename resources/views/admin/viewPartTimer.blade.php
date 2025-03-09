<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Part Timer Details') }}</h2>
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <!-- Profile Header -->
                <div class="flex items-center justify-between space-x-6 mb-12 border-b border-gray-200 pb-6">
                    <div class="flex items-center space-x-6">
                        <!-- Part Timer Avatar (Optional) -->
                        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-2xl font-bold text-blue-600">{{ substr($partTimer->name, 0, 1) }}</span>
                        </div>
                        <!-- Part Timer Name and Bio -->
                        <div>
                            <h1 class="text-4xl font-bold text-gray-800">{{ $partTimer->name }}</h1>
                            <p class="text-gray-600 mt-2 text-lg">{{ $partTimer->partTimerProfile->bio ?? 'No bio available' }}</p>
                        </div>
                    </div>
                    <!-- View Ratings Button -->
                    <a href="{{ route('ratings.show', ['userId' => $partTimer->id]) }}" 
                       class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200">
                        View Ratings
                    </a>
                </div>

                <!-- Profile Details -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Profile Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Phone -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-blue-600">
                                    <i class="bi bi-telephone"></i> <!-- Bootstrap Phone Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Phone</h4>
                                    <p class="text-gray-900 text-lg">{{ $partTimer->partTimerProfile->phone ?? 'Not specified' }}</p>
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
                                    <p class="text-gray-900 text-lg">{{ $partTimer->partTimerProfile->location ?? 'Not specified' }}</p>
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
                                    <p class="text-gray-900 text-lg">{{ $partTimer->partTimerProfile->work_experience ?? 'No experience added' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Work Photos -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Previous Work Photos</h2>
                    @php
                        $workPhotos = is_array($partTimer->partTimerProfile->work_photos) ? $partTimer->partTimerProfile->work_photos : json_decode($partTimer->partTimerProfile->work_photos ?? '[]', true);
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
                        <p class="text-gray-600">No photo</p> <!-- Updated to "No photo" -->
                    @endif
                </div>

                <!-- Back Button -->
                <div class="mt-6 text-center">
                    <a href="{{ route('admin.partTimers') }}" 
                       class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-lg transition hover:bg-blue-700">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</x-app-layout>