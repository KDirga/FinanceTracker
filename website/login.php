<?php
session_start();

// Database connection settings
$host = "localhost";
$dbname = "keannadi_finance_tracker";
$dbuser = "root";
$dbpass = "";

// Create connection
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Make sure form was submitted correctly
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.html");
    exit();
}

// Get form values
$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");

// Basic validation
if ($email === "" || $password === "") {
    die("Please enter both email and password.");
}

// Check login against Account_Holder
$sql = "SELECT User_ID, First_Name, Last_Name, Email
        FROM Account_Holder
        WHERE Email = ? AND Password = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

// Successful login
if ($row = $result->fetch_assoc()) {
    $_SESSION["user_id"] = $row["User_ID"];
    $_SESSION["first_name"] = $row["First_Name"];
    $_SESSION["last_name"] = $row["Last_Name"];
    $_SESSION["email"] = $row["Email"];

    header("Location: dashboard.php");
    exit();
} else {
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <title>Login Failed</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          background: #f4f7fb;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
        }
        .box {
          background: white;
          padding: 30px;
          border-radius: 12px;
          box-shadow: 0 4px 14px rgba(0,0,0,0.12);
          text-align: center;
          width: 340px;
        }
        a {
          display: inline-block;
          margin-top: 15px;
          text-decoration: none;
          color: #1f3c88;
          font-weight: bold;
        }
      </style>
    </head>
    <body>
      <div class='box'>
        <h2>Login Failed</h2>
        <p>Invalid email or password.</p>
        <a href='login.html'>Try Again</a>
      </div>
    </body>
    </html>";
}

$stmt->close();
$conn->close();
?>