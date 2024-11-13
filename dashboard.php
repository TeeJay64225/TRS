<?php include('subfolder/main.php'); ?>
<?php include('subfolder/pie_chart.php'); ?>
<?php
// Assuming you already have a session started and user authentication in place
//session_start();
//include('db_connection.php'); // Include your database connection

//if (isset($_SESSION['user_id'])) {
// $user_id = $_SESSION['user_id'];
//$login_time = date('Y-m-d H:i:s');

// Insert login record into the database
//$sql = "INSERT INTO login_records (user_id, login_time) VALUES (?, ?)";
// $stmt = $db_connection->prepare($sql); // Use $db_connection instead of $conn
// $stmt->bind_param("is", $user_id, $login_time);
// $stmt->execute();
//}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboardstyle.css">
    <link rel="stylesheet" href="https://kit.fontawesome.com/aa7454d09f.js" crossorigin="anonymous">
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

<body>
    <div id="content">
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
                        <li class="navLink activeNavLink" id="dashboardNav">
                            <i class="fa-solid fa-gauge icon"></i>
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="navLink" id="clientManagementNav">
                            <i class="fa-solid fa-dollar-sign icon"></i>
                            <a href="ad_client.php">Client Management</a>
                        </li>
                        <li class="navLink" id="invoiceCreationNav">
                            <i class="fa-solid fa-mug-hot"></i>
                            <a href="ad_user.php">User Management</a>
                        </li>
                        <li class="navLink" id="receiptManagementNav">
                            <i class="fa-solid fa-address-book icon"></i>
                            <a href="Receipt_record.php">Receipt Records</a>
                        </li>
                        <li class="navLink" id="recordsNav">
                            <i class="fa-solid fa-file-invoice"></i>
                            <a href="invoice_record.php">Invoice Records</a>
                        </li>
                        <li class="navLink" id="userManagementNav">
                            <i class="fa-solid fa-list-check"></i>
                            <a href="ad_user.php">User Management (Admin Only)</a>
                        </li>
                        <li class="navLink" id="reportsNav">
                            <i class="fa-solid fa-chart-simple icon"></i>
                            Reports
                        </li>
                    </ul>
                    <p class="navSectionName">Others</p>
                    <ul class="nav">
                        <li class="navLink" id="settingsNav">
                            <i class="fa-solid fa-gear icon"></i>
                            <a href="#settings">Setting</a>
                        </li>
                        <li class="navLink" id="helpCenterNav">
                            <i class="fa-solid fa-headset icon"></i>
                            <a href="#help_center">Help Center</a>
                        </li>
                        <li class="navLink" id="logoutNav">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
                <div id="bottomNav">
                    <h3 class="copyright">&copy; Truck Receipt Service (TRS), 2022</h3>
                    <p class="copyDesc">Digital payment platform is a solution for all types of service.</p>
                </div>
            </div>
        </div>
        <div id="dashboardContent" class="content activeContent">

            <main id="main">
                <header>
                    <div class="headlineContainer">
                        <h1 class="headline">Welcome to TRS</h1>
                        <p class="subheadline">
                            Hi, Dev_Quarm. Welcome Back
                        </p>
                    </div>
                    <div class="headlineContainer">
                        <h1 class="headline">Admin Dashboard</h1>
                    </div>
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
                <div class="analyticsCard totalBalanceCard">
                    <div>
                        <h3 class="cardHeader">Total Users</h3>
                        <h1 class="totalBalance"><?php echo $total_users; ?></h1>
                       <!-- <p class="earnDate" id="currentDateTime"></p> -->
                        <div class="btnContainer">
                            <div class="btn">
                                <i class="fa-solid fa-paper-plane"></i>
                                send
                            </div>
                            <div class="btn">
                                <i class="fa-solid fa-circle-plus"></i>
                                topup
                            </div>
                            <div class="btn">
                                <i class="fa-solid fa-braille"></i>
                                more
                            </div>
                        </div>
                    </div>

                    <div class="side ">
                        <h3 class="cardHeader">Total Clients</h3>
                        <h1 class="totalBalance"><?php echo $total_clients; ?></h1>
                       <!-- <p class="earnDate" id="currentDateTime"> Display something</p> -->
                        <div class="btnContainer">
                            <div class="btn">
                                <i class="fa-solid fa-paper-plane"></i>
                                send
                            </div>
                            <div class="btn">
                                <i class="fa-solid fa-circle-plus"></i>
                                topup
                            </div>
                            <div class="btn">
                                <i class="fa-solid fa-braille"></i>
                                more
                            </div>
                        </div>
                    </div>
                    <div class="side ">
                        <h3 class="cardHeader">Total Receipts</h3>
                        <h1 class="totalBalance"><?php echo $total_receipts; ?></h1>
                       <!-- <p class="earnDate" id="currentDateTime"> Display something</p> -->
                        <div class="btnContainer">
                            <div class="btn">
                                <i class="fa-solid fa-paper-plane"></i>
                                send
                            </div>
                            <div class="btn">
                                <i class="fa-solid fa-circle-plus"></i>
                                topup
                            </div>
                            <div class="btn">
                                <i class="fa-solid fa-braille"></i>
                                more
                            </div>
                        </div>
                    </div>
                    <div class="side ">
                        <h3 class="cardHeader">Total Invoices</h3>
                        <h1 class="totalBalance"><?php echo $total_invoices; ?></h1>
                      <!--  <p class="earnDate" id="currentDateTime"> Display something</p> -->
                        <div class="btnContainer">
                            <div class="btn">
                                <i class="fa-solid fa-paper-plane"></i>
                                send
                            </div>
                            <div class="btn">
                                <i class="fa-solid fa-circle-plus"></i>
                                topup
                            </div>
                            <div class="btn">
                                <i class="fa-solid fa-braille"></i>
                                more
                            </div>
                        </div>
                    </div>
                </div>
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
                <br>

                <!-- Receipts Gauge -->
                <div class="analyticsCard1 totalBalanceCard1">
                    <h3 class="cardHeaderr cardHeader2">
                        <h3 class="cardHeaderr">Total Receipt Guage</h3>
                        <span><i class="fa-solid fa-ellipsis"></i></span>
                    </h3>
                    <h3 class="cardHeaderr"></h3>
                    <div class="gaugeContainer">
                        <div class="gaugeBody">
                            <div class="gaugeProgress receipts"></div>
                            <div class="guageNumber">
                                <span id="receiptPercentage">85.5%</span><br>
                                <span class="expenseStatus">Receipts</span>
                            </div>
                        </div>
                        <div class="totalExpense">Total Receipts:
                            <span class="totalExpensePrice" id="totalReceipts"><?php echo $total_receipts; ?></span>
                        </div>
                    </div>
                    <h3 class="cardHeader cardHeader2">
                        <h3 class="cardHeaderr">Total Invoice Guage </h3>
                        <span><i class="fa-solid fa-ellipsis"></i></span>
                    </h3>
                    <h3 class="cardHeaderr"> </h3>
                    <div class="gaugeContainer">
                        <div class="gaugeBody">
                            <div class="gaugeProgress receipts"></div>
                            <div class="guageNumber">
                                <span id="receiptPercentage">85.5%</span><br>
                                <span class="expenseStatus">Invoices</span>
                            </div>
                        </div>
                        <div class="totalExpense">Total Invoice:
                            <span class="totalExpensePrice" id="totalReceipts"><?php echo $total_invoices; ?></span>
                        </div>
                    </div>
                </div>
                <br>







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

        //for the time update
        function updateDateTime() {
            const dateTimeElement = document.getElementById('currentDateTime');
            const now = new Date();

            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',

            };

            dateTimeElement.textContent = now.toLocaleDateString('en-US', options);
        }

        document.addEventListener('DOMContentLoaded', updateDateTime);

        // Attendance Chart
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

        // Training Chart
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
        // Get all navigation links
        const navLinks = document.querySelectorAll('.navLink');
        const contentSections = document.querySelectorAll('.content');

        // Add click event listener to each link
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Remove 'activeNavLink' class from all links
                navLinks.forEach(link => link.classList.remove('activeNavLink'));

                // Add 'activeNavLink' class to the clicked link
                this.classList.add('activeNavLink');

                // Hide all content sections
                contentSections.forEach(section => section.classList.remove('activeContent'));

                // Show the corresponding content section
                const targetContent = this.querySelector('a').getAttribute('href').substring(1) + 'Content';
                document.getElementById(targetContent).classList.add('activeContent');
            });
        });



        // JavaScript to handle modals
        var userModal = document.getElementById("addUserModal");
        var userBtn = document.getElementById("addUserBtn");
        var clientModal = document.getElementById("addClientModal");
        var clientBtn = document.getElementById("addClientBtn");
        var span = document.getElementsByClassName("close");

        userBtn.onclick = function() {
            userModal.style.display = "block";
        }

        clientBtn.onclick = function() {
            clientModal.style.display = "block";
        }

        span[0].onclick = function() {
            userModal.style.display = "none";
        }

        span[1].onclick = function() {
            clientModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == userModal) {
                userModal.style.display = "none";
            } else if (event.target == clientModal) {
                clientModal.style.display = "none";
            }
        }

        // Example data
        const totalReceipts = 86; // Replace with actual data
        const totalInvoices = <?php echo number_format($invoice_percentage, 1); ?>; // Replace with actual data

        // Update receipt gauge
        document.getElementById('receiptPercentage').innerText = `${totalReceipts}%`;
        document.querySelector('.gaugeProgress.receipts').style.transform = `rotate(${totalReceipts / 100 / 2}turn)`;
        document.getElementById('totalReceipts').innerText = `$${(totalReceipts * 10).toFixed(2)}`; // Example calculation

        // Update invoice gauge
        document.getElementById('invoicePercentage').innerText = `${totalInvoices}%`;
        document.querySelector('.gaugeProgress.invoices').style.transform = `rotate(${totalInvoices / 100 / 2}turn)`;
        document.getElementById('totalInvoices').innerText = `$${(totalInvoices * 10).toFixed(2)}`; // Example calculation
    </script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>