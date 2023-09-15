<?php
// Start the session before using session variables
session_start();

$mysqli = require __DIR__ . "/database.php";
if ($mysqli) {
  $username = 'helo';

  $stmt = $mysqli->prepare("SELECT ID FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->bind_result($user_id);

  if ($stmt->fetch()) {
    $_SESSION["user_id"] = $user_id;
    echo "User ID set in session: " . $_SESSION["user_id"];
  } else {
    echo "User not found";
  }

  $stmt->close();
  $mysqli->close();
} else {
  echo "Database connection error";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="./style/style.css">
</head>

<body>
hello
</body>

</html>