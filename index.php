<?php
session_start();

$mysqli = require __DIR__ . "/database.php"; // Replace with the correct path to your database connection file

// Check if the user_id session variable is set
if (isset($_SESSION["user_id"])) {
  // Fetch the user's role from the database based on user_id
  $user_id = $_SESSION["user_id"];
  $sql = "SELECT role FROM users WHERE ID = ?";

  // Prepare and execute the query
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i", $user_id); // Assuming "ID" is an integer

  if ($stmt->execute()) {
    // Bind the result
    $stmt->bind_result($userRole);

    // Fetch the role
    if ($stmt->fetch()) {
      // Display content based on the user's role
      if ($userRole === "elderly") {
        echo "Hello Elderly User!";
        // Display content specific to elderly users here
      } elseif ($userRole === "volunteer") {
        echo "Hello Volunteer User!";
        // Display content specific to volunteer users here
      }

      // Add a log-out button
      echo '<button class="navbtn"><a href="logout.php">Log-Out</a></button>';
    } else {
      echo "Error fetching user role.";
    }

    // Close the statement
    $stmt->close();
  } else {
    echo "Error executing the query.";
  }
} else {
  // If user_id is not set, redirect to the login page
  header("Location: login.php");
}
?>
