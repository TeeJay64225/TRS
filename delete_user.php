<?php
session_start();

// Check if user_id is set and is a valid integer
if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
    $user_id = $_GET['user_id'];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "trs";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Set a success message
        $_SESSION['success_message'] = "User deleted successfully.";
    } else {
        // Set an error message
        $_SESSION['error_message'] = "Failed to delete user.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Invalid or missing user_id
    $_SESSION['error_message'] = "Invalid user ID.";
}

// Redirect back to the user list page with feedback
header("Location: /TRS copy 2/ad_user.php");
exit;
