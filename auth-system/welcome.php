<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome | Point Break</title>
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
      color: #8c52ff;
      z-index: 10;
    }

    .content-box {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      width: 380px;
      z-index: 2;
    }

    .content-box h2 {
      margin-bottom: 10px;
      color: #333;
    }

    .content-box p {
      margin-bottom: 20px;
    }

    .logout-btn {
      display: inline-block;
      padding: 12px 24px;
      background-color: #8c52ff;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .logout-btn:hover {
      background-color: #6a3dcc;
    }

    @media screen and (max-width: 480px) {
      .content-box {
        width: 90%;
      }
    }
  </style>
</head>
<body>

  <div class="site-header">Point Break</div>

  <div class="content-box">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!</h2>
    <p>You’ve successfully logged in.</p>
    <a class="logout-btn" href="logout.php">Logout</a>
  </div>

</body>
</html>
