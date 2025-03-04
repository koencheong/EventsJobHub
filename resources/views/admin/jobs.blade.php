<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Manage Jobs
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Job Listings</h3>

            @if ($jobs->isEmpty())
                <p class="text-gray-500">No job postings available.</p>
            @else
                <table class="w-full border-collapse border border-gray-300 text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-3">Title</th>
                            <th class="border p-3">Employer</th>
                            <th class="border p-3">Status</th>
                            <th class="border p-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobs as $job)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3">{{ $job->name }}</td>
                                <td class="border p-3">{{ $job->employer->name }}</td>
                                <td class="border p-3">
                                    <span class="px-3 py-1 rounded-full text-white text-sm font-semibold 
                                        {{ $job->status == 'pending' ? 'bg-yellow-500' : '' }}
                                        {{ $job->status == 'approved' ? 'bg-green-500' : '' }}
                                        {{ $job->status == 'rejected' ? 'bg-red-500' : '' }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td class="border p-3 text-center">
                                    <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.jobs.reject', $job->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                            Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
