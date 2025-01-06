<?php
session_start();
include 'connection.php'; // Include your database connection file

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect to login page
    exit;
}

// Initialize response message
$response_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['respond'])) {
    $feedback_id = intval($_POST['feedback_id']);
    $response_text = trim($_POST['response']);

    // Validate response
    if (!empty($response_text)) {
        // Update the feedback entry with the admin's response
        $sql = "UPDATE feedback SET response = ? WHERE feedback_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $response_text, $feedback_id);

        if ($stmt->execute()) {
            $response_message = "Response sent to passenger.";
        } else {
            $response_message = "There was an error sending the response: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $response_message = "Please enter a response.";
    }
}

// Fetch all feedback messages for the admin to view
$feedbacks = $conn->query("SELECT f.feedback_id, f.message, f.response, u.username 
                           FROM feedback f 
                           JOIN users u ON f.user_id = u.user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback</title>
    <link rel="stylesheet" href="adimin.css">
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <h1>Feedback from Passengers</h1>

    <?php if ($response_message): ?>
        <script>
            showAlert("<?= addslashes($response_message); ?>");
        </script>
    <?php endif; ?>

    <?php if ($feedbacks->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Feedback ID</th>
                <th>Passenger</th>
                <th>Message</th>
                <th>Response</th>
                <th>Action</th>
            </tr>

            <?php while($row = $feedbacks->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['feedback_id']; ?></td>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                    <td><?= htmlspecialchars($row['message']); ?></td>
                    <td><?= htmlspecialchars($row['response'] ? $row['response'] : 'No response yet'); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="feedback_id" value="<?= $row['feedback_id']; ?>">
                            <textarea name="response" rows="2" placeholder="Type your response..." required><?= htmlspecialchars($row['response']); ?></textarea>
                            <input type="submit" name="respond" value="<?= empty($row['response']) ? 'Send Response' : 'Update Response'; ?>">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No feedback available at the moment.</p>
    <?php endif; ?>

    <br>
    <a href="view_announcements.php">View Announcements</a>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
