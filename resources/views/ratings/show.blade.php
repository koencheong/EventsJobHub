<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Ratings for {{ $user->name }}</h2>
    </x-slot>

    <div class="bg-gray-100 py-10"> 
        <div class="max-w-3xl mx-auto px-6">
            @if($ratings->isNotEmpty())
                <!-- Ratings Summary -->
                <div class="bg-white shadow-lg rounded-lg p-8 mb-8 text-center border border-gray-300">
                    <h3 class="text-2xl font-semibold text-gray-800">Overall Rating</h3>
                    <div class="flex justify-center items-center mt-3">
                        <span class="text-yellow-500 text-3xl">
                            {!! str_repeat('★', round($ratings->avg('rating'))) !!}
                            {!! str_repeat('☆', 5 - round($ratings->avg('rating'))) !!}
                        </span>
                    </div>
                    <p class="text-lg text-gray-700 font-medium mt-3">
                        {{ number_format($ratings->avg('rating'), 1) }} / 5 ({{ $ratings->count() }} reviews)
                    </p>
                </div>

                <!-- Ratings List -->
                <div class="space-y-6">
                    @foreach($ratings as $rating)
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300">
                            <div class="flex items-center mb-4">
                                <img src="{{ $rating->fromUser->profile_photo_url ?? asset('default-avatar.png') }}" 
                                     alt="User Avatar" 
                                     class="w-12 h-12 rounded-full border border-gray-300 mr-4">
                                <div>
                                    <p class="text-lg font-semibold text-gray-900">{{ $rating->fromUser->name ?? 'Anonymous' }}</p>
                                    <p class="text-sm text-gray-500">{{ $rating->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center mb-3">
                                <span class="text-yellow-500 text-xl">
                                    {!! str_repeat('★', $rating->rating) !!}
                                    {!! str_repeat('☆', 5 - $rating->rating) !!}
                                </span>
                            </div>

                            <!-- Display Event Name -->
                            @if($rating->event)
                                <p class="text-sm font-medium text-gray-700 mb-2">
                                    <span class="font-semibold">Event:</span> {{ $rating->event->name }}
                                </p>
                            @endif

                            <p class="text-gray-700 italic bg-gray-100 p-4 rounded-md border border-gray-200">
                                "{{ $rating->feedback ?? 'No feedback provided.' }}"
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 text-lg">No ratings yet.</p>
            @endif

            <div class="text-center mt-10">
                @php
                    // 1. Get the previous URL
                    $previousUrl = url()->previous();
                    // 2. Use the native PHP 8.0+ function str_contains() for reliability.
                    // This checks if the previous page URL contains the segment '/admin'.
                    $isAdmin = str_contains($previousUrl, '/admin');
                    
                    if ($isAdmin) {
                        // Admin: Go back to the Admin's list of all employers (fixed route).
                        $backRoute = route('admin.employers'); 
                    } else {
                        // Part-Timer: Go back to the Part-Timer's view of this specific employer 
                        // using the ID available in the current ratings view ($user->id).
                        $backRoute = route('part-timers.viewEmployer', ['userId' => $user->id]);
                    }
                @endphp

                <a href="{{ $backRoute }}" 
                class="px-6 py-3 bg-blue-600 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
