<?php
session_start();

$mysqli = require __DIR__ . "/database.php"; // Replace with the correct path to your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the elder's information from the form
  $elder_name = $_POST["elder_name"];
  $elder_age = $_POST["elder_age"];
  $preferences = $_POST["preferences"];
  $elder_health = $_POST["elder_health"];

  // You need to fetch the current user's ID from the session or other means
  // For this example, let's assume the ID is stored in $_SESSION['user_id']
  $user_id = $_SESSION['user_id'];

  // Update the elder's details in the "epro" table
  $sql = "UPDATE epro SET username=?, age=?, preferences=?, health=? WHERE ID=?";
  $stmt = $mysqli->prepare($sql);

  // Bind parameters and execute the statement
  $stmt->bind_param("ssssi", $elder_name, $elder_age, $preferences, $elder_health, $user_id);

  if ($stmt->execute()) {
    echo "Elder's details updated successfully.";
  } else {
    echo "Error updating elder's details: " . $stmt->error;
  }

  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgelessAlliance - Elderly</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/stylep.css">
</head>

<body>
    <!-- ... (your existing navbar and content) ... -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./images/360_F_300533572_GEpPSVG2m4r5pqsk0HMmtuMgSXs58SWF.jpg" alt="Company Logo">
                <span class="company-name">AgelessAlliance</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Elder User Details Form -->
    <div class="container">
        <h2>Edit Elder User Details</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="elder_name">Name:</label>
                <input type="text" class="form-control" id="elder_name" name="elder_name" placeholder="Elder's Name">
            </div>
            <div class="form-group">
                <label for="elder_age">Age:</label>
                <input type="number" class="form-control" id="elder_age" name="elder_age" placeholder="Elder's Age">
            </div>
            <div class="form-group">
                <label for="elder_address">Preferences</label>
                <input type="text" class="form-control" id="preferences" name="preferences"
                    placeholder="Elder's Preferences">
            </div>
            <div class="form-group">
                <label for="elder_health">Health Condition:</label>
                <textarea class="form-control" id="elder_health" name="elder_health" rows="4"
                    placeholder="Elder's Health Condition"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Details</button>
        </form>
    </div>


    <!-- ... (your existing scripts) ... -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>