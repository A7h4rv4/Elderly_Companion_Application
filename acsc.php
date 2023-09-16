<?php
session_start();

$mysqli = require __DIR__ . "/database.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activityName = $_POST["activity-name"];
    $activityStartDateTime = $_POST["activity-start-date"];
    $activityEndDateTime = $_POST["activity-end-date"];
    $userId = $_SESSION["user_id"];

    // Insert the activity into the 'activities' table
    $insertQuery = "INSERT INTO activities (user_id, activity_name, start_datetime, end_datetime) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insertQuery);
    $stmt->bind_param("isss", $userId, $activityName, $activityStartDateTime, $activityEndDateTime);
    $stmt->execute();
    $stmt->close();
}

// Retrieve scheduled activities from the 'activities' table
$selectQuery = "SELECT ID, activity_name, start_datetime, end_datetime FROM activities WHERE user_id = ?";
$stmt = $mysqli->prepare($selectQuery);
$userId = $_SESSION["user_id"];
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$activities = [];
while ($row = $result->fetch_assoc()) {
    $activities[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... (Your HTML head content) ... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Scheduling</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/styleacsc.css">
</head>
<body>
    <!-- ... (Your HTML content) ... -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Activity Scheduling</h1>
        </div>
        
    <form id="activity-form" method="post">
        <div class="form-group">
            <label for="activity-name">Activity Name</label>
            <input type="text" class="form-control" id="activity-name" name="activity-name" placeholder="Enter activity name" required>
        </div>
        <div class="form-group">
            <label for="activity-start-date">Start Date and Time</label>
            <input type="datetime-local" class="form-control" id="activity-start-date" name="activity-start-date" required>
        </div>
        <div class="form-group">
            <label for="activity-end-date">End Date and Time</label>
            <input type="datetime-local" class="form-control" id="activity-end-date" name="activity-end-date" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Activity</button>
    </form>
    <hr>
    <!-- Display scheduled activities from the database -->
    <h2>Scheduled Activities</h2>
    <ul id="activity-list" class="list-group">
        <?php foreach ($activities as $activity): ?>
                                                <li class="list-group-item">
                                                    <?php echo $activity["activity_name"]; ?> (Start: <?php echo $activity["start_datetime"]; ?>, End: <?php echo $activity["end_datetime"]; ?>)
                                                </li>
        <?php endforeach; ?>
    </ul>
        </div>
    <!-- ... (Your JavaScript scripts) ... -->
    <script src="./script/script.js"></script>
</body>
</html>
