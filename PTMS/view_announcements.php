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

// Fetch all announcements
$announcements = $conn->query("SELECT * FROM Announcements ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
    <link rel="stylesheet" href="pasenger.css">

</head>
<body>
    <h1>Announcements</h1>

    <?php if ($announcements->num_rows > 0): ?>
        <ul>
            <?php while ($row = $announcements->fetch_assoc()): ?>
                <li>
                    <strong><?= htmlspecialchars($row['announcement_text']); ?></strong><br>
                    <em>Posted on <?= htmlspecialchars($row['created_at']); ?></em>
                </li>
                <hr>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No announcements available.</p>
    <?php endif; ?>

    <br>
    <a href="contact_support.php">Contact Support</a> | <a href="passenger.php">Back to Board</a>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
