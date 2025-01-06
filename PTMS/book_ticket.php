<?php
session_start();
include 'connection.php'; // Include your database connection file

// Check if user is logged in as a passenger
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'passenger') {
    echo "<script>
            alert('You need to log in as passengers.');
            window.location.href = 'login.php'; // Redirect to the login page
          </script>";
    exit; // Stop further execution
}

// Fetch routes from the database
$sql_routes = "SELECT * FROM Routes";
$result_routes = $conn->query($sql_routes);
if (!$result_routes) {
    die("Error fetching routes: " . $conn->error);
}

// Fetch schedules from the database
$sql_schedules = "SELECT * FROM Schedule";
$result_schedules = $conn->query($sql_schedules);
if (!$result_schedules) {
    die("Error fetching schedules: " . $conn->error);
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ticket</title>
    <link rel="stylesheet" href="pasenger.css">
</head>
<body>
    <h1>Book a Ticket</h1>
    <form method="POST" action="process_booking.php">
        <label for="route_id">Select Route:</label>
        <select name="route_id" id="route_id" required>
            <option value="">--Select Route--</option>
            <?php while ($row = $result_routes->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['route_id']); ?>">
                    <?= htmlspecialchars($row['origin'] . ' to ' . $row['destination']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <br><br>

        <label for="schedule_id">Select Schedule:</label>
        <select name="schedule_id" id="schedule_id" required>
            <option value="">--Select Schedule--</option>
            <?php while ($row = $result_schedules->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['schedule_id']); ?>">
                    <?= htmlspecialchars($row['bus_number'] . ' - Departure: ' . $row['departure_time']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <br><br>

        <label for="seat_number">Enter Seat Number:</label>
        <input type="number" name="seat_number" placeholder="Enter seat number" id="seat_number" required>

        <br><br>

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <button type="submit">Book Ticket</button><br>
    </form>
</body>
</html>
