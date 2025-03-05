<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @php
                    $stats = [
                        ['title' => 'Total Applications', 'value' => $applications->count(), 'color' => 'text-indigo-600', 'icon' => '📝'],
                        ['title' => 'Completed Jobs', 'value' => $completedJobs, 'color' => 'text-green-600', 'icon' => '✅'],
                        ['title' => 'Upcoming Jobs', 'value' => $upcomingJobs, 'color' => 'text-blue-600', 'icon' => '📅'],
                        ['title' => 'Earnings This Month', 'value' => 'RM ' . number_format($totalEarnings, 2), 'color' => 'text-yellow-600', 'icon' => '💰']
                    ];
                @endphp
                
                @foreach ($stats as $stat)
                    <div class="p-6 bg-white shadow-xl rounded-lg flex items-center space-x-4 transition hover:shadow-2xl hover:-translate-y-1">
                        <div class="text-4xl">{{ $stat['icon'] }}</div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">{{ $stat['title'] }}</h3>
                            <p class="text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Job Applications Table -->
            <div class="bg-white shadow-xl rounded-lg p-8 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">My Job Applications</h3>
                    
                    <!-- Sorting Dropdown -->
                    <select id="sortApplications" class="border-gray-300 rounded-lg text-gray-700 px-7 py-2">
                        <option value="date">Sort by Applied Date</option>
                        <option value="name">Sort by Event Name</option>
                        <option value="status">Sort by Status</option>
                    </select>
                </div>

                @if ($applications->isEmpty())
                    <p class="text-gray-600 text-lg font-medium">You have not applied for any jobs yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left" id="applicationsTable">
                            <thead>
                                <tr class="bg-gray-200 text-gray-700">
                                    <th class="py-3 px-4 border">Event</th>
                                    <th class="py-3 px-4 border">Status</th>
                                    <th class="py-3 px-4 border">Progress</th>
                                    <th class="py-3 px-4 border">Applied On</th>
                                    <th class="py-3 px-4 border text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                    <tr class="hover:bg-gray-100 transition">
                                        <td class="py-3 px-4 border">{{ $application->event->name ?? 'N/A' }}
                                            <!-- Info Icon -->
                                            @if ($application->event)
                                                <a href="{{ route('events.show', $application->event->id) }}" 
                                                class="text-blue-500 hover:text-blue-700" 
                                                title="View Event Details">
                                                    <i class="fas fa-info-circle"></i> <!-- FontAwesome Icon -->
                                                </a></td>
                                            @endif
                                        <td class="py-3 px-4 border">
                                            <span class="px-3 py-1 rounded-lg text-sm font-semibold
                                                @if ($application->status == 'approved') bg-green-500 text-white 
                                                @elseif ($application->status == 'pending') bg-yellow-400 text-gray-800 
                                                @else bg-red-500 text-white @endif">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>

                                        <!-- Progress Tracker -->
                                        <td class="py-3 px-4 border">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-full bg-gray-300 rounded-full h-2">
                                                    <div class="h-2 rounded-full transition-all
                                                        @if ($application->status == 'pending') bg-yellow-400 w-1/4 
                                                        @elseif ($application->status == 'approved') bg-green-500 w-2/4 
                                                        @elseif ($application->status == 'completed') bg-green-500 w-3/4
                                                        @elseif ($application->status == 'paid') bg-blue-500 w-full 
                                                        @else bg-red-500 w-1/4 @endif">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium">
                                                    @if ($application->status == 'pending') 25% 
                                                    @elseif ($application->status == 'approved') 50% 
                                                    @elseif ($application->status == 'completed') 75% 
                                                    @elseif ($application->status == 'paid') 100% 
                                                    @else 25% @endif
                                                </span>
                                            </div>
                                        </td>

                                        <td class="py-3 px-4 border">{{ $application->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-4 border text-center">
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
                    </div>
                @endif
                <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('reports.create') }}" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                            Report an Issue </a>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const sortSelect = document.getElementById("sortApplications");
                    const table = document.getElementById("applicationsTable").getElementsByTagName("tbody")[0];

                    sortSelect.addEventListener("change", function () {
                        let rows = Array.from(table.rows);
                        let sortBy = this.value;

                        rows.sort((a, b) => {
                            let valA, valB;

                            if (sortBy === "name") {
                                valA = a.cells[0].innerText.trim().toLowerCase();
                                valB = b.cells[0].innerText.trim().toLowerCase();
                                return valA.localeCompare(valB);
                            } 
                            
                            else if (sortBy === "status") {
                                // Priority order: Pending (Highest), Approved, Completed, Rejected, Canceled (Lowest)
                                let statusPriority = { 
                                    "Pending": 0, 
                                    "Approved": 1, 
                                    "Completed": 2, 
                                    "Rejected": 3, 
                                    "Canceled": 4 
                                };
                                
                                valA = statusPriority[a.cells[1].innerText.trim()] ?? 99;
                                valB = statusPriority[b.cells[1].innerText.trim()] ?? 99;
                                return valA - valB; // Lower priority number first
                            } 
                            
                            else if (sortBy === "date") { // Sorting by latest applied date first
                                valA = new Date(a.cells[3].innerText.trim()).getTime();
                                valB = new Date(b.cells[3].innerText.trim()).getTime();

                                if (isNaN(valA) || isNaN(valB)) {
                                    return 0; // Handle invalid date
                                }
                                
                                return valB - valA; // Sort by latest date first
                            }
                        });

                        rows.forEach(row => table.appendChild(row));
                    });
                });
            </script>

            <!-- Earnings Chart -->
            <div class="bg-white shadow-xl rounded-lg p-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Monthly Earnings Overview</h3>
                </div>
                <canvas id="earningsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chartData = @json($earningsData);

            const ctx = document.getElementById('earningsChart').getContext('2d');

            let earningsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.dates,
                    datasets: [{
                        label: 'Earnings Over Time',
                        data: chartData.amounts,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointRadius: 3, 
                        pointHoverRadius: 6, 
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: { display: true, text: 'Date', font: { size: 14 } },
                            ticks: { autoSkip: true, maxTicksLimit: 10 },
                            grid: { display: false }
                        },
                        y: {
                            title: { display: true, text: 'Earnings (RM)', font: { size: 14 } },
                            beginAtZero: true,
                            grid: { color: 'rgba(200, 200, 200, 0.3)' }
                        }
                    },
                    plugins: {
                        legend: { display: true, position: 'top', labels: { boxWidth: 15 } }
                    }
                }
            });

            // Filter event for future functionality
            document.getElementById('earningsFilter').addEventListener('change', function () {
                console.log("Filter changed:", this.value);
            });
        });
    </script>

</x-app-layout>
