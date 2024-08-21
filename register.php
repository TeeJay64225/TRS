<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = 'user'; // Default role for new users

    // Check if the phone number already exists
    $check_sql = "SELECT * FROM users WHERE phone_number='$phone_number'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "This phone number is already registered.";
    } else {
        $sql = "INSERT INTO users (phone_number, password, role) VALUES ('$phone_number', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "New account created successfully";
            // Optionally, redirect to the login page
            // header("Location: login.php");
            // exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Create Account</h1>
        <form action="register.php" method="post">
            <input type="text" name="phone_number" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Create Account</button>
        </form>
    </div>
</body>

</html>