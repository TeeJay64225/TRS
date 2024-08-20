<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_details = $_POST['contact_details'];

    $sql = "INSERT INTO clients (name, address, contact_details) VALUES ('$name', '$address', '$contact_details')";
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
    <title>Client Management</title>
    <link rel="stylesheet" href="styles.css">
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
    <div class="container">
        <h1>Client Management</h1>
        <form action="client-add.php" method="post">
            <input type="text" name="name" placeholder="Client Name" required>
            <input type="text" name="address" placeholder="Address">
            <input type="text" name="contact_details" placeholder="Contact Details" required>
            <button type="submit">Add Client</button>
        </form>
        <h2>Clients List</h2>
        <ul>
            <?php
            $sql = "SELECT * FROM clients";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . $row['name'] . " - " . $row['address'] . " - " . $row['contact_details'] . "</li>";
                }
            } else {
                echo "0 results";
            }
            ?>
        </ul>
    </div>
</body>

</html>