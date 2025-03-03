<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Applications for {{ $job->name }}
        </h2>
    </x-slot>

    <!-- Job Details Section -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-xl font-semibold">Job Details</h3>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><strong>Title:</strong> {{ $job->name }}</p>
                <p><strong>Location:</strong> {{ $job->location }}</p>
                <p><strong>Date:</strong> 
                @if ($job->start_date == $job->end_date)
                    {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }}
                @else
                    {{ \Carbon\Carbon::parse($job->start_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($job->end_date)->format('F j, Y') }}
                @endif
                </p>
                <p><strong>Payment Amount:</strong> RM{{ number_format($job->payment_amount, 2) }} / day</p>
            </div>
        </div>

        <!-- Applicants Section -->
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Applicants</h3>

            @if ($applications->isEmpty())
                <p class="text-gray-500">No applications yet.</p>
            @else
                <table class="w-full border-collapse border border-gray-300 text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-3">Applicant Name</th>
                            <th class="border p-3 text-center">Status</th>
                            <th class="border p-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3">{{ $application->user->name }}</td>

                                <!-- Status Column with Color Coding -->
                                <td class="border p-3 text-center">
                                    <span class="px-3 py-1 rounded-full text-white text-sm font-semibold 
                                        {{ $application->status == 'pending' ? 'bg-yellow-500' : '' }}
                                        {{ $application->status == 'accepted' ? 'bg-green-500' : '' }}
                                        {{ $application->status == 'rejected' ? 'bg-red-500' : '' }}
                                        {{ $application->status == 'paid' ? 'bg-blue-500' : '' }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>

                                <!-- Action Column -->
                                <td class="border p-3 text-center">
                                    <div class="flex items-center justify-center gap-4">
                                        <!-- View Profile Button -->
                                        <a href="{{ route('employers.viewApplicant', ['id' => $application->user_id]) }}" 
                                           class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                            View Applicant
                                        </a>

                                        <!-- Status Update Dropdown -->
                                        <div x-data="{ showModal: false, selectedStatus: '', applicationId: '' }">
                                            <select @change="selectedStatus = $event.target.value; applicationId = {{ $application->id }}; showModal = true;" 
                                                    class="appearance-none border px-4 py-2 rounded-md bg-white shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200 cursor-pointer text-gray-700">
                                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                <option value="paid" {{ $application->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            </select>

                                            <!-- Modal for Confirmation -->
                                            <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                                    <h2 class="text-xl font-semibold mb-3">Confirm Status Update</h2>
                                                    <p class="text-gray-600 mb-5" x-text="getConfirmationMessage(selectedStatus)"></p>
                                                    <div class="flex justify-end gap-3">
                                                        <button @click="showModal = false" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 transition">
                                                            Cancel
                                                        </button>
                                                        <form :action="'{{ route('application.update', '') }}/' + applicationId" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" :value="selectedStatus">
                                                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                                                Confirm
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Alpine.js Script -->
                                            <script>
                                                function getConfirmationMessage(status) {
                                                    switch (status) {
                                                        case "accepted": return "Are you sure you want to accept this applicant for the job?";
                                                        case "rejected": return "Are you sure you want to reject this applicant?";
                                                        case "paid": return "Are you sure you want to mark this applicant as paid?";
                                                        default: return "Are you sure you want to update the status?";
                                                    }
                                                }
                                            </script>
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

</x-app-layout>