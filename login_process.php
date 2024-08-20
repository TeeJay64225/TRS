<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['phone_number']) && isset($_POST['password'])) {
        $phone_number = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM users WHERE phone_number='$phone_number'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['$phone_number'] = $row['$phone_number'];
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that email.";
        }
    } else {
        echo "Please enter both email and password.";
    }
} else {
    echo "Invalid request method.";
}
?>
