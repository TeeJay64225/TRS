<?php include('subfolder/main.php'); ?>

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
                <br>
                <br>
                <section class="analytics">
                    <div class="analyticsCard">
                        <h3 class="cardHeader">Client Information</h3>

                        <div class="clientInfoContainer">
                            <?php foreach ($clients as $client) : ?>
                                <div class="clientInfo">
                                    <div class="clientField">
                                        <span class="clientLabel">Name:</span>
                                        <span class="clientData"><?php echo htmlspecialchars($client['firstname'] . ' ' . $client['lastname']); ?></span>
                                    </div>
                                    <hr>
                                    <div class="clientField">
                                        <span class="clientLabel">Email:</span>
                                        <span class="clientData"><?php echo htmlspecialchars($client['email']); ?></span>
                                    </div>
                                    <hr>
                                    <div class="clientField">
                                        <span class="clientLabel">Phone:</span>
                                        <span class="clientData"><?php echo htmlspecialchars($client['phone']); ?></span>
                                    </div>
                                    <hr>
                                    <div class="transactionPrice">
                                        <form method="post" style="display:inline-block;">
                                            <input type="hidden" name="delete_client_id" value="<?php echo $client['id']; ?>">
                                            <button type="submit" class="btn delete-btn">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button id="addClientBtn" class="btn add-btn">Add Client</button>
                    </div>

                    <!-- Client Modal -->
                    <div id="addClientModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h1 class="cardHeader cardHeader1"><b>Add Client</b></h1>

                            <form action="admin_dashboard.php" method="post">
                                <div class="input-box">
                                    <input type="text" name="firstname" placeholder="First Name" required>
                                </div>
                                <div class="input-box">
                                    <input type="text" name="lastname" placeholder="Last Name" required>
                                </div>
                                <div class="input-box">
                                    <input type="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="input-box">
                                    <input type="text" name="phone" placeholder="Phone Number" required>
                                </div>
                                <button type="submit" name="add_client" class="btn add-btn">Add Client</button>
                            </form>
                        </div>
                    </div>
                </section>

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


                <!-- User-->
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
                                        <hr>
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

                <!-- User Modal -->
                <div id="addUserModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="cardHeader cardHeader1"><b>Add User</b></h1>

                        <form action="admin_dashboard.php" method="post">
                            <div class="input-box">
                                <input type="text" name="firstname" placeholder="First Name" required>
                            </div>
                            <div class="input-box">
                                <input type="text" name="lastname" placeholder="Last Name" required>
                            </div>
                            <div class="input-box">
                                <input type="text" name="role" placeholder="Role" required>
                            </div>
                            <div class="input-box">
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="input-box">
                                <input type="text" name="phone" placeholder="Phone Number" required>
                            </div>
                            <div class="input-box">
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" name="add_user" class="btn add-btn">Add User</button>
                        </form>
                    </div>
                </div>

                <!-- Receipts Gauge -->
                <div class="analyticsCard totalBalanceCard">
                    <h3 class="cardHeader cardHeader1">
                        <span>Total Receipt Guage</span>
                        <span><i class="fa-solid fa-ellipsis"></i></span>
                    </h3>
                    <div class="gaugeContainer">
                        <div class="gaugeBody">
                            <div class="gaugeProgress receipts"></div>
                            <div class="guageNumber">
                                <span id="receiptPercentage">85.5%</span><br>
                                <span class="expenseStatus">Receipts</span>
                            </div>
                        </div>
                        <div class="totalExpense">Total Receipts:
                            <span class="totalExpensePrice" id="totalReceipts">$1,820.80</span>
                        </div>
                    </div>
                </div>

                <!-- Invoices Gauge -->
                <div class="analyticsCard totalBalanceCard">
                    <h3 class="cardHeader cardHeader1">
                        <span>Total Invoice Guage</span>
                        <span><i class="fa-solid fa-ellipsis"></i></span>
                    </h3>
                    <div class="gaugeContainer">
                        <div class="gaugeBody">
                            <div class="gaugeProgress invoices"></div>
                            <div class="guageNumber">
                                <span id="invoicePercentage"><?php echo number_format($invoice_percentage, 1); ?>%</span><br>
                                <span class="expenseStatus">Invoices</span>
                            </div>
                        </div>
                        <div class="totalExpense">Total Invoices:
                            <span class="totalExpensePrice" id="totalInvoices"><?php echo number_format($total_invoices); ?></span>
                        </div>
                    </div>
                </div>
                </section>
            </main>
        </div>
    </div>

    <div id="clientManagementContent" class="content">
        <h2>Client Management</h2>
        <div class="analyticsCard">
            <h3 class="cardHeader cardHeader1">Clients</h3>
            <div class="transactionContainer">
                <?php foreach ($clients as $client) : ?>
                    <div class="eachTransaction">
                        <div class="tansactionDesc">
                            <div class="paymentStatus">
                                <h3><?php echo htmlspecialchars($client['firstname'] . ' ' . $client['lastname']); ?></h3>
                                <p>Email: <?php echo htmlspecialchars($client['email']); ?></p>
                                <p>Phone: <?php echo htmlspecialchars($client['phone']); ?></p>
                            </div>
                        </div>
                        <div class="transactionPrice">
                            <form method="post" style="display:inline-block;">
                                <input type="hidden" name="delete_client_id" value="<?php echo $client['id']; ?>">
                                <button type="submit" class="btn delete-btn">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button id="addClientBtn" class="btn add-btn">Add Client</button>
        </div>
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
</body>

</html>