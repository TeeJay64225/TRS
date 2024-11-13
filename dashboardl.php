<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
require_once('db.php');

// Fetch the total number of users from the database
$sql = "SELECT COUNT(*) as total_users FROM users";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_users = $row['total_users'];
}


?>

<?php

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Function to delete a user
if (isset($_POST['delete_user_id'])) {
    $delete_user_id = $_POST['delete_user_id'];
    $delete_sql = "DELETE FROM users WHERE id = $delete_user_id";
    $conn->query($delete_sql);
    header("Location: admin_dashboard.php");
    exit();
}

// Function to add a user
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $role = $_POST['role'];

    $add_sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";
    $conn->query($add_sql);
    header("Location: admin_dashboard.php");
    exit();
}
?>










<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboardstyle.css">
    <link rel="stylesheet" href="https://kit.fontawesome.com/aa7454d09f.js" crossorigin="anonymous">
</head>

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
                            <a href="#dashboard">Dashboard</a>
                        </li>
                        <li class="navLink" id="clientManagementNav">
                            <i class="fa-solid fa-dollar-sign icon"></i>
                            <a href="#client_management">Client Management</a>
                        </li>
                        <li class="navLink" id="invoiceCreationNav">
                            <i class="fa-solid fa-mug-hot"></i>
                            <a href="invoice_creation.php">Invoice Creation</a>
                        </li>
                        <li class="navLink" id="receiptManagementNav">
                            <i class="fa-solid fa-address-book icon"></i>
                            <a href="receipt_management.php">Receipt Management</a>
                        </li>
                        <li class="navLink" id="recordsNav">
                            <i class="fa-solid fa-file-invoice"></i>
                            <a href="records.php">Invoice and Receipt Records</a>
                        </li>
                        <li class="navLink" id="userManagementNav">
                            <i class="fa-solid fa-list-check"></i>
                            <a href="usermanagement.php">User Management (Admin Only)</a>
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

                <section class="analytics">
                    <div class="analyticsCard">
                        <h3 class="cardHeader">Debit Card Account</h3>

                        <div class="debitcardContainer">
                            <div class="debitcardPic">
                                <img src="./img/debit card.png" alt="debit card">
                            </div>

                            <div class="addDebitCard">
                                <div class="addbutton">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                                Add Debit Card
                            </div>
                        </div>
                    </div>

                    <div class="analyticsCard totalBalanceCard">
                        <h3 class="cardHeader">Total Users</h3>
                        <h1 class="totalBalance"><?php echo $total_users; ?></h1>

                        <p class="earnDate" id="currentDateTime"></p>


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

                    <div class="analyticsCard">
                        <h3 class="cardHeader cardHeader1">Users</h3>
                        <div class="transactionContainer">
                            <?php foreach ($users as $user) : ?>
                                <div class="eachTransaction">
                                    <div class="tansactionDesc">
                                        <div class="paymentStatus">
                                            <h3><?php echo $user['username']; ?></h3>
                                            <p>Email: <?php echo $user['email']; ?></p>
                                            <p>Role: <?php echo $user['role']; ?></p>
                                        </div>
                                    </div>
                                    <div class="transactionPrice">
                                        <form method="post" style="display:inline-block;">
                                            <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn delete-btn">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button id="addUserBtn" class="btn add-btn">Add User</button>
                    </div>

                    <!-- Modal -->
                    <div id="addUserModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h3 class="cardHeader cardHeader1">Add User</h3>
                            <form method="post">
                                <input type="text" name="username" placeholder="Username" required>
                                <input type="password" name="password" placeholder="Password" required>
                                <input type="email" name="email" placeholder="Email" required>
                                <select name="role" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <button type="submit" name="add_user" class="btn add-btn">Add User</button>
                            </form>
                        </div>
                    </div>

                    <div class="analyticsCard totalBalanceCard">
                        <h3 class="cardHeader cardHeader1">
                            <span>Expenses Instead</span>
                            <span><i class="fa-solid fa-ellipsis"></i></span>
                        </h3>

                        <div class="gaugeContainer">
                            <div class="gaugeBody">
                                <div class="gaugeProgress"></div>
                                <div class="guageNumber">
                                    85.5%<br>
                                    <span class="expenseStatus">Normal Level</span>
                                </div>
                            </div>
                            <div class="totalExpense">Total Exp:
                                <span class="totalExpensePrice">$1,820.80</span>
                            </div>
                        </div>
                    </div>
                </section>

            </main>
        </div>
        <div id="clientManagementContent" class="content">
            <h2>Client Management</h2>
            <p>Manage your clients' information, add new clients, and update existing client details here.</p>
        </div>
        <div id="invoiceCreationContent" class="content">
            <h2>Invoice Creation</h2>
            <p>Create new invoices for your clients, add itemized services, and calculate totals.</p>
        </div>
        <div id="receiptManagementContent" class="content">
            <h2>Receipt Management</h2>
            <p>Manage receipts, view and update past transactions, and ensure accurate record-keeping.</p>
        </div>
        <div id="recordsContent" class="content">
            <h2>Invoice and Receipt Records</h2>
            <p>Access and review all your past invoices and receipts, filter by date or client.</p>
        </div>
        <div id="userManagementContent" class="content">
            <h2>User Management</h2>
            <p>Admin can manage user accounts, assign roles, and ensure secure access to the system.</p>
        </div>
        <div id="reportsContent" class="content">
            <h2>Reports</h2>
            <p>Generate various reports to analyze business performance and make informed decisions.</p>
        </div>
        <div id="settingsContent" class="content">
            <h2>Settings</h2>
            <p>Adjust your preferences, configure system settings, and update your profile information.</p>
        </div>
        <div id="helpCenterContent" class="content">
            <h2>Help Center</h2>
            <p>Find answers to common questions, contact support, and access user guides.</p>
        </div>
    </div>
    </div>
    </section>
    </main>
    </div>

    <script>
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
                second: '2-digit'
            };

            dateTimeElement.textContent = now.toLocaleDateString('en-US', options);
        }


        document.addEventListener('DOMContentLoaded', updateDateTime);

        // JavaScript to handle modal
        var modal = document.getElementById("addUserModal");
        var btn = document.getElementById("addUserBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>