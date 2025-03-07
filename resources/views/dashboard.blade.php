<!-- Employer Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - Event Jobs Hub</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }
        .dashboard-container {
            background: #ffffff;
            border-radius: 15px;
            padding: 30px;
            margin: 20px auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .stat-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 10px;
            padding: 20px;
            text-align: left;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex: 1;
            margin: 0 10px;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }
        .stat-card h6 {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .stat-card h4 {
            color: #343a40;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .stat-card .symbol {
            font-size: 30px;
            color: #4CAF50; /* Green color for icons */
        }
        .greeting {
            margin-bottom: 30px;
        }
        .greeting .hello {
            font-size: 28px;
            font-weight: bold;
            color: #343a40;
        }
        .greeting .subtext {
            font-size: 16px;
            color: #6c757d;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }
        .chart-container {
            position: relative;
            height: 300px;
        }
        .recently-posted-jobs {
            max-height: 400px;
            overflow-y: auto;
        }
        .recently-posted-jobs table {
            width: 100%;
            border-collapse: collapse;
        }
        .recently-posted-jobs th, .recently-posted-jobs td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .recently-posted-jobs th {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        .recently-posted-jobs td {
            color: #343a40;
        }
        .recently-posted-jobs button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .recently-posted-jobs button:hover {
            background: #0056b3;
        }
        .upcoming-events iframe {
            border-radius: 10px;
        }
        .stat-cards-row {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            margin-bottom: 40px; /* Increased margin */
        }
        .section-title {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
        }
        .row.mt-4 {
            margin-top: 40px !important; /* Increased gap */
        }
    </style>
</head>
<body>
    <x-app-layout>
        <!-- Main Content -->
        <main class="container-fluid p-4">
            <div class="dashboard-container">
                <!-- Greeting Message -->
                <div class="greeting">
                    <div class="hello">Hello {{ auth()->user()->name }}!</div>
                    <div class="subtext">Here’s what’s happening with your jobs and applications today.</div>
                </div>

                <!-- Statistics Section -->
                <div class="stat-cards-row">
                    @foreach ([
                        ['4.5 ★', 'Average Rating', 'star', '#FF9800'],
                        ['65', 'Total Active Jobs', 'briefcase', '#2196F3'],
                        ['7469', 'Total Applications', 'file-alt', '#4CAF50'],
                        ['600', 'Selected Applications', 'check', '#9C27B0'],
                        ['3200', 'Rejected Applications', 'times', '#F44336']
                    ] as $stat)
                    <div class="stat-card">
                        <div>
                            <h6>{{ $stat[1] }}</h6>
                            <h4>{{ $stat[0] }}</h4>
                        </div>
                        <div class="symbol" style="color: {{ $stat[3] }};">
                            <i class="fas fa-{{ $stat[2] }}"></i>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Charts and Recently Posted Jobs -->
                <div class="row mt-4">
                    <!-- Job Status Distribution Chart -->
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h5 class="section-title">Job Status Distribution</h5>
                            <div class="chart-container">
                                <canvas id="jobStatusChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Recently Posted Jobs -->
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h5 class="section-title">Recently Posted Jobs</h5>
                            <div class="recently-posted-jobs">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Job</th>
                                            <th>Status</th>
                                            <th>Applications</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><i class="fas fa-briefcase"></i> Event Coordinator - Tech Expo</td>
                                            <td>Active</td>
                                            <td>120</td>
                                            <td><button>View</button></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-briefcase"></i> Sound Engineer - Music Festival</td>
                                            <td>Active</td>
                                            <td>85</td>
                                            <td><button>View</button></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-briefcase"></i> Photographer - Corporate Event</td>
                                            <td>Closed</td>
                                            <td>45</td>
                                            <td><button>View</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card p-3">
                            <h5 class="section-title">Upcoming Events</h5>
                            <iframe src="https://calendar.google.com/calendar/embed?height=400&wkst=1&ctz=Asia%2FKuala_Lumpur&showPrint=0&src=d2ppbmd3ZW43NUBnbWFpbC5jb20&src=ZW4ubWFsYXlzaWEjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&src=ZW4tZ2IubWFsYXlzaWEjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039BE5&color=%230B8043&color=%230B8043" style="border:solid 1px #777" width="100%" height="400" frameborder="0" scrolling="no"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-app-layout>

    <!-- Bootstrap and Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Job Status Distribution Chart
        var ctx1 = document.getElementById('jobStatusChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Approved', 'Rejected', 'Completed'],
                datasets: [{
                    label: 'Jobs',
                    data: [20, 50, 10, 30],
                    backgroundColor: ['#FF9800', '#4CAF50', '#F44336', '#2196F3']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            color: '#e0e0e0'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>