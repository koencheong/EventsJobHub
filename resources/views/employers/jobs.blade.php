<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posted Jobs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">All Posted Jobs</h3>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto rounded-lg shadow-sm">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Event Name</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Job Type</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Location</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Payment Amount / Day</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Applications</th>
                                <th class="py-3 px-6 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($jobs as $job)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6">{{ $job->name }}</td>
                                    <td class="py-4 px-6">{{ $job->job_type === 'Others' ? $job->other_job_type : $job->job_type }}</td>
                                    <td class="py-4 px-6">{{ $job->location }}</td>
                                    <td class="py-4 px-6">
                                        @if ($job->start_date == $job->end_date)
                                            {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($job->end_date)->format('F j, Y') }}
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">RM {{ number_format($job->payment_amount, 2) }}</td>
                                    <td class="py-4 px-6">{{ $job->applications->count() }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('events.edit', $job) }}" class="px-3 py-1.5 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors whitespace-nowrap">
                                                Edit
                                            </a>
                                            <!-- View Applications Button -->
                                            <a href="{{ route('employer.jobs.applications', $job->id) }}" class="px-3 py-1.5 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors whitespace-nowrap">
                                                View Applications
                                            </a>
                                            <!-- Delete Button -->
                                            <form action="{{ route('events.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors whitespace-nowrap">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Post New Job Button -->
                <div class="mt-6 text-left">
                    <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Post New Job
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>