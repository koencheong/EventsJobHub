<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @php
                    $stats = [
                        ['title' => 'Total Applications', 'value' => $applications->count(), 'color' => 'text-indigo-600', 'icon' => 'bi bi-file-earmark-text'],
                        ['title' => 'Completed Jobs', 'value' => $completedJobs, 'color' => 'text-green-600', 'icon' => 'bi bi-check-circle'],
                        ['title' => 'Upcoming Jobs', 'value' => $upcomingJobs, 'color' => 'text-blue-600', 'icon' => 'bi bi-calendar-event'],
                        ['title' => 'Earnings This Month', 'value' => 'RM ' . number_format($totalEarnings, 2), 'color' => 'text-yellow-600', 'icon' => 'bi bi-currency-dollar']
                    ];
                @endphp
                
                @foreach ($stats as $stat)
                    <div class="p-6 bg-white shadow-xl rounded-lg flex items-center space-x-4 transition hover:shadow-2xl hover:-translate-y-1">
                        <div class="text-4xl {{ $stat['color'] }}">
                            <i class="{{ $stat['icon'] }}"></i> <!-- Bootstrap Icon -->
                        </div>
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
                    <select id="sortApplications" class="border-gray-300 rounded-lg text-gray-700 px-4 py-2 bg-white shadow-sm">
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
                                <tr class="bg-gray-50 text-gray-700">
                                    <th class="py-3 px-4 border">Event</th>
                                    <th class="py-3 px-4 border">Status</th>
                                    <th class="py-3 px-4 border">Progress</th>
                                    <th class="py-3 px-4 border">Applied On</th>
                                    <th class="py-3 px-4 border text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                    <tr class="hover:bg-gray-50 transition">
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
                                                @if ($application->status == 'approved') bg-green-100 text-green-700 
                                                @elseif ($application->status == 'pending') bg-yellow-100 text-yellow-700 
                                                @else bg-red-100 text-red-700 @endif">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>

                                        <!-- Progress Tracker -->
                                        <td class="py-3 px-4 border">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
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
                                        @if ($application->status == 'paid')
                                            @php
                                                // Retrieve company_id from the event
                                                $company_id = App\Models\Event::where('id', $application->event_id)->value('company_id');

                                                // Check if the rating exists
                                                $existingRating = App\Models\Rating::where('event_id', $application->event_id)
                                                    ->where('from_user_id', auth()->id())
                                                    ->where('to_user_id', $company_id) 
                                                    ->where('type', 'part_timer_to_employer')
                                                    ->exists();
                                            @endphp

                                            @if (!$existingRating)
                                                <a href="{{ route('ratings.create', ['event' => $application->event_id, 'toUser' => $company_id, 'type' => 'part_timer_to_employer']) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 text-sm font-medium rounded-lg transition">
                                                    Rate Job
                                                </a>
                                            @else
                                                <button class="bg-gray-400 text-white px-4 py-2 text-sm font-medium rounded-lg cursor-not-allowed" disabled>
                                                    Rated
                                                </button>
                                            @endif
                                        @elseif ($application->status == 'pending')
                                            <form action="{{ route('applications.cancel', $application->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 text-sm font-medium rounded-lg transition">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="flex justify-between items-center mt-6 space-x-3">
                    <a href="{{ route('reports.create') }}" 
                    class="bg-red-500 text-white px-4 py-2.5 rounded-md text-sm hover:bg-red-600 transition">
                        Report Issue
                    </a>
                    
                    <a href="{{ route('ratings.show', ['userId' => auth()->id()]) }}" 
                    class="bg-green-500 text-white px-4 py-2.5 rounded-md text-sm hover:bg-green-600 transition">
                        View Ratings
                    </a>
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
                                let statusPriority = { 
                                    "Pending": 0, 
                                    "Approved": 1, 
                                    "Completed": 2, 
                                    "Rejected": 3, 
                                    "Canceled": 4 
                                };
                                
                                valA = statusPriority[a.cells[1].innerText.trim()] ?? 99;
                                valB = statusPriority[b.cells[1].innerText.trim()] ?? 99;
                                return valA - valB;
                            } 
                            else if (sortBy === "date") {
                                valA = new Date(a.cells[3].innerText.trim()).getTime();
                                valB = new Date(b.cells[3].innerText.trim()).getTime();
                                return valB - valA;
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
                        borderColor: 'rgba(79, 70, 229, 1)', // Indigo-600
                        backgroundColor: 'rgba(79, 70, 229, 0.1)', // Light Indigo
                        borderWidth: 2,
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