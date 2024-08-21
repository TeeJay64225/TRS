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