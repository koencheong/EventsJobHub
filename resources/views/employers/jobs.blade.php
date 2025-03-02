<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            {{ __('My Posted Jobs') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Your Posted Jobs</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Job Name</th>
                        <th class="border p-2">Date</th>
                        <th class="border p-2">Applications</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td class="border p-2">{{ $job->name }}</td>
                            <td class="border p-2">{{ $job->date }}</td>
                            <td class="border p-2">{{ $job->applications->count() }}</td>
                            <td class="border p-2">
                                <a href="{{ route('employer.jobs.applications', $job->id) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    View Applications
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
