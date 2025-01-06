<?php
// Include the database connection file
include 'connection.php';

// Fetch all cancellations with booking status 'cancelled'
$cancellations = $conn->query("SELECT c.cancellation_id, c.booking_id, c.cancellation_date, c.reason, c.refund_amount, b.user_id, b.booking_date 
                                 FROM Cancellations c
                                 JOIN Bookings b ON c.booking_id = b.booking_id
                                 WHERE b.booking_status = 'cancelled'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cancellations</title>
    <link rel="stylesheet" href="adimin.css">
</head>
<body>

<h1>Cancelled Bookings</h1>

<table border="1">
    <tr>
        <th>Cancellation ID</th>
        <th>Booking ID</th>
        <th>User ID</th>
        <th>Booking Date</th>
        <th>Cancellation Date</th>
        <th>Reason</th>
        <th>Refund Amount</th>
    </tr>

    <?php while($row = $cancellations->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['cancellation_id']; ?></td>
            <td><?php echo $row['booking_id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['booking_date']; ?></td>
            <td><?php echo $row['cancellation_date']; ?></td>
            <td><?php echo $row['reason']; ?></td>
            <td><?php echo number_format($row['refund_amount'], 2); ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
