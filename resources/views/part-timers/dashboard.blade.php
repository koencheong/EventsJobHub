<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="p-6 bg-white shadow-xl sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700">Total Applications</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $applications->count() }}</p>
                </div>
                <div class="p-6 bg-white shadow-xl sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700">Completed Jobs</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $completedJobs }}</p>
                </div>
                <div class="p-6 bg-white shadow-xl sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700">Upcoming Jobs</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $upcomingJobs }}</p>
                </div>
                <div class="p-6 bg-white shadow-xl sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700">Earnings This Month</h3>
                    <p class="text-3xl font-bold text-yellow-600">RM {{ number_format($totalEarnings, 2) }}</p>
                </div>
            </div>

            <!-- Job Applications Table -->
            <div class="bg-white shadow-xl sm:rounded-lg p-8 rounded-xl overflow-hidden mb-6">
                <h3 class="text-xl font-semibold mb-4">My Job Applications</h3>

                @if ($applications->isEmpty())
                    <p class="text-gray-600 text-lg font-medium">You have not applied for any jobs yet.</p>
                @else
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="py-2 px-4 border">Event</th>
                                <th class="py-2 px-4 border">Status</th>
                                <th class="py-2 px-4 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-2 px-4 border">{{ $application->event->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border">
                                        <span class="px-2 py-1 rounded-lg text-sm font-semibold
                                            @if ($application->status == 'approved') bg-green-500 text-white 
                                            @elseif ($application->status == 'pending') bg-yellow-400 text-gray-800 
                                            @else bg-red-500 text-white @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border text-center">
                                        @if ($application->status == 'pending')
                                            <form action="{{ route('applications.cancel', $application->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 text-sm font-medium rounded-lg transition">
                                                    Cancel
                                                </button>
                                            </form>
                                        @else
                                            <button class="bg-gray-300 text-gray-600 px-4 py-2 text-sm font-medium rounded-lg cursor-not-allowed" title="Only Pending jobs can be canceled">
                                                Cancel
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Earnings Chart -->
            <div class="bg-white shadow-xl sm:rounded-lg p-8 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">Earnings This Month</h3>
                <canvas id="earningsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('earningsChart').getContext('2d');
            const chartData = @json($earningsData); // Laravel passes earnings data

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.dates,
                    datasets: [{
                        label: 'Earnings (RM)',
                        data: chartData.amounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>

</x-app-layout>
