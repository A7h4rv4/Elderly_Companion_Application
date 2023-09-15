<?php
session_start();

$mysqli = require __DIR__ . "/database.php"; // Replace with the correct path to your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the elder's information from the form
  $name = $_POST["name"];
  $interest = $_POST["interest"];
  $skills = $_POST["skills"];
  $availability = $_POST["availability"];

  // You need to fetch the current user's ID from the session or other means
  // For this example, let's assume the ID is stored in $_SESSION['user_id']
  $user_id = $_SESSION['user_id'];

  // Update the elder's details in the "epro" table
  $sql = "UPDATE vpro SET username=?, interest=?, skills=?, availability=? WHERE ID=?";
  $stmt = $mysqli->prepare($sql);

  // Bind parameters and execute the statement
  $stmt->bind_param("ssssi", $name, $interest, $skills, $availability, $user_id);

  if ($stmt->execute()) {
    echo "Volunteer's details updated successfully.";
  } else {
    echo "Error updating volunteer's details: " . $stmt->error;
  }

  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgelessAlliance - Volunteer</title>
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
    <!-- Volunteer Details Form -->
    <div class="container">
        <h2>Edit Volunteer Details</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name">
            </div>
            <div class="form-group">
                <label for="interest">Interest:</label>
                <input type="text" class="form-control" id="interest" name="interest" placeholder="Your Interest">
            </div>
            <div class="form-group">
                <label for="skills">Skills</label>
                <input type="text" class="form-control" id="skills" name="skills" placeholder="Your Skills">
            </div>
            <div class="form-group">
                <label for="availability">Availability:</label>
                <textarea class="form-control" id="availability" name="availability" rows="4" placeholder="Describe your availability"></textarea>
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
