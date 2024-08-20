<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST['company_name'];
    $logo = null;

    // Check if a file was uploaded without errors
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
        // Check the file type to ensure it's an image
        $allowed_types = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
        $file_type = mime_content_type($_FILES['logo']['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            $logo = file_get_contents($_FILES['logo']['tmp_name']);
        } else {
            die("Unsupported file type. Please upload a PNG, JPEG, JPG, or GIF image.");
        }
    }

    // Insert company name and logo into the database
    $sql = "INSERT INTO companies (company_name, logo) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sb", $company_name, $logo);

    if ($stmt->execute()) {
        echo "New company created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Company</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Add Company</h1>
        <form action="insert_user.php" method="post" enctype="multipart/form-data">
            <input type="text" name="company_name" placeholder="Company Name" required>
            <input type="file" name="logo" accept="image/png, image/jpeg, image/jpg, image/gif" required>
            <button type="submit">Add Company</button>
        </form>

    </div>
</body>

</html>