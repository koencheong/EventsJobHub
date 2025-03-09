<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Posted Jobs') }}</h2>
            <a href="{{ route('events.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200">
                Add New Job
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-100">
                <!-- Pending Jobs Section -->
                <div class="mb-10">
                    <h3 class="text-2xl font-semibold text-yellow-700 mb-4">Pending Approval</h3>
                    <div class="overflow-x-auto rounded-xl shadow-sm border border-yellow-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-yellow-50 text-yellow-800 uppercase text-xs font-semibold">
                                <tr>
                                    <th class="py-3 px-6 text-left">Event Name</th>
                                    <th class="py-3 px-6 text-left">Job Type</th>
                                    <th class="py-3 px-6 text-left">Location</th>
                                    <th class="py-3 px-6 text-left">Date</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-yellow-100">
                                @forelse($jobs->where('status', 'pending') as $job)
                                    <tr class="hover:bg-yellow-50 transition duration-150">
                                        <td class="py-4 px-6 text-gray-800">{{ $job->name }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $job->job_type === 'Others' ? $job->other_job_type : $job->job_type }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $job->location }}</td>
                                        <td class="py-4 px-6 text-gray-800">
                                            {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }}
                                            @if ($job->start_date != $job->end_date)
                                                - {{ \Carbon\Carbon::parse($job->end_date)->format('F j, Y') }}
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-medium">Pending</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-6 text-center text-gray-500">No pending jobs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Approved Jobs Section -->
                <div class="mb-10">
                    <h3 class="text-2xl font-semibold text-green-700 mb-4">Approved Jobs</h3>
                    <div class="overflow-x-auto rounded-xl shadow-sm border border-green-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-green-50 text-green-800 uppercase text-xs font-semibold">
                                <tr>
                                    <th class="py-3 px-6 text-left">Event Name</th>
                                    <th class="py-3 px-6 text-left">Job Type</th>
                                    <th class="py-3 px-6 text-left">Location</th>
                                    <th class="py-3 px-6 text-left">Date</th>
                                    <th class="py-3 px-6 text-center">Applications</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-green-100">
                                @forelse($jobs->where('status', 'approved')->filter(fn($job) => $job->applications->where('status', 'paid')->isEmpty()) as $job)
                                    <tr class="hover:bg-green-50 transition duration-150">
                                        <td class="py-4 px-6 text-gray-800">{{ $job->name }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $job->job_type === 'Others' ? $job->other_job_type : $job->job_type }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $job->location }}</td>
                                        <td class="py-4 px-6 text-gray-800">
                                            {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }}
                                            @if ($job->start_date != $job->end_date)
                                                - {{ \Carbon\Carbon::parse($job->end_date)->format('F j, Y') }}
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center text-gray-800">{{ $job->applications->count() }}</td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('events.edit', $job) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm transition duration-200">Edit</a>
                                                <a href="{{ route('employer.jobs.applications', $job->id) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-3 py-1 rounded-md text-sm transition duration-200">View</a>
                                                <button onclick="showDeleteConfirmation('{{ route('events.destroy', $job) }}')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm transition duration-200">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-6 text-center text-gray-500">No approved jobs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Completed Jobs Section -->
                <div class="mb-10">
                    <h3 class="text-2xl font-semibold text-blue-700 mb-4">Completed Jobs Awaiting Payment</h3>
                    <div class="overflow-x-auto rounded-xl shadow-sm border border-blue-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-blue-50 text-blue-800 uppercase text-xs font-semibold">
                                <tr>
                                    <th class="py-3 px-6 text-left">Event Name</th>
                                    <th class="py-3 px-6 text-left">Job Type</th>
                                    <th class="py-3 px-6 text-left">Location</th>
                                    <th class="py-3 px-6 text-left">Date</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-100">
                                @forelse($jobs->where('status', 'approved')->filter(fn($job) => $job->applications->where('status', 'completed')->isNotEmpty()) as $job)
                                    <tr class="hover:bg-blue-50 transition duration-150">
                                        <td class="py-4 px-6 text-gray-800">{{ $job->name }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $job->job_type === 'Others' ? $job->other_job_type : $job->job_type }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $job->location }}</td>
                                        <td class="py-4 px-6 text-gray-800">
                                            {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }}
                                            @if ($job->start_date != $job->end_date)
                                                - {{ \Carbon\Carbon::parse($job->end_date)->format('F j, Y') }}
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <a href="{{ route('employer.jobs.applications', $job->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-md text-sm transition duration-200">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-6 text-center text-gray-500">No completed jobs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Rejected Jobs Section -->
                <div>
                    <h3 class="text-2xl font-semibold text-red-700 mb-4">Rejected Jobs</h3>
                    <div class="overflow-x-auto rounded-xl shadow-sm border border-red-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-red-50 text-red-800 uppercase text-xs font-semibold">
                                <tr>
                                    <th class="py-3 px-6 text-left">Event Name</th>
                                    <th class="py-3 px-6 text-left">Reason for Rejection</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-100">
                                @forelse($jobs->where('status', 'rejected') as $job)
                                    <tr class="hover:bg-red-50 transition duration-150">
                                        <td class="py-4 px-6 text-gray-800">{{ $job->name }}</td>
                                        <td class="py-4 px-6 text-gray-600">{{ $job->rejection_reason ?? 'No reason provided' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="py-4 px-6 text-center text-gray-500">No rejected jobs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex justify-start mt-8 space-x-4">
                    <a href="{{ route('reports.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition duration-200">
                        Report an Issue
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden transition-opacity duration-300">
        <div class="bg-white p-6 rounded-xl shadow-xl max-w-md w-full transform transition-all duration-300 scale-95">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Confirm Deletion</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this job? This action cannot be undone.</p>
            <div class="flex justify-end gap-4">
                <button id="cancelDeleteButton" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function showDeleteConfirmation(deleteUrl) {
            const modal = document.getElementById('deleteConfirmationModal');
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = deleteUrl;
            modal.classList.remove('hidden');
            setTimeout(() => modal.querySelector('div').classList.remove('scale-95'), 10);
        }

        document.getElementById('cancelDeleteButton').addEventListener('click', () => {
            const modal = document.getElementById('deleteConfirmationModal');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 200);
        });
    </script>
</x-app-layout>