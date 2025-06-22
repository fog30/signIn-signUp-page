<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match.";
    } else {
        $checkSql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $checkParams = array($username, $email);
        $checkStmt = sqlsrv_query($conn, $checkSql, $checkParams);

        if (sqlsrv_has_rows($checkStmt)) {
            $message = "Username or email already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertSql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $params = array($username, $email, $hashedPassword);
            $stmt = sqlsrv_query($conn, $insertSql, $params);

            if ($stmt) {
                header("Location: login.php?registered=true");
                exit();
            } else {
                $message = "Signup failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Point Break | Sign Up</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #001f3f 50%, #f5f5dc 50%);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .site-header {
      position: absolute;
      top: 20px;
      left: 30px;
      font-size: 28px;
      font-weight: bold;
      color: #f5f5dc;
    }

    .form-box {
      background: rgba(255, 255, 255, 0.95);
      padding: 35px 30px;
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
      width: 400px;
      max-width: 90%;
      text-align: center;
    }

    .form-box h2 {
      color: #333;
      margin-bottom: 20px;
    }

    label {
      display: block;
      text-align: left;
      font-weight: 500;
      color: #333;
      margin-top: 10px;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid #ccc;
      background-color: #f5f5dc;
      margin-bottom: 15px;
      font-size: 15px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #8c52ff;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #6b3ce0;
    }

    .switch {
      margin-top: 15px;
      font-size: 14px;
    }

    .switch a {
      color: #8c52ff;
      text-decoration: none;
      font-weight: 500;
    }

    .error {
      background-color: #fff0f0;
      color: #b30000;
      padding: 12px 15px;
      border-left: 5px solid #ff4d4d;
      font-size: 14px;
      border-radius: 6px;
      margin-bottom: 20px;
      text-align: left;
    }
  </style>
</head>
<body>
  <div class="site-header">Point Break</div>

  <div class="form-box">
    <h2>Create an Account</h2>
    <?php if (!empty($message)) echo "<div class='error'>$message</div>"; ?>

    <form method="POST" action="signup.php">
      <label>Username</label>
      <input type="text" name="username" required />

      <label>Email</label>
      <input type="email" name="email" required />

      <label>Password</label>
      <input type="password" name="password" required />

      <label>Confirm Password</label>
      <input type="password" name="confirm_password" required />

      <button type="submit">Sign Up</button>
      <p class="switch">Already a user? <a href="login.php">Login here</a></p>
    </form>
  </div>
</body>
</html>
