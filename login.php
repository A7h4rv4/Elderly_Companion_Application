<?php
// Start the session before using session variables
session_start();

$mysqli = require __DIR__ . "/database.php";

if ($mysqli) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $mysqli->prepare("SELECT ID, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);

    if ($stmt->fetch() && $password === $hashed_password) {
      $_SESSION["user_id"] = $user_id;
      header("Location: index.php");
      exit;
    } else {
      $login_error = "Invalid username or password.";
    }

    $stmt->close();
  }
  $mysqli->close();
} else {
  echo "Database connection error";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./style/style.css">
</head>
<body>
<div class="container">
    <div class="box form-box">
    <header>Login</header>
    <?php if (isset($login_error)) { ?>
      <p><?php echo $login_error; ?></p>
    <?php } ?>
    <form method="POST" action="">
    <div class="field input">
          <label for="username">Username</label>
          <input type="text" name="username" class="ip" id="username" autocomplete="off" required>
        </div>
        <div class="field input">
          <label for="password">Password</label>
          <input type="password" name="password" class="ip" id="password" autocomplete="off" required>
        </div><br>
        <div class="field">
          <input type="submit" class="btn" name="submit" value="Login">
        </div>
        <div class="link">
          Not registered yet? <a href="./register.html">Register Here</a>
        </div>
    </form>
    </div></div>
</body>
</html>
