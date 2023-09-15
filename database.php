<?php

$host = "localhost";
$dbname = "hackathon";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
  die("Connection Error: " . $mysqli->connect_error);
}

return $mysqli;

?>