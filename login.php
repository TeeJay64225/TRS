<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE phone_number='$phone_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] == 'admin') {
                header("Location: dashboard.php");
            } elseif ($row['role'] == 'user') {
                header("Location: user_landing_page.php");
            } else  { 
                header("Location: client_landing_page.php  ");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that phone number.";
    }
}
