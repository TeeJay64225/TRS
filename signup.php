
<?php
include('newuser.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Create Account</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="wrapper">
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