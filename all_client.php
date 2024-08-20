<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $address1 = $_POST['address1'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $town = $_POST['town'] ?? '';
    $country = $_POST['country'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    $client_id = $_POST['client_id'] ?? '';

    if ($action == 'add') {
        $sql = "INSERT INTO clients (name, email, address1, phone, town, country, postcode) 
                VALUES ('$name', '$email', '$address1', '$phone', '$town', '$country', '$postcode')";
        if ($conn->query($sql) === TRUE) {
            echo "New client added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'edit' && !empty($client_id)) {
        $sql = "UPDATE clients SET name='$name', email='$email', address1='$address1', phone='$phone', town='$town', country='$country', postcode='$postcode' WHERE id='$client_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Client updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'delete' && !empty($client_id)) {
        $sql = "DELETE FROM clients WHERE id='$client_id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $conn->error]);
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Management</title>
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
                            <i class="fa-solid fa-mug-hot"></i>
                            <a href="invoice_creation.php">Invoice Creation</a>
                        </li>
                        <li class="navLink ">
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
                        <li class="navLink activeNavLink">
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

            <h2>Clients List</h2>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Town</th>
                        <th>Country</th>
                        <th>Post Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM clients";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['address1'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['town'] . "</td>";
                            echo "<td>" . $row['country'] . "</td>";
                            echo "<td>" . $row['postcode'] . "</td>";
                            echo '<td>
                                    <form style="display:inline;" action="all_client.php" method="post">
                                        <input type="hidden" name="client_id" value="' . $row['id'] . '">
                                        <input type="hidden" name="name" value="' . $row['name'] . '">
                                        <input type="hidden" name="address1" value="' . $row['address1'] . '">
                                        <input type="hidden" name="phone" value="' . $row['phone'] . '">
                                        <input type="hidden" name="email" value="' . $row['email'] . '">
                                        <input type="hidden" name="town" value="' . $row['town'] . '">
                                        <input type="hidden" name="country" value="' . $row['country'] . '">
                                        <input type="hidden" name="postcode" value="' . $row['postcode'] . '">
                                        <div class="gen">
                                            <button type="button" class="editBtn">Edit</button>
                                            <button type="button" class="deleteBtn" data-client-id="' . $row['id'] . '">Delete</button>
                                        </div>
                                    </form>
                                  </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No clients found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Edit Client Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Client</h2>
            <form id="editForm" action="all_client.php" method="post">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="client_id" id="editClientId">
                <input type="text" name="name" id="editName" placeholder="Client Name" required>
                <input type="text" name="address1" id="editAddress" placeholder="Address">
                <input type="text" name="phone" id="editContactDetails" placeholder="Contact Details" required>
                <input type="text" name="email" id="editEmail" placeholder="Email">
                <input type="text" name="town" id="editTown" placeholder="Town">
                <input type="text" name="country" id="editCountry" placeholder="Country">
                <input type="text" name="postcode" id="editPostCode" placeholder="Post Code">
                <button type="submit">Update Client</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Are you sure you want to delete this client?</h2>
            <form id="deleteForm" method="post">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="client_id" id="deleteClientId">
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


        // Open edit modal
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('editModal').style.display = "block";
                var form = this.closest('form');
                document.getElementById('editClientId').value = form.querySelector('input[name="client_id"]').value;
                document.getElementById('editName').value = form.querySelector('input[name="name"]').value;
                document.getElementById('editAddress').value = form.querySelector('input[name="address1"]').value;
                document.getElementById('editContactDetails').value = form.querySelector('input[name="phone"]').value;
                document.getElementById('editEmail').value = form.querySelector('input[name="email"]').value;
                document.getElementById('editTown').value = form.querySelector('input[name="town"]').value;
                document.getElementById('editCountry').value = form.querySelector('input[name="country"]').value;
                document.getElementById('editPostCode').value = form.querySelector('input[name="postcode"]').value;
            });
        });

        // Open delete modal
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('deleteModal').style.display = "block";
                document.getElementById('deleteClientId').value = this.getAttribute('data-client-id');
            });
        });

        // Close modals
        document.querySelectorAll('.close').forEach(span => {
            span.addEventListener('click', function() {
                this.closest('.modal').style.display = "none";
            });
        });

        // Cancel button in delete modal
        document.querySelector('.cancelBtn').addEventListener('click', function() {
            document.getElementById('deleteModal').style.display = "none";
        });
    </script>
</body>

</html>