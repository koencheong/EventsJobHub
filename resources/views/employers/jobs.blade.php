<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Posted Jobs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-8">

                <!-- Pending Jobs Section -->
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Pending Approval</h3>
                    <div class="overflow-hidden rounded-lg shadow-sm border border-gray-200">
                        <table class="min-w-full bg-white rounded-lg">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <tr>
                                    <th class="py-4 px-6 text-left">Event Name</th>
                                    <th class="py-4 px-6 text-left">Job Type</th>
                                    <th class="py-4 px-6 text-left">Location</th>
                                    <th class="py-4 px-6 text-left">Date</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($jobs->where('status', 'pending') as $job)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-6">{{ $job->name }}</td>
                                        <td class="py-4 px-6">{{ $job->job_type === 'Others' ? $job->other_job_type : $job->job_type }}</td>
                                        <td class="py-4 px-6">{{ $job->location }}</td>
                                        <td class="py-4 px-6">
                                            {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }}
                                            @if ($job->start_date != $job->end_date)
                                                - {{ \Carbon\Carbon::parse($job->end_date)->format('F j, Y') }}
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="px-3 py-1 bg-yellow-500 text-white rounded-md text-xs font-semibold">Pending</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Approved Jobs Section -->
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Approved Jobs</h3>
                    <div class="overflow-hidden rounded-lg shadow-sm border border-gray-200">
                        <table class="min-w-full bg-white rounded-lg">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <tr>
                                    <th class="py-4 px-6 text-left">Event Name</th>
                                    <th class="py-4 px-6 text-left">Job Type</th>
                                    <th class="py-4 px-6 text-left">Location</th>
                                    <th class="py-4 px-6 text-left">Date</th>
                                    <th class="py-4 px-6 text-center">Applications</th>
                                    <th class="py-4 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($jobs->where('status', 'approved') as $job)
                                    @if($job->applications->where('status', 'paid')->isEmpty())
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="py-4 px-6">{{ $job->name }}</td>
                                            <td class="py-4 px-6">{{ $job->job_type === 'Others' ? $job->other_job_type : $job->job_type }}</td>
                                            <td class="py-4 px-6">{{ $job->location }}</td>
                                            <td class="py-4 px-6">
                                                {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }}
                                                @if ($job->start_date != $job->end_date)
                                                    - {{ \Carbon\Carbon::parse($job->end_date)->format('F j, Y') }}
                                                @endif
                                            </td>
                                            <td class="py-4 px-6 text-center">{{ $job->applications->count() }}</td>
                                            <td class="py-4 px-6 text-center">
                                                <div class="flex justify-center space-x-3">
                                                    <a href="{{ route('events.edit', $job) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                                                        Edit
                                                    </a>
                                                    <a href="{{ route('employer.jobs.applications', $job->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
                                                        View
                                                    </a>
                                                    <form action="{{ route('events.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Completed Jobs Section -->
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Completed Jobs</h3>
                    <div class="overflow-hidden rounded-lg shadow-sm border border-gray-200">
                        <table class="min-w-full bg-white rounded-lg">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <tr>
                                    <th class="py-4 px-6 text-left">Event Name</th>
                                    <th class="py-4 px-6 text-left">Job Type</th>
                                    <th class="py-4 px-6 text-left">Location</th>
                                    <th class="py-4 px-6 text-left">Date</th>
                                    <th class="py-4 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($jobs->where('status', 'approved') as $job)
                                    @if($job->applications->where('status', 'paid')->isNotEmpty())
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="py-4 px-6">{{ $job->name }}</td>
                                            <td class="py-4 px-6">{{ $job->job_type === 'Others' ? $job->other_job_type : $job->job_type }}</td>
                                            <td class="py-4 px-6">{{ $job->location }}</td>
                                            <td class="py-4 px-6">
                                                {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($job->end_date)->format('F j, Y') }}
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <div class="flex justify-center space-x-3">
                                                    <a href="{{ route('employer.jobs.applications', $job->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                                        View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Rejected Jobs Section -->
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Rejected Jobs</h3>
                    <div class="overflow-hidden rounded-lg shadow-sm border border-gray-200">
                        <table class="min-w-full bg-white rounded-lg">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <tr>
                                    <th class="py-4 px-6 text-left">Event Name</th>
                                    <th class="py-4 px-6 text-left">Reason for Rejection</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($jobs->where('status', 'rejected') as $job)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-6">{{ $job->name }}</td>
                                        <td class="py-4 px-6">{{ $job->rejection_reason ?? 'No reason provided' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex justify-start mt-6 space-x-4">
                    <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg">
                        Add New Job
                    </a>
                    <a href="{{ route('reports.create') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        Report an Issue
                    </a>
                    <a href="{{ route('ratings.show', auth()->id()) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                        View Ratings
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
