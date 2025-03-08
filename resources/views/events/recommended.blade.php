<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-900">Recommended Jobs</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Jobs You Might Like</h3>

            @if($recommendedJobs->isEmpty())
                <p class="text-gray-600">No recommendations available at the moment. Apply for jobs to get personalized suggestions!</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recommendedJobs as $job)
                        <div class="p-4 border rounded-lg shadow-sm">
                            <h4 class="font-semibold text-lg">{{ $job->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $job->job_type }}</p>
                            <p class="text-sm text-gray-600">{{ $job->location }}</p>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }}</p>
                            <a href="{{ route('events.show', $job) }}" class="block mt-3 text-blue-500 hover:underline">View Details</a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ url()->previous() }}" 
                   class="inline-block px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow-md 
                          hover:bg-gray-600 transition duration-300">
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
