<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('My Portfolio') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8 rounded-xl overflow-hidden">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold">Full Name:</h3>
                    <p class="text-gray-700">{{ $portfolio->full_name }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold">Phone:</h3>
                    <p class="text-gray-700">{{ $portfolio->phone }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold">Location:</h3>
                    <p class="text-gray-700">{{ $portfolio->location ?? 'Not specified' }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold">Bio:</h3>
                    <p class="text-gray-700">{{ $portfolio->bio ?? 'No bio available' }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold">Work Experience:</h3>
                    <p class="text-gray-700">{{ $portfolio->work_experience ?? 'No experience added' }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold">Previous Work Photos:</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach (json_decode($portfolio->work_photos ?? '[]') as $photo)
                            <img src="{{ asset('storage/' . $photo) }}" class="w-full rounded-lg shadow">
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('portfolio.edit') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow">
                        Edit Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
