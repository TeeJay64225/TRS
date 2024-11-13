<?php include('subfolder/pie_chart.php'); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | landing</title>
    <link rel="stylesheet" href="invoice_creation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/aa7454d09f.js" crossorigin="anonymous"></script>
</head>
<style>
    .navLink a {
        color: var(--primaryColor);
        /* Set the text color to black */
        text-decoration: none;
        /* Remove the underline from the links */
    }

    .navLink a:hover {
        color: var(--primaryColor);
        /* Optional: Darker color on hover */
    }
</style>
<>
    <div id="dashboard">
        <!--SideNav-->
        <div>
            <div class="toggleMenu" id="toggleMenu">
                <i class="fa-solid fa-arrow-right icon toggelMenuIcon" id="toggelMenuIcon"></i>
            </div>
            <div class="sideNav" id="sideNav">
                <div id="topNav">
                    <div id="logo">
                        <span class="logoPic">TRS</span>
                        <h1 class="logoName">Truck Record Services</h1>
                    </div>
                    <p class="navSectionName">Main Menu</p>
                    <ul class="nav">
                        <li class="navLink activeNavLink ">
                            <i class="fa-solid fa-gauge icon"></i>
                            <a href="user_landing_page.php"> Home
                            </a>
                        </li>
                        <li class="navLink ">
                            <i class="fa-solid fa-plus icon"></i>
                            <a href="invoice_creation.php">Invoice Creation</a>
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-plus icon"></i>
                            <a href="receipt_management.php">Receipt Creation</a>
                        </li>
                        <li class="navLink" id="invoiceCreationNav">
                            <i class="fa-solid fa-mug-hot"></i>
                            <a href="all_invoice.php">All Invoice</a>
                        </li>
                        <li class="navLink" id="invoiceCreationNav">
                            <i class="fa-solid fa-mug-hot"></i>
                            <a href="all_receipt.php">All Receipt</a>
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-credit-card icon"></i>
                            <a href="all_client.php">All clients</a>
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-address-book icon"></i>
                            <a href="client_management.php">Add Client </a>
                        </li>

                    </ul>
                    <p class="navSectionName">Others</p>
                    <ul class="nav">
                        <li class="navLink">
                            <i class="fa-solid fa-gear icon"></i>
                            Setting
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-headset icon"></i>
                            Help Center
                        </li>
                        <li class="navLink" id="logoutNav">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>

                <div id="bottomNav">
                    <h3 class="copyright">&copy; Truck Receipt Service (TRS), 2024</h3>
                    <p class="copyDesc">Digital payment platform is a solution for all types of service.</p>
                </div>

            </div>
        </div>

        <main id="main">

            <!--Header-->
            <header>

                <div class="toggleMenu" id="toggleMenu">
                    <i class="fa-solid fa-arrow-right icon toggelMenuIcon" id="toggelMenuIcon"></i>
                </div>
                <div class="headlineContainer">
                    <h1 class="headline">Welcome to TRS</h1>
                    <p class="subheadline">
                        Hi, User. Welcome Back
                    </p>
                </div>
                <div class="headlineContainer">
                    <h1 class="headline">User Dashboard</h1>

                </div>
                <div>

                    <div class="profileContainer">
                        <div class="iconContainer moonIcon" id="toggleTheme">
                            <i class="fa-solid fa-moon" id="toggleThemeIcon"></i>
                        </div>
                        <div class="iconContainer">
                            <i class="fa-solid fa-bell notification"></i>
                        </div>
                        <div class="profilePic">
                            <img src="./img/profile.jpg" alt="">
                        </div>
                    </div>
            </header>

            <br>
            <br>




            <br>
            <section class="invoice-form">
                <div class="form-container">
                    <div class="form-section">
                        <div class="chart-container">
                            <h2 class="card-title">Total Overview</h2>
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>

                    <div class="form-section1">

                        <div class="form-group">
                            <div class="chart-container">
                                <h2 class="card-title">Invoice Overview</h2>
                                <canvas id="trainingChart"></canvas>
                            </div>
                        </div>

            </section>
            <section class="invoice-form">
                <div class="form-container">
                    <div class="form-section">
                        <div class="chart-container">
                            <h2 class="card-title">Total Receipt Overview</h2>
                            <canvas id="evaluationChart"></canvas>
                        </div>
                    </div>

                    <div class="form-section1">

                        <div class="form-group">
                            <div class="chart-container">
                                <h2 class="card-title">No of Clients</h2>
                                <canvas id="vacationChart">Data</canvas>
                            </div>
                        </div>

            </section>





        </main>

    </div>


    <script>
        //toogle
        const toggleMenu = document.getElementById("toggleMenu");
        const toggelMenuIcon = document.getElementById("toggelMenuIcon");
        const sideNav = document.getElementById("sideNav");
        const toggleTheme = document.getElementById("toggleTheme");
        const toggleThemeIcon = document.getElementById("toggleThemeIcon");

        toggleMenu.onclick = (e) => {
            sideNav.classList.toggle("showsideNav");
            toggelMenuIcon.classList.toggle("rotateToggelMenuIcon")
            toggleMenu.classList.toggle("slidetoggleMenu")
        }

        toggleTheme.onclick = () => {
            document.body.classList.toggle("darkTheme")
            e.target.classList.toggle("lightMoonIcon");
        }



        // Attendance Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            const attendanceData = {
                labels: ['Users', 'Clients'],
                datasets: [{
                    data: [<?php echo $total_users; ?>, <?php echo $total_clients; ?>],
                    backgroundColor: ['#007bff', '#6610f2']
                }]
            };
            new Chart(ctx, {
                type: 'pie',
                data: attendanceData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        });

        // Invoice Overview Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('trainingChart').getContext('2d');
            const invoiceData = {
                labels: ['Unpaid Invoices', 'Paid Invoices', 'Overdue Invoices'],
                datasets: [{
                    data: [<?php echo $unpaid_invoices; ?>, <?php echo $paid_invoices; ?>, <?php echo $overdue_invoices; ?>],
                    backgroundColor: ['#007bff', '#28a745', '#dc3545']
                }]
            };
            new Chart(ctx, {
                type: 'pie',
                data: invoiceData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        });


        // Evaluation Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('evaluationChart').getContext('2d');
            const evaluationData = {
                labels: ['Credit Card', 'Bank Transfer', 'PayPal'],
                datasets: [{
                    data: [<?php echo $credit_card_receipts; ?>, <?php echo $bank_transfer_receipts; ?>, <?php echo $paypal_receipts; ?>],
                    backgroundColor: ['#007bff', '#28a745', '#dc3545']
                }]
            };
            new Chart(ctx, {
                type: 'pie',
                data: evaluationData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
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
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    </body>

</html>