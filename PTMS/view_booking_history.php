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

// Fetch booking history for the logged-in user
$user_id = $_SESSION['user_id'];
$sql_history = "SELECT b.booking_id, r.origin, r.destination, s.departure_time, s.arrival_time, b.seat_number, b.booking_status, b.booking_date
                FROM Bookings b
                JOIN Schedule s ON b.schedule_id = s.schedule_id
                JOIN Routes r ON s.route_id = r.route_id
                WHERE b.user_id = $user_id
                ORDER BY b.booking_date DESC";
$result_history = $conn->query($sql_history);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="pasenger.css">

</head>
<body>
    <h1>Your Booking History</h1>

    <?php if ($result_history->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Seat Number</th>
                    <th>Booking Status</th>
                    <th>Booking Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_history->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['origin']); ?></td>
                        <td><?= htmlspecialchars($row['destination']); ?></td>
                        <td><?= htmlspecialchars($row['departure_time']); ?></td>
                        <td><?= htmlspecialchars($row['arrival_time']); ?></td>
                        <td><?= htmlspecialchars($row['seat_number']); ?></td>
                        <td><?= htmlspecialchars($row['booking_status']); ?></td>
                        <td><?= htmlspecialchars($row['booking_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no booking history.</p>
    <?php endif; ?>

    <br>
    <a href="book_ticket.php">Book a Ticket</a>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
