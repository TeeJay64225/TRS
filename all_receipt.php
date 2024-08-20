<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Receipts</title>
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
                        <li class="navLink">
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
                        <li class="navLink activeNavLink" id="invoiceCreationNav">
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
            <div class="form-group float-right">
                <div class="input-group col-xs-4">
                    <input type="text" id="searchInput" placeholder="Search Receipts">
                    <select id="filterByCountry">
                        <option value="">All Countries</option>
                        <option value="USA">USA</option>
                        <option value="UK">UK</option>
                    </select>
                    <select id="filterByTown">
                        <option value="">All Towns</option>
                        <option value="New York">New York</option>
                        <option value="London">London</option>
                    </select>
                </div>
            </div>
            <h2>All Receipts</h2>

            <br>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Receipt No</th>
                        <th>Date</th>
                        <th>Due Date</th>
                        <th>Client ID</th>
                        <th>Tax</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM receipts";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row["id"];
                            $receipt_number = $row["receipt_number"];
                            $receipt_date = $row["receipt_date"];
                            $due_date = $row["due_date"];
                            $client_id = $row["client_id"];
                            $tax = $row["tax"];
                            $grand_total = $row["grand_total"];
                            $payment_method = $row["payment_method"];

                            echo '<tr>
                               
                                <td>' . $id . '</td>
                                <td>' . $receipt_number . '</td>
                                <td>' . $receipt_date . '</td>
                                <td>' . $due_date . '</td>
                                <td>' . $client_id . '</td>
                                <td>' . $tax . '</td>
                                <td>' . $grand_total . '</td>
                                <td>' . $payment_method . '</td>
                                <td>
                            <div class="gen">
    <form method="GET" action="delete.php">
        <button type="submit" class="btn btn-primary">
            <a href="generate-receipt.php?receipt_id=' . $id . '" class="printBtn" target="_blank" style="color: white; text-decoration: none;">Print</a>
        </button>
        <input type="hidden" name="deleteid" value="' . $id . '">
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>

                                </td> 
                            </tr>';
                        }
                    } else {
                        echo "<tr><td colspan='9'>No receipts found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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