<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Report an Issue') }}
        </h2>
    </x-slot>

    <div class="min-h-screen flex flex-col justify-center items-center">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8 mt-8 mb-16 border border-gray-200">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Report an Issue</h2>
            <p class="text-gray-600 mb-6">If you've encountered a problem, please provide details below. Our admin team will review and respond accordingly.</p>

            <form action="{{ route('reports.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Subject</label>
                    <input type="text" name="subject" required class="w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg p-3 shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Message</label>
                    <textarea name="message" required rows="5" class="w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg p-3 shadow-sm"></textarea>
                </div>

                <!-- Button Container -->
                <div class="flex justify-between">
                    <a href="{{ url()->previous() }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300">
                        Back
                    </a>

                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300">
                        Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
