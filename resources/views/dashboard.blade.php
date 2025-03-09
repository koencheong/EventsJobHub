<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Employer Dashboard') }}</h2>
            <a href="{{ route('ratings.show', ['userId' => Auth::id()]) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200">
                View All Ratings
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @php
                    $stats = [
                        ['title' => 'Average Rating', 'value' => number_format($averageRating, 1), 'color' => 'text-indigo-600', 'icon' => 'bi bi-star-fill'],
                        ['title' => 'Active Jobs', 'value' => $activeJobs, 'color' => 'text-green-600', 'icon' => 'bi bi-briefcase-fill'],
                        ['title' => 'Total Applications', 'value' => $totalApplications, 'color' => 'text-blue-600', 'icon' => 'bi bi-file-earmark-text-fill'],
                        ['title' => 'Pending Payments', 'value' => $pendingPayments, 'color' => 'text-yellow-600', 'icon' => 'bi bi-cash-coin']
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

            <!-- Job Status Distribution Chart -->
            <div class="mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Job Status Distribution</h2>
                <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                    <canvas id="jobStatusChart" class="w-full" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Recent Job Applications -->
            <div class="bg-white shadow-xl rounded-lg p-8 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Recent Job Applications</h3>
                </div>

                <div class="overflow-x-auto shadow-md border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead class="bg-blue-100 text-black uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-6 text-left">Job</th>
                                <th class="py-3 px-6 text-left">Applicant</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($jobApplications as $index => $application)
                                <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-teal-50 transition-colors duration-150">
                                    <td class="py-4 px-6 text-gray-800 font-medium truncate max-w-xs">{{ $application->event->name }}</td>
                                    <td class="py-4 px-6 text-gray-700 truncate max-w-xs">{{ $application->user->name }}</td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' : '' }}
                                            {{ $application->status === 'approved' ? 'bg-green-100 text-green-800 border border-green-300' : '' }}
                                            {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800 border border-red-300' : '' }}
                                            {{ $application->status === 'completed' ? 'bg-blue-100 text-blue-800 border border-blue-300' : '' }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('employer.jobs.applications', $application->event->id) }}"
                                        class="text-teal-600 hover:text-teal-800 font-semibold text-sm transition duration-200">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white">
                                    <td colspan="4" class="py-4 px-6 text-center text-gray-500 rounded-bl-xl rounded-br-xl">
                                        No recent applications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Job Calendar -->
            <div class="mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Job Calendar</h2>
                <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                    <div id="calendar" class="w-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dynamic Job Status Distribution Chart
            var jobStatusData = @json($jobStatusCounts);
            var labels = ['Pending', 'Approved', 'Rejected', 'Completed'];
            var data = labels.map(status => jobStatusData[status.toLowerCase()] || 0);

            var ctx1 = document.getElementById('jobStatusChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jobs',
                        data: data,
                        backgroundColor: ['#FFCA28', '#66BB6A', '#EF5350', '#42A5F5'],
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false } },
                        y: { grid: { color: '#e0e0e0' }, beginAtZero: true }
                    }
                }
            });

            // Initialize FullCalendar
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($eventData),
                eventClick: function(info) {
                    window.location.href = `/events/${info.event.id}`;
                },
                eventContent: function(arg) {
                    return {
                        html: `
                            <div class="p-2">
                                <strong>${arg.event.title}</strong><br>
                                <small>${arg.event.extendedProps.location}</small>
                            </div>
                        `
                    };
                },
                eventDidMount: function(info) {
                    const colors = ['#0288D1', '#388E3C', '#D32F2F', '#FBC02D', '#0288D1'];
                    const color = colors[info.event.id % colors.length];
                    info.el.style.backgroundColor = color;
                    info.el.style.borderColor = color;
                }
            });
            calendar.render();
        });
    </script>
</x-app-layout>