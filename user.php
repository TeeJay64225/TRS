<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
        }

        .nav-link {
            color: #343a40;
        }

        .nav-link:hover {
            color: #007bff;
        }

        .header {
            background: linear-gradient(to right, #007bff, #6610f2);
            color: white;
            padding: 10px 0;
        }

        .profile-img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            object-fit: cover;
            margin-right: 20px;
        }

        .card-container {
            margin-bottom: 20px;
        }

        .chart-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .session-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
        }

        .session-container table {
            width: 100%;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .footer {
            background: #343a40;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Manager Dashboard</h1>
            <div class="d-flex align-items-center">
                <img src="../images/default_profile.jpg" alt="Profile Picture" class="profile-img">
                <div>
                    <p>Welcome, Manager John Doe</p>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="../manager/manage_projects.html"><i class="fas fa-tachometer-alt"></i> Manage Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="../manager/view_attendance.html"><i class="fas fa-calendar-check"></i> View Attendances</a></li>
                    <li class="nav-item"><a class="nav-link" href="../manager/add_salary.html"><i class="fas fa-dollar-sign"></i> Add Salary</a></li>
                    <li class="nav-item"><a class="nav-link" href="../manager/view_salaries.html"><i class="fas fa-money-bill-wave"></i> View Salaries</a></li>
                    <li class="nav-item"><a class="nav-link" href="../manager/schedule_trainings.html"><i class="fas fa-chalkboard-teacher"></i> Schedule Trainings</a></li>
                    <li class="nav-item"><a class="nav-link" href="../manager/view_trainings.html"><i class="fas fa-calendar-alt"></i> View Trainings</a></li>
                    <li class="nav-item"><a class="nav-link" href="../manager/employee_evaluations.html"><i class="fas fa-clipboard-list"></i> Evaluate Employees</a></li>
                    <li class="nav-item"><a class="nav-link" href="../manager/view_evaluations.html"><i class="fas fa-star"></i> View Evaluations</a></li>
                    <li class="nav-item"><a class="nav-link" href="../manager/view_vacations.html"><i class="fas fa-plane-departure"></i> View Vacation Requests</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.html"><i class="fas fa-user"></i> Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.html"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="session-container mb-4">
            <h2 class="card-title">Employee Sessions</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jane Smith</td>
                        <td>2024-08-04 08:00:00</td>
                        <td>2024-08-04 17:00:00</td>
                    </tr>
                    <tr>
                        <td>John Doe</td>
                        <td>2024-08-04 09:00:00</td>
                        <td>2024-08-04 18:00:00</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="chart-container">
                    <h2 class="card-title">Attendance Overview</h2>
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="chart-container">
                    <h2 class="card-title">Training Overview</h2>
                    <canvas id="trainingChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="chart-container">
                    <h2 class="card-title">Evaluations Overview</h2>
                    <canvas id="evaluationChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="chart-container">
                    <h2 class="card-title">Vacation Requests</h2>
                    <canvas id="vacationChart"></canvas>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="chart-container">
                    <h2 class="card-title">Salary Distribution</h2>
                    <canvas id="salaryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 HR Management System. All rights reserved.</p>
    </footer>

    <script>
        // Attendance Chart
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var attendanceData = {
            labels: ['2024-08-01', '2024-08-02', '2024-08-03'],
            datasets: [{
                data: [10, 15, 8],
                backgroundColor: ['#007bff', '#6610f2', '#e83e8c']
            }]
        };
        new Chart(ctx, {
            type: 'pie',
            data: attendanceData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' days';
                            }
                        }
                    }
                }
            }
        });

        // Training Chart
        var ctx = document.getElementById('trainingChart').getContext('2d');
        var trainingData = {
            labels: ['Total Trainings'],
            datasets: [{
                data: [30],
                backgroundColor: ['#007bff']
            }]
        };
        new Chart(ctx, {
            type: 'pie',
            data: trainingData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' trainings';
                            }
                        }
                    }
                }
            }
        });

        // Evaluation Chart
        var ctx = document.getElementById('evaluationChart').getContext('2d');
        var evaluationData = {
            labels: ['Excellent', 'Good', 'Average'],
            datasets: [{
                data: [12, 20, 8],
                backgroundColor: ['#007bff', '#6610f2', '#e83e8c']
            }]
        };
        new Chart(ctx, {
            type: 'pie',
            data: evaluationData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' evaluations';
                            }
                        }
                    }
                }
            }
        });

        // Vacation Chart
        var ctx = document.getElementById('vacationChart').getContext('2d');
        var vacationData = {
            labels: ['Approved', 'Pending', 'Rejected'],
            datasets: [{
                data: [5, 3, 2],
                backgroundColor: ['#007bff', '#6610f2', '#e83e8c']
            }]
        };
        new Chart(ctx, {
            type: 'pie',
            data: vacationData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' requests';
                            }
                        }
                    }
                }
            }
        });

        // Salary Chart
        var ctx = document.getElementById('salaryChart').getContext('2d');
        var salaryChartData = {
            labels: ['Jane Smith', 'John Doe'],
            datasets: [{
                label: 'Salary',
                data: [50000, 55000],
                backgroundColor: '#007bff'
            }]
        };
        new Chart(ctx, {
            type: 'bar',
            data: salaryChartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': $' + tooltipItem.raw;
                            }
                        }
                    }
                },
                indexAxis: 'x'
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>