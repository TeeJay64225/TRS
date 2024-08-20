<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $invoice_no = $_POST['invoice_no'] ?? '';
    $date = $_POST['date'] ?? '';
    $customer_info = $_POST['customer_info'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';
    $address = $_POST['address'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $delivery_status = $_POST['delivery_status'] ?? 'undelivered';
    $payment_status = $_POST['payment_status'] ?? 'unpaid';
    $notes = $_POST['notes'] ?? '';
    $invoice_id = $_POST['invoice_id'] ?? '';
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Invoices</title>
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
                        <li class="navLink activeNavLink" id="invoiceCreationNav">
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
                    <input type="text" id="searchInput" placeholder="Search Clients">
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
            <h2> All Undelivered Invoices</h2>

            <br>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Invoice No</th>
                        <th>Date</th>
                        <th>Due Date</th>
                        <th>Client ID</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Tax</th>
                        <th>Grand Total</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM invoices ORDER BY client_id DESC";
                    $result = $conn->query($sql);
                    $sl = 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $sl++ . "</td>";
                            echo "<td>" . $row["invoice_number"] . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            echo "<td>" . $row["due_date"] . "</td>";
                            echo "<td>" . $row["client_id"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>" . $row["total_amount"] . "</td>";
                            echo "<td>" . $row["tax"] . "</td>";
                            echo "<td>" . $row["grand_total"] . "</td>";
                            echo "<td>" . $row["payment_method"] . "</td>";
                            echo '<td>
        <form style="display:inline;" action="invoice_management.php" method="post">
            <div class="gen"> 
            <button type="submit" class="btn btn-primary" >  <a href="generate_invoice.php?invoice_id=' . $row['invoice_id'] . '" class="printBtn" target="_blank" style="color: white; text-decoration: none;">Print</a></button>
            <button type="submit" name="action" value="delete" class="deleteBtn">Delete</button>
        </div>
            </form>
      </td>';

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>No invoices found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>


    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Are you sure you want to delete this invoice?</h2>
            <form id="deleteForm" action="all_invoice.php" method="post">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="invoice_id" id="deleteInvoiceId">
                <button type="submit" class="deleteBtn">Yes, Delete</button>
                <button type="button" class="cancelBtn">Cancel</button>
            </form>
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
        // Get modal elements
        var editModal = document.getElementById("editModal");
        var deleteModal = document.getElementById("deleteModal");
        var closeEditModal = document.getElementsByClassName("close")[0];
        var closeDeleteModal = document.getElementsByClassName("close")[1];



        // Open delete modal
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function() {
                deleteModal.style.display = "block";
                var invoiceId = this.parentElement.querySelector('input[name="invoice_id"]').value;
                document.getElementById('deleteInvoiceId').value = invoiceId;
            });
        });

        // Close modals
        closeEditModal.onclick = function() {
            editModal.style.display = "none";
        }
        closeDeleteModal.onclick = function() {
            deleteModal.style.display = "none";
        }
        document.querySelectorAll('.cancelBtn').forEach(button => {
            button.addEventListener('click', function() {
                deleteModal.style.display = "none";
            });

        });

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
            if (event.target == deleteModal) {
                deleteModal.style.display = "none";
            }
        }
    </script>
</body>

</html>