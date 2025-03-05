<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Manage Jobs
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Job Listings</h3>
            <form method="GET" action="{{ route('admin.jobs') }}" class="mb-4 flex items-center gap-4"></form>

            @if ($jobs->isEmpty())
                <p class="text-gray-500">No job postings available.</p>
            @else
                <table class="w-full border-collapse border border-gray-300 text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-3">Title</th>
                            <th class="border p-3">Employer</th>
                            <th class="border p-3">Date Posted</th>
                            <th class="border p-3">Status</th>
                            <th class="border p-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobs as $job)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3">{{ $job->name }}</td>
                                <td class="border p-3">{{ $job->employer->name }}</td>
                                <td class="border p-3">{{ $job->created_at->format('M d, Y') }}</td>
                                <td class="border p-3">
                                    <span class="px-3 py-1 rounded-full text-white text-sm font-semibold 
                                        {{ $job->status == 'pending' ? 'bg-yellow-500' : '' }}
                                        {{ $job->status == 'approved' ? 'bg-green-500' : '' }}
                                        {{ $job->status == 'rejected' ? 'bg-red-500' : '' }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td class="border p-3 text-center">
                                    <!-- Approve Button -->
                                    <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                            Approve
                                        </button>
                                    </form>

                                    <!-- Reject Button (Opens Modal) -->
                                    <button onclick="openModal('rejectModal-{{ $job->id }}')" 
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition ml-2">
                                        Reject
                                    </button>

                                    <!-- View Event Details Button -->
                                    <a href="{{ route('events.show', $job->id) }}" 
                                        class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition ml-2">
                                        View Details
                                    </a>

                                    <!-- Rejection Reason Modal -->
                                    <div id="rejectModal-{{ $job->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center">
                                        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                                            <h3 class="text-xl font-semibold mb-4">Reject Job</h3>
                                            <p class="text-gray-600 mb-4">Please provide a reason for rejection.</p>
                                            <form action="{{ route('admin.jobs.reject', $job->id) }}" method="POST">
                                                @csrf
                                                <textarea name="rejection_reason" required class="w-full border rounded p-2 mb-4" placeholder="Enter rejection reason"></textarea>
                                                <div class="flex justify-end">
                                                    <button type="button" onclick="closeModal('rejectModal-{{ $job->id }}')" 
                                                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition mr-2">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                                        Reject
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-app-layout>
