<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Create Account</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="wrapper">
    <?php
    include('db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $firstname = $conn->real_escape_string($_POST['firstname']);
      $lastname = $conn->real_escape_string($_POST['lastname']);
      $role = $conn->real_escape_string($_POST['role']);
      $email = $conn->real_escape_string($_POST['email']);
      $phone_number = $conn->real_escape_string($_POST['phone_number']);
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

      // Check if the phone number or email already exists
      $check_sql = "SELECT * FROM users WHERE phone_number='$phone_number' OR email='$email'";
      $result = $conn->query($check_sql);

      if ($result->num_rows > 0) {
        echo "This phone number or email is already registered.";
      } else {
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, role, email, phone_number, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstname, $lastname, $role, $email, $phone_number, $password);

        if ($stmt->execute()) {
          echo "New account created successfully";
          // Optionally, redirect to the login page
          // header("Location: login.php");
          // exit();
        } else {
          echo "Error: " . $stmt->error;
        }

        $stmt->close();
      }

      $conn->close();
    }
    ?>

    <h1>Create Account</h1>
    <form action="signup.php" method="post">
      <div class="input-box">
        <input type="text" name="firstname" placeholder="First Name" required>
      </div>
      <div class="input-box">
        <input type="text" name="lastname" placeholder="Last Name" required>
      </div>
      <div class="input-box">
        <input type="text" name="role" placeholder="Role" required>
      </div>
      <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="input-box">
        <input type="text" name="phone_number" placeholder="Phone Number" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit" class="btn">Signup</button>
      <div class="login-link">
        <p>Already have an account? <a href="login.html">Login</a></p>
      </div>
    </form>
  </div>
</body>

</html>