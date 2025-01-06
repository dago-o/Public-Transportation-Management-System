<?php
// Include the database connection file
include 'connection.php';
session_start(); // Start the session

// Initialize variables
$report_generated = false;

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id'])) {
    echo "Error: You need to log in as an admin to generate reports.";
    exit;
}

// Fetch the user role securely using prepared statements
$admin_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT role FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user || $user['role'] !== 'admin') {
    echo "Error: You do not have permission to generate reports.";
    exit;
}

// Generate a report
if (isset($_POST['generate_report'])) {
    // Fetch booking and cancellation data
    $report_data_query = $conn->query("
        SELECT 
            b.booking_id, 
            b.booking_date, 
            b.seat_number, 
            b.booking_status, 
            c.cancellation_date, 
            c.reason AS cancellation_reason, 
            c.refund_amount, 
            s.departure_time, 
            s.arrival_time, 
            s.bus_number 
        FROM Bookings b
        LEFT JOIN Cancellations c ON b.booking_id = c.booking_id
        LEFT JOIN Schedule s ON b.schedule_id = s.schedule_id
    ");

    // Prepare report data in JSON format
    $report_data = [];
    while ($row = $report_data_query->fetch_assoc()) {
        $report_data[] = $row;
    }
    $report_data_json = json_encode($report_data);

    // Insert report data into the Reports table
    $report_type = 'booking_cancellation'; // Type of report
    $stmt = $conn->prepare("INSERT INTO Reports (admin_id, report_type, report_data) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $admin_id, $report_type, $report_data_json);

    if ($stmt->execute()) {
        $report_generated = true;
    } else {
        error_log("Report generation failed: " . $stmt->error); // Log the error
        echo "An error occurred while generating the report. Please try again later.";
    }
    $stmt->close();
}

// Fetch all reports for display
$reports = $conn->query("SELECT * FROM Reports");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
    <link rel="stylesheet" href="adimin.css">
</head>
<body>

<h1>Generate Booking and Cancellation Report</h1>

<!-- Form to generate the report -->
<form method="POST" action="report.php">
    <button type="submit" name="generate_report">Generate Report</button>
</form>

<?php if ($report_generated): ?>
    <p>Report generated successfully!</p>
<?php endif; ?>

<h2>Generated Reports</h2>

<?php if ($reports->num_rows == 0): ?>
    <p>No reports generated yet.</p>
<?php else: ?>
    <table border="1">
        <tr>
            <th>Report ID</th>
            <th>Admin ID</th>
            <th>Report Type</th>
            <th>Generated At</th>
            <th>Report Data</th>
        </tr>
        <?php while ($row = $reports->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['report_id']; ?></td>
                <td><?php echo $row['admin_id']; ?></td>
                <td><?php echo $row['report_type']; ?></td>
                <td><?php echo $row['generated_at']; ?></td>
                <td>
                    <details>
                        <summary>View Data</summary>
                        <pre><?php echo json_encode(json_decode($row['report_data'], true), JSON_PRETTY_PRINT); ?></pre>
                    </details>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php endif; ?>

</body>
</html>
