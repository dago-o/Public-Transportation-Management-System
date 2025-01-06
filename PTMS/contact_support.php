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

// Initialize message variable
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $support_message = trim($_POST['message']);
    
    // Validate message
    if (!empty($support_message)) {
        // Insert the message into the feedback table
        $sql = "INSERT INTO feedback (user_id, message) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $support_message);

        if ($stmt->execute()) {
            $message = "Your message has been sent to support.";
        } else {
            $message = "There was an error sending your message. Please try again.";
        }

        $stmt->close();
    } else {
        $message = "Please enter a message.";
    }
}

$user_id = $_SESSION['user_id'];

// Fetch feedback messages for the logged-in user
$sql_feedback = "
    SELECT f.feedback_id, f.message AS feedback_message, f.response AS admin_response, f.created_at
    FROM feedback f
    WHERE f.user_id = ?
    ORDER BY f.created_at DESC
";
$stmt_feedback = $conn->prepare($sql_feedback);
$stmt_feedback->bind_param("i", $user_id);
$stmt_feedback->execute();
$result_feedback = $stmt_feedback->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Support</title>
    <link rel="stylesheet" href="pasenger.css">

</head>
<body>
    <h1>Contact Support</h1>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="contact_support.php" method="POST">
        <label for="message">Your Message:</label><br>
        <textarea name="message" id="message" rows="5" required></textarea><br>
        <input type="submit" value="Send Message">
    </form>

    <br>
  <!-- --feedback section-- -->
    <h2>Feedback Messages</h2>
    <?php if ($result_feedback->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result_feedback->fetch_assoc()): ?>
                <li>
                    <strong>Your Message:</strong> <?= htmlspecialchars($row['feedback_message']); ?><br>
                    <strong>Response:</strong> <?= htmlspecialchars($row['admin_response'] ?: 'No response yet'); ?><br>
                    <strong>Received At:</strong> <?= htmlspecialchars($row['created_at']); ?>
                </li>
                <hr>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You have no feedback messages.</p>
    <?php endif; ?>
   <a href="passenger.php">Back to Board</a>
</body>
</html>

<?php
// Close all prepared statements and database connections
 $stmt_feedback->close();
$conn->close(); // Close the database connection
?>
