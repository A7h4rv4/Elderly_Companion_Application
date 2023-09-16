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
        if ($stmt->fetch()) { ?>
                                             <?php if ($userRole === "elderly") { ?>
                                                            <!DOCTYPE html>
                                                            <html lang="en">
                                                                <head>
                                                                    <meta charset="UTF-8">
                                                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                                                    <title>AgelessAlliance -Elderly</title>
                                                                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                                                                    <link rel="stylesheet" href="./style/stylee.css">
                                                                </head>
                                                                <body>
                                                                    <nav class="navbar navbar-expand-lg navbar-light">
                                                                        <div class="container">
                                                                            <a class="navbar-brand" href="index.php">
                                                                                <img src="./images/360_F_300533572_GEpPSVG2m4r5pqsk0HMmtuMgSXs58SWF.jpg" alt="Company Logo">
                                                                                <span class="company-name">AgelessAlliance</span>
                                                                            </a>
                                                                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                                                                                        <li class="nav-item">
                                                                                            <a class="nav-link" href="logout.php">Log-Out</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </nav>
                                                                        <div class="container">
                                                                             <div class="home-buttons">
                                                                                <div class="btn-card">
                                                                                     <img src="./images/viewclix-video-for-seniors.jpeg" alt="Video Call Image" style="height: 180px">
                                                                                     <h3 class="btn-title">Video Call</h3>
                                                                                     <p class="btn-description">Connect with your volunteer through video calls.</p>
                                                                                     <a href="https://dazzling-starburst-02f9eb.netlify.app/lobby.html" class="btn btn-primary">Start Video Call</a>
                                                                                    </div>
                                                                                    <div class="btn-card">
                                                                                         <img src="./images/935178da2cb63f4378c0f07b4d48ba18.jpg" alt="Activity Scheduling Image" style="height: 180px">
                                                                                         <h3 class="btn-title">Activity Scheduling</h3>
                                                                                         <p class="btn-description">Plan and schedule activities to stay engaged.</p>
                                                                                         <a href="acsc.php " class="btn btn-primary">Schedule Activities</a>
                                                                                        </div>
                                                                                        <div class="btn-card">
                                                                                            <img src="./images/permissions_Intro-500x260-03.png" alt="Profile Management Image" style="height: 180px">
                                                                                            <h3 class="btn-title">Profile Management</h3>
                                                                                            <p class="btn-description">Manage your profile and preferences.</p>
                                                                                            <a href="edetails.php" class="btn btn-primary">Manage Profile</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                                                                                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
                                                                                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                                                                                <script src="./script/script.js"></script>
                                                                                </html>
                                                                                <?php
                                             } elseif ($userRole === "volunteer") { ?>
                                                                                <!DOCTYPE html>
                                                                                <html lang="en">

                                                                                <head>
                                                                                     <meta charset="UTF-8">
                                                                                     <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                                                                     <title>AgelessAlliance - Volunteer</title>
                                                                                     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                                                                                     <link rel="stylesheet" href="./style/stylev.css">
                                                                                    </head>

                                                                                    <body>
                                                                                        <nav class="navbar navbar-expand-lg navbar-light">
                                                                                             <div class="container">
                                                                                                <a class="navbar-brand" href="index.php">
                                                                                                    <img src="./images/360_F_300533572_GEpPSVG2m4r5pqsk0HMmtuMgSXs58SWF.jpg" alt="Company Logo">
                                                                                                    <span class="company-name">AgelessAlliance</span>
                                                                                                </a>
                                                                                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                                                                                                        <li class="nav-item">
                                                                                                            <a class="nav-link" href="logout.php">Log-Out</a>
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </nav>
                                                                                        <div class="container">
                                                                                            <div class="home-buttons">
                                                                                                <h1>Welcome Volunteers</h1>
                                                                                                <p>This is the volunteer section of AgelessAlliance. Here you can find information and resources for volunteering.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="container">
                                                                                             <div class="btn-separator"></div>
                                                                                            </div>
                                                                                            <div class="container">
                                                                                                <div class="home-buttons">
                                                                                                    <div class="btn-card">
                                                                                                         <img src="./images/istockphoto-638461504-612x612.jpg" alt="Timeslot Image">
                                                                                                         <div class="btn-container">
                                                                                                            <h3 class="btn-title">Timeslot</h3>
                                                                                                            <p class="btn-description">Choose a time that suits your convenience.</p>
                                                                                                            <a href="ts.php" class="btn btn-primary">Select Timeslot</a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="btn-card">
                                                                                                         <img src="./images/hio.jpeg" alt="Profile Image" width="500px" ;height="900px" ;>
                                                                                                         <div class="btn-container">
                                                                                                            <h3 class="btn-title">Manage Profile</h3>
                                                                                                            <p class="btn-description">Manage your profile and preferences.</p>
                                                                                                            <a href="vdetails.php" class="btn btn-primary">Manage Profile</a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                                                                                            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
                                                                                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                                                                                        </body>
                                                                                        </html>
                                                                            <?php }
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
