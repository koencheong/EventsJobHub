<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Report an Issue') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-semibold mb-4">Report an Issue</h2>
        <p class="text-gray-600 mb-4">Please describe the issue you encountered. Our admin team will review and respond accordingly.</p>

        <form action="{{ route('reports.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Subject</label>
                <input type="text" name="subject" required class="w-full border-gray-300 rounded-lg p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Message</label>
                <textarea name="message" required rows="4" class="w-full border-gray-300 rounded-lg p-2"></textarea>
            </div>

            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                Submit Report
            </button>
        </form>
    </div>
</x-app-layout>
