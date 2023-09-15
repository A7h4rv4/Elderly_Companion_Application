<?php

if (empty($_POST["username"])) {
  die("Name is Required.");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
  die("Enter valid E-mail");
}

if (preg_match("/[a-z]/i", $_POST["age"])) {
  die("Age can only be numbers.");
}

if (strlen($_POST["password"] < 8)) {
  die("Password should be atleast 8 characters.");
}

$mysqli = require __DIR__ . "/database.php";

$sql = "insert into users (username, email, age, password) values(?, ?, ?, ?);";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
  die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssss", $_POST["username"], $_POST["email"], $_POST["age"], $_POST["password"]);

if ($stmt->execute()) {
  header("Location: login.php");
  exit;
} else {
  die($mysqli->error . " " . $mysqli->errno);
}

?>