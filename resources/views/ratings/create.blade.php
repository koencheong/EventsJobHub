<x-app-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">
                {{ __('Rating and Feedback') }}
            </h2>

            <form action="{{ route('events.rate', $event->id) }}" method="POST">
                @csrf
                <input type="hidden" name="to_user_id" value="{{ $toUser->id }}">
                <input type="hidden" name="type" value="{{ $type }}">

                <!-- Rating Selection -->
                <div class="mb-5">
                    <label for="rating" class="block font-semibold text-gray-700 mb-2">Rating (1-5):</label>
                    <select name="rating" class="w-full p-3 border border-gray-300 rounded-lg text-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
                        <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
                        <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                        <option value="3">⭐⭐⭐ (3 Stars)</option>
                        <option value="2">⭐⭐ (2 Stars)</option>
                        <option value="1">⭐ (1 Star)</option>
                    </select>
                </div>

                <!-- Feedback Textarea -->
                <div class="mb-5">
                    <label for="feedback" class="block font-semibold text-gray-700 mb-2">Feedback (optional):</label>
                    <textarea name="feedback" class="w-full p-3 border border-gray-300 rounded-lg text-lg focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none" rows="4" maxlength="1000" placeholder="Write your feedback here..."></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-center space-x-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 shadow-md">
                        Submit Rating
                    </button>
                    @if (auth()->user()->role === 'part-timer')
                        <a href="{{ route('part-timers.dashboard') }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            Cancel
                        </a>
                    @elseif (auth()->user()->role === 'employer')
                        <a href="{{ route('dashboard') }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            Cancel
                        </a>
                    @endif

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
