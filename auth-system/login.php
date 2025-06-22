<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = trim($_POST["identifier"]);
    $password = $_POST["password"];

    if (empty($identifier) || empty($password)) {
        $message = "All fields are required.";
    } else {
        $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";
        $params = array($identifier, $identifier);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["userid"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                header("Location: welcome.php");
                exit();
            } else {
                $message = "Incorrect password.";
            }
        } else {
            $message = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Point Break | Login</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f5f5dc 50%, #001f3f 50%);
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
      color: #001f3f; /* changed to dark blue */
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

    .success {
      background-color: #f0fff5;
      color: #2b8a3e;
      padding: 12px 15px;
      border-left: 5px solid #4ddf75;
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
    <h2>Welcome Back</h2>

    <?php if (!empty($message)) echo "<div class='error'>$message</div>"; ?>
    <?php if (isset($_GET['registered'])) echo "<div class='success'>Signup successful! Please login.</div>"; ?>

    <form method="POST" action="login.php">
      <label>Username or Email</label>
      <input type="text" name="identifier" required>

      <label>Password</label>
      <input type="password" name="password" required>

      <button type="submit">Login</button>
      <p class="switch">New here? <a href="signup.php">Create an account</a></p>
    </form>
  </div>

</body>
</html>
