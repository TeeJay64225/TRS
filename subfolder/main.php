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
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = 'user'; // Default role for new users

    // Check if the phone number already exists
    $check_sql = "SELECT * FROM users WHERE phone_number='$phone_number'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo " This phone number is already registered.";
    } else {
        $sql = "INSERT INTO users (phone_number, password, role) VALUES ('$phone_number', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo " New account created successfully";
            // Optionally, redirect to the login page
            // header("Location: login.php");
            // exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<?php
// Fetch the total number of invoices and completed invoices
$sql_invoices = "SELECT 
                    COUNT(*) as total_invoices,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_invoices
                 FROM invoices";
$result_invoices = $conn->query($sql_invoices);
$total_invoices = 0;
$completed_invoices = 0;

if ($result_invoices->num_rows > 0) {
    $row_invoices = $result_invoices->fetch_assoc();
    $total_invoices = $row_invoices['total_invoices'];
    $completed_invoices = $row_invoices['completed_invoices'];
}

// Calculate the invoice percentage
$invoice_percentage = 0;
if ($total_invoices > 0) {
    $invoice_percentage = ($completed_invoices / $total_invoices) * 100;
}
?>

<?php
// Fetch total number of clients
$sql = "SELECT COUNT(*) as total_clients FROM clients";
$result = $conn->query($sql);
$total_clients = ($result->num_rows > 0) ? $result->fetch_assoc()['total_clients'] : 0;

// Fetch all clients
$sql = "SELECT * FROM clients";
$result = $conn->query($sql);
$clients = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}

// Delete client
if (isset($_POST['delete_client_id'])) {
    $delete_client_id = $_POST['delete_client_id'];
    $delete_sql = "DELETE FROM clients WHERE id = $delete_client_id";
    $conn->query($delete_sql);
    header("Location: admin_dashboard.php");
    exit();
}

// Add client
if (isset($_POST['add_client'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $add_sql = "INSERT INTO clients (firstname, lastname, email, phone) VALUES ('$firstname', '$lastname', '$email', '$phone')";
    $conn->query($add_sql);
    header("Location: admin_dashboard.php");
    exit();
}



?>

