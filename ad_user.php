<?php include('subfolder/main.php'); ?>
<?php
include('db.php');

// Fetch the visit data
$sql = "SELECT 
            u.phone_number,
            COUNT(ua.id) AS visit_count,
            ua.login_time AS visit_time,
            DATE_FORMAT(ua.login_time, '%W') AS visit_day,
            DATE_FORMAT(ua.login_time, '%Y-%m-%d') AS visit_date
        FROM 
            users u
        JOIN 
            user_activity ua ON u.user_id = ua.user_id
        GROUP BY 
            u.user_id, ua.login_time
        ORDER BY 
            ua.login_time DESC";

$result = $conn->query($sql);


?>





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
                        <li class="navLink" id="clientManagementNav">
                            <i class="fa-solid fa-dollar-sign icon"></i>
                            <a href="ad_client.php">Client Management</a>
                        </li>
                        <li class="navLink activeNavLink" id="invoiceCreationNav">
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
                <br>
                <br>




                <!-- User-->
                <div class="analyticsCard">
                    <h3 class="cardHeader cardHeader1">Users</h3>
                    <div class="transactionContainer">
                        <?php foreach ($users as $user) : ?>
                            <div class="eachTransaction">
                                <div class="tansactionDesc">
                                    <div class="paymentStatus">
                                        <h3>Name: <?php echo $user['user_ID']; ?></h3>
                                        <h3>Name: <?php echo $user['phone_number']; ?></h3>
                                        <h3>Role: <?php echo $user['role']; ?></h3>
                                    </div>
                                </div>
                                <div class="transactionPrice">
                                    <form method="post" style="display:inline-block;">
                                        <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn delete-btn">Delete</button>
                                    </form>
                                    <button class="btn view-record-btn" data-user-id="<?php echo $user['id']; ?>">View Records</button>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button id="addUserBtn" class="btn add-btn">Add User</button>
                </div>
                <br>
                <br>
                <br>
                <!-- User Modal -->
                <div id="addUserModal" class="modal">
                    <?php
                    include('db.php');

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        try {
                            // Sanitize and validate user input
                            $phone_number = $_POST['phone_number'];
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
                            $role = $_POST['role']; // Get the role from the form

                            // Check if the phone number already exists
                            $check_sql = "SELECT * FROM users WHERE phone_number = :phone_number";
                            $stmt = $pdo->prepare($check_sql);
                            $stmt->execute([':phone_number' => $phone_number]);

                            if ($stmt->rowCount() > 0) {
                                echo "This phone number is already registered.";
                            } else {
                                // Insert the new user into the database
                                $sql = "INSERT INTO users (phone_number, password, role) VALUES (:phone_number, :password, :role)";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([
                                    ':phone_number' => $phone_number,
                                    ':password' => $password,
                                    ':role' => $role
                                ]);

                                if ($stmt) {
                                    echo "New account created successfully";
                                    // Optionally, redirect to the login page
                                    // header("Location: login.php");
                                    // exit();
                                } else {
                                    echo "Error: Could not execute the query.";
                                }
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    }
                    ?>
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="cardHeader cardHeader1"><b>Add User</b></h1>

                        <form action="" method="post">
                            <div class="input-box">
                                <input type="text" name="role" placeholder="Role" required>
                            </div>
                            <div class="input-box">
                                <input type="text" name="phone_number" placeholder="Phone Number" required>
                            </div>
                            <div class="input-box">
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn add-btn">Add User</button>
                        </form>
                    </div>
                </div>


                <!-- User Records Modal -->
                <div id="viewUserModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="cardHeader cardHeader1"><b>User Login Records</b></h1>
                        <br>
                        <div id="userRecordContent">
                            <!-- User login records will be loaded here -->
                        </div>
                        <br>
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

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.view-record-btn').forEach(button => {
                button.addEventListener('click', function() {
                    var userId = this.getAttribute('data-user-id');

                    // Make AJAX request to fetch user activity
                    fetch('fetch_user_activity.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'user_id=' + userId
                        })
                        .then(response => response.text())
                        .then(data => {
                            // Insert data into the modal content
                            document.getElementById('modalContent').innerHTML = data;

                            // Display the modal
                            document.getElementById('userActivityModal').style.display = 'block';
                        });
                });
            });
        });




        //for the time update
        function updateDateTime() {
            const now = new Date();

            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };

            return now.toLocaleDateString('en-US', options);
        }

        // Record login (this should be called when a user logs in)
        function recordLogin(userId) {
            const loginDateTime = updateDateTime();
            // Assuming an AJAX call to save the login record in the database
            console.log(`User ${userId} logged in at ${loginDateTime}`);
        }

        // JavaScript to handle modals
        var userModal = document.getElementById("addUserModal");
        var userBtn = document.getElementById("addUserBtn");
        var viewUserModal = document.getElementById("viewUserModal");
        var span = document.getElementsByClassName("close");

        userBtn.onclick = function() {
            userModal.style.display = "block";
        }

        // Open user records modal
        const viewRecordBtns = document.querySelectorAll('.view-record-btn');
        viewRecordBtns.forEach(btn => {
            btn.onclick = function() {
                const userId = this.getAttribute('data-user-id');
                // Fetch and display user records here
                fetchUserRecords(userId);
                viewUserModal.style.display = "block";
            }
        });

        span[0].onclick = function() {
            userModal.style.display = "none";
        }

        span[1].onclick = function() {
            viewUserModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == userModal) {
                userModal.style.display = "none";
            } else if (event.target == viewUserModal) {
                viewUserModal.style.display = "none";
            }
        }

        function fetchUserRecords(userId) {
            // Implement an AJAX call to fetch user records
            // For demonstration, we will use static data
            const userRecords = [{
                date: '2024-08-01',
                time: '10:00 AM',
                month: 'August'
            }];

            const userRecordContent = document.getElementById('userRecordContent');
            userRecordContent.innerHTML = '';

            userRecords.forEach(record => {
                const recordDiv = document.createElement('div');
                recordDiv.classList.add('record');
                recordDiv.innerHTML = `
      <h2>User Visits</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Phone Number</th>
                <th>Visit Count</th>
                <th>Visit Time</th>
                <th>Visit Day</th>
                <th>Visit Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['phone_number']}</td>
                            <td>{$row['visit_count']}</td>
                            <td>{$row['visit_time']}</td>
                            <td>{$row['visit_day']}</td>
                            <td>{$row['visit_date']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No visits found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    `;
                userRecordContent.appendChild(recordDiv);
            });
        }
    </script>
</body>

</html>