<?php

if (empty($_POST["username"])) {
  die("Name is Required.");
}

if (strlen($_POST["password"]) < 8) {
  die("Password should be at least 8 characters.");
}

if (!is_numeric($_POST["age"])) {
  die("Age should only be numerical.");
}

$mysqli = require __DIR__ . "/database.php";

// Check if the email already exists in the database
$email = $_POST["email"];
$checkEmailQuery = "SELECT email FROM users WHERE email = ?";

if ($stmt = $mysqli->prepare($checkEmailQuery)) {
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    die("Email already exists. Please choose a different one.");
  }

  $stmt->close();
}

// Generate a 10-digit numeric ID
$numericID = mt_rand(1000000000, 9999999999);

$sql = "INSERT INTO users (id, username, email, age, role, password) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
  die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("isssss", $numericID, $_POST["username"], $_POST["email"], $_POST["age"], $_POST["role"], $_POST["password"]);

if ($stmt->execute()) {
  header("Location: login.php");
  exit;
} else {
  die($mysqli->error . " " . $mysqli->errno);
}
?>
