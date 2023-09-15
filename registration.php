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

$sql = "INSERT INTO users (username, email, age, role, password) VALUES (?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
  die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sssss", $_POST["username"], $_POST["email"], $_POST["age"], $_POST["role"], $_POST["password"]);

if ($stmt->execute()) {
  // Get the ID of the newly inserted user
  $userID = $mysqli->insert_id;

  if ($_POST["role"] === "elderly") {
    // Insert into the 'epro' table for elderly users
    $insertElderlyQuery = "INSERT INTO epro (ID, username, age, preferences, health) VALUES (?, ?, ?, '', '')";
    $stmt = $mysqli->prepare($insertElderlyQuery);
    $stmt->bind_param("iss", $userID, $_POST["username"], $_POST["age"]);
    $stmt->execute();
  } elseif ($_POST["role"] === "volunteer") {
    // Insert into the 'vpro' table for volunteer users
    $insertVolunteerQuery = "INSERT INTO vpro (ID, username, interest, skills, availability) VALUES (?, ?, '', '', '')";
    $stmt = $mysqli->prepare($insertVolunteerQuery);
    $stmt->bind_param("is", $userID, $_POST["username"]);
    $stmt->execute();
  }

  header("Location: login.php");
  exit;
} else {
  die($mysqli->error . " " . $mysqli->errno);
}
?>