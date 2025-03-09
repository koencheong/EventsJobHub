<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Manage Jobs') }}</h2>
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-100">
                <!-- Job Listings Section -->
                <h3 class="text-2xl font-semibold text-blue-700 mb-6">Job Listings</h3>

                <!-- Search Bar -->
                <input type="text" id="searchInput" onkeyup="searchJobs()" placeholder="Search jobs..." 
                       class="w-full mb-6 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">

                @if ($jobs->isEmpty())
                    <p class="text-gray-500 text-center">No job postings available.</p>
                @else
                    <div class="overflow-x-auto rounded-xl shadow-sm border border-blue-200">
                        <table class="min-w-full bg-white" id="jobsTable">
                            <thead class="bg-blue-50 text-blue-800 uppercase text-xs font-semibold">
                                <tr>
                                    <th class="py-3 px-6 text-left">Title</th>
                                    <th class="py-3 px-6 text-left">Employer</th>
                                    <th class="py-3 px-6 text-left">Date Posted</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="jobsBody" class="divide-y divide-blue-100">
                                @foreach ($jobs->sortByDesc('status')->sortBy(function($job) {
                                    return $job->status == 'pending' ? -1 : 1;
                                }) as $job)
                                    <tr class="hover:bg-blue-50 transition duration-150 job-row" data-id="{{ $job->id }}" data-title="{{ strtolower($job->name) }}" data-employer="{{ strtolower($job->employer->name) }}">
                                        <td class="py-4 px-6 text-gray-800">{{ $job->name }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $job->employer->name }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $job->created_at->format('M d, Y') }}</td>
                                        <td class="py-4 px-6 text-gray-800">
                                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                                {{ $job->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $job->status == 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $job->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                                {{ ucfirst($job->status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center space-x-2">
                                            @if ($job->status == 'pending')
                                                <!-- Approve Button -->
                                                <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm transition duration-200">
                                                        Approve
                                                    </button>
                                                </form>

                                                <!-- Reject Button (Opens Modal) -->
                                                <button onclick="openModal('rejectModal-{{ $job->id }}')" 
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm transition duration-200">
                                                    Reject
                                                </button>
                                            @endif

                                            <!-- View Event Details Button -->
                                            <a href="{{ route('events.show', $job->id) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2.5 rounded-md text-sm transition duration-200">
                                                View
                                            </a>

                                            <!-- Clear from View Button -->
                                            <button onclick="clearJob({{ $job->id }})" 
                                                    class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-md text-sm transition duration-200">
                                                Clear
                                            </button>

                                            <!-- Rejection Reason Modal -->
                                            <div id="rejectModal-{{ $job->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
                                                <div class="bg-white rounded-xl shadow-lg w-full max-w-md">
                                                    <div class="p-6">
                                                        <h3 class="text-xl font-bold text-gray-800 mb-4">Reject Job</h3>
                                                        <p class="text-gray-600 mb-4">Please provide a reason for rejection.</p>
                                                        <form action="{{ route('admin.jobs.reject', $job->id) }}" method="POST">
                                                            @csrf
                                                            <textarea name="rejection_reason" required 
                                                                      class="w-full border rounded-lg p-3 mb-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                                                      placeholder="Enter rejection reason"></textarea>
                                                            <div class="flex justify-end">
                                                                <button type="button" onclick="closeModal('rejectModal-{{ $job->id }}')" 
                                                                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition mr-2">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit" 
                                                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                                    Reject
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Open and Close Modals
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Clear Job from View (does not delete from database)
        function clearJob(jobId) {
            let row = document.querySelector(`.job-row[data-id="${jobId}"]`);
            if (row) {
                row.style.display = "none";  // Hide the row instead of deleting it
            }
        }

        // Search Jobs
        function searchJobs() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll(".job-row");

            rows.forEach(row => {
                let title = row.dataset.title;
                let employer = row.dataset.employer;

                if (title.includes(input) || employer.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</x-app-layout>