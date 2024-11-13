<?php include('subfolder/main.php'); ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboardstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://kit.fontawesome.com/aa7454d09f.js" crossorigin="anonymous">
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
                        <li class="navLink " id="dashboardNav">
                            <i class="fa-solid fa-gauge icon"></i>
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="navLink activeNavLink" id="clientManagementNav">
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

                        <div class="transactionContainer">
                            <?php foreach ($clients as $client) : ?>
                                <form method="post" action="">
                                    <div class="eachTransaction">
                                        <div class="tansactionDesc">
                                            <div class="paymentStatus">
                                                <br>
                                                <div class="clientField">
                                                    <span class="clientLabel" style="margin-left: 20px;">Name: </span>
                                                    <span class="clientData" style="margin-left: 120px;"><?php echo htmlspecialchars($client['name']); ?></span>
                                                </div>
                                                <hr>
                                                <div class="clientField">
                                                    <span class="clientLabel">Email: </span>
                                                    <span class="clientData" style="margin-left: 120px;"><?php echo htmlspecialchars($client['email']); ?></span>
                                                </div>
                                                <hr>
                                                <div class="clientField">
                                                    <span class="clientLabel">Phone:</span>
                                                    <span class="clientData" style="margin-left: 120px;"><?php echo htmlspecialchars($client['phone']); ?></span>
                                                </div>
                                                <hr>
                                                <div class="clientField">
                                                    <span class="clientLabel">Address:</span>
                                                    <span class="clientData" style="margin-left: 120px;"><?php echo htmlspecialchars($client['address1']); ?></span>
                                                </div>
                                                <hr>
                                                <div class="clientField">
                                                    <span class="clientLabel">Town:</span>
                                                    <span class="clientData" style="margin-left: 120px;"><?php echo htmlspecialchars($client['town']); ?></span>
                                                </div>
                                                <hr>
                                                <div class="clientField">
                                                    <span class="clientLabel">Country:</span>
                                                    <span class="clientData" style="margin-left: 120px;"><?php echo htmlspecialchars($client['country']); ?></span>
                                                </div>
                                                <hr>
                                                <div class="clientField">
                                                    <span class="clientLabel">Postal Code:</span>
                                                    <span class="clientData" style="margin-left: 120px;"><?php echo htmlspecialchars($client['postcode']); ?></span>
                                                </div>
                                                <hr>
                                                <div class="clientField">
                                                    <span class="clientLabel">Created:</span>
                                                    <span class="clientData" style="margin-left: 120px;"><?php echo htmlspecialchars($client['created_at']); ?></span>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="transactionPrice">
                                            <input type="hidden" name="" value="<?php echo $client['id']; ?>">
                                            <button type="submit" class="">Delete</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endforeach; ?>
                        </div>
                        <button class="btn add-btn"><a href="ad_add_client.php">Add Client</a></button>
                    </div>
                </section>

                <br>
                <br>
                <br>

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

        // Get all navigation links


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
        var clientModal = document.getElementById("addClientModal");
        var clientBtn = document.getElementById("addClientBtn");
        var span = document.getElementsByClassName("close")[0];

        clientBtn.onclick = function() {
            clientModal.style.display = "block";
        }

        span.onclick = function() {
            clientModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == clientModal) {
                clientModal.style.display = "none";
            }
        }
    </script>
</body>

</html>