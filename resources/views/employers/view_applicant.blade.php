<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Applicant Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8 rounded-xl overflow-hidden">
                
                <!-- Profile Header -->
                <div class="mb-8 border-b pb-6">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $partTimer->full_name }}</h3>
                    <p class="text-gray-600 italic">{{ $partTimer->bio ?? 'No bio available' }}</p>
                </div>

                <!-- Profile Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="p-4 bg-gray-100 rounded-lg">
                        <h4 class="text-gray-700 font-semibold text-lg">Phone</h4>
                        <p class="text-gray-800 font-medium">{{ $partTimer->phone ?? 'Not specified' }}</p>
                    </div>
                    <div class="p-4 bg-gray-100 rounded-lg">
                        <h4 class="text-gray-700 font-semibold text-lg">Location</h4>
                        <p class="text-gray-800 font-medium">{{ $partTimer->location ?? 'Not specified' }}</p>
                    </div>
                    <div class="p-4 bg-gray-100 rounded-lg">
                        <h4 class="text-gray-700 font-semibold text-lg">Work Experience</h4>
                        <p class="text-gray-800 font-medium">{{ $partTimer->work_experience ?? 'No experience added' }}</p>
                    </div>
                </div>

                <!-- Work Photos -->
                @php
                    $workPhotos = is_array($partTimer->work_photos) ? $partTimer->work_photos : json_decode($partTimer->work_photos ?? '[]', true);
                @endphp

                <div class="mt-6">
                    <h3 class="text-xl font-semibold border-b pb-2">Previous Work Photos</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                        @forelse ($workPhotos as $photo)
                            <img src="{{ asset('storage/' . $photo) }}" class="w-full h-32 object-cover rounded-lg shadow">
                        @empty
                            <p class="text-gray-500 italic">No photos uploaded</p>
                        @endforelse
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-6 text-center">
                    <a href="{{ url()->previous() }}"
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg shadow-lg transition hover:bg-gray-700">
                        Back
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>