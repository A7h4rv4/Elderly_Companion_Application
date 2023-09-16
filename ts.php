<?php
session_start();

$mysqli = require __DIR__ . "/database.php"; // Replace with the correct path to your database connection file

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["date"], $_POST["time"], $_POST["description"])) {
    // Get the user ID (You should implement a proper way to fetch the user ID)
    $userId = $_SESSION['user_id']; // Change this to your actual user ID retrieval logic

    // Sanitize user input
    $date = $_POST["date"];
    $time = $_POST["time"];
    $description = $_POST["description"];

    // Combine date and time into a DateTime object
    $dateTimeStr = $date . ' ' . $time;
    $dateTime = new DateTime($dateTimeStr);

    // Format the DateTime object into a format suitable for MySQL datetime
    $formattedDateTime = $dateTime->format('Y-m-d H:i:s');

    // Prepare and execute the SQL statement to insert the data into the database
    $stmt = $mysqli->prepare("INSERT INTO slot (ID, description, time) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $description, $formattedDateTime);

    if ($stmt->execute()) {
        // Slot added successfully
        $successMessage = "Slot added successfully!";
    } else {
        // Error occurred while adding the slot
        $errorMessage = "Error: " . $stmt->error;
    }

    $stmt->close();

    function getExistingSlots($mysqli, $userId)
    {
        $slots = [];
        $query = "SELECT * FROM slot WHERE ID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $slots[] = $row;
        }
        $stmt->close();
        return $slots;
    }

    // Get the user ID (You should implement a proper way to fetch the user ID)
    $userId = $_SESSION['user_id']; // Change this to your actual user ID retrieval logic

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["date"], $_POST["time"], $_POST["description"])) {
        // ... Your existing code for adding a new slot ...

        // After adding a new slot, retrieve the updated list of slots
        $userSlots = getExistingSlots($mysqli, $userId);
    } else {
        // If not a POST request, retrieve the existing slots when the page is initially loaded
        $userSlots = getExistingSlots($mysqli, $userId);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Timeslot - AgelessAlliance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="./style/stylets.css">
</head>

<body>
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
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-content">
            <h1>Select Timeslot</h1>
            <p>Choose a date and time slot for volunteering.</p>
        </div>
    </div>

    <div class="container">
        <div class="calendar-container">
            <div class="calendar-header">
                <button id="prevMonthBtn">Previous Month</button>
                <h2 id="calendarMonthYear"></h2>
                <button id="nextMonthBtn">Next Month</button>
            </div>
            <div class="calendar" id="calendarGrid">
            </div>
        </div>
    </div>
    <div class="container">
        <form method="post" action="">
            <label for="timePicker">Select Time:</label>
            <input type="text" id="timePicker" class="form-control" name="time" required>
            <label for="description">Description:</label>
            <textarea id="description" class="form-control" name="description" required></textarea>
            <input type="hidden" id="selectedDate" name="date">
            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Add Slot</button>
        </form>
        <?php
        if (isset($errorMessage)) {
            echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
        }
        ?>
    </div>
    <div class="container">
        <h2>Added Slots</h2>
        <ul>
            <?php foreach ($userSlots as $slot) { ?>
                        <li>Time: <?php echo date("H:i", strtotime($slot["time"])); ?>, Description: <?php echo htmlspecialchars($slot["description"]); ?></li>
            <?php } ?>
        </ul>
    </div>

    <script>
        // Define the months and weekdays
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        // Get current date
        const currentDate = new Date();

        // Function to generate the calendar grid
        function generateCalendar(year, month) {
            const calendarGrid = document.getElementById('calendarGrid');
            calendarGrid.innerHTML = '';
            const firstDayOfMonth = new Date(year, month, 1);
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Add headers for weekdays
            weekdays.forEach(weekday => {
                const dayElement = document.createElement('div');
                dayElement.classList.add('calendar-day');
                dayElement.textContent = weekday;
                calendarGrid.appendChild(dayElement);
            });

            // Add empty cells before the first day of the month
            for (let i = 0; i < firstDayOfMonth.getDay(); i++) {
                const emptyCell = document.createElement('div');
                calendarGrid.appendChild(emptyCell);
            }

            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.classList.add('calendar-day');
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);

                // Add click event listener to select/deselect the day
                dayElement.addEventListener('click', () => {
                    dayElement.classList.toggle('selected');
                });
            }

            // Update the calendar month and year header
            const calendarMonthYear = document.getElementById('calendarMonthYear');
            calendarMonthYear.textContent = `${months[month]} ${year}`;
        }

        // Initialize the flatpickr time picker
        const timePicker = flatpickr("#timePicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });

        // Initial calendar generation
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());

        // Event listeners for navigating between months
        document.getElementById('prevMonthBtn').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        });

        document.getElementById('nextMonthBtn').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        });
        dayElement.addEventListener('click', () => {
            dayElement.classList.toggle('selected');
            if (dayElement.classList.contains('selected')) {
                document.getElementById('selectedDate').value = `${currentDate.getFullYear()}-${currentDate.getMonth() + 1}-${day}`;
            } else {
                document.getElementById('selectedDate').value = '';
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>