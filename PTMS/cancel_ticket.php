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

// Fetch booked tickets for the logged-in user
$user_id = $_SESSION['user_id'];
$sql_bookings = "SELECT b.booking_id, r.origin, r.destination, s.departure_time, s.arrival_time, b.seat_number, b.booking_status
                 FROM Bookings b
                 JOIN Schedule s ON b.schedule_id = s.schedule_id
                 JOIN Routes r ON s.route_id = r.route_id
                 WHERE b.user_id = $user_id AND b.booking_status = 'confirmed'";
$result_bookings = $conn->query($sql_bookings);

// Handle ticket cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking_id'])) {
    $booking_id = $_POST['cancel_booking_id'];
    
    // Update the booking status to 'cancelled'
    $sql_cancel = "UPDATE Bookings SET booking_status = 'cancelled' WHERE booking_id = $booking_id";
    
    if ($conn->query($sql_cancel) === TRUE) {
        echo "<script>alert('Ticket cancelled successfully.');</script>";
        // Optionally, refresh the page to update the booking list
        header("Refresh:0");
    } else {
        echo "<script>alert('Error cancelling ticket: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Ticket</title>
    <link rel="stylesheet" href="pasenger.css">

    
</head>
<body>
    <h1>Your Booked Tickets</h1>

    <?php if ($result_bookings->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Seat Number</th>
                    <th>Booking Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['origin']); ?></td>
                        <td><?= htmlspecialchars($row['destination']); ?></td>
                        <td><?= htmlspecialchars($row['departure_time']); ?></td>
                        <td><?= htmlspecialchars($row['arrival_time']); ?></td>
                        <td><?= htmlspecialchars($row['seat_number']); ?></td>
                        <td><?= htmlspecialchars($row['booking_status']); ?></td>
                        <td>
                            <?php if ($row['booking_status'] == 'confirmed'): ?>
                                <form action="" method="post">
                                    <input type="hidden" name="cancel_booking_id" value="<?= $row['booking_id']; ?>">
                                    <input type="submit" value="Cancel Ticket">
                                </form>
                            <?php else: ?>
                                <span>Cancelled</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no booked tickets.</p>
    <?php endif; ?>

    <br>
    <a href="book_ticket.php">Book a Ticket</a>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
