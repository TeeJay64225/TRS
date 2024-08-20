<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == "add") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $town = $_POST['town'];
    $country = $_POST['country'];
    $postcode = $_POST['postcode'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO clients (name, email, address1, address2, town, country, postcode, phone) 
            VALUES ('$name', '$email', '$address1', '$address2', '$town', '$country', '$postcode', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo "New client added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>client_management</title>
    <link rel="stylesheet" href="client_mang.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                        <li class="navLink ">
                            <a href="user_landing_page.php">
                                <i class="fa-solid fa-gauge icon"></i>
                                Home
                            </a>
                        </li>
                        <li class="navLink" id="invoiceCreationNav">
                            <i class="fa-solid fa-plus"></i>
                            <a href="invoice_creation.php">Invoice Creation</a>
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-plus"></i>
                            <a href="receipt_management.php">Receipt Management</a>
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
                        <li class="navLink activeNavLink">
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
                    <h1 class="headline">Add Client</h1>

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
            <br>
            <br>
            <br>
            <br>

            <section class="invoice-form">
                <div class="form-container">
                    <div class="form-section">
                        <form action="client_management.php" method="post">
                            <h2>Client Information (Details)</h2>
                            <div class="form-group">
                                <input type="hidden" name="action" value="add">
                                <label for="customer-name">Client Name</label>
                                <input type="text" name="name" placeholder="Client Name" required>
                            </div>
                            <div class="form-group">
                                <label for="customer-email">E-mail Address</label>
                                <input type="email" name="email" placeholder="E-mail Address" required>
                            </div>
                            <div class="form-group">
                                <label for="customer-address1">Address 1</label>
                                <input type="text" name="address1" placeholder="Address" required>
                            </div>
                            <div class="form-group">
                                <label for="customer-address2">Address 2</label>
                                <input type="text" name="address2" placeholder="additional address">
                            </div>
                            <div class="form-group">
                                <label for="customer-phone">Phone Number</label>
                                <input type="text" name="phone" placeholder="Contact Details" required>
                            </div>
                    </div>
                    <div class="form-section1">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-control required" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="customer-town">Town</label>
                            <input type="text" name="town" placeholder="Town">
                        </div>
                        <div class="form-group">
                            <label for="customer-country">Country</label>
                            <input type="text" name="country" placeholder="Country">
                        </div>
                        <div class="form-group">
                            <label for="customer-postcode">Postcode</label>
                            <input type="text" name="postcode" placeholder="Postcode">
                        </div>
                        <div class="gen">
                            <button type="submit">Add Client</button>
                            <a href="all_client.php">Client</a>
                        </div>
                    </div>
                </div>
                <br>
                </form>
            </section>







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
    </script>
</body>

</html>