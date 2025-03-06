<x-app-layout>
    <div class="container mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">
            Ratings for {{ $user->name }}
        </h2>

        @if($ratings->isNotEmpty())
            <!-- Ratings Summary -->
            <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mb-6 text-center border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-700">Overall Rating</h3>
                <div class="flex justify-center items-center mt-2">
                    <span class="text-yellow-500 text-2xl">
                        {!! str_repeat('★', round($ratings->avg('rating'))) !!}
                        {!! str_repeat('☆', 5 - round($ratings->avg('rating'))) !!}
                    </span>
                </div>
                <p class="text-lg text-gray-600 font-medium mt-2">
                    {{ number_format($ratings->avg('rating'), 1) }} / 5 ({{ $ratings->count() }} reviews)
                </p>
            </div>

            <!-- Ratings List -->
            <div class="max-w-3xl mx-auto space-y-6">
                @foreach($ratings as $rating)
                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        <div class="flex items-center mb-4">
                            <img src="{{ $rating->fromUser->profile_photo_url ?? asset('default-avatar.png') }}" 
                                 alt="User Avatar" 
                                 class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="text-lg font-semibold text-gray-800">{{ $rating->fromUser->name ?? 'Anonymous' }}</p>
                                <p class="text-sm text-gray-500">{{ $rating->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-2">
                            <span class="text-yellow-500 text-lg">
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

                        <p class="text-gray-600 italic">
                            "{{ $rating->feedback ?? 'No feedback provided.' }}"
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500">No ratings yet.</p>
        @endif

        <div class="text-center mt-8">
            <a href="{{ url()->previous() }}" 
               class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                Back
            </a>
        </div>
    </div>
</x-app-layout>
