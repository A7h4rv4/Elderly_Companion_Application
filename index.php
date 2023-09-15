<?php
// Start the session before using session variables
session_start();
echo "User ID set in session: " . $_SESSION["user_id"];

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
  <?php if (isset($_SESSION["user_id"])): ?>
    hello!
    <button class="navbtn"><a href="logout.php">Log-Out</a></button></li>
<?php else:
    header("Location: login.php"); ?>
<?php endif; ?>
</body>

</html>