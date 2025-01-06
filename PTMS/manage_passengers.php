<?php
session_start();
include 'connection.php'; // Include your database connection file

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "<script>
            alert('You need to log in as an admin to manage passengers.');
            window.location.href = 'login.php'; // Redirect to the login page
          </script>";
    exit; // Stop further execution
}

// Fetch all passengers
$sql = "SELECT * FROM users WHERE role = 'passenger'";
$result = $conn->query($sql);

// Initialize response message for notification sending
$response_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_notification'])) {
    $passenger_id = $_POST['passenger_id'];
    $message = trim($_POST['notification_message']);

    // Validate message
    if (!empty($message)) {
        // Insert the notification into the Notifications table
        $sql = "INSERT INTO Notifications (user_id, message) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $passenger_id, $message);

        if ($stmt->execute()) {
            $response_message = "Notification sent to passenger.";
        } else {
            $response_message = "There was an error sending the notification.";
        }

        $stmt->close();
    } else {
        $response_message = "Please enter a notification message.";
    }
}

// Handle passenger deletion
if (isset($_GET['delete'])) {
    $passenger_id = filter_var($_GET['delete'], FILTER_VALIDATE_INT);

    if ($passenger_id) {
        // Delete the passenger
        $delete_sql = "DELETE FROM users WHERE user_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $passenger_id);
        $delete_stmt->execute();
        $delete_stmt->close();
        header("Location: manage_passengers.php"); // Redirect to prevent accidental re-deletion
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Passengers</title>
    <link rel="stylesheet" href="adimin.css">
    <style>
        .notification-form {
            display: none;
            padding: 10px;
            border: 1px solid #ccc;
            background: #f9f9f9;
        }
        .notification-form textarea {
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Manage Passengers</h1>

    <?php if ($response_message): ?>
        <p><?= htmlspecialchars($response_message); ?></p>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>Passenger ID</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['user_id']; ?></td>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td>
                    <a href="?delete=<?= $row['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this passenger?');">Delete</a>
                    <button onclick="toggleForm(<?= $row['user_id']; ?>)">Contact</button>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 10px;">
                    <div id="notification_form_<?= $row['user_id']; ?>" class="notification-form">
                        <form method="POST">
                            <input type="hidden" name="passenger_id" value="<?= $row['user_id']; ?>">
                            <textarea name="notification_message" rows="3" placeholder="Type your notification here..." required></textarea><br>
                            <input type="submit" name="send_notification" value="Send Notification">
                        </form>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="admin.php">Back to Dashboard</a>

    <script>
        function toggleForm(userId) {
            const form = document.getElementById(`notification_form_${userId}`);
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
