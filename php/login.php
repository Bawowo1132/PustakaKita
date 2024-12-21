<?php
 include('../php/koneksi.php');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error variable
$error = null;

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
        $error = "Email tidak ditemukan. Silakan daftar terlebih dahulu.";
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
    <link rel="stylesheet" href="css/login.css" />
    <title>Login Pustaka Kita</title>
  </head>
  <style>
    :root {
  --primary-color: #b6895b;
  --background-color: #f0f0f0;
  --text-color: #333;
  --button-hover: #99680d;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--background-color);
}

.container {
  width: 400px;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  background-color: var(--primary-color);
}

.separator {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 20px 0;
}

.separator .line {
  flex: 1;
  height: 1px;
  background-color: #ccc;
}

.separator p {
  margin: 0 10px;
  font-size: 14px;
  color: white;
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

form input {
  padding: 10px 15px;
  border-radius: 5px;
  border: 1px solid #ddd;
  font-size: 14px;
}

form a {
  font-size: 14px;
  color: var(--text-color);
  text-decoration: none;
  align-self: flex-end;
}

form a:hover {
  text-decoration: underline;
}

form .btn {
  padding: 10px;
  border: none;
  border-radius: 5px;
  background-color: var(--primary-color);
  color: white;
  font-size: 16px;
  cursor: pointer;
}

form .btn:hover {
  background-color: var(--button-hover);
}

  </style>

  <body>
    <div class="container">
      <div class="login-section">
        <div style="text-align: center; margin: 20px 0;">
          <i class="bx bxs-user-circle" style="font-size: 80px; color: #99680d;"></i>
        </div>

        <div class="separator">
          <div class="line"></div>
          <p>Login with Email</p>
          <div class="line"></div>
        </div>

        <!-- Form Login -->
        <form action="" method="POST">
          <input type="email" name="email" placeholder="Email address" required />
          <input type="password" name="password" placeholder="Password" required />
          <a href="#">Forgot Password?</a>
          <button type="submit" class="btn">Login</button>
        </form>

        <!-- Display error message -->
        <?php if ($error): ?>
          <p style="color: red; text-align: center; margin-top: 10px;"><?php echo $error; ?></p>
        <?php endif; ?>
      </div>
    </div>

    <!--<script src="js/login.js"></script> -->
    <script>
      document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const emailInput = form.querySelector('input[name="email"]');
  const passwordInput = form.querySelector('input[name="password"]');

  form.addEventListener("submit", (event) => {
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    // Validasi sederhana
    if (!validateEmail(email)) {
      alert("Masukkan email yang valid.");
      event.preventDefault(); // Batalkan pengiriman form
      return;
    }

    if (password.length === 0) {
      alert("Masukkan password.");
      event.preventDefault();
    }
  });

  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
});

    </script>
  </body>
</html>
