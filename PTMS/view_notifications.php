<?php
session_start();
include 'connection.php'; // Include your database connection file

// Check if the user is logged in as a passenger
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'passenger') {
    echo "<script>
    alert('You need to log in as passengers.');
    window.location.href = 'login.php'; // Redirect to the login page
  </script>";
exit; // Stop further execution
}

$user_id = $_SESSION['user_id'];

// Fetch notifications for the logged-in user from the Notifications table
$sql_notifications = "
    SELECT n.notification_id, n.message, n.created_at
    FROM Notifications n
    WHERE n.user_id = ?
    ORDER BY n.created_at DESC
";
$stmt_notifications = $conn->prepare($sql_notifications);
$stmt_notifications->bind_param("i", $user_id);
$stmt_notifications->execute();
$result_notifications = $stmt_notifications->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notifications</title>
    <link rel="stylesheet" href="pasenger.css">

</head>
<body>
    <h1>Your Notifications</h1>
    <!-- Notifications Section -->
    <h2>Admin Notifications</h2>
    <?php if ($result_notifications->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result_notifications->fetch_assoc()): ?>
                <li>
                    <strong>Notification:</strong> <?= htmlspecialchars($row['message']); ?><br>
                    <strong>Received At:</strong> <?= htmlspecialchars($row['created_at']); ?>
                </li>
                <hr>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You have no notifications.</p>
    <?php endif; ?>

    <br>
    <a href="contact_support.php">Contact Support</a>
</body>
</html>

<?php
// Close all prepared statements and database connections
$stmt_notifications->close();
$conn->close();
?>
