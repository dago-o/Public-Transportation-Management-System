<?php
// Include the database connection file
include 'connection.php';
session_start(); // Start the session

// Initialize variables
$announcement_created = false;

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id'])) {
    echo "Error: You need to log in as an admin to manage announcements.";
    exit; // Stop execution if not logged in
}

// Fetch the admin ID from session
$admin_id = $_SESSION['user_id'];

// Add a new announcement
if (isset($_POST['add_announcement'])) {
    $announcement_text = $_POST['announcement_text'];

    $sql = "INSERT INTO announcements (admin_id, announcement_text) 
            VALUES ('$admin_id', '$announcement_text')";

    if ($conn->query($sql) === TRUE) {
        $announcement_created = true;
    } else {
        echo "Error creating announcement: " . $conn->error;
    }
}

// Fetch all announcements to display
$announcements = $conn->query("SELECT * FROM Announcements ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements</title>
    <link rel="stylesheet" href="adimin.css">

</head>
<body>

<h1>Manage Announcements</h1>

<!-- Form for Adding Announcements -->
<form method="POST" action="announcement.php">
    <label for="announcement_text">Announcement Text:</label><br>
    <textarea name="announcement_text" rows="4" required></textarea><br>
    <button type="submit" name="add_announcement">Add Announcement</button>
</form>

<?php if ($announcement_created): ?>
    <p>Announcement created successfully!</p>
<?php endif; ?>

<h2>Existing Announcements</h2>
<table border="1">
    <tr>
        <th>Announcement ID</th>
        <th>Admin ID</th>
        <th>Announcement Text</th>
        <th>Created At</th>
    </tr>

    <?php while($row = $announcements->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['announcement_id']; ?></td>
            <td><?php echo $row['admin_id']; ?></td>
            <td><?php echo htmlspecialchars($row['announcement_text']); ?></td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
