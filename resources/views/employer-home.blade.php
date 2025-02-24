<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employer Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome Employers!</h1>
                <p class="text-lg text-gray-600 mb-6">Find the best part-timers for your events with ease.</p>

            <!-- Benefits Section -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">Post Jobs Easily</h3>
                    <p class="text-gray-600 mt-2">Create and manage event job listings effortlessly.</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">Find Reliable Part-Timers</h3>
                    <p class="text-gray-600 mt-2">Browse through qualified candidates ready to help.</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">Manage Applications</h3>
                    <p class="text-gray-600 mt-2">Track, review, and hire with a simple dashboard.</p>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-12 bg-blue-50 rounded-lg p-8 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Ready to Post Your First Event?</h2>
                <p class="text-gray-600 mt-2">Join us and find the perfect part-timer for your event today.</p>
                <a href="{{ route('events.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                     Post a Job
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
