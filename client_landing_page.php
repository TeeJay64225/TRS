<?php include('subfolder/main.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client | landing</title>
    <link rel="stylesheet" href="dashboardstyle.css">
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
    <div id="dashboard">
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
                        <li class="navLink activeNavLink">
                            <i class="fa-solid fa-gauge icon"></i>
                            Home
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-dollar-sign icon"></i>Create Invoice
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-credit-card icon"></i>
                            View Receipts
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-address-book icon"></i>
                            Client Information
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-wallet icon"></i>
                            E-wallet Center
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-chart-simple icon"></i>
                            Reports
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
                    </ul>
                </div>

                <div id="bottomNav">
                    <h3 class="copyright">&copy; Truck Receipt Service (TRS), 2022</h3>
                    <p class="copyDesc">Digital payment platform is a solution for all types of service.</p>
                </div>

            </div>
        </div>
        <main id="main">
            <header>
                <div class="headlineContainer">
                    <h1 class="headline">Welcome to TRS</h1>
                    <p class="subheadline">
                        Hi, Client. Welcome Back
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


            </section>


        </main>
    </div>
</body>

</html>