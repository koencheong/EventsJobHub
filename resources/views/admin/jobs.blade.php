<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Manage Jobs
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-8 rounded-xl shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Job Listings</h3>

            <!-- Search Bar -->
            <input type="text" id="searchInput" onkeyup="searchJobs()" placeholder="Search jobs..." 
                   class="w-full mb-4 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            @if ($jobs->isEmpty())
                <p class="text-gray-500">No job postings available.</p>
            @else
                <table class="w-full border-collapse" id="jobsTable">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-4 text-left text-gray-700 font-semibold">Title</th>
                            <th class="p-4 text-left text-gray-700 font-semibold">Employer</th>
                            <th class="p-4 text-left text-gray-700 font-semibold">Date Posted</th>
                            <th class="p-4 text-left text-gray-700 font-semibold">Status</th>
                            <th class="p-4 text-center text-gray-700 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="jobsBody">
                        @foreach ($jobs->sortByDesc('status') as $job)
                            <tr class="hover:bg-gray-50 transition duration-200 job-row" data-title="{{ strtolower($job->name) }}" data-employer="{{ strtolower($job->employer->name) }}">
                                <td class="p-4 border-t border-gray-200">{{ $job->name }}</td>
                                <td class="p-4 border-t border-gray-200">{{ $job->employer->name }}</td>
                                <td class="p-4 border-t border-gray-200">{{ $job->created_at->format('M d, Y') }}</td>
                                <td class="p-4 border-t border-gray-200">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                        {{ $job->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $job->status == 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $job->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td class="p-4 border-t border-gray-200 text-center space-x-2">
                                    @if ($job->status == 'pending')
                                        <!-- Approve Button -->
                                        <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                                Approve
                                            </button>
                                        </form>

                                        <!-- Reject Button (Opens Modal) -->
                                        <button onclick="openModal('rejectModal-{{ $job->id }}')" 
                                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                            Reject
                                        </button>
                                    @endif

                                    <!-- View Event Details Button -->
                                    <a href="{{ route('events.show', $job->id) }}" 
                                       class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                        View Details
                                    </a>

                                    <!-- Clear from View Button -->
                                    <button onclick="clearJob({{ $job->id }})" 
                                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                        Clear
                                    </button>

                                    <!-- Rejection Reason Modal -->
                                    <div id="rejectModal-{{ $job->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
                                        <div class="bg-white rounded-xl shadow-lg w-full max-w-md">
                                            <div class="p-6">
                                                <h3 class="text-2xl font-bold text-gray-800 mb-4">Reject Job</h3>
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
            @endif
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

        // Clear Job from View
        function clearJob(jobId) {
            let row = document.querySelector(`.job-row[data-id="${jobId}"]`);
            if (row) {
                row.remove();
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
