<?php
include('../php/koneksi.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get email and password from the form
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prepare SQL query to check the user credentials
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email); // Bind the email parameter to the SQL query
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // User found, now check the password
    $user = $result->fetch_assoc();

    // Verify the password (use password_verify if passwords are hashed)
    if ($password === $user['password']) {
      // Set session variables and redirect
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['email'] = $user['email'];
      header("Location: ../php/admin.php");
      exit();
    } else {
      $error = "Password salah. Silakan coba lagi.";
    }
  } else {
    $error = "Email tidak ditemukan.";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/login2.css" />
  <title>Dashboard Pustaka Kita</title>
</head>
<style>

</style>

<body>
  <div class="container">
    <div class="login-section">
      <div style="text-align: center; margin: 20px 0;">
        <i class="bx bxs-user-circle" style="font-size: 80px; color: #99680d;"></i>
      </div>

      <div class="separator">
        <div class="line"></div>
        <p>Login Admin</p>
        <div class="line"></div>
      </div>

      <!-- Form Login -->
      <form action="" method="POST">
        <input type="email" name="email" placeholder="Email Address" required />
        <input type="password" name="password" placeholder="Password" required /> <br>
        <!-- <a href="">Forgot Password?</a> -->
        <button type="submit" class="btn">Login</button>
      </form>
    </div>
  </div>

  <!--<script src="js/login.js"></script> -->
  <script src="../js/login.js"></script>
</body>

</html>