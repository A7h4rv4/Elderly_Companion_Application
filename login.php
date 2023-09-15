<?php
session_start(); // Start the session at the very beginning

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  include "database.php";

  $query = "SELECT * FROM users WHERE username = ? AND password = ?";

  $stmt = $mysqli->prepare($query);
  $stmt->bind_param("ss", $username, $password);
  if ($stmt->execute()) {
    $result = $stmt->get_result();

    // Check if a row was returned
    if ($result->num_rows === 1) {
      // User is authenticated
      $_SESSION["username"] = $username;

      // Redirect to a dashboard or another page
      header("Location: index.php");
      exit();
    } else {
      // Invalid username or password
      $error = "Invalid username or password. Please try again.";
    }

    // Close the statement
    $stmt->close();
  } else {
    // Query preparation failed
    $error = "Database error. Please try again later.";
  }

  // Close the database connection
  $mysqli->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./style/style.css">
</head>

<body>
  <div class="container">
    <div class="box form-box">
      <header>LOGIN</header>
      <form method="post">
        <div class="field input">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" autocomplete="off" required>
        </div>
        <div class="field input">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" autocomplete="off" required>
        </div>
        <div class="field">
          <input type="submit" class="btn" name="submit" value="Login">
        </div>
        <div class="link">
          Don't have an Account? <a href="./register.html">Sign-Up</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>