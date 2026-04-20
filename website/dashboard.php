<?php
session_start();

// If user is not logged in, send them back to login page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logged In</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: white;
    }

    .top-bar {
      padding: 20px;
    }

    .logout-btn {
      padding: 10px 16px;
      background: #1f3c88;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
    }

    .message {
      text-align: center;
      margin-top: 200px;
      font-size: 40px;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <a class="logout-btn" href="logout.php">Logout</a>
  </div>

  <div class="message">
    Logged In
  </div>

</body>
</html>