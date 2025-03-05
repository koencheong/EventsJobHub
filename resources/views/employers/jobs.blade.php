<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posted Jobs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Pending Approval</h3>
                <div class="overflow-x-auto rounded-lg shadow-sm mb-8">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Event Name</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Job Type</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Location</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="py-3 px-6 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($jobs->where('status', 'pending') as $job)
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
                                    <td class="py-4 px-6 text-center">
                                        <span class="px-3 py-1.5 bg-yellow-500 text-white rounded-md">Pending Approval</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Approved Jobs</h3>
                <div class="overflow-x-auto rounded-lg shadow-sm mb-8">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Event Name</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Job Type</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Location</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Applications</th>
                                <th class="py-3 px-6 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($jobs->where('status', 'approved') as $job)
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
                                    <td class="py-4 px-6">{{ $job->applications->count() }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('events.edit', $job) }}" class="px-3 py-1.5 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">Edit</a>
                                            <a href="{{ route('employer.jobs.applications', $job->id) }}" class="px-3 py-1.5 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">View</a>
                                            <form action="{{ route('events.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Rejected Jobs</h3>
                <div class="overflow-x-auto rounded-lg shadow-sm">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Event Name</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Reason for Rejection</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($jobs->where('status', 'rejected') as $job)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6">{{ $job->name }}</td>
                                    <td class="py-4 px-6">{{ $job->rejection_reason ?? 'No reason provided' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-left mt-4">
                    <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Add New Job
                    </a>
                </div>

                <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('reports.create') }}" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                            Report an Issue </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
