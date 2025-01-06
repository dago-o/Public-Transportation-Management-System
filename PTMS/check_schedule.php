<?php
session_start();
include 'connection.php'; // Include your database connection file

// Check if user is logged in as a passenger
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'passenger') {
//     die("You need to log in as a passenger to check schedules.");
// }

// Fetch schedules along with associated routes from the database
$sql_schedules = "SELECT s.schedule_id, r.origin, r.destination, s.bus_number, s.departure_time, s.arrival_time, s.available_seats
                  FROM Schedule s
                  JOIN Routes r ON s.route_id = r.route_id";
$result_schedules = $conn->query($sql_schedules);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Schedule</title>
    <link rel="stylesheet" href="pasenger.css">

</head>
<body>
    <h1>Available Schedules</h1>

    <?php if ($result_schedules->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Bus Number</th>
                    <th>Route</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Available Seats</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_schedules->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['bus_number']); ?></td>
                        <td><?= htmlspecialchars($row['origin'] . ' to ' . $row['destination']); ?></td>
                        <td><?= htmlspecialchars($row['departure_time']); ?></td>
                        <td><?= htmlspecialchars($row['arrival_time']); ?></td>
                        <td><?= htmlspecialchars($row['available_seats']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No schedules available at the moment.</p>
    <?php endif; ?>

    <br>
    <a href="book_ticket.php">Book a Ticket</a>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
