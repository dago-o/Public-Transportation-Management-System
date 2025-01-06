<?php
// Include the database connection file
include 'connection.php';

// Fetch all bookings with related schedule and user details
$bookings = $conn->query("
    SELECT Bookings.*, Users.username, Schedule.departure_time, Schedule.arrival_time, Schedule.bus_number, Routes.origin, Routes.destination
    FROM Bookings
    JOIN Users ON Bookings.user_id = Users.user_id
    JOIN Schedule ON Bookings.schedule_id = Schedule.schedule_id
    JOIN Routes ON Schedule.route_id = Routes.route_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="adimin.css">
</head>
<body>

<h1 style="color: red;">View Bookings</h1>

<!-- Display the list of bookings -->
<table>
    <tr>
        <th>Booking ID</th>
        <th>User</th>
        <th>Route</th>
        <th>Bus Number</th>
        <th>Departure Time</th>
        <th>Arrival Time</th>
        <th>Seat Number</th>
        <th>Booking Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while($row = $bookings->fetch_assoc()) { ?>
        <tr>
            <td data-label="Booking ID"><?php echo $row['booking_id']; ?></td>
            <td data-label="User"><?php echo $row['username']; ?></td>
            <td data-label="Route"><?php echo $row['origin'] . ' - ' . $row['destination']; ?></td>
            <td data-label="Bus Number"><?php echo $row['bus_number']; ?></td>
            <td data-label="Departure Time"><?php echo $row['departure_time']; ?></td>
            <td data-label="Arrival Time"><?php echo $row['arrival_time']; ?></td>
            <td data-label="Seat Number"><?php echo $row['seat_number']; ?></td>
            <td data-label="Booking Date"><?php echo $row['booking_date']; ?></td>
            <td data-label="Status"><?php echo $row['booking_status']; ?></td>
            <td data-label="Action">
                <?php if ($row['booking_status'] == 'confirmed') { ?>
                    <a href="cancelbooking.php?booking_id=<?php echo $row['booking_id']; ?>"
                       onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
                <?php } else { ?>
                    Cancelled
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
